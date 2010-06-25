#!/usr/bin/env ruby

# Save the last 7 days of Confluence backups, and 1 each from the last
# 5 weeks, and 1 each month forever; delete the rest now.

path, junk = ARGV

# Requires Ruby 1.9 or later for gratuitous use of named captures in
# regexps below.

pattern = %r{daily-backup-(?<year>\d+)_(?<month>\d+)_(?<day>\d+).zip}

by_time  = {}
by_day   = {}
by_week  = {}
by_month = {}

Dir.entries(path).each { |entry|
  next unless m = pattern.match(entry)

  t = Time.local(m['year'], m['month'], m['day'])

  by_time[t] = entry

  (by_day[t.strftime("%Y/%j")]   ||= []) << entry
  (by_week[t.strftime("%Y/%W")]  ||= []) << entry
  (by_month[t.strftime("%Y/%m")] ||= []) << entry
}

# Assemble lists of times from each of the...

last_7_days  = by_day.keys.sort[-7..-1].collect { |day| by_day[day] }.flatten
# This will still work if times get more granular than once/day.

last_5_weeks = by_week.keys.sort[-5..-1].collect { |week| by_week[week].first }

months = by_month.keys.sort.collect { |month| by_month[month].first }

# ...and exclude those from the chopping block.

to_delete = by_time.values - last_7_days - last_5_weeks - months

to_delete.sort.each { |entry| File.unlink(path + '/' + entry) }
