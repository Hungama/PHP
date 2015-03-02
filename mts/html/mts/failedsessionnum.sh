#!/bin/bash 

WHICH="/usr/bin/which"
SQL="`$WHICH mysql`"
AWK="`$WHICH awk`"
ARITH="`$WHICH expr`"
DATE="`$WHICH date`"
SED="`$WHICH sed`"

mysql_db="MTS_IVR"
mysql_user="ivr" 
mysql_password="ivr" 
mysql_host="database.master_mts"

prevdate=`date -d '1 day ago' +'%Y-%m-%d'`
#ani="8130335773"

processline()
{
	ani=`echo $line | $AWK 'BEGIN { FS="#" } { print $3 }'`
}

echo "script start at - "`date +'%d-%m-%Y %T'`
logfile="/var/www/html/mts/logs/Charging/Fail/"`date -d '1 day ago' +'%d%m%Y'`"_log.txt";
#logfile="/var/www/html/mts/logs/Charging/Fail/log.txt";

exec 0<$logfile
while read line
do
processline $line
$SQL -h$mysql_host -u$mysql_user  -p$mysql_password $mysql_db -e "insert into MTS_IVR.tbl_failed_session_num values('$ani','$prevdate');"
done
echo "script end at - "`date +'%d-%m-%Y %T'`
