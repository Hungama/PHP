#!/bin/sh
#Shell Script for insertDailyAirtelMIS

start="##START: `date` ##"
end="##END: `date` ##"
log1="/home/Scripts/script_logs/insertAirteldailyMIS.log"
log2="/home/Scripts/script_logs/insertAirteldailyMISCallLogs.log"
log3="/home/Scripts/script_logs/insertDocomodailyMIS.log"
log4="/home/Scripts/script_logs/insertDocomodailyMISCallLogs.log"
log5="/home/Scripts/script_logs/insertUninordailyMIS.log"
log6="/home/Scripts/script_logs/insertUninordailyMISCallLogs.log"
log7="/home/Scripts/script_logs/insertMTSdailyMIS.log"
log8="/home/Scripts/script_logs/insertDailyMTSCallLogLive.log"

cd /var/www/html/kmis/mis/livemis/

echo -e "$start" >> $log1 
/usr/bin/php /var/www/html/kmis/mis/livemis/insertAirteldailyMIS.php >> /home/Scripts/script_logs/insertAirteldailyMIS.log &
echo -e "$end\n" >> $log1

echo -e "$start" >> $log2
/usr/bin/php /var/www/html/kmis/mis/livemis/insertAirteldailyMISCallLogs.php >> /home/Scripts/script_logs/insertAirteldailyMISCallLogs.log &
echo -e "$end\n" >> $log2

echo -e "$start" >> $log3
/usr/bin/php /var/www/html/kmis/mis/livemis/insertDocomodailyMIS.php >> /home/Scripts/script_logs/insertDocomodailyMIS.log & 
echo -e "$end\n" >> $log3

echo -e "$start" >> $log4
/usr/bin/php /var/www/html/kmis/mis/livemis/insertDocomodailyMISCallLogs.php >> /home/Scripts/script_logs/insertDocomodailyMISCallLogs.log &
echo -e "$end\n" >> $log4

echo -e "$start" >> $log5
/usr/bin/php /var/www/html/kmis/mis/livemis/insertUninordailyMIS.php >> /home/Scripts/script_logs/insertUninordailyMIS.log &
echo -e "$end\n" >> $log5

echo -e "$start" >> $log6
/usr/bin/php /var/www/html/kmis/mis/livemis/insertUninordailyMISCallLogs.php >> /home/Scripts/script_logs/insertUninordailyMISCallLogs.log &
echo -e "$end\n" >> $log6

echo -e "$start" >> $log7
/usr/bin/php /var/www/html/kmis/mis/livemis/insertMTSdailyMIS.php >> /home/Scripts/script_logs/insertMTSdailyMIS.log &
echo -e "$end\n" >> $log7

echo -e "$start" >> $log8
/usr/bin/php /var/www/html/kmis/mis/livemis/insertDailyMTSCallLogLive.php >> /home/Scripts/script_logs/insertDailyMTSCallLogLive.log &
echo -e "$end\n" >> $log8
