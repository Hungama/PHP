#!/bin/sh
#Shell Script for insertAllWapCallLogs
cd /var/www/html/kmis/mis/livemis/mis2.0/wap/
echo "Start `date` " >> /var/www/html/kmis/mis/livemis/mis2.0/wap/insertAllWapCallLogs.txt
#/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/aircel/livewaplogsAircel.php &
#sleep 5
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/tata/livewaplogstata.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/voda/livewaplogsvoda.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/airtel/livewaplogsairtel.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/uninorBrowsingMIS/livewaplogsuninor.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/idea/livewaplogsidea.php &
echo "End  `date` " >> /var/www/html/kmis/mis/livemis/insertAllWapCallLogs.txt