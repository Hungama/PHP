#!/bin/sh
#Shell Script for Processing Billilng

cd /var/www/html/hungamacare/

echo "Start `date` " > status.txt
/usr/bin/php /var/www/html/hungamacare/updateBulkCount.php &
echo "End  `date` " >> status.txt
~
