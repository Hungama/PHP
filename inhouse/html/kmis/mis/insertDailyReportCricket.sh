#!/bin/sh
#Shell Script for Cricket Mania Mis

cd /var/www/html/kmis/mis/

echo "Start `date` " > reportStatusCricket.txt

/usr/bin/php /var/www/html/kmis/mis/insertDailyReportCricket.php & 

echo "End  `date` " >> reportStatusCricketMania.txt
