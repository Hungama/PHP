#!/bin/sh
#Shell Script for MTV Mis

cd /var/www/html/kmis/mis/

echo "Start `date` " > reportStatusMtv.txt

/usr/bin/php /var/www/html/kmis/mis/insertDailyReportMTV.php & 

echo "End  `date` " >> reportStatusMtv.txt
