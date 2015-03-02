#!/bin/sh
#Shell Script for insert DIGI DAILY MIS

cd /var/www/html/digi/

echo "Start `date` " > insertDigiLiveMIS.txt
/usr/bin/php /var/www/html/digi/insertDigiLiveMIS.php & 
/usr/bin/php /var/www/html/digi/insertDigiLiveMISCallLogs.php & 

echo "End  `date` " >> insertDigiLiveMIS.txt