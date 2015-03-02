#!/bin/sh
#Shell Script for Uninor winner Recharge  (at 5:00 AM)
echo "Start `date` " >> /var/www/html/hungamacare/summercontest/uninor/report_status.txt
/usr/bin/php /var/www/html/hungamacare/summercontest/uninor/getAllWinner_uninor_new.php &
sleep 1
/usr/bin/php /var/www/html/hungamacare/summercontest/mts/getAllWinner_mts.php &
sleep 1
/usr/bin/php /var/www/html/hungamacare/summercontest/AirltailLdr/getAllWinner_ldr.php &
sleep 1
/usr/bin/php /var/www/html/hungamacare/summercontest/uninor54646/getAllWinner.php &
sleep 2
/usr/bin/php /var/www/html/hungamacare/summercontest/uninor/uninorContestRecharge_process_new.php &
sleep 5
/usr/bin/php /var/www/html/hungamacare/summercontest/mts/mtsContestRecharge_process.php &
sleep 5
/usr/bin/php /var/www/html/hungamacare/summercontest/AirltailLdr/AirtailLdrRecharge_process.php &
sleep 5
/usr/bin/php /var/www/html/hungamacare/summercontest/uninorcricket/uninorCricketRecharge_process.php &
sleep 5
/usr/bin/php /var/www/html/hungamacare/summercontest/uninor54646/recharge_process.php &
#added for billing wap LDR data
sleep 20
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/airtel/airtelwapBillingMIS.php &
sleep 2
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/uninor/uninorwapBillingMIS.php &
#sleep 20
sleep 5
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/aircel/aircelwapBrowsingMIS.php &
sleep 5
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/mis/insertTataTiscondailyReportMitr.php &
sleep 20
#Airtel LDR WAP Report
/usr/bin/php /var/www/html/kmis/mis/waplog/insertdailyWAPReport.php &
sleep 20
/usr/bin/php /var/www/html/hungamacare/missedcall/admin/html/mis/saveExcelData.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/aircel/updateDeviceinfo.php &
sleep 10
#Airtel DGM Report Insertion
#/usr/bin/php /var/www/html/kmis/mis/waplog/insertdailyWAP_S2SReport.php &
echo "End `date` " >> /var/www/html/hungamacare/summercontest/uninor/report_status.txt