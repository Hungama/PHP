#!/bin/bash 

WHICH="/usr/bin/which"
SQL="`$WHICH mysql`"
AWK="`$WHICH awk`"
ARITH="`$WHICH expr`"
DATE="`$WHICH date`"

today_date=`$DATE +%Y%m%d`

mysql_db="Hungama_BNB"
mysql_user="webcc" 
mysql_password="webcc" 
mysql_host="database.master"
echo "Start `date` " >> BnbSMSLogs.txt
date=`$DATE +%Y-%m-%d`

#today_date='20131116'
#date='2013-11-16'
echo $date;

$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "delete from Hungama_BNB.insertDailyReport_smsKeyword where date(req_received)='$date';"
echo BNB Contest
bnb_contest_sms="/var/www/html/hungamacare/BNB/logs/SMS/keywords/keywords_$today_date.txt";
echo "Process bnb_contest_sms " >> liveCallogSMS.txt
$SQL -h$mysql_host -u$mysql_user $mysql_db -p$mysql_password -e "LOAD DATA LOCAL INFILE '$bnb_contest_sms' INTO TABLE Hungama_BNB.insertDailyReport_smsKeyword FIELDS TERMINATED BY '#' LINES TERMINATED BY '\n' (ANI,operator,circle,main_keyword,sub_keyword,req_received,response_submited);"
echo "End  `date` " >> liveCallogSMS.txt
