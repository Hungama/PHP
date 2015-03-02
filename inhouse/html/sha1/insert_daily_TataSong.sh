#!/bin/bash

/usr/bin/php /var/www/html/TataSong/InsertDailyTataSong15-02-2012.php

echo "Data Inserted in the IVR_MIS_TATASONGBOOK"


WHICH="/usr/bin/which"
SQL="`$WHICH mysql`"

mysql_db="mis_db"
mysql_user="Shashank"
mysql_password="Shashank123"
mysql_host="119.82.69.210"

#date=`date -d yesterday +%Y%m%d`.
date=20120217;
echo $date



$SQL -h$mysql_host -u$mysql_user $mysql_db -p$mysql_password -e "call IVR_MIS_TATA_SONGBOOK();"
echo "data inserted"
echo $date

elinks --dump "http://119.82.69.212:1111/HMXP/push.jsp?smppgateway=HMXP&msisdn=8287587569&shortcode=HUNVOC&msgtype=plaintext&msg=Successful%20Tata_Song_call%20call"
echo "message sent"
#elinks --dump "http://119.82.69.212:1111/HMXP/push.jsp?smppgateway=HMXP&msisdn=9560314100&shortcode=HUNVOC&msgtype=plaintext&msg=Successful%20Tata_Song_Call%20call"
echo "last line";
~

cp /var/www/html/TataSong/Calling_Date_$date.csv  /var/www/html/TataSong_Calllogs/
echo "File Moved"
rm /var/www/html/TataSong/Calling_Date_$date.csv

echo "Previous Data deleted"

#elinks --dump "http://119.82.69.212:1111/HMXP/push.jsp?smppgateway=HMXP&msisdn=7838959000&shortcode=HUNVOC&msgtype=plaintext&msg=Successful%20Tata_Song_Call%20call"
