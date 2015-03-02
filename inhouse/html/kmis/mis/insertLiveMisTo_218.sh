#!/bin/sh
#Shell Script for insertAllLiveMIS To 218

#Etisalat Livemis
/usr/bin/php /var/www/html/kmis/mis/aircel/EtisalatLiveMIS.php &

#Airtel Livemis
/usr/bin/php /var/www/html/kmis/mis/airtel/insertDailyReportLiveAllAirtel1.php &

#Digi Livemis
/usr/bin/php /var/www/html/kmis/mis/digi/insertDailyReportLiveAll1.php &

#docomo/indicom/VIM Livemis
/usr/bin/php /var/www/html/kmis/mis/docomo/insertDailyReportLiveAll1.php &

#MTS Livemis
/usr/bin/php /var/www/html/kmis/mis/mts/insertDailyReportLiveAllMTS1.php &

#Reliance Livemis
/usr/bin/php /var/www/html/kmis/mis/reliance/insertDaliyReportCallLive.php &

#Tunetalk Livemis
/usr/bin/php /var/www/html/kmis/mis/tunetalk/insertDailyReportLiveAllTuneTalk.php &

#uninor Livemis
/usr/bin/php /var/www/html/kmis/mis/uninor/insertDailyReportLiveAll1.php &

#Vodafone Livemis
/usr/bin/php /var/www/html/kmis/mis/vodafone/insertDailyReportLiveAllVoda1.php &




