#!/usr/bin/env ruby

count   = ARGV.shift.to_i
victims = ARGV.shuffle[0,count]

puts victims
