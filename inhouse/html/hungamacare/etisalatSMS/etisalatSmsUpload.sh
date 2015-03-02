#!/bin/bash
cd /var/www/html/hungamacare/etisalatSMS/
/usr/bin/php /var/www/html/hungamacare/etisalatSMS/cronprocessfile.php &

## PHP Team Script for USSD Prompt upload##
sh /var/www/html/hungamacare/ussd/prompt/copyobdfile.sh
####