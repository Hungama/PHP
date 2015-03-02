#!/bin/sh
#Shell Script for event charging

cd /var/www/html/hungamacare/

echo "Start `date` " > VodaMSurlHit.txt
/usr/bin/php /var/www/html/hungamacare/VodaMSurlHit.php & 
echo "End  `date` " >> VodaMSurlHit.txt
