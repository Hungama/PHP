#!/bin/sh
#Shell Script for HNY Data (at 8:00 AM)
cd /var/www/html/hungamacare/missedcall/obd_alert/data/
echo "Start `date` " >> /var/www/html/hungamacare/missedcall/obd_alert/data/report_status.txt
/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/data/mail.php &
echo "End `date` " >> /var/www/html/hungamacare/missedcall/obd_alert/data/report_status.txt
