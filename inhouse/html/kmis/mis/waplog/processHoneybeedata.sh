#!/bin/bash
#Process honeybee rt selection data support
cd /var/www/html/kmis/mis/waplog/
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_aircel_honeyBeeModule_step1.php &
sleep 300
/usr/bin/php /var/www/html/kmis/mis/waplog/core-device/detect-device/detect-process/aircel_honeyBeeModule_step2.php &
