#!/bin/sh
#Shell Script for MTS winner Recharge (at 6:00 AM)
echo "Start `date` " >> /var/www/html/hungamacare/summercontest/uninor/report_status.txt
/usr/bin/php /var/www/html/hungamacare/summercontest/uninor/updateStatus_new.php &
sleep 10
/usr/bin/php /var/www/html/hungamacare/summercontest/mts/updateStatus.php &
sleep 2
/usr/bin/php /var/www/html/hungamacare/summercontest/AirltailLdr/updateStatus_Txid.php &
sleep 2
/usr/bin/php /var/www/html/hungamacare/summercontest/uninorcricket/updateStatus_Txid.php &
sleep 2
/usr/bin/php /var/www/html/hungamacare/summercontest/uninor54646/updateStatus_Txid.php &
echo "End `date` " >> /var/www/html/hungamacare/summercontest/uninor/report_status.txt