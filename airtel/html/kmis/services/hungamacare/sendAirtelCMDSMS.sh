#!/bin/sh
#Shell Script for send schedule message for Airtel Comdey
cd /var/www/html/kmis/services/hungamacare/
echo "Start `date` " > sendAirtelCMDSMS.txt
/usr/bin/php /var/www/html/kmis/services/hungamacare/sendAirtelCMDSMS.php & 
echo "Stopped End  `date` " >> sendAirtelCMDSMS.txt
