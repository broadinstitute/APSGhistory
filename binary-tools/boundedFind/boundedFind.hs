#!/usr/bin/env runhaskell

import Directory

import Data.List ((\\), intercalate)
import Data.Maybe (maybeToList)

import System (getArgs)
import System.IO
import System.IO.Unsafe (unsafePerformIO, unsafeInterleaveIO)
import System.FilePath.Posix (combine)
import System.Posix.Files

-- Suppose we have a collection of tasks, and performing each task
-- will produce some results and some more tasks.  The steps
-- function starts with a task list, performs the first task, reports
-- the results and the new task list, and continues.

-- for the task queue
import Prelude hiding (null, mapM)
import Data.Sequence hiding (zipWith, take)
import Data.Traversable

steps step = takeUntil (null . snd) . process . fromList where
    process tasks | null tasks = []
                  | otherwise  =
                      let (task :< rest) = viewl tasks
                          (result, more) = step task
                          tasks' = rest >< fromList more
                      in ((result, tasks') : process tasks')

takeUntil test [] = []
takeUntil test (a:as) | test a    = [a]
                      | otherwise = (a : takeUntil test as)

instance Show FileStatus where
         show s = intercalate "/" $ zipWith ($) [show . fileSize, show . fileMode,
                                                 show . fileOwner, show . fileGroup,
                                                 show . modificationTime,
                                                 show . accessTime,
                                                 show . statusChangeTime] (repeat s)

data FileInfo = FI { status :: FileStatus, path :: FilePath } deriving (Show)

getFileInfo p = do s <- getSymbolicLinkStatus p
                   return FI { status = s, path = p }

processPath p = do info <- getFileInfo p
                   kids <- if isDirectory $ status info
                           then getDirectoryContents $ path info
                           else return []
                   return (info, map (combine p) $ kids \\ [".", ".."])

showResults h [] = []
showResults h [(r,t)]    = [print r, (mapM (hPutStrLn h) t >> return ())]
showResults h ((r,t):xs) = (print r : showResults h xs)

deMaybe = concatMap (maybeToList.promoteMaybe) where
    promoteMaybe (Nothing, t) = Nothing
    promoteMaybe (Just r, t)  = Just (r,t)

main = do (checkpointPath : count : paths) <- getArgs
       	  withFile checkpointPath WriteMode $ \h ->
	   sequence_ $ showResults h $ take (read count) $ deMaybe $
            steps (unsafePerformIO . (graceful processPath)) paths where
             graceful p i = catch (return . (\(r,t) -> (Just r, t)) =<< p i)
                                  (\e -> return (Nothing, []))
