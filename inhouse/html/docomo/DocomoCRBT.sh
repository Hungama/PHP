#!/bin/sh
#Shell Script for docomo CRBT

cd /var/www/html/docomo/

echo "Start `date` " > docomoCRBT.txt

/usr/bin/php /var/www/html/docomo/docomoCRBT.php & 

echo "End  `date` " >> docomoCRBT.txt