#!/bin/sh
#Shell Script fro Music Renewal

cd /var/www/html/kmis/mis/reliance/

echo "Start `date` " > relianceReportStatus.txt

/usr/bin/php /var/www/html/kmis/mis/reliance/insertDailyReportReliance.php & 

echo "End  `date` " >> relianceReportStatus.txt