#!/usr/bin/env perl -w

use strict;
use LWP::UserAgent;
use HTML::TableExtract;

my $ua = LWP::UserAgent->new;
$ua->timeout(10);
$ua->env_proxy;

my $file = shift or die "Usage: $0 filepath";
open(my $fh, '<:encoding(UTF-8)', $file) or die "Could not open file '$file' $!";
my $output = 'songs';
open(my $oh, '>', $output) or die "Could not open file '$output' $!";
while(my $r = <$fh>) {
    chomp $r;
    my @cols = split(",", $r);
    $cols[1] =~ s/" "/"_"/g;
    my $response = $ua->get('http://en.wikipedia.org/wiki/'.$cols[1].'#Track_listing');
    if ($response->is_success) {
        if($response->decoded_content =~ m/disambigbox/ ) {
            $response = $ua->get('http://en.wikipedia.org/wiki/'.$cols[1].'_(album)#Track_listing');
        }
        my $url = "";
        if($response->decoded_content =~ m{src="(.*?(jpg|png|gif))"}g) {
            $url = $1;
        }
        my $te = HTML::TableExtract->new(headers => ['No.', 'Title', 'Length']);
        $te->parse($response->decoded_content);
        print "\n\t---------------------------------------------------------------\n";
        print "\t Album: $cols[1]\t Artist: $cols[2]";
        print "\n\t---------------------------------------------------------------\n";
        print "\t Cover:\n\t $url\n";
        print "\t Tracks:\n\n";
        foreach my $ts ($te->table_states) {
            foreach my $row ($ts->rows) {
                if (defined $row->[1]) {
                    next unless $row->[1] =~ /\w/;
                    next if $row->[2] =~ m/\240/ || $row->[2] =~ m/ /;
                    $row->[1] = $1 if $row->[1] =~ /"(.*?)"/;
                    print $oh $cols[0]."   ".$row->[1]."   ".$row->[2]."   ".$cols[2]."\n";
                    print "\t  $row->[1]\t\t$row->[2]\t\t$cols[2]\n";
                }
            }
        }
    }
    print "\n";
}
print "\t** DONE **\n\n";
close($output);
