#!/bin/sh

#Shell Script for Vodafone Mis

cd /var/www/html/hungamacare/

echo "Start `date` " > reportStatusVodafone.txt

/usr/bin/php /var/www/html/hungamacare/insertDailyReportVoda.php & 

echo "End  `date` " >> reportStatusVodafone.txt