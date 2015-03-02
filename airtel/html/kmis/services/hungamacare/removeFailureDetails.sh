#!/bin/sh
#Shell Script for removeFailureDetails

cd /var/www/html/kmis/services/hungamacare/

echo "Start `date` " > removeFailureDetails.txt
/usr/bin/php /var/www/html/kmis/services/hungamacare/removeFailureDetails.php & 
echo "End  `date` " >> removeFailureDetails.txt