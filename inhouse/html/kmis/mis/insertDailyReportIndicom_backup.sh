#!/bin/sh
#Shell Script for Indicom Mis

cd /var/www/html/kmis/mis/

echo "Start `date` " > reportStatusIndicom.txt

/usr/bin/php /var/www/html/kmis/mis/insertDailyReportIndicom.php & 

echo "End  `date` " >> reportStatusIndicom.txt