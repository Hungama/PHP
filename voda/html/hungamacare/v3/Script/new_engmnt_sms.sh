#!/bin/sh
#Shell Script for Engagement Log
# stopped for block out day start here
cd /var/www/html/hungamacare/v3/Script
echo "Stopped Start `date` " > /var/www/html/hungamacare/v3/Script/automation_report_status_sms.txt
/usr/bin/php /var/www/html/hungamacare/v3/Script/getSmsEmailRuleForProcess.php &
sleep 15
/usr/bin/php /var/www/html/hungamacare/v3/Script/cron.php &
echo "done"
echo "Stopped End  `date` " >> /var/www/html/hungamacare/v3/Script/automation_report_status_sms.txt
# stopped for block out day end here
