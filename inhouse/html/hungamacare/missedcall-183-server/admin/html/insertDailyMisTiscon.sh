#!/bin/sh
#Shell Script for TATA TISCON Mis
cd /var/www/html/hungamacare/missedcall/admin/html/
echo "Start `date` " >> reportStatusMISTiscon.txt
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertTiscondailyMIS.php & 
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertMCDDailyMIS.php & 
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertGSKDailyMIS_NIGERA.php & 
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertGSKDailyMIS_KENYA.php & 
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertGSKDailyMIS_GHANA.php & 
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertGSKDailyMIS_AFRICA.php & 
echo "End  `date` " >> reportStatusMISTiscon.txt