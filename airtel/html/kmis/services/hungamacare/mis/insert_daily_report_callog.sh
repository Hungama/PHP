#!/bin/sh
#Shell Script for Airtel Callog Services

cd /var/www/html/kmis/services/hungamacare/mis/

echo "Start `date` " > report_status_callog.txt

/usr/bin/php /var/www/html/kmis/services/hungamacare/mis/insert_daily_report_calllog.php & 

echo "End  `date` " >> report_status_callog.txt
