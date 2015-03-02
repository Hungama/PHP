#!/bin/sh
#Shell Script for LiveFM Mis

cd /var/www/html/kmis/mis/

echo "Start `date` " > reportStatusLiveFM.txt

/usr/bin/php /var/www/html/kmis/mis/insertDailyReportLiveFM.php & 

echo "End  `date` " >> reportStatusLiveFM.txt
