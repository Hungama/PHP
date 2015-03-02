#!/bin/sh
#Shell Script for MTS Mis

cd /var/www/html/kmis/mis/

echo "Start `date` " > reportStatusMTS.txt

/usr/bin/php /var/www/html/kmis/mis/insertDailyReportMTS.php & 

echo "End  `date` " >> reportStatusMTS.txt
