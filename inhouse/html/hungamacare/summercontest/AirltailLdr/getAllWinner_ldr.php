<?php
error_reporting(0);
include("/var/www/html/airtel/dbInhousewithAirtel.php");
$date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$allcircle=array();
$circle_mts=array('KAR','KER','GUJ','RAJ','KOL','UPW','DEL','TNU');
$getwinner_query="select msisdn,circle,chrg_amount,response_time from master_db.tbl_billing_success nolock 
where service_id=1527 and date(response_time)='".$date."'
and event_type='SUB' and chrg_amount=35 and mode='WAP' order by rand() limit 10";
$result_winner = mysql_query($getwinner_query, $dbConnAirtel) or die(mysql_error());
$result_row_winner = mysql_num_rows($result_winner);	
if ($result_row_winner > 0) {

$deletequery = "delete from airtel_rasoi.ldr_contest_recharge where date(date_time)='".$date."' ";
$result_delete = mysql_query($deletequery, $dbConn212) or die(mysql_error());
while ($winner_details = mysql_fetch_array($result_winner))
{
//insert in recharge table to process
$insert_query = "insert into airtel_rasoi.ldr_contest_recharge (ANI,date_time,recharge_flag,circle) 
values ('". $winner_details['msisdn'] ."','".$date."','0','" .$winner_details['circle']. "')";
mysql_query($insert_query, $dbConn212);
}

mysql_close($dbConn212);	
}
		else
{

 echo 'No records found';
exit;
}
echo 'done';
 mysql_close($dbConnAirtel);
?>  