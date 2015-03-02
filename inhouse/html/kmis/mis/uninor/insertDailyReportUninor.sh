#!/bin/sh
#Shell Script for Uninor Mis

cd /var/www/html/kmis/mis/uninor/

echo "Start `date` " > reportStatusUninor.txt

/usr/bin/php /var/www/html/kmis/mis/uninor/insertDailyReportUninor.php & 
sleep 100
/usr/bin/php /var/www/html/kmis/mis/BSNL/insertDailyReportBSNL.php &

echo "End  `date` " >> reportStatusUninor.txt
