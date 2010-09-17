#!/usr/bin/env ruby

require 'etc'
require 'parsedate'

$repository, $revision, $pattern, *$recipients = ARGV

raise "usage: #{$0} REPOSITORY REVISION PATTERN RECIPIENTS" unless $repository and $revision and $pattern and $recipients

$pattern = Regexp.new($pattern, Regexp::IGNORECASE)

# puts "checking #{$repository}:#{$revision} for /#{$pattern}/ and mailing #{$recipients} if found"

# gather commit data with reckless disregard for fork() efficiency

(author, datestamp, log_size, *log), dirs, changed = %w[info dirs-changed changed].map { |command|
	 `svnlook #{command} #{$repository} --revision=#{$revision}`.split(%r{\r?\n})
}

# check *only* the paths of changed files (not the full line, which
# includes status) against the supplied PATTERN

exit 0 if changed.map { |line| line.sub(/^.\s+/,'') }.grep($pattern).empty?

# translate author into email address

hostname = `hostname -d`.chomp.sub('broad.mit.edu','broadinstitute.org')
fullname = Etc.getpwnam(author).gecos
author   = "\"#{fullname}\" <#{author}@#{hostname}>"

# translate datestamp directly into RFC 2822 email format

datestamp = Time.local(* ParseDate.parsedate(datestamp)).strftime('%a, %d %b %Y %H:%M:%S %z')

sendmail = IO.popen('/usr/sbin/sendmail -t -f svnadmin@broadinstitute.org', 'w')

sendmail.puts <<END_HEADER
From:    #{author}
To:      #{$recipients.join(', ')}
Date:    #{datestamp}
Subject: [#{$repository.split('/').last} \##{$revision}] #{dirs.join(' ')}

END_HEADER

sendmail.puts log, '', changed
