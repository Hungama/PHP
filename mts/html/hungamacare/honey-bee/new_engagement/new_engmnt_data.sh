#!/bin/sh
#Shell Script for Engagement Scenerio data insertion
cd /var/www/html/hungamacare/honey-bee/new_engagement
echo "Start `date` " >> /var/www/html/hungamacare/honey-bee/new_engagement/getAllSceneriodate.txt
/usr/bin/php /var/www/html/hungamacare/honey-bee/new_engagement/truncateEngagemnetNumber.php&
sleep 5m
/usr/bin/php /var/www/html/hungamacare/honey-bee/new_engagement/new_engagementlog_activeBase.php &
sleep 1m
/usr/bin/php /var/www/html/hungamacare/honey-bee/new_engagement/new_engagementlog_Call.php &
sleep 1m
/usr/bin/php /var/www/html/hungamacare/honey-bee/new_engagement/new_engagementlog_noCall.php &
sleep 1m
/usr/bin/php /var/www/html/hungamacare/honey-bee/new_engagement/new_engagementlog_ageOfservice.php &
sleep 1m
/usr/bin/php /var/www/html/hungamacare/honey-bee/new_engagement/new_engagementlog_MOU.php &
sleep 1m
/usr/bin/php /var/www/html/hungamacare/honey-bee/new_engagement/new_engagementlog_NonLive.php &
sleep 1m
/usr/bin/php /var/www/html/hungamacare/honey-bee/new_engagement/new_engagementlog_crbtDwnld.php &
sleep 1m
/usr/bin/php /var/www/html/hungamacare/honey-bee/new_engagement/new_engagementlog_nonCrbtDwnld.php &
echo "End  `date` " >> /var/www/html/hungamacare/honey-bee/new_engagement/getAllSceneriodate.txt
echo "done"