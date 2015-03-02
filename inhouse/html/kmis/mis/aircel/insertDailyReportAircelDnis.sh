#!/bin/sh
#Shell Script for Aircel MIS DNIS wise

cd /var/www/html/kmis/mis/aircel/

/usr/bin/php /var/www/html/kmis/mis/aircel/insertDailyReportDnisAircel.php & 
sleep 60
