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

#file_date=20140528
#added_date=2014-05-28
#currentmonth=201405
echo $added_date
echo $file_date
echo $currentmonth

#exit;
#For MTS
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "delete from $mydb where date(added_on)='$added_date' and operator='DIGM';"

#For DIGI
filePath="/home/ivr/javalogs/BillingMnger/SMS/DIGI/42/$currentmonth/$file_date.log"
totalcount_sms=`cat $filePath | grep -c 'sms-promo'`
totalcount_nocall=`cat $filePath | grep -c no_call_promo`
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_sms','DIGM','sms-promo','$added_date');"	  
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_nocall','DIGM','no_call_promo','$added_date');"	 
