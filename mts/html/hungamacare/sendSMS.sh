#shell Script for Send bulk Message
# stopped for block out day start here
cd /var/www/html/hungamacare/
echo "Start `date` " > sendSMS.txt
/usr/bin/php /var/www/html/hungamacare/sendSMS.php &
echo "End  `date` " >> sendSMS.txt
# stopped for block out day end here

