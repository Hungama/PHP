#!/bin/sh
#Shell Script for Processing Billilng

cd /var/www/html/hungamacare/
#stopped on blockout day
echo "Start `date` " > sendSMS.txt
#/usr/bin/php /var/www/html/hungamacare/sendSMS.php & 
echo "End  `date` " >> sendSMS.txt
