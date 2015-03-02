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
mydb="master_db.bulk_sms_successFailcount"

file_date=`$DATE +%Y%m%d`
added_date=`$DATE +%Y-%m-%d`
#file_date="$(date --date='1 days ago' "+%Y%m%d")"
#added_date="$(date --date='2 days ago' "+%Y-%m-%d")"
currentmonth=$(date +%Y%m)
echo $added_date
echo $file_date
echo $currentmonth
#file_date=20131106
#added_date=2013-11-06
#currentmonth=201311
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "delete from $mydb where date(added_on)='$added_date' and alert_type='live';"
#For BSNL North
filePath="/home/java/SMS/log/BSNL_NH_RECIVER$file_date.txt"
totalcount_succes_sms=`cat $filePath | grep -c '#OK|'`
totalcount_sms=`cat $filePath | wc -l`
totalcount_failure_sms=$(($totalcount_sms - $totalcount_succes_sms))
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (succescount,failurecount,operator,message_type,added_on,alert_type) values('$totalcount_succes_sms','$totalcount_failure_sms','BSNL_NH','',now(),'live');"

#For BSNL South
filePath="/home/java/SMS/log/BSNL_SH_RECIVER$file_date.txt"
totalcount_succes_sms=`cat $filePath | grep -c '#OK|'`
totalcount_sms=`cat $filePath | wc -l`
totalcount_failure_sms=$(($totalcount_sms - $totalcount_succes_sms))
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (succescount,failurecount,operator,message_type,added_on,alert_type) values('$totalcount_succes_sms','$totalcount_failure_sms','BSNL_SH','',now(),'live');"
