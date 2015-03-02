#!/bin/bash
#cd /var/www/html/hungamacare/all/
/usr/bin/php /var/www/html/hungamacare/all/sendreport-TotalBulkHistory.php &
/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/getTisconData.php &
sleep 1
#/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/getMCDDataNew.php & (Stopped)
#/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/getMCDPromoData.php & (Stopped)
#Recharge &dedcation alert
#/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/getMCDDataNew_song_dedicate.php & (Stopped)
sleep 1
/usr/bin/php /var/www/html/kmis/services/hungamacare/Sendreport-Sms_bulk_upload.php &
sleep 1
/usr/bin/php /var/www/html/kmis/services/hungamacare/Sendreport-Sms_bulk_uploadBSNL.php &
sleep 1
/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/getGSKData.php &
sleep 2
/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/contents_Tiscon1.php &
sleep 1
#/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/contents_MCD_New.php & (Stopped)
sleep 1
/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/contents_GSK.php &
sleep 1
#Recharge &dedcation alert
#/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/contents_MCD_New_song_dedicate.php & (Stopped)
#/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/mailHny.php & (Stopped)
sleep 1
/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/mailTiscon.php &
sleep 1
/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/mailGSK.php &
sleep 1
#/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/mailMCD.php & (Stopped)
sleep 1
#Recharge &dedcation alert
#/usr/bin/php /var/www/html/hungamacare/missedcall/obd_alert/mailMCD_song_dedicate.php & (Stopped)
#/usr/bin/php /var/www/html/hungamacare/igenius/alert/getiGeniusData.php & (Stopped)
sleep 3
#/usr/bin/php /var/www/html/hungamacare/igenius/alert/contents_iGenius.php & (Stopped)
sleep 3
#/usr/bin/php /var/www/html/hungamacare/igenius/alert/mailiGenius.php & (Stopped)
sleep 2
/usr/bin/php /var/www/html/hungamacare/all/updateBulkCount_224_DoubleConsent.php &