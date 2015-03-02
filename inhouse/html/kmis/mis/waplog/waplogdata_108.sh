#!/bin/bash
cd /var/www/html/kmis/mis/waplog/
/usr/bin/php /var/www/html/kmis/mis/waplog/getdata_108.php &

## PHP Team Script for tataGSM##
sh /var/www/html/kmis/mis/waplog/waplogdata_tatagsm.sh
####