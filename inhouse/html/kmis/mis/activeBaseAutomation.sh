#!/bin/sh
#Shell Script fro Music Renewal

cd /var/www/html/kmis/mis/

echo "Start `date` " >> /var/www/html/kmis/mis/automation_report_status.txt

/usr/bin/php /var/www/html/kmis/mis/ActivebaseDocomo.php &
sleep 120
/usr/bin/php /var/www/html/kmis/mis/PendingbaseDocomo.php &
sleep 150
/usr/bin/php /var/www/html/kmis/mis/ActivebaseUninor.php &
sleep 200
/usr/bin/php /var/www/html/kmis/mis/PendingbaseUninor.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/ActivebaseAirtel.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/PendingbaseAirtel.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/ActivebaseVoda.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/ActivebaseMTS.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/Activebasevmi.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/ActivebaseIndicom.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/ActivebaseReliance.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/ActivebaseDIGI.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/ActivebaseTunetalk.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/ActivebaseBSNL.php &
sleep 250
/usr/bin/php /var/www/html/kmis/mis/PendingbaseBSNL.php &
#script to update ad campgion count
/usr/bin/php  /var/www/html/kmis/mis/addashboard/insert_ad_report.php
#sleep 10
#/usr/bin/php /var/www/html/kmis/mis/ActivebaseTiscon.php &
#Macdowels active base
#/usr/bin/php /var/www/html/kmis/mis/ActivebaseMCD.php &
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/mis/MCD_dedication_RechargeData/dedication_missedcallMCDMIS.php & 
sleep 10
#GSK active base
/usr/bin/php /var/www/html/kmis/mis/ActivebaseGSK.php &
sleep 10
/usr/bin/php /var/www/html/kmis/services/hungamacare/EngagemnentBox/new_engagement/insert_tiscon_callog.php &
#For WAP LDR Subscription base
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/airtel/airtelwapSubscriberMIS.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/uninor/uninorwapSubscriberMIS.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/tata/tatawapSubscriberMIS.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/tata/tatawapBillingMIS.php &
sleep 100
# added for billing team process
/usr/bin/php /var/www/html/kmis/mis/smsUssdDataUninor.php &

#/usr/bin/php /var/www/html/kmis/mis/ActivePendingBaseEtisalat.php &
#/usr/bin/php /var/www/html/kmis/services/hungamacare/smsDashboardHistory.php &
#/usr/bin/php /var/www/html/kmis/services/hungamacare/smsdashboard/insertsmsDashboardHistory.php &

echo "End  `date` " >> /var/www/html/kmis/mis/report_status.txt


