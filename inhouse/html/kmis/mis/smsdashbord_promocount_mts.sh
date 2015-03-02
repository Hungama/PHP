#!/bin/sh
#Shell Script for sms dashboard promo

WHICH="/usr/bin/which"
SQL="`$WHICH mysql`"
DATE="`$WHICH date`"
#date --date="1 days ago"

mysql_password="Smita123"
mysql_host="database.master"
mysql_db="master_db"
mysql_user="Smita"
#mydb="Inhouse_tmp.smsdashboardhistory_temp"
mydb="master_db.smsdashboardhistory"
mydb2="master_db.bulk_sms_successFailcount"

#file_date=`$DATE +%Y%m%d`
#added_date=`$DATE +%Y-%m-%d`
file_date="$(date --date='1 days ago' "+%Y%m%d")"
added_date="$(date --date='1 days ago' "+%Y-%m-%d")"
currentmonth=$(date +%Y%m)

file_date=20141116
added_date=2014-11-16
currentmonth=201411
echo $added_date
echo $file_date
echo $currentmonth
mtsfilename='MTS_PROMO_RECIVER'
#exit;
#For MTS
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "delete from $mydb where date(added_on)='$added_date' and operator='MTSM';"
#MTS_PROMO_RECIVER20141101.txt MTS_promo
filePath="/home/ivr/javalogs/BillingMnger/SMS/MTS/106/$currentmonth/$mtsfilename$file_date.txt"
totalcount_sms_106=`cat $filePath | grep -ic 'sms-promo'`
totalcount_nocall_106=`cat $filePath | grep -ic no_call_promo`
totalcount_conteng_106=`cat $filePath | grep -ic 'CONT-ENG'`

filePath="/home/ivr/javalogs/BillingMnger/SMS/MTS/107/$currentmonth/$mtsfilename$file_date.log"
totalcount_sms_107=`cat $filePath | grep -ic 'sms-promo'`
totalcount_nocall_107=`cat $filePath | grep -ic no_call_promo`
totalcount_conteng_107=`cat $filePath | grep -ic 'CONT-ENG'`

totalcount_sms=$(($totalcount_sms_106 + $totalcount_sms_107))
totalcount_nocall=$(($totalcount_nocall_106 + $totalcount_nocall_107))
totalcount_conteng=$(($totalcount_conteng_106 + $totalcount_conteng_107))
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_sms','MTSM','sms-promo','$added_date');"	  
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_nocall','MTSM','no_call_promo','$added_date');"	 
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_conteng','MTSM','conteng','$added_date');"
