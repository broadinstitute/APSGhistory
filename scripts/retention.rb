#!/usr/bin/env

# Basic retention policy.  Given a list of files, keep the only:
#
# - the newest one
# - the oldest one in the 1 day - 1 week range
# - the oldest one in the 1 week - 1 month range
# - the oldest one in the 1 month - 1 year range

ARGF.each { |line| file = line.chomp
  

}


require 'find'
require 'etc'

Find.find('/broad/shptmp/') { |path|

   Find.prune if File.basename(path) == '.snapshot'
   status = File.lstat(path) rescue next

   next if status.directory?

   next if %w[mtime ctime atime].detect { |time| Time.now - status.send(time) < 7*86400 }

   (email[status.uid] ||= start_email(status.uid)).puts path    
}
