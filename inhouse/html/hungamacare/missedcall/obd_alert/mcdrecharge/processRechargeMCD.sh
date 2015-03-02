#!/bin/sh
#Shell Script for send bulk SMS
echo "Start Start `date` " > process.txt
# Recharge Process MCdowles (Stopped due to operator mismatch)
#/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/mcdrecharge/mcdRecharge_process.php & 
sleep 10
#/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/mcdrecharge/updateStatus_Txid.php & 
sleep 10
# SMS Bulk Promotion on MCD
/usr/bin/php /var/www/html/kmis/services/hungamacare/processEntPromotionSMSFiles.php & 
sleep 10
# MISSED CALL Bulk Promotion on MCD
/usr/bin/php /var/www/html/kmis/services/hungamacare/processEntPromotionMISSEDCALLFiles.php & 
echo "End  `date` " >> process.txt
