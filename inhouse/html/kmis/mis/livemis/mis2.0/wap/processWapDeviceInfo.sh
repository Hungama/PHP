#!/bin/sh
#Shell Script for processWapDeviceInfo.sh
cd /var/www/html/kmis/mis/livemis/mis2.0/wap/
echo "Start `date` " >> /var/www/html/kmis/mis/livemis/mis2.0/wap/processWapDeviceInfo.txt
#/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/aircel/updateDeviceinfo.php &
#sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/tata/updateDeviceinfo.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/voda/updateDeviceinfo.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/airtel/updateDeviceinfo.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/uninorBrowsingMIS/updateDeviceinfo.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/idea/updateDeviceinfo.php &
echo "End  `date` " >> /var/www/html/kmis/mis/livemis/processWapDeviceInfo.txt