#!/bin/sh
#Shell Script fro Music Renewal

cd /var/www/html/kmis/mis/

echo "Start `date` " >> /var/www/html/kmis/mis/automation_report_status.txt


/usr/bin/php /var/www/html/kmis/mis/ActivePendingBaseEtisalat.php &

echo "End  `date` " >> /var/www/html/kmis/mis/report_status.txt


