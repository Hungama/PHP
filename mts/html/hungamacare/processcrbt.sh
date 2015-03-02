#!/bin/sh
#Shell Script for Indicom bulk upload

cd /var/www/html/hungamacare/

echo "Start `date` " > ProcessCrbt.txt

/usr/bin/php /var/www/html/hungamacare/ProcessCrbt.php & 

echo "End  `date` " >> ProcessCrbt.txt