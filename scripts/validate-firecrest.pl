#!/util/bin/perl -w

$USAGE = <<'END';

    validate-firecrest.pl FILE

Perform some simple checks on a Firecrest/Bustard file.

The filename must be of the form s_x_y_{int,sig2}.txt, where x and y
are unsigned decimal integers.  The additional suffix .old is also
permitted.

Each check is performed per file without reference to any other files.
Within a file,

* Every line must have the same number of whitespace-delimited fields.

* The first two fields must match the two integers in the basename.

* The first four fields must be integers.

* The remainder of the fields must be decimal numbers with 1-5 digits
  before the decimal point and exactly 1 after, with an optional minus
  sign in front.

The script reports all errors it finds and returns a nonzero value if
and only if there were errors.

END
;

die $USAGE unless 1 == @ARGV and -r ($file = shift @ARGV);

$basename = (split "/", $file)[-1];

die $USAGE unless $basename =~ /^s_(\d+)_(\d+)_(int|sig2)\.txt$/;

$signature = join "\t", 0+$1, 0+$2;

open FILE, "<$file" or die "Can't read $file: $!";

$width = undef;

$error = 0;

LINE:
while (<FILE>) {

    unless ($_ =~ s/^$signature\t//) {
	warn "bad signature at $file:$.: $_";
	$error = 1;
	next LINE;
    }

    unless ($_ =~ s/^(-?\d+)\t(-?\d+)\t//) {
	warn "missing two leading integers after signature at $file:$.: $_";
	$error = 2;
	next LINE;
    }

    @fields = split;

    unless (defined($width)) {
	$width = scalar @fields;
	next LINE;
    }

    unless ($width == ($w = scalar @fields)) {
	warn "width changed from $width to $w at $file:$.: $_";
	$error = 3;
	next LINE;
    }

    for (@fields) {
	next if /^-?\d+\.\d/;
	die "bad field at $file:$.: $_\n";
    }
}

exit $error;
