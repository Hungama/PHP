#!/bin/bash
cd /var/www/html/hungamacare/all/zipemail/
/usr/bin/php /var/www/html/hungamacare/all/zipemail/airtelSeDumpEmail.php &
/usr/bin/php /var/www/html/hungamacare/all/etisalatsocialshare/insertDailyReportEtisalatSocail.php &
