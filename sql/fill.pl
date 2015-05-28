#!/usr/bin/perl -w

use strict;
use DBI;

my $file1 = "albumlist";
my $file2 = "songs";
my $database = 'abaldan-PR';
my $hostname = 'basidati1004.studenti.math.unipd.it';
my $port = 3306;
my $user = 'abaldan';
my $password = 'NtQEfO78';
open(my $ah, '<:encoding(UTF-8)', $file1);

my $dsn = "DBI:mysql:database=$database;host=$hostname;port=$port";
my $dbh = DBI->connect($dsn, $user, $password);
my $drh = DBI->install_driver("mysql");
my @databases = DBI->data_sources("mysql");

while(my $row = <$ah>) {
    chomp $row;
    my @fields = split(",", $row);
    my $sth = $dbh->do('INSERT INTO Album (IdAlbum, Titolo, Autore, Info, Anno, Live, Locazione, PathCopertina) VALUES(?,?,?,?,?,?,?,?)', undef, $fields[0], $fields[1], $fields[2], $fields[3], $fields[4], $fields[5], $fields[6], "NULL", "NULL");
}
open(my $sh, '<:encoding(UTF-8)', $file2);
while(my $row = <$sh>) {
    chomp $row;
    my @fields = split(",", $row);
    my @duration = split(":", $fields[2]);
    my $drt = ($duration[0] * 60) + $duration[1];
    my $sth = $dbh->do('INSERT INTO Brani (IdAlbum, Titolo, Durata, Genere)VALUES(?,?,?,?)', undef, $fields[0], $fields[1], $drt, $fields[3]);
}
