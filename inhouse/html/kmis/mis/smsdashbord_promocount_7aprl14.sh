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

#file_date=`$DATE +%Y%m%d`
#added_date=`$DATE +%Y-%m-%d`
file_date="$(date --date='1 days ago' "+%Y%m%d")"
added_date="$(date --date='1 days ago' "+%Y-%m-%d")"
currentmonth=$(date +%Y%m)
echo $added_date
echo $file_date
echo $currentmonth
#file_date=20131106
#added_date=2013-11-06
#currentmonth=201311
#exit;
#For Tata GSM
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "delete from $mydb where date(added_on)='$added_date' and operator!='ETIS';"
filePath="/home/java/SMS/log/TATM_SENDER$file_date.txt"
totalcount_sms=`cat $filePath | grep -c 'sms-promo'`
totalcount_nocall=`cat $filePath | grep -c no_call_promo`
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_sms','TATM','sms-promo','$added_date');"	  
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_nocall','TATM','no_call_promo','$added_date');"	 

#For TataCDMA
filePath="/home/java/SMS/log/TATC_SENDER$file_date.txt"
totalcount_sms=`cat $filePath | grep -c 'sms-promo'`
totalcount_nocall=`cat $filePath | grep -c no_call_promo`
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_sms','TATC','sms-promo','$added_date');"	  
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_nocall','TATC','no_call_promo','$added_date');"	 


#For Uninor
filePath="/home/java/SMS/log/UNIM_SENDER$file_date.txt"
totalcount_sms=`cat $filePath | grep -c 'sms-promo'`
totalcount_nocall=`cat $filePath | grep -c no_call_promo`
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_sms','UNIM','sms-promo','$added_date');"	  
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_nocall','UNIM','no_call_promo','$added_date');"	 

#For RELIANCE
#filePath="/home/java/SMS/log/RELC_SENDER$file_date.txt"
filePath="/home/java/RELIANCESMSSENDER/log/$file_date.txt"
totalcount_sms=`cat $filePath | grep -c 'sms-promo'`
totalcount_nocall=`cat $filePath | grep -c no_call_promo`
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_sms','RELC','sms-promo','$added_date');"	  
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_nocall','RELC','no_call_promo','$added_date');"	 

#For BSNL
filePath="/home/java/SMS/log/BSNL_SENDER$file_date.txt"
totalcount_sms=`cat $filePath | grep -c 'sms-promo'`
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_sms','BSNL','sms-promo','$added_date');"

#For Airtel

filePath="/home/ivr/javalogs/BillingMnger/SMS/Airtel/156/$currentmonth/$file_date.log"
totalcount_sms_156=`cat $filePath | grep -c 'promo'`
totalcount_nocall_156=`cat $filePath | grep -c no_call_promo`

filePath="/home/ivr/javalogs/BillingMnger/SMS/Airtel/158/$currentmonth/$file_date.log"
totalcount_sms_158=`cat $filePath | grep -c 'promo'`
totalcount_nocall_158=`cat $filePath | grep -c no_call_promo`

totalcount_sms=$(($totalcount_sms_156 + $totalcount_sms_158))
totalcount_nocall=$(($totalcount_nocall_156 + $totalcount_nocall_158))
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_sms','AIRM','sms-promo','$added_date');"	  
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_nocall','AIRM','no_call_promo','$added_date');"	 

#For MTS

filePath="/home/ivr/javalogs/BillingMnger/SMS/MTS/106/$currentmonth/$file_date.log"
totalcount_sms_106=`cat $filePath | grep -c 'sms-promo'`
totalcount_nocall_106=`cat $filePath | grep -c no_call_promo`
totalcount_conteng_106=`cat $filePath | grep -c 'CONT-ENG'`

filePath="/home/ivr/javalogs/BillingMnger/SMS/MTS/107/$currentmonth/$file_date.log"
totalcount_sms_107=`cat $filePath | grep -c 'sms-promo'`
totalcount_nocall_107=`cat $filePath | grep -c no_call_promo`
totalcount_conteng_107=`cat $filePath | grep -c 'CONT-ENG'`

totalcount_sms=$(($totalcount_sms_106 + $totalcount_sms_107))
totalcount_nocall=$(($totalcount_nocall_106 + $totalcount_nocall_107))
totalcount_conteng=$(($totalcount_conteng_106 + $totalcount_conteng_107))
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_sms','MTSM','sms-promo','$added_date');"	  
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_nocall','MTSM','no_call_promo','$added_date');"	 
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_conteng','MTSM','conteng','$added_date');"
#For VODA

filePath="/home/ivr/javalogs/BillingMnger/SMS/Voda/$currentmonth/$file_date.log"
totalcount_sms=`cat $filePath | grep -c 'sms-promo'`
totalcount_nocall=`cat $filePath | grep -c no_call_promo`
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_sms','VODM','sms-promo','$added_date');"	  
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_nocall','VODM','no_call_promo','$added_date');"	 

#For DIGI

filePath="/home/ivr/javalogs/BillingMnger/SMS/DIGI/42/$currentmonth/$file_date.log"
totalcount_sms=`cat $filePath | grep -c 'sms-promo'`
totalcount_nocall=`cat $filePath | grep -c no_call_promo`
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_sms','DIGM','sms-promo','$added_date');"	  
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into $mydb (totalcount,operator,message_type,added_on) values('$totalcount_nocall','DIGM','no_call_promo','$added_date');"	 
