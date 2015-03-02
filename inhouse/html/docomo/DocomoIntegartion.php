<?php
error_reporting(0);
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
include_once("/var/www/html/kmis/services/hungamacare/config/dbConfig.php");

$msisdn=$_REQUEST['mobileno'];
$sc=$_REQUEST['service'];
$partner=$_REQUEST['partner'];
$mode=$_REQUEST['channel'];
$transid=$_REQUEST['transid'];

switch($sc)
{
	case '59090':
		$amount=2;
		$planid=1;
	break;
	case '590906':
		$amount=60;
		$planid=3;
	break;
	case '590907':
		$amount=14;
		$planid=2;
	break;
}

$servicename='EndlessMusic';
$s_id='1001';
$subscriptionProcedure="docomo_radio.RADIO_SUB";
$lang='99';

$call="call ".$subscriptionProcedure."('$msisdn','$lang','$mode','$sc','$amount',$s_id,$planid)";
$qry1=mysql_query($call) or die( mysql_error() );

$hunTransId=date('ymdhis');
echo "SUCCESS";
$fileDir="/var/www/html/docomo/logs/pcnlog/";
$fileName=date('Ymd').".txt";
$logFilePath=$fileDir.$fileName;
$fp=fopen($logFilePath,'a+');
fwrite($fp,$msisdn."|".$sc."|".$partner."|".$mode."|".$transid."|".$hunTransId."\r\n");
fclose($fp);

mysql_close($dbConn);

?>   