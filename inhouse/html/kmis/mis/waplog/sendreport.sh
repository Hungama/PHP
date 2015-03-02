#!/bin/bash
cd /var/www/html/kmis/mis/waplog/
echo "Start `date` " > sendWapReport.txt
/usr/bin/php /var/www/html/kmis/mis/waplog/sendreportAll.php &
sleep 10
/usr/bin/php /var/www/html/kmis/mis/waplog/sendreportaffiliatedidcount.php &
echo "End  `date` " >> sendWapReport.txt