#!/bin/sh
#Shell Script for cricket_content_logs

cd /var/www/html/cricketlog/
/usr/bin/php /var/www/html/cricketlog/upload_file.php & 
#/usr/bin/php /var/www/html/cricketlog/upload_file1.php &

#usr/bin/php /var/www/html/cricketlog/upload_file_213.php &

#/usr/bin/php /var/www/html/cricketlog/upload_file_217.php &

#################  Vikas Sir MTS Billing Data #########

sh /home/Scripts/LOGS_SHARING/securecopy_MTS.sh
#######################################################
