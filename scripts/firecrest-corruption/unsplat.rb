#!/util/bin/ruby

# This is for disentangling LSF logs that have lines splatted into
# other lines from stdout/stderr mixing.

# If we see pattern 

SPLATTED = %r{^(\S+|/seq/.*?)(/seq/.*?\n)$}

# replace it with \1 and save $2.  If we see pattern

LINE     = %r{^/seq.*$}

# keep appending that to the splatted stuff until we find the tail of
# the original line, at which point we print it and then the splatted
# stuff.

# The end result should be as though the splatted lines came after the
# line that they were inserted into.

splat = nil

ARGF.each { |line|

  if splat.nil?

    # If we see the start of a splat, trim it and go into splat mode.

    if line.sub!(SPLATTED, '\1')
      (splat ||= []) << $2
    end

    print line

  else                  # We're in a splat, so
    if line =~ LINE     # if the line is complete,
      splat << line     # append it;
    else                # otherwise dump it.
      print line
      puts splat
      splat = nil
    end

  end

}

raise (['Terminal splat!'] + splat).join("\n\t") if splat
