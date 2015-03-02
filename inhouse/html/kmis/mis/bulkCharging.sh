#!/bin/sh
#Shell Script fro Music Renewal

cd /var/www/html/kmis/mis/

echo "Start `date` " > bulkCharging.txt

/usr/bin/php /var/www/html/kmis/mis/bulkCharging.php & 

echo "End  `date` " >> bulkCharging.txt
