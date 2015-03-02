#!/bin/sh
#Shell Script for insertAllDailyMIS To 218

#Airtel dailymis
/usr/bin/php /var/www/html/kmis/mis/airtel/insertAirteldailyMIS.php &
sleep 600
#Digi dailymis
/usr/bin/php /var/www/html/kmis/mis/digi/insertDigidailyMIS.php &
sleep 600
#docomo/indicom/VIM dailymis
/usr/bin/php /var/www/html/kmis/mis/docomo/insertDocomodailyMIS.php &
sleep 600
/usr/bin/php /var/www/html/kmis/mis/docomo/insertIndicomdailyMIS.php &
sleep 600
/usr/bin/php /var/www/html/kmis/mis/docomo/insertVMIdailyMIS.php &
sleep 600
#MTS dailymis
/usr/bin/php /var/www/html/kmis/mis/mts/insertMTSdailyMIS.php &
sleep 600
#Reliance dailymis
/usr/bin/php /var/www/html/kmis/mis/reliance/insertRELCdailyMIS.php &
sleep 600
#Tunetalk dailymis
/usr/bin/php /var/www/html/kmis/mis/tunetalk/insertTunedailyMIS.php &
sleep 600
#uninor dailymis
/usr/bin/php /var/www/html/kmis/mis/uninor/insertUninordailyMIS.php &
sleep 600
#Vodafone dailymis
/usr/bin/php /var/www/html/kmis/mis/vodafone/insertVodafonedailyMIS.php &




