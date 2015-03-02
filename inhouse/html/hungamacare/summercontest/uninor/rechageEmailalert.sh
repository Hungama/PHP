#!/bin/sh
#Shell Script for MTS winner Recharge (at 8:00 AM)
cd /var/www/html/hungamacare/summercontest/uninor/
echo "Start `date` " >> /var/www/html/hungamacare/summercontest/uninor/report_status.txt
/usr/bin/php /var/www/html/hungamacare/summercontest/uninor/updateStatus_new.php &
sleep 20
/usr/bin/php /var/www/html/hungamacare/summercontest/uninor/mail_new.php &
sleep 10
/usr/bin/php /var/www/html/hungamacare/summercontest/mts/updateStatus.php &
sleep 10
/usr/bin/php /var/www/html/hungamacare/summercontest/mts/mail.php &
sleep 2
/usr/bin/php /var/www/html/hungamacare/summercontest/AirltailLdr/updateStatus_Txid.php &
sleep 10
/usr/bin/php /var/www/html/hungamacare/summercontest/AirltailLdr/mail.php &
sleep 5
/usr/bin/php /var/www/html/hungamacare/summercontest/uninorcricket/mail.php &
sleep 5
/usr/bin/php /var/www/html/hungamacare/summercontest/uninor54646/mail.php &
#/usr/bin/php /var/www/html/hungamacare/summercontest/worldMusicDayRecharge/mts/mail.php &
#sleep 10
#/usr/bin/php /var/www/html/hungamacare/summercontest/worldMusicDayRecharge/voda/mail.php &
# To send FIFA Active Base Email ALert
#/usr/bin/php /var/www/html/hungamacare/summercontest/uninor/fifa/mail.php &
# To send Mcdowles Promotional OBD Base Email ALert
/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/mcwdataAlert/mail_MCD.php &
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/mcwdataAlert/mailGSK.php &
sleep 10
#/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/mcwdataAlert/mailCinthol.php &

#added for Wap log/afflicated id count on email
/usr/bin/php /var/www/html/kmis/mis/waplog/sendreportAll.php &
#added for update device info for WAP LDR
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/airtel/airtelwapBrowsingMIS_deviceinfo.php &
sleep 5
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/uninor/updateDeviceinfo.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/waplog/sendreportaffiliatedidcount.php &
sleep 10
#send report of Airtel WAP Activation browsing report
/usr/bin/php /var/www/html/kmis/mis/waplog/mailWAPACtReport.php &
sleep 1
/usr/bin/php /var/www/html/kmis/mis/waplog/mailAirtelWAP_S2S_Report.php &
sleep 1
/usr/bin/php /var/www/html/hungamacare/summercontest/AirltailLdr/CCGReport/mail.php &
#send report of MCD Recharge Report
sleep 10
/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/mcdrecharge/emailalert/mail.php &
sleep 40
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/mis/email/mail.php &
sleep 10
#delete Airtel CCG reqs for last date
/usr/bin/php /var/www/html/airtel/removePendingCCgReqs.php &
#Missed Call Activity obd send-
/usr/bin/php /var/www/html/kmis/services/hungamacare/ActiveBaseSUMissedCall.php &
echo "End `date` " >> /var/www/html/hungamacare/summercontest/uninor/report_status.txt
