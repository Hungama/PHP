#!/bin/sh
#Shell Script fro Music Renewal

cd /var/www/html/kmis/mis/

echo "Start `date` " >> /var/www/html/kmis/mis/automation_report_status.txt

/usr/bin/php /var/www/html/kmis/mis/ActivebaseDocomo.php &
sleep 120
/usr/bin/php /var/www/html/kmis/mis/PendingbaseDocomo.php &
sleep 150
/usr/bin/php /var/www/html/kmis/mis/ActivebaseUninor.php &
sleep 200
/usr/bin/php /var/www/html/kmis/mis/PendingbaseUninor.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/ActivebaseAirtel.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/PendingbaseAirtel.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/ActivebaseVoda.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/ActivebaseMTS.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/Activebasevmi.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/ActivebaseIndicom.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/ActivebaseReliance.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/ActivebaseDIGI.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/ActivebaseTunetalk.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/ActivePendingBaseEtisalat.php &
sleep 250
#/usr/bin/php /var/www/html/kmis/services/hungamacare/smsDashboardHistory.php &
#/usr/bin/php /var/www/html/kmis/services/hungamacare/smsdashboard/insertsmsDashboardHistory.php &

echo "End  `date` " >> /var/www/html/kmis/mis/report_status.txt


