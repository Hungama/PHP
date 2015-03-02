#!/bin/sh
#Shell Script for Etislat MIS

cd /var/www/html/kmis/mis/etislat/

echo "Start `date` " > insertEtislatdailyMIS.txt
/usr/bin/php /var/www/html/kmis/mis/etislat/insertEtislatdailyMIS.php & 
sleep 100
/usr/bin/php /var/www/html/kmis/mis/BSNL/insertBSNLdailyMIS.php & 

echo "End  `date` " >> insertEtislatdailyMIS.txt