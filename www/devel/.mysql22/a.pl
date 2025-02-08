#!/usr/bin/perl

my $a = int(rand(220));
my $b = 0;
print "Scanning: ".$a.".0.0.0/8";
system('./start '.$a.' ');
