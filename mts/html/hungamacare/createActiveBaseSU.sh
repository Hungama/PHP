#!/bin/sh
#Shell Script for create Active Base for MTS SU
cd /var/www/html/hungamacare/2.0/
echo "Start `date` " > activeBaseSU.txt
/usr/bin/php /var/www/html/hungamacare/2.0/createActiveBaseSU.php& 
echo "End `date` " >> activeBaseSU.txt