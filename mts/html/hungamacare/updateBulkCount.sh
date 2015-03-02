#!/bin/sh
#Shell Script for Indicom Mis

cd /var/www/html/hungamacare/

echo "Start `date` " > updateBulkCount.txt

/usr/bin/php /var/www/html/hungamacare/updateBulkCount.php & 

echo "End  `date` " >> updateBulkCount.txt
