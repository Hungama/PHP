#!/bin/sh
#Shell Script for Indicom bulk upload

cd /var/www/html/hungamacare/

echo "Start `date` " > processbilling.txt

/usr/bin/php /var/www/html/hungamacare/processbilling.php & 
/usr/bin/php /var/www/html/hungamacare/processbilling_topup.php & 
/usr/bin/php /var/www/html/billing_api/getBalance/getBalProcess.php &

echo "End  `date` " >> processbilling.txt