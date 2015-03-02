#!/bin/sh
#Shell Script for insert DIGI DAILY MIS

cd /var/www/html/digi/

echo "Start `date` " > insertDigidailyMIS.txt
#/usr/bin/php /var/www/html/digi/insertDigidailyMIS.php & 
/usr/bin/php /var/www/html/digi/insertDigidailyMISCallLogs.php & 

echo "End  `date` " >> insertDigidailyMIS.txt