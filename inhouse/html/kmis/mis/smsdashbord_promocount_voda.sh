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
echo $added_date
echo $file_date
echo $currentmonth
file_date=20140824
added_date=2014-08-24
currentmonth=201408
#exit;
#For Tata GSM
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "delete from $mydb where date(added_on)='$added_date' and operator='VODM';"
#For VODA

filePath="/home/ivr/javalogs/BillingMnger/SMS/Voda/$currentmonth/$file_date.txt"
totalcount_sms=`cat $filePath | grep -c 'sms-promo'`
totalcount_nocall=`cat $filePath | grep -c 'no_call_promo'`
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_sms','VODM','sms-promo','$added_date');"	  
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_nocall','VODM','no_call_promo','$added_date');"	 
