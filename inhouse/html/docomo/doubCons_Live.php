<?php
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
$TPCGID=$_REQUEST['TPCGID'];
$transID=$_REQUEST['transID'];
$productId =$_REQUEST['productId'];

switch($productId)
		{
	/*	case 'GSMENDLESSDAILY2':
				$dbname="docomo_hungama";
				$subscriptionProcedure="JBOX_DC_SUBREQUEST";
				break;
		case 'GSMENDLESSMONTHLY60':
				$dbname="docomo_hungama";
				$subscriptionProcedure="JBOX_DC_SUBREQUEST";
				break;*/
		case 'GSMREDFM10':
				$dbname="docomo_redfm";
				$subscriptionProcedure="REDFM_DC_SUBREQUEST";
				break;				
				
				
		}
		$con = mysql_connect("192.168.100.224","webcc","webcc");
		
		if(!$con)
		{
			die('could not connect1: ' . mysql_error());
		}
		$call="call ".$dbname.".".$subscriptionProcedure."('$msisdn','$transID','$TPCGID','$mode')";
		//echo $call="call docomo_redfm.REDFM_DC_SUBREQUEST('9711711335','20130619113829','130619114018541979','IVR')";
		$qry1=mysql_query($call);
		$logData="#query#".$call."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$logPath2);
		mysql_close($con);
		
		
		
echo $servletResult="SUCCESS";
exit;
?>