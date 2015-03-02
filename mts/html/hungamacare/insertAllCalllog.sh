#!/bin/sh
#Shell Script for Indicom Mis

cd /var/www/html/hungamacare/

echo "Start `date` " > inserDailyReport.txt

/usr/bin/php /var/www/html/hungamacare/insertAllCalllog.php & 

echo "End  `date` " >> inserDailyReport.txt
