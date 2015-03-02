#shell Script for Send Cricket bulk Message
# stopped for block out day start here
cd /var/www/html/hungamacare/2.0/
echo "Start `date` " > sendCricketSMS.txt
/usr/bin/php /var/www/html/hungamacare/2.0/sendSMSLiveCricketAlert.php &
echo "End  `date` " >> sendCricketSMS.txt
# stopped for block out day end here