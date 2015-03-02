<?php 
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
if(!$dbConn)
	die('could not connect: ' . mysql_error());

/*$selectDate="select id,friendANI from master_db.tbl_refer_ussdData where date(referDate) between date(date_sub(now(),interval 3 day)) and date(date_sub(now(),interval 1 day)) 
and status=5 and chrgAmount<0";
$getResult=mysql_query($selectDate);
$msisdnArray=array();
while($Record=mysql_fetch_array($getResult))
	array_push($msisdnArray,$Record['friendANI']);
*/

$getChargingQuery="select msisdn,chrg_amount,a.service_id  from master_db.tbl_billing_success a,master_db.tbl_refer_ussdData b 
where date(response_time)=date(date_sub(now(),interval 1 day)) 
and event_type='SUB' and mode='USSD_Retail' and date(b.referDate) between date(date_sub(now(),interval 3 day)) and date(date_sub(now(),interval 1 day)) 
and b.status=5 and b.chrgAmount=0 and a.msisdn=b.friendANI ";

echo $getChrgResult=mysql_query($getChargingQuery);
while($chrgData=mysql_fetch_array($getChrgResult))
{
	$getMsisdnRecord="select max(id) 'id' from master_db.tbl_refer_ussdData where friendANI= ".$chrgData['msisdn']." and date(referDate) between  date(date_sub(now(),interval 3 day)) 
and date(date_sub(now(),interval 1 day)) and status=5 and service_id=1517 and optServiceId= ".$chrgData['service_id'];
	$getResult1=mysql_query($getMsisdnRecord);
	$Record=mysql_fetch_array($getResult1);

	echo $updateQuery="update master_db.tbl_refer_ussdData set status=5,chrgAmount=".$chrgData['chrg_amount'].",chrgDate=date(date_sub(now(),interval 1 day)) where date(referDate) between date(date_sub(now(),interval 3 day)) and date(date_sub(now(),interval 1 day)) and  friendANI=".$chrgData['msisdn']." and status=5 and service_id=1517 and optServiceId=".$chrgData['service_id']." and id=".$Record['id'];

	echo "<br>";
	$getUpdateResult=mysql_query($updateQuery);
}
mysql_close($dbConn);	
echo "done";
?>   