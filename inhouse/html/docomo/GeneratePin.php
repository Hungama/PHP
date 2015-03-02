<?php
error_reporting(0);
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
include_once("/var/www/html/kmis/services/hungamacare/config/dbConfig.php");
$msisdn=$_REQUEST['msisdn'];
$type=$_REQUEST['type'];
$pin1=$_REQUEST['pin'];
$serviceId=$_REQUEST['serviceId'];
$servicename="EndlessMusic";
$log_file_path="logs/docomo/subscription/".$servicename."/websubscription_".date('ymd').".txt";
$file=fopen($log_file_path,"a");
if($type=='pin')
{
	$pin=rand(1000,10000);
	$InsertPin="insert into docomo_radio.tbl_docomo_web values('',$msisdn,'$pin',now(),$serviceId,0)";
	$loginquery = mysql_query($InsertPin,$dbConn) or die(mysql_error());
	$msgSend="Welcome to Tata DoCoMo SongBook.Click http://bit.ly/pPGoeT to connect your Facebook account. Username:".$msisdn." Pass:".$pin;
	$Url="http://119.82.69.212:1111/HMXP/push.jsp";
	$data="smppgateway=HMXP&msisdn=$msisdn&shortcode=HUNVOC&msgtype=plaintext&msg=".$msgSend;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $Url);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$ApiResponse = curl_exec($ch);
	curl_close($ch);
	 
	fwrite($file,"pin"."#".$msisdn."#".$pin."#".$ApiResponse."#".date('H:i:s')."\r\n" );
	echo "pin sent";
}
elseif($type=='charge')
{
	$getCharged="select id from docomo_radio.tbl_docomo_web where msisdn=$msisdn and pin=$pin1 and status=0 and serviceid=$serviceId";
	$chargedResult = mysql_query($getCharged,$dbConn) or die(mysql_error());
	$chargedRow = mysql_fetch_array($chargedResult);
	if($chargedRow['id'])
	{
		if($serviceId==1001)
		{
			$lang=99;
			$mode='WAP';
			$sc=59090;
			$amount=2;
			$s_id=1001;
			$planid=1;
			$subscriptionProcedure="docomo_radio.RADIO_SUB";
		}
		elseif($serviceId==1601)
		{
			$lang=99;
			$mode='HUNWAP';
			$sc=59090;
			$amount=2;
			$s_id=1601;
			$planid=25;
			$subscriptionProcedure="indicom_radio.RADIO_SUB";
		}
		else
		{
			echo "Sevice Id Wrong";
			exit;
		}
		$call="call ".$subscriptionProcedure."('$msisdn','$lang','$mode','$sc','$amount',$s_id,$planid)";
		$qry1=mysql_query($call) or die( mysql_error() );

		$updateQuery="update docomo_radio.tbl_docomo_web set status=1 where msisdn=$msisdn and pin=$pin1 and serviceid=$serviceId";
		$qry2=mysql_query($updateQuery) or die( mysql_error() );
		echo "billing Request send ";
	}
	else
	{
		echo "Wrong Parameter send";
	}
	fwrite($file,"charging"."#".$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s'). "\r\n" );
}
fclose($file);


mysql_close($dbConn);

?>   