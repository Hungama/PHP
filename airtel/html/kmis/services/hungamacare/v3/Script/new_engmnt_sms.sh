#!/bin/sh
#Shell Script for Engagement Log
cd /var/www/html/kmis/services/hungamacare/v3/Script
echo "Start `date` " > /var/www/html/kmis/services/hungamacare/v3/Script/automation_report_status_sms.txt
/usr/bin/php /var/www/html/kmis/services/hungamacare/v3/Script/getRuleForProcess.php &
sleep 15
/usr/bin/php /var/www/html/kmis/services/hungamacare/v3/Script/cron.php &
echo "done"
echo "Stopped End  `date` " >> /var/www/html/kmis/services/hungamacare/v3/Script/automation_report_status_sms.txt
