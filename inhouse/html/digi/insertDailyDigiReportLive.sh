#!/bin/sh
#Shell Script for insert DIGI Live MIS

cd /var/www/html/digi/

echo "Start `date` " > insertDailyDigiReportLive1.txt
#/usr/bin/php /var/www/html/digi/insertDailyReportLiveAll1.php & 
#/usr/bin/php /var/www/html/digi/insertLiveCallLogDigi.php & 
#/usr/bin/php /var/www/html/digi/insertLiveCallLogDigi_backtime.php &
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/digi/insertDailyReportLiveAll_Digi.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/digi/insertDailyReportCallLive_Digi.php &
echo "End  `date` " >> insertDailyDigiReportLive1.txt