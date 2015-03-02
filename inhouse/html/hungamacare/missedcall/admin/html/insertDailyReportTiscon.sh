#!/bin/sh
#Shell Script for TATA TISCON Mis
cd /var/www/html/hungamacare/missedcall/admin/html/
echo "Start `date` " >> reportStatusTiscon.txt
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertTataTiscondailyReport.php & 
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertMCDdailyReport.php & 
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertMCDPromodailyReport.php & 
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertGSKdailyReport_NIGERA.php & 
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertGSKdailyReport_Kenya.php & 
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertGSKdailyReport_Ghana.php & 
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/insertGSKdailyReport_Africa.php & 
sleep 10
#dedication & Recharge data insertion- Mcdowles
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/mis/MCD_dedication_RechargeData/dedication_RechargeMCDMIS.php & 
#sleep 10
#/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/mis/MCD_dedication_RechargeData/dedication_missedcallMCDMIS.php & 
echo "End  `date` " >> reportStatusTiscon.txt