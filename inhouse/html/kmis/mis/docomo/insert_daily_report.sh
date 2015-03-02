#!/bin/sh
#Shell Script fro Music Renewal

cd /var/www/html/kmis/mis/docomo/

echo "Start `date` " > report_status.txt

/usr/bin/php /var/www/html/kmis/mis/docomo/insert_daily_report.php &
sleep 300
/usr/bin/php /var/www/html/kmis/mis/docomo/insertDailyReportVirm.php &
sleep 300
/usr/bin/php /var/www/html/kmis/mis/docomo/insertDailyReportIndicom.php &


echo "End  `date` " >> report_status.txt

#########################VODA_BILLING_LOGS####################VIKAS
sh /home/Scripts/LOGS_SHARING/securecopy_VODA.sh
