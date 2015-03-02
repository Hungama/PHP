<?php
$msisdn=$_REQUEST['msisdn'];
$reqtype=$_REQUEST['reqtype'];
$planid=$_REQUEST['planid'];
$mode=$_REQUEST['mode'];
$subchannel = $_REQUEST['subchannel'];

if(!$_REQUEST['subchannel'])
	$subchannel = $mode; 

if($mode=='') 
	$mode='net';

$seviceId=$_REQUEST['serviceid'];
//$seviceId1=1511;
$ac=0;
$curdate = date("Y-m-d");
$msisdn = substr($msisdn, -10);
$logDir='/var/www/html/airtel/logs/'.$seviceId.'/Wap/';
$logFile='subscription_'.date('Y-m-d').".txt";
$logPath=$logDir.$logFile;

if($msisdn)
{
	$con = mysql_connect("10.2.73.156","root","");
 	switch($planid)
	{
		case '29':
			$sc='55001';
			$s_id='1511';
			$subscriptionTable="airtel_rasoi.tbl_rasoi_subscription";
			$subscriptionProcedure="airtel_rasoi.RASOI_SUB";
			$unSubscriptionProcedure="airtel_rasoi.RASOI_UNSUB";
			$unSubscriptionTable="airtel_rasoi.tbl_rasoi_unsub";
			$query="select count(*) from airtel_rasoi.tbl_rasoi_subscription where ani=".$msisdn;
			$lang='01';
		break;
		case '28':
			$sc='55841';
			$s_id='1507';
			$subscriptionTable="airtel_vh1.tbl_jbox_subscription";
			$subscriptionProcedure="airtel_vh1.JBOX_SUB";
			$unSubscriptionProcedure="airtel_vh1.JBOX_UNSUB";
			$unSubscriptionTable="airtel_vh1.tbl_jbox_unsub";
			$query="select count(*) from airtel_vh1.tbl_jbox_subscription where ani=".$msisdn;
			$lang='01';
		break;
	}		
	$execute=mysql_query($query);
	$row=mysql_fetch_row($execute);
    //print_r($row);
	/*echo "Q:".$query;
	echo "M:".$msisdn;
	echo "R:".$row[0];*/
	if($msisdn && $row[0]==0 && $reqtype==1)
	{  
		$amtquery="select iAmount from master_db.tbl_plan_bank where Plan_id=".$planid." and S_id=".$s_id;
		$amt = mysql_query($amtquery);
		List($row1) = mysql_fetch_row($amt);
		$amount = $row1;
		$actionQry="call ".$subscriptionProcedure."('".$msisdn."','".$lang."','".$mode."','".$sc."','".$amount."',".$s_id.",".$planid.")";
		$qry1=mysql_query($actionQry) or die( mysql_error());
		echo $response="Success";
		$subscriptionString=$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode .  "#" .$response. "\r\n" ;
	}
	elseif($row[0]>0)
	{
		echo $response="Already Subscribed";
		$subscriptionString=$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode .  "#" .$response. "\r\n" ;
	}
	else
	{
		echo $response="Failure";
		$subscriptionString=$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode .  "#" .$response. "\r\n" ;
	}
	
error_log($subscriptionString,3,$logPath);
mysql_close($con);
}	
	
?>   
