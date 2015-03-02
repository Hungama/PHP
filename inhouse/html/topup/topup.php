<?php 
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$msisdn=$_REQUEST['ani'];
$mode='OBD-MS';
$operator=strtoupper($_REQUEST['operator']);
$amount=$_REQUEST['amount'];
$sCode=$_REQUEST['scode'];
if(!$sCode)
	$sCode=54646;
$remoteAdd=trim($_SERVER['REMOTE_ADDR']);
$curdate = date("Y-m-d");
$log_file_path="/var/www/html/topup/log/topup_log_".$curdate.".txt";
$LogString=$msisdn."#".$mode."#".$amount."#".$operator."#".date('H:i:s');

function getTopUpDetails($operator,$sCode)
{
	switch($operator)
	{
		case 'UNIM':
			switch($sCode)
			{
				case '54646':
					$sc='54646';
					$s_id='1402';
					$lang='HIN';
					$plan_id='86';	//$amount=10;
				Break;
				case '5464626':
					$sc='5464626';
					$s_id='1409';
					$lang='HIN';
					$plan_id='87';	//$amount=10;
				Break;
			}
		break;
		case 'RELC':
			$sc='54646';
			$s_id='1202';
			$lang='HIN';
			$plan_id='5';	//$amount=10;
		Break;
		case 'TATM':
			$sc='54646';
			$s_id='1602';
			$lang='HIN';
			$plan_id='8';			
		Break;
		case 'TATC':
			$sc='54646';
			$s_id='1002';
			$lang='HIN';
			$plan_id='24';
		Break;
		default:
			echo $response1="Failure|Operator not configured";
		exit;
		break;
			
	}
	$topUpDetails1=$sc."#".$s_id."#".$lang."#".$plan_id;
	return $topUpDetails1;
}
if($msisdn && $mode && $operator) 
{ 
	$topUpDetails=getTopUpDetails($operator,$sCode);
	$explodeDetails=explode('#',$topUpDetails);
	$getCircle="select circle from master_db.tbl_valid_series where series=substring($msisdn,1,4) and length(series)=4";
	$circle1=mysql_query($getCircle) or die( mysql_error() );
	$circle=mysql_fetch_row($circle1);
	$insertToppupRequest="insert into master_db.tbl_billing_reqs values('',$msisdn,'TOPUP',now(),$amount,0,'$explodeDetails[2]',$explodeDetails[0],'$mode','$circle[0]','$operator',$explodeDetails[1],0,$explodeDetails[3])";
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