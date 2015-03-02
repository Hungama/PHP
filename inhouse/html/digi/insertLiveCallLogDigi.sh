#!/bin/sh
#Shell Script for insert DIGI DAILY MIS

cd /var/www/html/digi/

echo "Start `date` " > insertLiveCallLogDigi.txt
/usr/bin/php /var/www/html/digi/insertLiveCallLogDigi.php & 
/usr/bin/php /var/www/html/digi/insertDigidailyMISCallLogs.php & 

echo "End  `date` " >> insertLiveCallLogDigi.txt