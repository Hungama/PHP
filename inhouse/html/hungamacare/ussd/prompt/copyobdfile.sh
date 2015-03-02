#!/bin/sh
#set -x
WHICH="/usr/bin/which"
SQL="`$WHICH mysql`"
AWK="`$WHICH awk`"
ARITH="`$WHICH expr`"

mysql_password="Smita123"
mysql_host="database.master"
#mysql_host="119.82.69.210"
mysql_db1="master_db"
mysql_user="Smita"
mysql_local_file="bulkupload.txt"
path="/var/www/html/kmis/services/hungamacare/bulkuploads"
log_path="/home/hungama/Scripts/log/BulkUpload/rel_log/"
count=0

while :
do
	currdate=`date +%d%m%Y_%H`
	log_time=`date +%Y%m%d:%H%M%S`

	SendError()
	{
		b_id=$1
		echo $b_id

		#tail -n 1 nohup.out | mutt  -f amit.khurana@hungama.com -s "Bulk Upload Process Error - Exiting from ActiDeactibulkupload.sh " smita.sahu@hungama.com
		
		
	}

	query_result=`$SQL -h$mysql_host -u$mysql_user $mysql_db1 -p$mysql_password -e "select id,obd_name from master_db.obd_upload_history where status=0 limit 1;"`
	echo $query_result
	q_err=`echo $?`	
	if [ $q_err -eq 0 ]
	then
		q_len=${#query_result}
		if [ $q_len -gt 1 ]
		then
			obd_id=`echo $query_result | $AWK ' { print $4 }'`
			obd_file_name=`echo $query_result | $AWK ' { print $5 }'`
			echo $log_time ": FILE NAME ="$obd_file_name "|OBD ID =" $obd_id
	
			$SQL -h$mysql_host -u$mysql_user $mysql_db1 -p$mysql_password -e "update  obd_upload_history set status=1 where id='$obd_id';"
			`sshpass -p 'HTitUP%$N#$%&<B00T$!*227Hun#' scp /var/www/html/hungamacare/ussd/prompt/$obd_id root@192.168.100.227:/sendobd`
	fi		
	fi
	exit
	done
