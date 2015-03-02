#!/bin/bash
cd /var/www/html/kmis/mis/waplog/
#/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_live.php &
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_ccgUninorWAP.php &
sleep 20
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_ccgvisitorlogsTata.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_ccgVodaWAP.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_ccgAirtelWAP.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_ccgResponseAirtelWAP.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_ccgAircellWAP.php &
sleep 5
#BSNL
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_ccgvisitorlogsBSNL.php &
sleep 5
#AircelStoreOne
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_147_ccgAircelStore1WAP.php &
sleep 5
#Airtel LDR Browsing data
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/airtel/airtelwapBrowsingMIS.php &
sleep 20
## PHP Team Script ##