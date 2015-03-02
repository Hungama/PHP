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
mysql_local_file="/home/Scripts/contest_engagementlogs/logs/mtssms.txt"

mysql_host_mts="10.130.14.106"
mysql_db1_mts="Mts_summer_contest"
mysql_user_mts="root"
mysql_password_mts="MtsHungama"

count=0




CURDATE="`$DATE +%Y-%m-%d`"
nowtime=`$DATE "+%Y-%m-%d %H:%M:%S"`

query_in=`$SQL -h$mysql_host -u$mysql_user $mysql_db -p$mysql_password --disable-column-names -e "select c.id,c.dnd_scrubing,replace(f.message,' ','_') from master_db.tbl_cron_schedule_contest c,master_db.tbl_cron_schedule_footer_msg f where c.status='1' and c.service_id='1123' and f.service_id='1123';"`
	
	id=`echo $query_in | $AWK '{ print $1 }'`
	dndstatus=`echo $query_in | $AWK '{ print $2 }'`
	footer=`echo $query_in | $AWK '{ print $3 }'`
	
	if [ "$dndstatus" = '1' ];
	then
		hangtype="Hangup"
	else
		hangtype="Mpdtnb"
	fi
	
$SQL -h$mysql_host_mts -u$mysql_user_mts $mysql_db1_mts -p$mysql_password_mts -e "select ANI from Mts_summer_contest.tbl_contest_subscription where status='8';" > $mysql_local_file

processLine()
{
	ANI=`echo $line | $AWK '{ print $1 }'`
	
	$SQL -h$mysql_host_mts -u$mysql_user_mts $mysql_db1_mts -p$mysql_password_mts -e "call Mts_summer_contest.CONTEST_ENGAGEMENTSMS('$ANI');"

	sms=`$SQL -h$mysql_host_mts -u$mysql_user_mts $mysql_db1_mts -p$mysql_password_mts --disable-column-names -e "select question from question_bank where prompt_name in (select prompt_name from current_question_playing where ANI='$ANI');"`		
	
	
	footer="${footer//_/ }"

	sms="$sms $footer"
	
	$SQL -h$mysql_host_mts -u$mysql_user_mts $mysql_db1_mts -p$mysql_password_mts -e "call master_db.SENDSMS_DND('$ANI','$sms','55333','$hangtype','1');"
	echo $ANI $sms >> /home/Scripts/contest_engagementlogs/logs/1123_$id.txt
}

exec 0<$mysql_local_file	




while read line
do
	if [ $count -gt 0 ]
	then
		processLine $line
	else
		count=`$ARITH $count + 1`
	fi	
done

cd /home/Scripts/contest_engagementlogs/logs/
rm -rf $mysql_local_file
