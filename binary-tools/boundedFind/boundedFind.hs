#!/usr/bin/env runhaskell

module Main (main, processPath, unsafeGracefulProcess, deMaybe, steps, showResults) where

import System.FilePath.Posix (combine)
import System.Posix.Files
import Directory
import Data.List ((\\), intercalate)
import System.IO.Unsafe (unsafePerformIO, unsafeInterleaveIO)
import System (getArgs)
import Data.Maybe (maybeToList)
import Time
import Control.Monad
import System.IO

-- Suppose we have a collection of tasks, and performing each task
-- will produce some results and some more tasks.  The steps
-- function starts with a task list, performs the first task, reports
-- the results and the new task list, and continues.

takeUntil test [] = []
takeUntil test (a:b:bs) | (test b) && not (test a) = [a,b]
takeUntil test (a:bs) = (a : takeUntil test bs)

steps step tasks = takeUntil (null . snd) $ process tasks where
           process (task:tasks) = let (r, t) = step task in ((r, t ++ tasks) : process (t ++ tasks))

instance Show FileStatus where
         show s = intercalate "/" $ zipWith ($) [show . fileSize, show . fileMode,
                                   show . fileOwner, show . fileGroup,
                                   show . modificationTime, show . accessTime, show . statusChangeTime] (repeat s)

data FileInfo = FI { status :: FileStatus, path :: FilePath } deriving (Show)

getFileInfo p = do s <- getSymbolicLinkStatus p
                   return FI { status = s, path = p }

processPath p = do info <- getFileInfo p
                   kids <- if isDirectory $ status info then getDirectoryContents $ path info else return []
                   return (info, map (combine p) $ kids \\ [".", ".."])

unsafeGracefulProcess p = unsafePerformIO $ catch (return . (\(r,t) -> (Just r, t)) =<< processPath p) (\e -> return (Nothing, []))

getLengths = map (\(r,t) -> (r,length t))

promoteMaybe (Nothing, t) = Nothing
promoteMaybe (Just r, t)  = Just (r,t)

showResults h [] = []
showResults h [(r,t)]    = (print r : map (hPutStrLn h) t)
showResults h ((r,t):xs) = (print r : showResults h xs)

deMaybe = concatMap (maybeToList.promoteMaybe)

main = do (checkpointPath : count : paths) <- getArgs
       	  withFile checkpointPath WriteMode $ \h ->
	  	   sequence_ $ showResults h $ take (read count) $ deMaybe $ steps unsafeGracefulProcess paths