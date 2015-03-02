#!/bin/sh
#Shell Script to find failure subscriptions 

cd /var/www/html/kmis/services/hungamacare/

echo "Start `date` " > report_status.txt

/usr/bin/php /var/www/html/kmis/services/hungamacare/updatebulksummary.php & 

echo "End  `date` " >> report_status.txt