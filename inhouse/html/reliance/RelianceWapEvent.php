<?php
//error_reporting(0);
$mode=$_REQUEST['mode']; //'net';
$reqtype=$_REQUEST['reqtype'];
$msisdn=$_REQUEST['msisdn'];
$planid=$_REQUEST['planid'];
$affid=$_REQUEST['AFFID'];
$zoneid=$_REQUEST['zoneid'];
$remoteAdd=trim($_SERVER['REMOTE_ADDR']);
$subchannel ='net';
if($mode=='')
	$mode='net';
$seviceId=$_REQUEST['serviceid'];
$ac=0;
$curdate = date("Y-m-d");
$msisdn = substr($msisdn, -10);
$log_file_path="/var/www/html/reliance/logs/reliance/WAP/".$seviceId."/log_".$curdate.".txt";
$log_file_path=str_replace("'","",$log_file_path); 
$file=fopen($log_file_path,"a+");
chmod($log_file_path,0777);
if($msisdn)
{
$con = mysql_connect("192.168.100.224","weburl","weburl") or die('we are facing some temporarily problem please try later');
switch($seviceId)
	{
	//1202, reliance_hungama.JBOX_EVENT_ACT_BULK('$msisdn','01','$mode','54646','$amt','$s_id','$p_id','$b_id')
	//1208, reliance_cricket.JBOX_EVENT_ACT_BULK('$msisdn','01','$mode','54433','$amt','$s_id','$p_id','$b_id')
	//1201,reliance_music_mania.music_topupBulk('$msisdn','01','$mode','543219','$amt','$s_id','$p_id','$b_id')
		case '1201':
			$sc='543219';
			$s_id='1201';
			$subscriptionProcedure="reliance_music_mania.music_topupBulkWAP";
			//$unSubscriptionProcedure="reliance_hungama.MTV_UNSUB";
			$lang='01';
			break;
		case '1202':
			$sc='54646';
			$s_id='1202';
			$subscriptionProcedure="reliance_hungama.JBOX_EVENT_ACT_BULKWAP";
			//$unSubscriptionProcedure="reliance_hungama.JBOX_UNSUB";
			$lang='01';
			break;
		case '1208':
			$sc='54433';
			$s_id='1208';
			$subscriptionProcedure="reliance_cricket.JBOX_EVENT_ACT_BULK_WAP";
			//$unSubscriptionProcedure="reliance_cricket.CRICKET_UNSUB";
			$lang='01';
			break;
		}	
	if($reqtype==1)
	{
		$amtquery="select iAmount from master_db.tbl_plan_bank where Plan_id='$planid' and S_id=$seviceId";
		$amt = mysql_query($amtquery);
		List($row1) = mysql_fetch_row($amt);
		$amount = $row1;
		
		if ($_GET['amt'])
            $amount = $_GET['amt'];

			
		
		$actionQry="call ". $subscriptionProcedure." ('".$msisdn."','".$lang."','".$mode."','".$sc."','".$amount."',".$s_id.",".$planid;
		$actionQry .=",0,'".$affid."','".$zoneid."')";
		
	}
	if($reqtype == 2)
	{
		//$actionQry="call ".$unSubscriptionProcedure." ('$msisdn','$mode')";
	}
	if(mysql_query($actionQry))
	$resp='SUCCESS';
	else
	$resp=mysql_error();
	
	fwrite($file,$affid."#".$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $actionQry . "#" . $remoteAdd."#".$resp ."#".date('H:i:s')."\r\n" );
	echo "Success";
}
else
{
	fwrite($file,$affid."#".$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $actionQry . "#" . $remoteAdd."#".$resp ."#".date('H:i:s'). "\r\n" );
	echo "Msisdn Not found";
}
	fclose($file);
	mysql_close($con);
?>