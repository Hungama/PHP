#!/bin/sh
#Shell Script for Processing Billilng

cd /var/www/html/kmis/services/hungamacare/

echo "Start `date` " > status.txt
/usr/bin/php /var/www/html/hungamacare/processbilling.php & 
echo "End  `date` " >> status.txt