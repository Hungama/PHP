#!/bin/sh
#Shell Script for docomo CRBT

cd /var/www/html/reliance/

echo "Start `date` " > RelianceCrbt.txt

/usr/bin/php /var/www/html/reliance/RelianceCrbt.php & 

echo "End  `date` " >> RelianceCrbt.txt