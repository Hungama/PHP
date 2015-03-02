<?php
include ("/var/www/html/hungamacare/config/dbConnect.php");

echo "<br>".$query="select msisdn,def_lang,status,amount,trans_ID,chrg_amount,SC,MODE,circle,operator,plan_id,response_time,adddate(response_time,chrg_amount) as renew_date,subdate(date_time,30) as sub_date from master_db.tbl_billing_success_backup where date(response_time)='2012-11-17' and service_id='1111' and mode='push2' and event_type='RESUB'";
$result=mysql_query($query);

$i=1;
while($row = mysql_fetch_array($result)) {
	$insertQuery = "INSERT INTO dm_radio.tbl_digi_subscription VALUES ('".$row['msisdn']."','".$row['sub_date']."','".$row['renew_date']."', '".$row['def_lang']."', '".$row['status']."','".$row['MODE']."','".$row['SC']."','30','','Bulk','".$row['plan_id']."','".$row['circle']."', '".$row['chrg_amount']."', '','')"; //".$row['trans_ID']."
	$i++;
	mysql_query($insertQuery);
}

mysql_close($dbConn);

echo "<br/>"."Done".$i;
?>