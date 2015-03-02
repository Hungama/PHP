#!/bin/sh
#Shell Script for Engagement Log

cd /var/www/html/hungamacare/v3/new_engagement

echo "Start `date` " >> /var/www/html/hungamacare/v3/new_engagement/automation_report_status_data.txt

/usr/bin/php /var/www/html/hungamacare/v3/new_engagement/new_engagementlog_MOU.php &
sleep 15m

/usr/bin/php /var/www/html/hungamacare/v3/new_engagement/new_engagementlog_Call.php &
sleep 15m

/usr/bin/php /var/www/html/hungamacare/v3/new_engagement/new_engagementlog_noCall.php &
sleep 15m

/usr/bin/php /var/www/html/hungamacare/v3/new_engagement/new_engagementlog_ageOfservice.php &
sleep 15m

/usr/bin/php /var/www/html/hungamacare/v3/new_engagement/new_engagementlog_crbtDwnld.php &
sleep 15m

/usr/bin/php /var/www/html/hungamacare/v3/new_engagement/new_engagementlog_nonCrbtDwnld.php &
sleep 15m

echo "done"
echo "End  `date` " >> /var/www/html/hungamacare/v3/new_engagement/report_status_data.txt


