<?php
error_reporting(0);
include "/var/www/html/hungamawap/config/new_functions.php";
$starttime=date('Y-m-d H:i:s');
include "/var/www/html/hungamawap/airtel/db.php";

if($_REQUEST['msisdn']!='')
$msisdn=trim($_REQUEST['msisdn']);

if (is_numeric($msisdn)) {
    
	$selectData = "select contentid from airtel_rasoi.tbl_ldr_wap_download nolock where msisdn='".$msisdn."' and status=1";
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
$logData = $msisdn . "#" .$response."#".$starttime."#".date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath);
mysql_close($con);
?>