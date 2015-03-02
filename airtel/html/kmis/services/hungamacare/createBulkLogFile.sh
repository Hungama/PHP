#!/bin/sh
#Shell Script for create log file for Airtel bulk upload

cd /var/www/html/kmis/services/hungamacare/

echo "Start `date` " > createBulkLogFile.txt

/usr/bin/php /var/www/html/kmis/services/hungamacare/createBulkLogFile.php & 

echo "End  `date` " >> createBulkLogFile.txt
