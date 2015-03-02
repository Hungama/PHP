echo -e "PHP Script all operator MIS started\n" >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log

echo -e "Script Started `date`  insertAirteldailyMIS.php" >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log
/usr/bin/php /var/www/html/kmis/mis/airtel/insertAirteldailyMIS.php >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log &
echo -e "Script Ended `date`  insertAirteldailyMIS.php" >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log
sleep 600

echo -e "Script Started `date`  insertMTSdailyMIS.php" >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log
/usr/bin/php /var/www/html/kmis/mis/mts/insertMTSdailyMIS.php >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log &
echo -e "Script Ended `date`  insertMTSdailyMIS.php" >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log
sleep 600

echo -e "Script Started `date`  insertTunedailyMIS.php" >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log
/usr/bin/php /var/www/html/kmis/mis/tunetalk/insertTunedailyMIS.php >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log &
echo -e "Script Ended `date`  insertTunedailyMIS.php" >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log
sleep 600

echo -e "Script Started `date`  insertVodafonedailyMIS.php" >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log
/usr/bin/php /var/www/html/kmis/mis/vodafone/insertVodafonedailyMIS.php >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log &
echo -e "Script Ended `date`  insertVodafonedailyMIS.php" >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log
sleep 600

echo -e "Script Started `date`  insertRELCdailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOtherOperatorMIS.log
/usr/bin/php /var/www/html/kmis/mis/reliance/insertRELCdailyMIS.php >> /home/Scripts/script_logs/insertDailyAllOtherOperatorMIS.log &
echo -e "Script Ended `date`  insertRELCdailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOtherOperatorMIS.log
sleep 600

echo -e "PHP Script all operator MIS Ended\n" >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log
