#!/bin/sh
#Shell Script for Bulk SMS
# stopped for block out day start here
cd /var/www/html/hungamacare/
echo "Stopped Start `date` " > sendSMS.txt
/usr/bin/php /var/www/html/hungamacare/sendSMS_voda.php & 
echo "Stopped End  `date` " >> sendSMS.txt
# stopped for block out day start here
