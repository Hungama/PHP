#!/bin/sh
#Shell Script for Vodafone 54646

cd /var/www/html/kmis/mis/

echo "Start `date` " > VodafoneReportStatus.txt

/usr/bin/php /var/www/html/kmis/mis/insertDailyReportVodafone.php & 

echo "End  `date` " >> VodafoneReportStatus.txt
