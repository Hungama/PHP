#!/bin/sh
#Shell Script for event charging

#### PHP Team ##
cd /var/www/html/docomo/
echo "Start `date` " > DocomoMessage.txt
/usr/bin/php /var/www/html/docomo/DocomoMessage.php &
echo "End  `date` " >> DocomoMessage.txt
###############

#### Dev Team ##
sh /home/Scripts/engagement54646.sh

###############
