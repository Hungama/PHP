#!/bin/sh
#Shell Script for BSNL Mis

cd /var/www/html/kmis/mis/BSNL/

echo "Start `date` " > reportStatusBsnl.txt

/usr/bin/php /var/www/html/kmis/mis/BSNL/insertDailyReportBSNL.php & 

echo "End  `date` " >> reportStatusBsnl.txt
