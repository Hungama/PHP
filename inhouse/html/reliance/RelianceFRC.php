<?php
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$msisdn=$_GET['msisdn'];
$channel=$_GET['mode'];
if($msisdn=='' || $channel=='')
{
	echo "Please provide required parameters";
	exit;
}

$checkStatus="select count(*) from reliance_cricket.tbl_cricket_subscription where ani=$msisdn";
$checkResult = mysql_query($checkStatus, $dbConn) or die(mysql_error());
$id = mysql_fetch_row($checkResult);

$Series="select circle from master_db.tbl_valid_series where series=substring($msisdn,1,4) and length(series)=4";
$selectSeries = mysql_query($Series, $dbConn) or die(mysql_error());
$circle = mysql_fetch_row($selectSeries);
	if($id[0]<1)
	{
		$insertData="insert into reliance_cricket.tbl_cricket_subscription(ani,sub_date,renew_date,def_lang,status,mode_of_sub,dnis,user_bal,sub_type,circle,plan_id,frc_date,frc_status)";  
		$insertData.=" values($msisdn,now(),date(date_add(now(),interval +7 day)),'01','5','$channel','54433',0,'',";
		$insertData .="'$circle[0]',0,";
		$insertData .="now(),'')";
		$insertResult = mysql_query($insertData, $dbConn) or die(mysql_error());
		//$iMsg="Congrats, U have been selected for FREE trail of Reliance CricketMania for 30 days. Dial 54433,predict and win Blackberry, Laptops, Talktime";
		//echo $msg_call="insert into tbl_reliance_sms(ani,message,date_time,status,dnis) values($fileContent[0],'$iMsg',now(),0,54433)";
		//mysql_query($msg_call, $dbConn);
		$response="Success";
	}
else
{
	$response="Already Subscribed";
}
echo $response;
$dateformat=date('Ymd');
$logpath="/var/www/html/reliance/logs/frc/frc_".$dateformat.".txt";
$errorString=$msisdn."|".$channel."|".date('h:i:s')."|".$response."|".$circle[0]."\r\n";
error_log($errorString,3,$logpath);

?>