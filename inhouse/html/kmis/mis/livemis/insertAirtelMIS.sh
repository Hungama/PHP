#!/bin/bash
#set -x

WHICH="/usr/bin/which"
SQL="`$WHICH mysql`"
AWK="`$WHICH awk`"
ARITH="`$WHICH expr`"
DATE="`$WHICH date`"

mysql_db="misdata"
mysql_user="amit.khurana"
mysql_password="hungama"
mysql_host="192.168.100.218"

date=`$DATE +%Y-%m-%d`

mysql_db1="mis_db"
mysql_user1="billing"
mysql_password1="billing"
#mysql_host1="10.2.73.156"
mysql_host1="database.master"

$SQL -h$mysql_host -u$mysql_user -p$mysql_password $mysql_db -e "delete from misdata.tbl_AirtelReport where date(call_date)='$date';"

$SQL -h$mysql_host -u$mysql_user -p$mysql_password $mysql_db -e "insert into mis_db.tbl_AirtelReport values($SQL -h$mysql_host -u$mysql_user -p$mysql_password $mysql_db -e 'insert into mis_db.tbl_AirtelReport values();');"	  
