<?php
error_reporting(0);
include "/var/www/html/hungamawap/config/new_functions.php";
include "/var/www/html/hungamawap/airtel/db.php";
include "/var/www/html/hungamawap/airtel/sarnam/baseConfig.php";

if($_REQUEST['msisdn']!='')
$msisdn=trim($_REQUEST['msisdn']);

if (is_numeric($msisdn)) {
if (strlen($msisdn) == 12)
$msisdn = substr($msisdn, -10);
    
	$selectData = "select contentid from $dwntable nolock where msisdn='".$msisdn."' and status=1 and contentid!=''";
    $result = mysql_query($selectData,$con);
	$totalCount=mysql_num_rows($result);
	$contentidArray=array();
	
	if($totalCount>=1)
	{
    while($data = mysql_fetch_array($result))
	{
	$contentidArray[]=$data['contentid'];
	}
	$response = implode("#", $contentidArray);
	}
	else
	{
	$response =0;
	}
	
	echo $response;

} else {
    echo $response = "Invalid Parameter";
}

$logPath = "logs/myacoountlog_" . date("Ymd") . ".txt";
$logData = $msisdn . "#" .$response."#".date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath);
mysql_close($con);
?>