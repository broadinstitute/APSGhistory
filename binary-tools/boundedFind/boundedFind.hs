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

steps step tasks = takeUntil (null . snd) $ process tasks where
           process (task:tasks) = let (r, t) = step task
                                  in ((r, t ++ tasks) : process (t ++ tasks))

-- Like takeWhile (not . f), but reports the 
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

promoteMaybe (Nothing, t) = Nothing
promoteMaybe (Just r, t)  = Just (r,t)

showResults h [] = []
showResults h [(r,t)]    = (print r : map (hPutStrLn h) t)
showResults h ((r,t):xs) = (print r : showResults h xs)

deMaybe = concatMap (maybeToList.promoteMaybe)

main = do (checkpointPath : count : paths) <- getArgs
       	  withFile checkpointPath WriteMode $ \h ->
	   sequence_ $ showResults h $ take (read count) $ deMaybe $
            steps (unsafePerformIO . (graceful processPath)) paths where
             graceful p i = catch (return . (\(r,t) -> (Just r, t)) =<< p i)
                                  (\e -> return (Nothing, []))
