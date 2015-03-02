#!/bin/sh
#Shell Script for Aircel MIS

echo "Start `date` " > insertLiveAircelMIS.txt

/usr/bin/php /var/www/html/kmis/mis/livemis/aircel/insertLiveAircelMIS.php & 

echo "End  `date` " >> insertLiveAircelMIS.txt
