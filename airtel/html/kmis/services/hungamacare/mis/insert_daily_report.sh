#!/bin/sh
#Shell Script fro Airtel Services

cd /var/www/html/kmis/services/hungamacare/mis/

echo "Start `date` " > report_status.txt

/usr/bin/php /var/www/html/kmis/services/hungamacare/mis/insert_daily_report.php & 

echo "End  `date` " >> report_status.txt
