#!/bin/sh
cd /var/www/html/hungamacare/all/temp
echo "Start `date` " > process.txt
#/usr/bin/php /var/www/html/hungamacare/all/temp/bulkload.php & 
sleep 4
#/usr/bin/php /var/www/html/hungamacare/all/temp/bulkload2.php & 
sleep 4
/usr/bin/php /var/www/html/hungamacare/all/temp/bulkload3.php & 
sleep 4
/usr/bin/php /var/www/html/hungamacare/all/temp/bulkload4.php & 
echo "End  `date` " >> process.txt