#!/bin/sh
#Shell Script for Engagement Log
# stopped for block out day start here
cd /var/www/html/kmis/services/hungamacare/sms_engmnt
echo "Start `date` " > /var/www/html/kmis/services/hungamacare/sms_engmnt/sms_engmnt.txt
/usr/bin/php /var/www/html/kmis/services/hungamacare/sms_engmnt/sms_engagementlog_noCall_airtelmnd.php &
echo "done"
echo "Stopped End  `date` " >> /var/www/html/kmis/services/hungamacare/sms_engmnt/sms_engmnt.txt
# stopped for block out day end here
