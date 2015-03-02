#!/bin/sh
#Shell Script for Docomo Mis

cd /var/www/html/kmis/mis/

echo "Start `date` " > reportStatusDocomo.txt

/usr/bin/php /var/www/html/kmis/mis/insertDailyReportDocomo.php & 

echo "End  `date` " >> reportStatusDocomo.txt