#!/bin/sh
#Shell Script for Recharging
cd /var/www/html/Recharge/
echo "Start `date` " > recharge.txt
#stopped due to insufficeint balance in mobikwik account
/usr/bin/php /var/www/html/Recharge/Recharge.php & 
echo "End  `date` " >> recharge.txt
