#!/bin/sh
cd /var/www/html/hungamacare/all/temp
echo "Start `date` " > process1.txt
/usr/bin/php /var/www/html/hungamacare/all/temp/bulkload_rahul.php & 
echo "End  `date` " >> process1.txt
