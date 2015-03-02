#!/bin/sh
#Shell Script for insertAllOperatorLiveMis

cd /var/www/html/kmis/mis/livemis/

echo "Start `date` " >> /var/www/html/kmis/mis/livemis/insertAllOperatorLiveMis.txt
#/usr/bin/php /var/www/html/kmis/mis/waplog/livewaplogsAirtelLdr.php &
#sleep 10
#/usr/bin/php /var/www/html/kmis/mis/waplog/livewaplogsUninorlLdr.php &
#sleep 5
#/usr/bin/php /var/www/html/kmis/mis/waplog/livewaplogsUninorKiji.php &
#sleep 5
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/inhouse/tatawapLiveMis.php &
sleep 1m
#sleep 2m
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertDailyAirtelCallLogLive1.php &
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/airtel/insertDailyReportCallLive_Airtel.php &
sleep 1m
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/mcw/insertDailyReportLiveAll_MCW.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/mcw/insertDailyReportLiveAll_GSK.php &
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertDailyReportLiveAllMTS1.php &
#/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/mts/insertDailyReportLiveAll_Mts.php &
#sleep 20
#/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/mts/insertDailyReportCallLive_Mts.php &
#sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/mts/insertDailyReportLivel_MTSCNS.php &
sleep 1m
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertDailyReportLiveAllAirtel1.php &
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/airtel/insertDailyReportLiveAll_Airtel.php &
sleep 1m
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertDailyReportLiveAllVoda1.php &
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/vodafone/insertDailyReportLiveAll_Voda.php &
#sleep 5m
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertDailyMTSCallLogLive1.php &
sleep 1m
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertDailyVodaCallLogLive1.php &
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/vodafone/insertDailyReportCallLive_Voda.php &

/usr/bin/php /var/www/html/kmis/mis/livemis/insertDailyReportLiveAllTuneTalk.php &
sleep 1m
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertDailyReportLiveAllBSNL1.php &
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/bsnl/insertDailyReportLiveAllBSNL1_new.php &
sleep 1m
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertBSNLDailyReportCallLive.php &
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/bsnl/insertDailyReportCallLive_BSNL.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/mcw/insertDailyReportLiveAll_MCW_Inbound.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/mcw/insertDailyReportLiveAll_Tiscon_Inbound.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/mcw/insertDailyReportLiveAll_GSK_Inbound.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/mcw/insertDailyReportLiveAll_IGENIUS.php &
sleep 2m
#WAP LIVE MIS
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/airtel/airtelwapLiveMis.php &
sleep 2m
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/wap/uninor/allUninorwapLiveMis.php &

echo "End  `date` " >> /var/www/html/kmis/mis/livemis/insertAllOperatorLiveMis.txt
