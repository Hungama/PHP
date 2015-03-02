#!/bin/sh
#Shell Script fro Music Renewal

cd /var/www/html/kmis/mis/

echo "Start `date` " > check147.txt

/usr/bin/php /var/www/html/kmis/mis/check_147.php & 

echo "End  `date` " >> check147.txt