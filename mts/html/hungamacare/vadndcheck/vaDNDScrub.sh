#shell Script for DND Scrub

cd /var/www/html/hungamacare/vadndcheck/

echo "Start `date` " > dndVAScrub.txt

/usr/bin/php /var/www/html/hungamacare/vadndcheck/va_dndcheck.php &

echo "End  `date` " >> dndVAScrub.txt