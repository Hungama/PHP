echo -e "PHP Script all operator MIS started\n" >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log

echo -e "Script Started `date`  insertRELCdailyMIS.php" >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log
#/usr/bin/php /var/www/html/kmis/mis/livemis/insertRELCdailyMIS.php >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log &
echo -e "Script Ended `date`  insertRELCdailyMIS.php" >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log
sleep 600

echo -e "Script Started `date`  insertUninordailyMIS.php" >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log
/usr/bin/php /var/www/html/kmis/mis/livemis/insertUninordailyMIS.php >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log &
echo -e "Script Ended `date`  insertUninordailyMIS.php" >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log


echo -e "PHP Script all operator MIS Ended\n" >> /home/Scripts/script_logs/insertDailyOtherOperatorMIS.log
