<?php
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$reqtype=$_REQUEST['reqtype'];
$planid=$_REQUEST['planid'];
$mode=$_REQUEST['mode'];
$subchannel = $_REQUEST['subchannel'];
$AFFID=$_REQUEST['AFFID'];
$zoneid=$_REQUEST['zoneid'];


$logFile_dump="/var/www/html/vodafone/vodafone/logs/dump/ccgdump_".date('Ymd').".txt";
$filePointer=fopen($logFile_dump,'a+');
chmod($logFile_dump,0777);
$arrCnt=sizeof($_REQUEST);
for($i=0;$i<$arrCnt;$i++)
{
	$keys=array_keys($_REQUEST);
	
}
for($k=0;$k<$arrCnt;$k++)
{
	fwrite($filePointer,$keys[$k].'=>'.$_REQUEST[$keys[$k]]."|");
}
fwrite($filePointer,date('H:i:s')."\n");
fclose($filePointer);
//end here

if($AFFID=='null' || $AFFID=='')
$AFFID = 0; 

if($zoneid=='null' || $zoneid=='')
$zoneid = 0; 

$refererName=$_SERVER['HTTP_REFERER'];

if(!$_REQUEST['subchannel'])
	$subchannel = $mode; 

if($mode=='') 
	$mode='net';

$seviceId=$_REQUEST['serviceid'];

$ac=0;
$curdate = date("Y-m-d");
if(strlen($msisdn)==12)
	$msisdn = substr($msisdn, -10);
	
$logDir='/var/www/html/vodafone/vodafone/logs/'.$seviceId.'/Wap/';
$logFile='subscription_'.date('Y-m-d').".txt";
$logPath=$logDir.$logFile;


if($msisdn)
{
	//include ("/var/www/html/vodafone/dbConnect.php");
	$dbConn = mysql_connect("10.43.248.137","php_promo","php@321");
	if(!$dbConn)
	{
		die('could not connect: ' . mysql_error());
	}
	switch($planid)
	{
		case '1':
			$sc='54646';
			$s_id='1302';
			$subscriptionTable="vodafone_hungama.tbl_jbox_subscription";
			$subscriptionProcedure="vodafone_hungama.JBOX_SUB";
			$subscriptionProcedure="vodafone_hungama.JBOX_SUB_WAP";
			$unSubscriptionProcedure="vodafone_hungama.JBOX_UNSUB";
			$unSubscriptionTable="vodafone_hungama.tbl_jbox_unsub";
			$query="select count(*) from vodafone_hungama.tbl_jbox_subscription nolock where ani=".$msisdn;
			$lang='01';
		break;
		case '6':
		case '7':
			$sc='55665';
			$s_id='1301';
			$subscriptionTable="vodafone_radio.tbl_radio_subscription";
			//$subscriptionProcedure="vodafone_radio.radio_sub";
			$subscriptionProcedure="vodafone_radio.radio_SUB_WAP";
			$unSubscriptionProcedure="vodafone_radio.radio_unsub";
			$unSubscriptionTable="vodafone_radio.tbl_radio_unsub";
			$query="select count(*) from vodafone_radio.tbl_radio_subscription nolock where ani=".$msisdn;
			$lang='01';
		break;
		case '4':
			$sc='55841';
			$s_id='1307';
			$subscriptionTable="vodafone_vh1.tbl_jbox_subscription";
			$subscriptionProcedure="vodafone_vh1.JBOX_SUB";
			$unSubscriptionProcedure="vodafone_vh1.JBOX_UNSUB";
			$unSubscriptionTable="vodafone_vh1.tbl_jbox_unsub";
			$query="select count(*) from vodafone_vh1.tbl_jbox_subscription nolock where ani=".$msisdn;
			$lang='01';
		break;
		case '3':
			$sc='55935';
			$s_id='1310';
			$subscriptionTable="vodafone_redfm.tbl_jbox_subscription";
			$subscriptionProcedure="vodafone_redfm.JBOX_SUB";
			$unSubscriptionProcedure="vodafone_redfm.JBOX_UNSUB";
			$unSubscriptionTable="vodafone_redfm.tbl_jbox_unsub";
			$query="select count(*) from vodafone_redfm.tbl_jbox_subscription nolock where ani=".$msisdn;
			$lang='01';
		break;
	}		
	$execute=mysql_query($query);
	$row=mysql_fetch_row($execute);
    
	if($msisdn && $row[0]==0 && $reqtype==1)
	{  
	
		$amtquery="select iAmount from master_db.tbl_plan_bank nolock where Plan_id=".$planid." and S_id=".$s_id;
		$amt = mysql_query($amtquery,$dbConn);
		List($row1) = mysql_fetch_row($amt);
		$amount = $row1;
		
		if($s_id==1301 || $s_id==1302)
		$actionQry="call ".$subscriptionProcedure."('".$msisdn."','".$lang."','".$mode."','".$sc."','".$amount."',".$s_id.",".$planid.",".$AFFID.",".$zoneid.")";
		else
		$actionQry="call ".$subscriptionProcedure."('".$msisdn."','".$lang."','".$mode."','".$sc."','".$amount."',".$s_id.",".$planid.")";
		
		if(mysql_query($actionQry,$dbConn))
		echo $response="Success";
		else
		echo $response=mysql_error();
		$subscriptionString=$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . $actionQry."#" . $rcode .  "#" .$response. "#".$AFFID."#".$refererName."#".date('H:i:s') ."\r\n" ;
	}
	elseif($row[0]>0)
	{
		echo $response="Already Subscribed";
		$subscriptionString=$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode .  "#" .$response."#".$AFFID."#".$refererName."#".date('H:i:s')."\r\n" ;
	}
	else
	{
		echo $response="Failure";
		$subscriptionString=$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . $actionQry."#".$rcode .  "#" .$response. "#".$AFFID."#".$refererName."#".date('H:i:s') ."\r\n" ;
	}
	
error_log($subscriptionString,3,$logPath);
mysql_close($dbConn);
}	
?>