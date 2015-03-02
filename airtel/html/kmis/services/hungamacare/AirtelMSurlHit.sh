#!/bin/sh
#Shell Script for event charging

cd /var/www/html/kmis/services/hungamacare/

echo "Start `date` " > AirtelMSurlHit.txt
/usr/bin/php /var/www/html/kmis/services/hungamacare/AirtelMSurlHit.php & 
echo "End  `date` " >> AirtelMSurlHit.txt
