#!/bin/sh
#Shell Script for uninorcall log alert
cd /var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert
/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/Uninorcalllogslivealert.php & 
#sleep 80
#/usr/bin/php /var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/sendEmail.php &