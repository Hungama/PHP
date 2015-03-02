#shell Script for ScheduledOn

cd /var/www/html/hungamacare/

echo "Start `date` " > sendScheduledOn.txt

/usr/bin/php /var/www/html/hungamacare/process_scheduledOn.php &

echo "End  `date` " >> sendScheduledOn.txt

