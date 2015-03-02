#!/bin/sh
#Shell Script for send bulk sms

cd /var/www/html/kmis/services/hungamacare/
echo "Start `date` " > sendSMS.txt
# stopped for block out day start here
/usr/bin/php /var/www/html/kmis/services/hungamacare/sendSMS.php & 
# stopped for block out day end here
echo "Stopped End  `date` " >> sendSMS.txt
## PHP Team Script didi not make any chages on blackout day##
#sh /var/www/html/kmis/services/hungamacare/updateBulkCount.sh
####
