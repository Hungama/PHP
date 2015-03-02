#!/bin/sh
#Shell Script BSNL SMS Success Failure Count update in Bulk Message History
cd /var/www/html/kmis/mis/
echo "Start `date` " >> /var/www/html/kmis/mis/BSNLSMS_status.txt
/usr/bin/php /var/www/html/kmis/mis/bsnlSmsSuccessFailUpdate.php &
echo "End  `date` " >> /var/www/html/kmis/mis/BSNLSMS_status.txt