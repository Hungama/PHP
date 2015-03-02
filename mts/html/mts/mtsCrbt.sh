#!/bin/sh
#Shell Script for insertMTSCrbt

cd /var/www/html/MTS/

echo "Start `date` " > insertMTSCrbt.txt
#/usr/bin/php /var/www/html/MTS/MTSCrbt_apd.php & 
/usr/bin/php /var/www/html/MTS/MTSCrbt_raj.php &
/usr/bin/php /var/www/html/MTS/MTSCrbt_wbl.php &
/usr/bin/php /var/www/html/MTS/MTSCrbt_kol.php &
/usr/bin/php /var/www/html/MTS/MTSCrbt_kar.php &
/usr/bin/php /var/www/html/MTS/MTSCrbt_other.php &
/usr/bin/php /var/www/html/MTS/Mts_Va_Sub.php &
echo "End  `date` " >> insertMTSCrbt.txt
