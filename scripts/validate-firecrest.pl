#!/util/bin/perl -w

use strict;

our $USAGE = <<'END';

    validate-firecrest.pl FILE1 FILE2 ...

Perform some simple checks on a set of Firecrest/Bustard files.

The filenames must be of the form s_x_y_{int,sig2}.txt, where x and y
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

=pod

Things to do to generalize this for multiple files:

* keep track of total good & bad files instead of dying on bad files

* return fail if any files were bad

* exactly one line of output per file (first problem or summary)

=cut

# main body
END {

  die $USAGE unless @ARGV;

  my %signatures = ();

  for (@ARGV) {

    my $basename = (split "/", $_)[-1];

    die "Filename '$basename' does not have the right format.\n\n$USAGE"
      unless $basename =~ /^s_(\d+)_(\d+)_(int|sig2)\.txt(?:\.old)?$/;

    $signatures{$_} ||= join "\t", 0+$1, 0+$2;

  }

  my @errors = ();

  for (@ARGV) { push @errors, check_file($_, $signatures{$_}) }

  exit (0 < @errors);
}

sub check_file($$) {

  my ($file, $signature) = @_;

  unless (open FILE, "<$file") {
    warn "$file: can't open: $!";
    return 1;
  }

  my $validator = qr!^$signature\t-?\d+\t-?\d+((?:\s+-?\d+\.\d)+)\s*$!;

  my ($reference_width, $width, $fields, $error) = undef, undef, undef, 0;

  while (<FILE>) {

    unless (/$validator/) {
      warn "$file: line $. does not match /$validator/\n";
      $error = 2;
      last;
    }

    $fields = $1;
     
    # count runs of whitespace (= # of fields) in the group
    $width = (() = ($fields =~ /\s+/g));

    $reference_width ||= $width;

    unless ($width == $reference_width) {
      warn "$file: line $. has $width decimal fields instead of $reference_width\n";
      $error = 3;
      last;
    }
  }

  close FILE;

  print "$file: OK, $reference_width fields\n" unless $error;

  return $error;
}
