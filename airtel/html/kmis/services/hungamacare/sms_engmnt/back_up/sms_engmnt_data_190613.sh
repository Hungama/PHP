#!/bin/sh
#Shell Script for Engagement Log

cd /var/www/html/kmis/services/hungamacare/sms_engmnt

echo "Start `date` " >> /var/www/html/kmis/services/hungamacare/sms_engmnt/automation_report_status_data.txt

/usr/bin/php /var/www/html/kmis/services/hungamacare/sms_engmnt/sms_engagementSendSms.php &
sleep 15m

/usr/bin/php /var/www/html/kmis/services/hungamacare/sms_engmnt/sms_engagementdata.php &
sleep 15m

/usr/bin/php /var/www/html/kmis/services/hungamacare/sms_engmnt/createSmsEngagementDwnFile.php &

echo "done"
echo "End  `date` " >> /var/www/html/kmis/services/hungamacare/sms_engmnt/report_status_data.txt


