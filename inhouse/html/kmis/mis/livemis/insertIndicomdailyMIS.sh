#!/bin/sh
#Shell Script for insertIndicomdailyMIS

echo -e "Script started `date`"
cd /var/www/html/kmis/mis/livemis/

/usr/bin/php /var/www/html/kmis/mis/livemis/insertIndicomdailyMIS.php &

/usr/bin/php /var/www/html/kmis/mis/livemis/insertIndicomdailyMISCallLogs.php &
echo -e "Script ended `date`\n"
