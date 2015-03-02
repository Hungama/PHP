<?php
$logDir="/var/www/html/docomo/logs/docomo/dc/ussd/";
$logFile="sdpResponse_".date('Ymd');
$logPath=$logDir.$logFile.".txt";
$filePointer=fopen($logPath,'a+');
chmod($logPath,0777);
$arrCnt=sizeof($_REQUEST);
$con = mysql_connect("192.168.100.224","webcc","webcc");
//print_r ($_REQUEST);
$str='';
$test=$_REQUEST['test'];
$msisdn=$_REQUEST['MSISDN'];
$mode=$_REQUEST['mode'];
$mode='USSD';
$CGPResult=$_REQUEST['Result'];

$TPCGID=$_REQUEST['TPCGID'];
$transID=$_REQUEST['transID'];
$productId =$_REQUEST['productId'];

$startTime=date("H:i:s");
for($i=0;$i<$arrCnt;$i++)
{
	$keys=array_keys($_REQUEST);
	
}
for($k=0;$k<$arrCnt;$k++)
{
	fwrite($filePointer,$keys[$k].'=>'.$_REQUEST[$keys[$k]]."|");
	$str.=$_REQUEST[$keys[$k]]."|";
}
fwrite($filePointer,date('H:i:s')."\n");
$data=explode("|",$str);

	switch ($productId)
	{
	case 'GSMENDLESSDAILY2':
				$dbname="docomo_radio";
				$subscriptionProcedure_ccg="RADIO_DC_SUBREQUEST";
				break;
	case 'GSMENDLESSWEEKLY14':
				$dbname="docomo_radio";
				$subscriptionProcedure_ccg="RADIO_DC_SUBREQUEST";
				break;
	case 'GSMENDLESS10':
				$dbname="docomo_radio";
				$subscriptionProcedure_ccg="RADIO_DC_SUBREQUEST";
				break;
	case 'GSMENDLESSMONTHLY60':
				$dbname="docomo_radio";
				$subscriptionProcedure_ccg="RADIO_DC_SUBREQUEST";
				break;
		
	}

		$call="call ".$dbname.".".$subscriptionProcedure_ccg."('$msisdn','$transID','$TPCGID','$mode')";
			
		if($CGPResult=='SUCCESS')
		{
		$result =mysql_query($call,$con);
		if($result)
		{
		$logData="#query#".$call."#Success#".date("Y-m-d H:i:s")."\n";
		}
		else
		{
		$logData="#query#".$call."#Failure".date("Y-m-d H:i:s")."\n";
		}
		}
		else
		{
		$logData="#query_notcall#".$call."#".$CGPResult."#".date("Y-m-d H:i:s")."\n";
		}
		error_log($logData,3,$logPath);
		mysql_close($con);
echo $servletResult="SUCCESS";
exit;
?>