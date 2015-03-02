#!/bin/sh
#Shell Script for insertDailyReportBNB
cd /var/www/html/hungamacare/BNB/
echo "Start at `date` " > insertDailyReportBNB.txt
/usr/bin/php /var/www/html/hungamacare/BNB/insert_bnb_contestinfo.php &
sleep 50
/usr/bin/php /var/www/html/hungamacare/BNB/insert_bnb_smsReport.php & 
echo "End at `date` " >> insertDailyReportBNB.txt
