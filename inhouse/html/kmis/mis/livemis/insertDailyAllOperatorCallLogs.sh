echo -e "PHP Script all operator call logs started\n" >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log

echo -e "Script Started `date` insertUninordailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
/usr/bin/php  /var/www/html/kmis/mis/livemis/insertUninordailyMISCallLogs.php >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log &
echo -e "Script Ended `date` insertUninordailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
sleep 1000

echo -e "Script Started `date` insertAirteldailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
/usr/bin/php  /var/www/html/kmis/mis/livemis/insertAirteldailyMISCallLogs.php >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log &
echo -e "Script Ended `date` insertAirteldailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
sleep 1000

echo -e "Script Started `date` insertVodafonedailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
/usr/bin/php  /var/www/html/kmis/mis/livemis/insertVodafonedailyMISCallLogs.php >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log &
echo -e "Script Ended `date` insertVodafonedailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
sleep 1000

echo -e "Script Started `date` insertDocomodailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
/usr/bin/php  /var/www/html/kmis/mis/livemis/insertDocomodailyMISCallLogs.php >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log &
echo -e "Script Ended `date` insertDocomodailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
sleep 1000

echo -e "Script Started `date` insertIndicomdailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
/usr/bin/php  /var/www/html/kmis/mis/livemis/insertIndicomdailyMISCallLogs.php >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log &
echo -e "Script Ended `date` insertIndicomdailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
sleep 1000

echo -e "Script Started `date` insertVMIdailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
/usr/bin/php  /var/www/html/kmis/mis/livemis/insertVMIdailyMISCallLogs.php >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log &
echo -e "Script Ended `date` insertVMIdailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
sleep 1000

echo -e "Script Started `date` insertRELCdailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
/usr/bin/php  /var/www/html/kmis/mis/livemis/insertRELCdailyMISCallLogs.php >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log &
echo -e "Script Ended `date` insertRELCdailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
sleep 1000

echo -e "Script Started `date` insertMTSdailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
/usr/bin/php  /var/www/html/kmis/mis/livemis/insertMTSdailyMISCallLogs.php >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log &
echo -e "Script Ended `date` insertMTSdailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
sleep 1000

echo -e "Script Started `date` insertAirceldailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
/usr/bin/php  /var/www/html/kmis/mis/livemis/insertAirceldailyMISCallLogs.php >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log &
echo -e "Script Ended `date` insertAirceldailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
sleep 1000

echo -e "Script Started `date` insertBSNLdailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
/usr/bin/php  /var/www/html/kmis/mis/insertBSNLdailyMISCallLogs.php >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log &
echo -e "Script Ended `date` insertBSNLdailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
sleep 100

echo -e "Script Started `date` insertMCDdailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
/usr/bin/php  /var/www/html/kmis/mis/livemis/insertMCDdailyMISCallLogs.php >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log &
echo -e "Script Ended `date` insertMCDdailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
sleep 10
echo -e "Script Started `date` insertTISCONdailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
/usr/bin/php  /var/www/html/kmis/mis/livemis/insertTISCONdailyMISCallLogs.php >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log &
echo -e "Script Ended `date` insertTISCONdailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
sleep 10
echo -e "Script Started `date` insertGSKdailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
/usr/bin/php  /var/www/html/kmis/mis/livemis/insertGSKdailyMISCallLogs.php >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log &
echo -e "Script Ended `date` insertGSKdailyMISCallLogs.php"  >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log

echo -e "PHP Script all operator call logs ended\n" >> /home/Scripts/script_logs/insertDailyAllOperatorCallLogs.log
