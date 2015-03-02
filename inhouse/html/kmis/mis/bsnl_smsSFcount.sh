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
mydb="master_db.bulk_message_history"

file_date=`$DATE +%Y%m%d`
added_date=`$DATE +%Y-%m-%d`
#file_date="$(date --date='1 days ago' "+%Y%m%d")"
#added_date="$(date --date='2 days ago' "+%Y-%m-%d")"
currentmonth=$(date +%Y%m)
batchid=$1
zoneid=$2
#echo $batchid
#echo $zoneid
#echo $added_date
#echo $file_date
#echo $currentmonth
#file_date=20131106
#added_date=2013-11-06
#currentmonth=201311
#For BSNL North
if [ "$zoneid" == "03" ];
then
filePath="/home/java/SMS/log/BSNL_NH_RECIVER$file_date.txt"
elif [ "$zoneid" == "04" ];
then
#For BSNL South
filePath="/home/java/SMS/log/BSNL_SH_RECIVER$file_date.txt"
fi

totalcount_succes_sms=`cat $filePath | grep -c "#OK|$batchid"`
totalcount_failure_sms=`cat $filePath | grep -c "#NOOK|$batchid"`
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "update $mydb set successCount='$totalcount_succes_sms',FailureCount='$totalcount_failure_sms' where batch_id=$batchid;"
echo $totalcount_succes_sms
echo $totalcount_failure_sms