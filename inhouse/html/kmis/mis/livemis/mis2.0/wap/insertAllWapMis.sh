#!/bin/sh
#Shell Script for insertAllWapMis
cd /var/www/html/kmis/mis/livemis/mis2.0/wap/
echo "Start `date` " >> /var/www/html/kmis/mis/livemis/mis2.0/wap/insertAllWapMis.txt
#/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/aircel/aircelwapBrowsingMIS.php &
#sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/tata/tatawapBrowsingMIS.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/voda/vodawapBrowsingMIS.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/airtel/airtelwapBrowsingMIS.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/uninorBrowsingMIS/uninorwapBrowsingMIS.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/uninor/uninorwapBrowsingMIS.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/airtel/update_affid_DataReco.php
sleep 5
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/idea/ideawapBrowsingMIS.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/waplog/insertdailyWAP_S2SReport.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/emailalert/alert_mailWapData.php &
echo "End  `date` " >> /var/www/html/kmis/mis/livemis/insertAllWapMis.txt