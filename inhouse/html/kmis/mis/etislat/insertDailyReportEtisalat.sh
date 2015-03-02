#!/bin/sh
#Shell Script for Etislat MIS

cd /var/www/html/kmis/mis/etislat/

echo "Start `date` " > insertDailyReportEtisalat.txt
/usr/bin/php /var/www/html/kmis/mis/etislat/insertDailyReportEtisalat.php & 

echo "End  `date` " >> insertDailyReportEtisalat.txt