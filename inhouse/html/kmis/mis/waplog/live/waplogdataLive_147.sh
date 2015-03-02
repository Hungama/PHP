#!/bin/bash
cd /var/www/html/kmis/mis/waplog/
echo "Start `date` " >> /var/www/html/kmis/mis/waplog/logs.txt
/usr/bin/php /var/www/html/kmis/mis/waplog/live/getdata_147_ccgAircelStore1WAP_live.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/waplog/live/getdata_147_ccgUninorWAP_live.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/waplog/live/getdata_147_ccgResponseAirtelWAP_live.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/waplog/live/getdata_147_ccgAircellWAP_live.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/waplog/live/getdata_147_ccgAirtelWAP_live.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/waplog/live/getdata_147_ccgvisitorlogsBSNL_live.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/waplog/live/getdata_147_ccgvisitorlogsTata_live.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/waplog/live/getdata_147_ccgVodaWAP_live.php &
echo "End  `date` " >> /var/www/html/kmis/mis/waplog/logs.txt