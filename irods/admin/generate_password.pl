#!/usr/bin/env perl

use String::Random qw(random_regex);

$password = random_regex("[a-zA-Z0-9]{16}");
print $password, "\n";

exit 0;

