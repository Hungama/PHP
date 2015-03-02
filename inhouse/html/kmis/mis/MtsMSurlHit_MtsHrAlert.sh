#!/bin/sh
#Shell Script for event charging

cd /var/www/html/kmis/mis

echo "Start `date` " > mtsMSurlHit.txt
/usr/bin/php /var/www/html/kmis/mis/MtsMSurlHit.php & 
echo "End  `date` " >> MISMSurlHit.txt

###### Script for MTS Hourly Alert #####

#sh /home/Scripts/MTS_Hourly_Alert.sh
