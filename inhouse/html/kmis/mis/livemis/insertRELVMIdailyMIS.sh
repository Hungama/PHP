#!/bin/sh
#Shell Script for insertRELVMIdailyMIS

start="##START: `date` ##"
end="##END: `date` ##"
log1="/home/Scripts/script_logs/insertRELCdailyMIS.log"
log2="/home/Scripts/script_logs/insertRELCdailyMISCallLogs.log"
log3="/home/Scripts/script_logs/insertVMIdailyMIS.log"
log4="/home/Scripts/script_logs/insertVMIdailyMISCallLogs.log"

cd /var/www/html/kmis/mis/livemis/

echo -e "$start" >> $log1 
/usr/bin/php /var/www/html/kmis/mis/livemis/insertAirteldailyMIS.php >> /home/Scripts/script_logs/insertRELCdailyMIS.log &
echo -e "$end\n" >> $log1

echo -e "$start" >> $log2
/usr/bin/php /var/www/html/kmis/mis/livemis/insertAirteldailyMISCallLogs.php >> /home/Scripts/script_logs/insertRELCdailyMISCallLogs.log &
echo -e "$end\n" >> $log2

echo -e "$start" >> $log3
/usr/bin/php /var/www/html/kmis/mis/livemis/insertDocomodailyMIS.php >> /home/Scripts/script_logs/insertVMIdailyMIS.log & 
echo -e "$end\n" >> $log3

echo -e "$start" >> $log4
/usr/bin/php /var/www/html/kmis/mis/livemis/insertDocomodailyMISCallLogs.php >> /home/Scripts/script_logs/insertVMIdailyMISCallLogs.log &
echo -e "$end\n" >> $log4
