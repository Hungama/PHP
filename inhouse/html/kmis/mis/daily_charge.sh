#!/bin/sh
#Shell Script fro Music Renewal
export LD_LIBRARY_PATH=/usr/lib/oracle/11.1/client64/lib
export TNS_ADMIN=/home

cd /usr/local/apache/htdocs/vodafone/music_portal_cron/

echo "Start `date` " > status.txt
/usr/bin/php /usr/local/apache/htdocs/vodafone/music_portal_cron/renewal_music_cron1.php & 
/usr/bin/php /usr/local/apache/htdocs/vodafone/music_portal_cron/renewal_music_cron1a.php &
/usr/bin/php /usr/local/apache/htdocs/vodafone/music_portal_cron/renewal_music_cron2.php &
/usr/bin/php /usr/local/apache/htdocs/vodafone/music_portal_cron/renewal_music_cron2a.php &
/usr/bin/php /usr/local/apache/htdocs/vodafone/music_portal_cron/renewal_music_cron3.php & 
/usr/bin/php /usr/local/apache/htdocs/vodafone/music_portal_cron/renewal_music_cron3a.php &
/usr/bin/php /usr/local/apache/htdocs/vodafone/music_portal_cron/renewal_music_cron4.php &
/usr/bin/php /usr/local/apache/htdocs/vodafone/music_portal_cron/renewal_music_cron4a.php &
/usr/bin/php /usr/local/apache/htdocs/vodafone/music_portal_cron/renewal_music_cron5.php &  
/usr/bin/php /usr/local/apache/htdocs/vodafone/music_portal_cron/renewal_music_cron5a.php &
echo "End  `date` " >> status.txt