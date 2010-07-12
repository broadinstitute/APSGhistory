#!/usr/bin/env ruby

require 'find'
require 'etc'

$email = {}

# Limits how much filename content we send per email; well short of
# our current 10 MB message size limit.
EMAIL_SIZE_LIMIT = 9876543
$email_size = {}

def start_email(uid)
  pwent = Etc.getpwuid(uid)
  username, fullname = pwent.name, pwent.gecos

  sendmail = IO.popen("/usr/sbin/sendmail -f apsg@broadinstitute.org #{username}@broadinstitute.org", 'w')

  sendmail.puts header = <<HEADER
From: Research Computing resource usage alerts <help@broadinstitute.org>
To:   \"#{fullname}\" <#{username}@broadinstitute.org>
Subject: /broad/shptmp deletion warning

The following files you own in /broad/shptmp have not been accessed or modified in 7 days
and will be deleted 7 days from now:

HEADER
  $email_size[uid] = header.size

  return sendmail
end

Find.find('/broad/shptmp/') { |path|

  Find.prune if File.basename(path) == '.snapshot'
  status = File.lstat(path) rescue next

  next if (status.directory? or
           %w[mtime ctime atime].detect { |time| Time.now - status.send(time) < 7*86400 })

  $email.delete(status.uid) if ($email[status.uid] and
                                $email_size[status.uid] >= EMAIL_SIZE_LIMIT)
  ($email[status.uid] ||= start_email(status.uid)).puts path
}
