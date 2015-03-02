#!/bin/sh
#Shell Script for event charging

cd /var/www/html/hungamacare/

echo "Start `date` " > MtsMSurlHit.txt
/usr/bin/php /var/www/html/hungamacare/MtsMSurlHit.php & 
echo "End  `date` " >> MtsMSurlHit.txt
