#!/usr/bin/env ruby

require 'time'

victims_per_day = ARGV.shift.to_i rescue 1

days = ARGV.shift.to_i if ARGV[0] and ARGV[0].to_i > 0

def straws(n)
  ARGV.shuffle[0,n].join(' ')
end

if days.nil?
  puts straws(victims_per_day)
else
  time = Time.now

  days.times {
    puts time.strftime("%Y-%m-%d ") + straws(victims_per_day)
    time += 86400 # 1 day in seconds
  }
end
