#!/bin/sh
#Shell Script fro mahindraMIS

cd /var/www/html/kmis/mis/

echo "Start `date` " > mahindraMIS.txt

/usr/bin/php /var/www/html/kmis/mis/mahindraMIS.php &

echo "End  `date` " >> mahindraMIS.txt

####
