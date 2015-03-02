#!/bin/sh
#Shell Script for insert Vodafone Daily Calllogs

cd /var/www/html/hungamacare/

echo "Start `date` " > insertVodafoneDailyCalllogs.txt
/usr/bin/php /var/www/html/hungamacare/insertVodafoneDailyCalllogs.php & 
echo "End  `date` " >> insertVodafoneDailyCalllogs.txt