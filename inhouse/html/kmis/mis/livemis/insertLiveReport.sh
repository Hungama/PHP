#!/bin/sh
#Shell Script for insertAllCalllog

cd /var/www/html/kmis/mis/livemis/

echo "Start `date` " > insertDailyReportLiveAllOther.txt
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertDailyReportLiveAllMTS.php & 
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertDailyMTSCallLogLive.php &
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertDailyReportLiveAllVoda.php & 
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertDailyVodaCallLogLive.php & 
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertDailyReportLiveAllAirtel.php & 
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertDailyAirtelCallLogLive.php & 

echo "End  `date` " >> insertDailyReportLiveAllOther.txt
