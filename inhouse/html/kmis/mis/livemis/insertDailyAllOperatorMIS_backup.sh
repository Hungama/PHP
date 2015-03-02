echo -e "PHP Script all operator MIS started\n" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log

echo -e "Script Started `date`  insertAirteldailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log
/usr/bin/php /var/www/html/kmis/mis/livemis/insertAirteldailyMIS.php >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log &
echo -e "Script Ended `date`  insertAirteldailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log
sleep 600

echo -e "Script Started `date`  insertIndicomdailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log
/usr/bin/php /var/www/html/kmis/mis/livemis/insertIndicomdailyMIS.php >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log &
echo -e "Script Ended `date`  insertIndicomdailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log
sleep 600

#echo -e "Script Started `date`  insertMTSdailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertMTSdailyMIS.php >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log &
#echo -e "Script Ended `date`  insertMTSdailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log
#sleep 600

echo -e "Script Started `date`  insertDocomodailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log
/usr/bin/php /var/www/html/kmis/mis/livemis/insertDocomodailyMIS.php >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log &
echo -e "Script Ended `date`  insertDocomodailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log
sleep 600

#echo -e "Script Started `date`  insertUninordailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertUninordailyMIS.php >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log &
#echo -e "Script Ended `date`  insertUninordailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log
#sleep 600

#echo -e "Script Started `date`  insertVodafonedailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertVodafonedailyMIS.php >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log &
#echo -e "Script Ended `date`  insertVodafonedailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log
#sleep 600

echo -e "Script Started `date`  insertVMIdailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log
/usr/bin/php /var/www/html/kmis/mis/livemis/insertVMIdailyMIS.php >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log &
echo -e "Script Ended `date`  insertVMIdailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log
sleep 600

#echo -e "Script Started `date`  insertRELCdailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertRELCdailyMIS.php >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log &
#echo -e "Script Ended `date`  insertRELCdailyMIS.php" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log

echo -e "PHP Script all operator MIS Ended\n" >> /home/Scripts/script_logs/insertDailyAllOperatorMIS.log

