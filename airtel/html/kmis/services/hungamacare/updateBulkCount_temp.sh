#!/bin/sh
#Shell Script for Airtel Bulk Count

cd /var/www/html/kmis/services/hungamacare/

echo "Start `date` " > updateBulkCount.txt

/usr/bin/php /var/www/html/kmis/services/hungamacare/updateBulkCount.php & 

echo "End  `date` " >> updateBulkCount.txt
