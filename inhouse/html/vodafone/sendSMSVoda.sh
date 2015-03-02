#!/bin/sh
#Shell Script for Processing Billilng

cd /var/www/html/vodafone/

echo "Start `date` " >> /home/Scripts/script_logs/sendSMS.log
/usr/bin/php /var/www/html/vodafone/sendSMSVoda.php & 
echo "End  `date` " >> /home/Scripts/script_logs/sendSMS.log
