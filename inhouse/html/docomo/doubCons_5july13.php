<?php
error_reporting(1);
$logDir="/var/www/html/docomo/logs/docomo/dc/ivr/";
$logFile="sdpResponse_".date('Ymd');
$logPath=$logDir.$logFile.".txt";
$curdate = date("Ymd");
$logPath2 = $logDir."data_".$curdate.".txt";

		
$filePointer=fopen($logPath,'a+');
chmod($logPath,0777);
$arrCnt=sizeof($_REQUEST);
$str='';
for($i=0;$i<$arrCnt;$i++)
{
	$keys=array_keys($_REQUEST);
	
}
for($k=0;$k<$arrCnt;$k++)
{
	fwrite($filePointer,$keys[$k].'=>'.$_REQUEST[$keys[$k]]."|");
	//$str.=$_REQUEST[$keys[$k]]."|";
}
fwrite($filePointer,date('H:i:s')."\n");
$msisdn=$_REQUEST['MSISDN'];
$mode=$_REQUEST['mode'];
if(empty($mode))
{
$mode='IVR';
}
//$mode='IVR';
$TPCGID=$_REQUEST['TPCGID'];
$transID=$_REQUEST['transID'];
$productId =$_REQUEST['productId'];
switch($productId)
		{
		case 'GSMHMP30':
				$dbname="docomo_hungama";
				$subscriptionProcedure_ccg="JBOX_DC_SUBREQUEST";
				break;
		case 'GSMREDFM10':
				$dbname="docomo_redfm";
				$sc='55935';
				$s_id='1010';
				$subscriptionProcedure="REDFM_SUB_DC";
				//$unSubscriptionProcedure="JBOX_UNSUB";
				//$unSubscriptionTable="tbl_jbox_unsub";
				$planid=38;
				$lang='01';
				$operator = "TATM";
				$subscriptionProcedure_ccg="REDFM_DC_SUBREQUEST";
				break;				
				
				
		}
		
			//db connect
		$con = mysql_connect("192.168.100.224","webcc","webcc");
		
		if(!$con)
		{
		$logData="#DB-Status-NotConnected#".date("Y-m-d H:i:s")."\n";
			die('could not connect1: ' . mysql_error());
		}
		else
		{
		$logData="#DB-Status-Connected#".date("Y-m-d H:i:s")."\n";
		}
		error_log($logData,3,$logPath2);
			//added only for WAP start here
			if($mode=='WAP')
			{
			$amt = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='$planid'" );
			List($row1) = mysql_fetch_row($amt);
			$amount = $row1;
			$call="call ".$dbname.".".$subscriptionProcedure."('$msisdn','$lang','$mode','$sc','$amount',$s_id,$planid,'$transID')";
			$result =mysql_query($call,$con);
			if($result)
			{
			$logData="#query-WAP#".$call."#Success#".date("Y-m-d H:i:s")."\n";
			}
			else
			{
			$logData="#query-WAP#".$call."#Failure#".date("Y-m-d H:i:s")."\n";
			// die('Invalid query: ' . mysql_error());
			}
				error_log($logData,3,$logPath2);
			}
			//added only for WAP end here
		sleep(2);
		$call="call ".$dbname.".".$subscriptionProcedure_ccg."('$msisdn','$transID','$TPCGID','$mode')";
		$result =mysql_query($call,$con);
		if($result)
		{
		$logData="#query#".$call."#Success#".date("Y-m-d H:i:s")."\n";
		}
		else
		{
		$logData="#query#".$call."#Failure".date("Y-m-d H:i:s")."\n";
		//die('Invalid query: ' . mysql_error());
		}
		error_log($logData,3,$logPath2);
		sleep(2);
		mysql_close($con);
				
		
echo $servletResult="SUCCESS";
exit;
?>