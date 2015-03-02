#!/bin/sh
#Shell Script for Uninor KIJI Top 3 winner Recharge

cd /var/www/html/hungamacare/summercontest/uninor/

echo "Start `date` " >> /var/www/html/hungamacare/summercontest/uninor/report_status.txt

/usr/bin/php /var/www/html/hungamacare/summercontest/uninor/getAllWinner_uninor.php &
sleep 50
/usr/bin/php /var/www/html/hungamacare/summercontest/uninor/uninorContestRecharge_process.php &
#sleep 250
#/usr/bin/php /var/www/html/hungamacare/summercontest/uninor/mail.php &
sleep 50
/usr/bin/php /var/www/html/hungamacare/summercontest/mts/getAllWinner_mts.php &
sleep 50
/usr/bin/php /var/www/html/hungamacare/summercontest/mts/mtsContestRecharge_process.php &
sleep 50
/usr/bin/php /var/www/html/hungamacare/summercontest/mts/mail.php &
sleep 1300
/usr/bin/php /var/www/html/hungamacare/summercontest/uninor/updateStatus.php &
sleep 50
/usr/bin/php /var/www/html/hungamacare/summercontest/uninor/mail.php &

echo "End `date` " >> /var/www/html/hungamacare/summercontest/uninor/report_status.txt