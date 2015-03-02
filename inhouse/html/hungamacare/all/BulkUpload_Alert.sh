
#!/bin/bash
FILENAME=/tmp/Uninor_Bulk_Alert.csv
FILENAME1=/tmp/TATA_Bulk_Alert.csv

FILESIZE=$(stat -c%s "$FILENAME")
a="$(date "+%Y-%b-%d")"
b="$(date)"
H1=`date +%H --date="$1 hour ago"`
MIN=`date +%M --date="1 hour ago"`
echo "MINUTE $MIN";
mysql -h  database.master -u billing -pbilling  master_db < /home/Scripts/BulkUpload_Alert.sql


############################### Uninor OPERATOR #################################################
mysql -h 192.168.100.224 -u billing -pbilling master_db -B -e "select (CASE WHEN status=2 THEN 'PROCESSED' WHEN status=1 THEN 'IN_PROCESS'  ELSE 'NOT_PROCESSED' END) STATUS,added_on ADDED_ON,batch_id BATCHID,file_name FILE_NAME,added_by ADDED_BY,service_id SERVICE_ID,total_file_count TOTAL_FILE_COUNT,block BLOCK,Already_subscribed ALREADY_SUBSCRIBED,in_process IN_PROCESS,in_success IN_SUCCESS,in_failure IN_FAILURE,gap_per GAP_PERCENTAGE from master_db.bulk_upload_history_triggered where service_id like '14%' and date(added_on)>=date(subdate(now(),2)) order by added_on desc;" |sed "s/'/\'/;s/\t/\",\"/g;s/^/\"/;s/$/\"/;s/\n//g" > /tmp/Uninor_Bulk_Alert.csv

mysql -h 192.168.100.224 -u billing -pbilling master_db -B -e "select (CASE WHEN status=2 THEN 'PROCESSED' WHEN status=1 THEN 'IN_PROCESS'  ELSE 'NOT_PROCESSED' END) STATUS,added_on ADDED_ON, batch_id BATCHID,file_name FILE_NAME,added_by ADDED_BY,service_id SERVICE_ID,total_file_count TOTAL_FILE_COUNT,block BLOCK,Already_subscribed ALREADY_SUBSCRIBED,in_process IN_PROCESS,in_success IN_SUCCESS,in_failure IN_FAILURE,gap_per GAP_PERCENTAGE from master_db.bulk_upload_history_triggered where service_id like '14%' and date(added_on)>=date(subdate(now(),2))  order by added_on desc ;"| sed "s/\t/\t\t/g">/tmp/Uninor_Bulk_Alert.txt

echo "<html><body>Dear Team,<br>Please find the data at $b<br><br><table border=1>$(mysql -h 192.168.100.224 -u billing -pbilling master_db -B -e "select (CASE WHEN status=2 THEN 'PROCESSED' WHEN status=1 THEN 'IN_PROCESS'  ELSE 'NOT_PROCESSED' END) STATUS,added_on ADDED_ON,batch_id BATCHID,file_name FILE_NAME,added_by ADDED_BY,service_id SERVICE_ID,total_file_count TOTAL_FILE_COUNT,block BLOCK,Already_subscribed ALREADY_SUBSCRIBED,in_process IN_PROCESS,in_success IN_SUCCESS,in_failure IN_FAILURE,gap_per GAP_PERCENTAGE from master_db.bulk_upload_history_triggered where service_id like '14%'  and date(added_on)>=date(subdate(now(),2))  order by added_on desc ;" |sed "s/'/\'/;s/\t/\",\"/g;s/^/<tr><td>/;s/$/\"/;s/\n//g;s/\"//g;s/\,/<td>/g")</table><br>Regards<br>Billing Team</body></html>" > /tmp/Uninor_Bulk_Alert.html
##################################### END #####################################################

########################################## TATA ##################################################
mysql -h 192.168.100.224 -u billing -pbilling master_db -B -e "select (CASE WHEN status=2 THEN 'PROCESSED' WHEN status=1 THEN 'IN_PROCESS'  ELSE 'NOT_PROCESSED' END) STATUS,added_on ADDED_ON,batch_id BATCHID,file_name FILE_NAME,added_by ADDED_BY,service_id SERVICE_ID,total_file_count TOTAL_FILE_COUNT,block BLOCK,Already_subscribed ALREADY_SUBSCRIBED,in_process IN_PROCESS,in_success IN_SUCCESS,in_failure IN_FAILURE,gap_per GAP_PERCENTAGE from master_db.bulk_upload_history_triggered where service_id like '10%' or service_id like '18%' or service_id like '16%'  order by added_on desc;" |sed "s/'/\'/;s/\t/\",\"/g;s/^/\"/;s/$/\"/;s/\n//g" > /tmp/TATA_Bulk_Alert.csv

mysql -h 192.168.100.224 -u billing -pbilling master_db -B -e "select (CASE WHEN status=2 THEN 'PROCESSED' WHEN status=1 THEN 'IN_PROCESS'  ELSE 'NOT_PROCESSED' END) STATUS,added_on ADDED_ON, batch_id BATCHID,file_name FILE_NAME,added_by ADDED_BY,service_id SERVICE_ID,total_file_count TOTAL_FILE_COUNT,block BLOCK,Already_subscribed ALREADY_SUBSCRIBED,in_process IN_PROCESS,in_success IN_SUCCESS,in_failure IN_FAILURE,gap_per GAP_PERCENTAGE from master_db.bulk_upload_history_triggered  where service_id like '10%' or service_id like '18%' or service_id like '16%' order by added_on desc ;"| sed "s/\t/\t\t/g">/tmp/TATA_Bulk_Alert.txt

echo "<html><body>Dear Team,<br>Please find the data at $b<br><br><table border=1>$(mysql -h 192.168.100.224 -u billing -pbilling master_db -B -e "select (CASE WHEN status=2 THEN 'PROCESSED' WHEN status=1 THEN 'IN_PROCESS'  ELSE 'NOT_PROCESSED' END) STATUS,added_on ADDED_ON,batch_id BATCHID,file_name FILE_NAME,added_by ADDED_BY,service_id SERVICE_ID,total_file_count TOTAL_FILE_COUNT,block BLOCK,Already_subscribed ALREADY_SUBSCRIBED,in_process IN_PROCESS,in_success IN_SUCCESS,in_failure IN_FAILURE,gap_per GAP_PERCENTAGE from master_db.bulk_upload_history_triggered  where service_id like '10%' or service_id like '18%' or service_id like '16%' order by added_on desc ;" |sed "s/'/\'/;s/\t/\",\"/g;s/^/<tr><td>/;s/$/\"/;s/\n//g;s/\"//g;s/\,/<td>/g")</table><br>Regards<br>Billing Team</body></html>" > /tmp/TATA_Bulk_Alert.html

##################################### END ########################################################

FILESIZE=$(stat -c%s "$FILENAME")
FILESIZE1=$(stat -c%s "$FILENAME1")

#### Testing
 #/usr/local/bin/mutt -e "set content_type=text/html"  manoj.prabhakar@hungama.com  -s "TATA Bulk Upload Alert $a" </tmp/TATA_Bulk_Alert.html -a /tmp/TATA_Bulk_Alert.csv -a  /tmp/TATA_Bulk_Alert.txt


if [ $MIN -le 15 ]; then

	if [ $FILESIZE -ge 2 ]; then
		echo "Uninor :: Sending Mail Alert"
 #	/usr/local/bin/mutt -e "set content_type=text/html" gagandeep.dhall@hungama.com gadadhar.nandan@hungama.com vinod.chauhan@hungama.com arun.gaur@hungama.com neha.nayyar@hungama.com shitij.rungan@hungama.com  voice.bill@hungama.com athar.haider@hungama.com satay.tiwari@hungama.com vishwa.tripathi@hungama.com Voice.ops@hungama.com voice.noc@hungama.com  -s "Uninor Bulk Upload Alert $a" </tmp/Uninor_Bulk_Alert.html -a /tmp/Uninor_Bulk_Alert.csv -a  /tmp/Uninor_Bulk_Alert.txt
	fi
  
	if [ $FILESIZE1 -ge 2 ]; then
		 echo "TATA :: Sending Mail Alert"
        /usr/local/bin/mutt -e "set content_type=text/html" anand.shukla@hungama.com ankur.saxena@hungama.com gagandeep.dhall@hungama.com vinod.chauhan@hungama.com vishwa.tripathi@hungama.com gagandeep.matnaja@hungama.com abul.hasan@hungama.com  pravin.bhakuni@hungama.com sajjad.akhter@hungama.com martin.tagore@hungama.com sundeep.gulati@hungama.com voice.bill@hungama.com athar.haider@hungama.com satay.tiwari@hungama.com Voice.ops@hungama.com voice.noc@hungama.com -s "TATA Bulk Upload Alert $a" </tmp/TATA_Bulk_Alert.html -a /tmp/TATA_Bulk_Alert.csv -a  /tmp/TATA_Bulk_Alert.txt
        fi

else
	echo "Only Updating database"
fi

exists=`mysql -h 192.168.100.224 -u billing -pbilling master_db -B -e "select count(1) from  master_db.bulk_upload_history_triggered where gap_per>10 and minute(timediff(now(),added_on))>20 and status in (1,2) ;" |sed '{:q;N;s/\n/ - /g;t q}'`
#echo "hi$exists hi"
if [ "$exists" == "count(1) - 0" ]; then
 echo "No GAP records found" 
else
#exists=`mysql -h 192.168.100.224 -u billing -pbilling master_db -B -e "select group_concat(batch_id separator ', ')  'Gap_in_count_for_Batchid' from  master_db.bulk_upload_history_triggered where gap_per>10 and minute(timediff(now(),added_on))>20;" |sed '{:q;N;s/\n/ - /g;t q}'`
 exists=`mysql -h 192.168.100.224 -u billing -pbilling master_db -B -e "select group_concat(concat(batch_id,'(',total_file_count,'-',(ifnull(Already_subscribed,0)+in_process+in_success+in_failure),')') separator '  , ')  'Gap_in_count_for_Batchid' from  master_db.bulk_upload_history_triggered where gap_per>10 and minute(timediff(now(),added_on))>20 and status in(1,2);" |sed '{:q;N;s/\n/ - /g;t q}'`

echo "result $exists"

#elinks -dump "http://192.168.100.212:1111/HMXP/push.jsp?smppgateway=HMXP&msisdn=8586968482&shortcode=590900&msgtype=plaintext&msg=$exists"
#elinks -dump "http://192.168.100.212:1111/HMXP/push.jsp?smppgateway=HMXP&msisdn=8586968485&shortcode=590900&msgtype=plaintext&msg=$exists"
#elinks -dump "http://192.168.100.212:1111/HMXP/push.jsp?smppgateway=HMXP&msisdn=8587800614&shortcode=590900&msgtype=plaintext&msg=$exists"
#elinks -dump "http://192.168.100.212:1111/HMXP/push.jsp?smppgateway=HMXP&msisdn=7838666172&shortcode=590900&msgtype=plaintext&msg=$exists"
#elinks -dump "http://192.168.100.212:1111/HMXP/push.jsp?smppgateway=HMXP&msisdn=8588838347&shortcode=590900&msgtype=plaintext&msg=$exists"
#elinks -dump "http://192.168.100.212:1111/HMXP/push.jsp?smppgateway=HMXP&msisdn=9711888229&shortcode=590900&msgtype=plaintext&msg=$exists"
#elinks -dump "http://192.168.100.212:1111/HMXP/push.jsp?smppgateway=HMXP&msisdn=9582220348&shortcode=590900&msgtype=plaintext&msg=$exists"
#elinks -dump "http://192.168.100.212:1111/HMXP/push.jsp?smppgateway=HMXP&msisdn=8586967042&shortcode=590900&msgtype=plaintext&msg=$exists"


fi
#fi
#/usr/local/bin/mutt -e "set content_type=text/html" manoj.prabhakar@hungama.com -s "UNINOR Alert $a" </tmp/Uninor.html -a /tmp/Uninor.txt

#echo "<html><body>Dear Team,<br>Please find the data at $b<br><br><table border=1>$(mysql -h 192.168.100.224 -u billing -pbilling master_db -B -e "select service SERVICE,P_resub_count RENEW_TODAY,p_grace_count GRACE_PARKING,resub_count SUCCESS,resub_revenue SUCCES_REVENUE,failcount FAIL_GRACE from  master_db.tbl_uninor_alertdata where hourpart=hour(now()) and date(date_time)=date(now());" |sed "s/'/\'/;s/\t/\",\"/g;s/^/<tr><td>/;s/$/\"/;s/\n//g;s/\"//g;s/\,/<td>/g")</table><br>Regards<br>Manoj Prabhakar</body></html>" > /tmp/Uninor.html

#echo "Please find attachment for Uninor Data : $b" | mutt vishwa.tripathi@hungama.com yogesh.kaushik@hungama.com Shitij.rungan@hungama.com ankur.tuteja@hungama.com gaurav.talwar@hungama.com  -a /tmp/Uninor.csv -c manoj.prabhakar@hungama.com gurmehar.kalra@hungama.com khajan.singh@hungama.com mahesh.kumar@hungama.com -s "UNINOR Alert $a"
#echo "Please find attachment for Uninor Data : $b" | mutt vishwa.tripathi@hungama.com yogesh.kaushik@hungama.com Shitij.rungan@hungama.com ankur.tuteja@hungama.com gaurav.talwar@hungama.com  -a /tmp/Uninor.csv -c manoj.prabhakar@hungama.com gurmehar.kalra@hungama.com khajan.singh@hungama.com mahesh.kumar@hungama.com -s "UNINOR Alert $a" 
#mutt -s 'Uninor Alert :$a' -e 'my_hdr Content-Type: text/html'  vishwa.tripathi@hungama.com yogesh.kaushik@hungama.com Shitij.rungan@hungama.com ankur.tuteja@hungama.com gaurav.talwar@hungama.com -c Voice.ops@hungama.com -c Voice.bill@hungama.com < /tmp/Uninor.html
