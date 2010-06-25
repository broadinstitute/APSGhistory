#!/usr/bin/env ruby

require 'find'
require 'etc'

email = {}

def start_email(uid)
    pwent = Etc.getpwuid(uid)
    username, fullname = pwent.name, pwent.gecos

    sendmail = IO.popen("/usr/sbin/sendmail -f apsg@broadinstitute.org #{username}@broadinstitute.org", 'w')

    sendmail.puts "From: Research Computing resource usage alerts <help@broadinstitute.org>",
                  "To:   \"#{fullname}\" <#{username}@broadinstitute.org>",
                  "Subject: /broad/shptmp deletion warning",
		  "",
		  "The following files you own in /broad/shptmp have not been accessed or modified in 7 days",
		  "and will be deleted 7 days from now:",
		  ""

    return sendmail
end

Find.find('/broad/shptmp/') { |path|

   Find.prune if File.basename(path) == '.snapshot'
   status = File.lstat(path) rescue next

   next if status.directory?

   next if %w[mtime ctime atime].detect { |time| Time.now - status.send(time) < 7*86400 }

   (email[status.uid] ||= start_email(status.uid)).puts path    
}
