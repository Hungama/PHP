#!/bin/sh
#Shell Script fro Music Renewal

cd /var/www/html/kmis/mis/

echo "Start `date` " > pujaReportStatus.txt

/usr/bin/php /var/www/html/kmis/mis/insertDailyReportPuja.php & 

echo "End  `date` " >> PujaReportStatus.txt