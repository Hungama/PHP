#!/bin/sh
#Shell Script for create MTS bulk upload

cd /var/www/html/hungamacare/

echo "Start `date` " > createBulkLogFile.txt

/usr/bin/php /var/www/html/hungamacare/createBulkLogFile.php & 

echo "End  `date` " >> createBulkLogFile.txt
