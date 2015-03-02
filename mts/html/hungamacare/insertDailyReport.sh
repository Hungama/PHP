#!/bin/sh
#Shell Script for Indicom Mis

cd /var/www/html/hungamacare/

echo "Start `date` " > insertDailyReport.txt

#/usr/bin/php /var/www/html/hungamacare/insertDailyReport.php & 
/usr/bin/php /var/www/html/hungamacare/mis/insertDailyReport.php & 

echo "End  `date` " >> insertDailyReport.txt