#!/bin/sh
#Shell Script for send schedule message for Airtel All service to pending base
cd /var/www/html/kmis/services/hungamacare/
echo "Start `date` " > sendAirtelPendingSMS.txt
/usr/bin/php /var/www/html/kmis/services/hungamacare/sendAirtelPendingSMS.php & 
echo "Stopped End  `date` " >> sendAirtelPendingSMS.txt
