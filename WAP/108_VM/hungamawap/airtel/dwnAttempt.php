<?php
error_reporting(0);
include "/var/www/html/hungamawap/config/new_functions.php";
$starttime=date('Y-m-d H:i:s');
include "/var/www/html/hungamawap/airtel/db.php";

if($_REQUEST['msisdn']!='')
$msisdn=trim($_REQUEST['msisdn']);

$contentid = trim($_REQUEST['contentid']);


if (is_numeric($msisdn)) {

if (strlen($msisdn) == 12)
$msisdn = substr($msisdn, -10);

    $selectData = "select count(*) from airtel_rasoi.tbl_ldr_wap_download nolock where status=1 and msisdn=" . $msisdn . " and contentid=" . $contentid;
    $result = mysql_query($selectData,$con);
    list($count) = mysql_fetch_array($result);

    
    if($count>=3)
	$left=0;
	else if($count==2)
	$left=1;
	else if($count==1)
	$left=2;
	
	if ($count == '' || $count == 0) {
        $left=3;
    }
	$response=$left;
	echo $response;
	
 
} else {
    echo $response = "Invalid Parameter";
}

$logPath = "logs/dwnAttemptlog_" . date("Ymd") . ".txt";
$logData = $msisdn . "#" .$contentid."#".$response."#".$starttime."#".date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath);
mysql_close($con);
?>
