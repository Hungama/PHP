#!/bin/sh
echo "Start at `date` " > bulkreport.txt
/usr/bin/php /var/www/html/airtel/CC/syncBulkUpload.php &
echo "End at `date` " >> bulkreport.txt