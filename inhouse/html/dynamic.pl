#!/usr/bin/perl

print "content-type: text/html \n\n"; #The header
$HTML = "myhtml.html";
open (HTML) or die "Can't open the file!";
@fileinput = <HTML>;
print $fileinput[0];
print $fileinput[1];
print $fileinput[2];
print $fileinput[3];
print "<table border='1' align='center'><tr>
<td>Dynamic</td><td>Table</td></tr>";
print "<tr><td>Temporarily Inserted</td>
<td>Using PERL!</td></tr></table>";
print $fileinput[4];
print $fileinput[5];
close (HTML);