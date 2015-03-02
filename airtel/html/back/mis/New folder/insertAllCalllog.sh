#!/bin/sh
#Shell Script for insertAllCalllog

cd /var/www/html/kmis/services/hungamacare/

echo "Start `date` " > insertAllCalllog.txt
/usr/bin/php /var/www/html/back/mis/insertAllCalllog.php & 
echo "End  `date` " >> insertAllCalllog.txt