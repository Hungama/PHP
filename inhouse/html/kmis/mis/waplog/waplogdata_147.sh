#!/bin/bash
cd /var/www/html/kmis/mis/waplog/
#added for copy tar file from VM server
sh /var/www/html/kmis/mis/livemis/mis2.0/wap/ALL_WAP_LOGS_108/Wap_ldr_log_final.sh
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147.php &
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_ccgUninorWAP.php &
sleep 20
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_117_ccgUninorWAP.php &
#(stopped)
#/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_ccgvisitorlogsTata.php &
#sleep 5
#(stopped)
#/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_ccgVodaWAP.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_ccgAirtelWAP.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_ccgResponseAirtelWAP.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_ccgAircellWAP.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_vodaWapDownload.php &
sleep 5
#BSNL
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_ccgvisitorlogsBSNL.php &
sleep 5
#AircelStoreOne
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_ccgAircelStore1WAP.php &
sleep 5
#Airtel LDR Browsing data(stopped)
#/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/airtel/airtelwapBrowsingMIS.php &
sleep 10
#Uninor LDR Browsing data(stopped)
#/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/uninor/uninorwapBrowsingMIS.php &
sleep 10
#Aircel Browsing Data
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/aircel/livewaplogsAircel.php &
sleep 20
## PHP Team Script ##
sh /var/www/html/kmis/mis/waplog/waplogdata_uninor.sh
####