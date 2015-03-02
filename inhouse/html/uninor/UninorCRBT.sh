#!/bin/sh
#Shell Script for Uninor CRBT

cd /var/www/html/Uninor/

echo "Start `date` " > UniNORCRBT.txt

/usr/bin/php /var/www/html/Uninor/UninorCrbt.php & 

echo "End  `date` " >> UniNORCRBT.txt