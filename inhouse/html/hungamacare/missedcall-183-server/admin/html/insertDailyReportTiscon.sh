#!/bin/sh
#Shell Script for TATA TISCON Mis
cd /var/www/html/hungamacare/missedcall/admin/html/
echo "Start `date` " >> reportStatusTiscon.txt
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertTataTiscondailyReport.php & 
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertMCDdailyReport.php & 
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertGSKdailyReport_NIGERA.php & 
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertGSKdailyReport_Kenya.php & 
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertGSKdailyReport_Ghana.php & 
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertGSKdailyReport_Africa.php & 
echo "End  `date` " >> reportStatusTiscon.txt