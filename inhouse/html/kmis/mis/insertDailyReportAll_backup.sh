#!/bin/sh
#Shell Script for insertAllDailyReport 

#Aircel/Etisalat dailyreport
/usr/bin/php /var/www/html/kmis/mis/aircel/insertDailyReportAircel.php &

#Docomo dailyreport
/usr/bin/php /var/www/html/kmis/mis/docomo/insert_daily_report.php &

#Indicom dailyreport
/usr/bin/php /var/www/html/kmis/mis/docomo/insertDailyReportIndicom.php &

#Virgin dailyreport
/usr/bin/php /var/www/html/kmis/mis/docomo/insertDailyReportVirm.php &

#Uninor dailyreport
/usr/bin/php /var/www/html/kmis/mis/uninor/insertDailyReportUninor.php &
