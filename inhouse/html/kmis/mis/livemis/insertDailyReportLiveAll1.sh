#!/bin/sh
#Shell Script for insertAllCalllogLive

cd /var/www/html/kmis/mis/livemis/

echo "Start at `date` " >> insertDailyReportLiveAll1.txt
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertDailyReportLiveAll1.php & 
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/inhouse/insertDailyReportLiveAll_Tata.php &
sleep 1
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/inhouse/insertDailyReportLiveAll_Uninor.php &
sleep 1
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/inhouse/insertDailyReportLiveAll_Reliance.php &
/usr/bin/php /var/www/html/kmis/mis/livemis/EtisalatLiveMIS.php &
/usr/bin/php /var/www/html/kmis/mis/livemis/insertCNSDailyReportLiveAll1.php & 
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertLiveRelianceMIS.php & 
echo "Before Call live End at `date` " >> insertDailyReportLiveAll1.txt
sleep 10
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertDailyReportCallLive.php &
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/inhouse/insertDailyReportCallLive_Tata.php &
sleep 2
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/inhouse/insertDailyReportCallLive_Uninor.php &
sleep 2
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/inhouse/insertDailyReportCallLive_Reliance.php &

sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/mts/insertDailyReportLiveAll_Mts.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/mts/insertDailyReportCallLive_Mts.php &
echo "End at `date` " >> insertDailyReportLiveAll1.txt
