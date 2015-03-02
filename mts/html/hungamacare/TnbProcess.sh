#!/bin/sh
#Shell Script for Indicom Mis

cd /var/www/html/hungamacare/

echo "Start `date` " > TnbProcess.txt

/usr/bin/php /var/www/html/hungamacare/TnbProcess.php & 

echo "End  `date` " >> TnbProcess.txt
