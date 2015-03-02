#!/bin/sh
#Shell Script for insertMSRelcData

cd /var/www/html/docomo/

/usr/bin/php /var/www/html/docomo/AirtelSendReq.php &
echo "End  `date` " >> AirtelSendReq.txt

