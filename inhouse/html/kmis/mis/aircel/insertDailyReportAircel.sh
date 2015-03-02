#!/bin/sh
#Shell Script for Aircel MIS

cd /var/www/html/kmis/mis/aircel/

echo "Start `date` " > AircelReportStatus.txt

/usr/bin/php /var/www/html/kmis/mis/aircel/insertDailyReportAircel.php & 
sleep 60
#/usr/bin/php /var/www/html/kmis/mis/aircel/insertDailyReportEtisalat.php & 

echo "End  `date` " >> AircelReportStatus.txt