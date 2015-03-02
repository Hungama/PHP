<?php 
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$msisdn=$_REQUEST['ani'];
$mode='OBD-FKS';
$operator=strtoupper($_REQUEST['operator']);
$remoteAdd=trim($_SERVER['REMOTE_ADDR']);
$curdate = date("Y-m-d");
$log_file_path="/var/www/html/CelebChat/log/".$curdate.".txt";
$LogString=$msisdn."#".$mode."#".$operator."#".date('H:i:s');

if($msisdn && $mode && $operator) 
{ 
	switch($operator)
	{
		case 'UNIM':
			$sc='54646';
			$s_id='1402';
			$lang='HIN';
			$plan_id='10';
			$amount=10;
		Break;
		case 'RELC':
			$sc='54646';
			$s_id='1202';
			$lang='HIN';
			$plan_id='5';
			$amount=10;
		Break;
		default:
			echo $response1="Failure|Operator not configured";
		exit;
		break;
	}
	$getCircle="select circle from master_db.tbl_valid_series where series=substring($msisdn,1,4) and length(series)=4";
	$circle1=mysql_query($getCircle) or die( mysql_error() );
	$circle=mysql_fetch_row($circle1);
	$insertToppupRequest="insert into master_db.tbl_billing_reqs values('',$msisdn,'TOPUP',now(),$amount,0,'$lang',$sc,'$mode','$circle[0]','$operator',$s_id,0,$plan_id)";
	$qry1=mysql_query($insertToppupRequest) or die( mysql_error());
	echo $response1="Success |".rand();
} 
else 
{
	echo $response1="Failure|Incomplete Parameter";
}
$LogString .="#".$response1."#".$remoteAdd."\r\n";
error_log($LogString,3,$log_file_path);
mysql_close($dbConnInhouseM); 

?>