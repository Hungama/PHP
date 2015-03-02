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

$ac=0;
$curdate = date("Y-m-d");
$msisdn = substr($msisdn, -10);
$logDir='/var/www/html/vodafone/logs/'.$seviceId.'/Wap/';
$logFile='subscription_'.date('Y-m-d').".txt";
$logPath=$logDir.$logFile;


if($msisdn)
{
	include ("/var/www/html/hungamacare/dbConnect.php");
	//$dbConn
	switch($planid)
	{
		case '1':
			$sc='54646';
			$s_id='1302';
			$subscriptionTable="vodafone_hungama.tbl_jbox_subscription";
			$subscriptionProcedure="vodafone_hungama.JBOX_SUB";
			$unSubscriptionProcedure="vodafone_hungama.JBOX_UNSUB";
			$unSubscriptionTable="vodafone_hungama.tbl_jbox_unsub";
			$query="select count(*) from vodafone_hungama.tbl_jbox_subscription where ani=".$msisdn;
			$lang='01';
		break;
	}		
	$execute=mysql_query($query);
	$row=mysql_fetch_row($execute);
    
	if($msisdn && $row[0]==0 && $reqtype==1)
	{  
		$amtquery="select iAmount from master_db.tbl_plan_bank where Plan_id=".$planid." and S_id=".$s_id;
		$amt = mysql_query($amtquery,$dbConn);
		List($row1) = mysql_fetch_row($amt);
		$amount = $row1;
		$actionQry="call ".$subscriptionProcedure."('".$msisdn."','".$lang."','".$mode."','".$sc."','".$amount."',".$s_id.",".$planid.")";
		$qry1=mysql_query($actionQry,$dbConn) or die( mysql_error());
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
mysql_close($dbConn);
}	
	
?>   
