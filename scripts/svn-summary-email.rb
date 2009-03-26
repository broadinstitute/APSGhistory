#!/util/bin/ruby

require 'etc'
require 'parsedate'

$repository, $revision, $pattern, *$recipients = ARGV

raise "usage: #{$0} REPOSITORY REVISION PATTERN RECIPIENTS" unless $repository and $revision and $pattern and $recipients

# puts "checking #{$repository}:#{$revision} for /#{$pattern}/ and mailing #{$recipients} if found"

$pattern = Regexp.new($pattern)

# gather commit data with reckless disregard for fork() efficiency

(author, datestamp, log_size, *log), dirs, changed = %w[info dirs-changed changed].map { |command|
	 `svnlook #{command} #{$repository} --revision=#{$revision}`.split(%r{\r?\n})
}

exit 0 if changed.grep($pattern).empty?

# translate author into email address

hostname = `hostname -d`.chomp
fullname = Etc.getpwnam(author).gecos
author   = "\"#{fullname}\" <#{author}@#{hostname}>"

# translate datestamp directly into RFC 2822 email format

datestamp = Time.local(* ParseDate.parsedate(datestamp)).strftime('%a, %d %b %Y %H:%M:%S %z')

sendmail = IO.popen('/usr/sbin/sendmail -t -f svnadmin@broad.mit.edu', 'w')

sendmail.puts <<END_HEADER
From:    #{author}
To:      #{$recipients.join(', ')}
Date:    #{datestamp}
Subject: [#{$repository.split('/').last} \##{$revision}] #{dirs.join(' ')}

END_HEADER

sendmail.puts log, '', changed