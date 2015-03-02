#!/bin/sh
#set -x      
     
WHICH="/usr/bin/which"
SQL="`$WHICH mysql`"
AWK="`$WHICH awk`"
ARITH="`$WHICH expr`"
DATE="`$WHICH date`"

mysql_db="master_db"
mysql_user="Mukesh"
mysql_password="Mukesh123"
mysql_host="database.master"

CURDATE="`$DATE +%Y-%m-%d`"
nowtime=`$DATE "+%H:%M:00"`
echo $nowtime
query_in=`$SQL -h$mysql_host -u$mysql_user $mysql_db -p$mysql_password --disable-column-names -e "select id,schedule_time,service_id from master_db.tbl_cron_schedule_contest where service_id=1123 and status=1 order by id desc"`
	id=`echo $query_in | $AWK '{ print $1 }'`
	schedule_time=`echo $query_in | $AWK '{ print $2 }'`
	service_id=`echo $query_in | $AWK '{ print $3 }'`

	echo $schedule_time

	if [ "$schedule_time" = "$nowtime" ]
	then
		echo 'Yes'
	else
		echo 'No'
	fi
