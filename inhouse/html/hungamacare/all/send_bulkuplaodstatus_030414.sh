#!/bin/bash
cd /var/www/html/hungamacare/all/
/usr/bin/php /var/www/html/hungamacare/all/sendreport-TotalBulkHistory.php &
/usr/bin/php /var/www/html/hungamacare/all/sendreport-TotalBulkHistory_my.php &

