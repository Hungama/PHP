#!/bin/sh
#Shell Script for insert DIGI Live MIS

cd /var/www/html/digi/

echo "Start `date` " > insertLiveCallLogDigi_backdate.txt
/usr/bin/php /var/www/html/digi/insertLiveCallLogDigi_backdate.php & 
echo "End  `date` " >> insertLiveCallLogDigi_backdate.txt