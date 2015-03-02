<?php
error_reporting(1);
include("/var/www/html/kmis/services/hungamacare/config/db_airtel.php");
$msisdn = trim($_REQUEST['msisdn']);
$contentid = trim($_REQUEST['contentid']);
$contenttype = trim($_REQUEST['contenttype']);
$ua = trim($_REQUEST['ua']);
$serviceid = trim($_REQUEST['sid']);

$logPath = "/var/www/html/airtel/log/notification/notification_" . date("Y-m-d") . ".txt";
$logData = $msisdn . "#" . $contentid . "#" . date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath);

if ($msisdn == '' || $contentid == '') {
    echo $response = "Incomplete Parameter";
    $logData = $msisdn . "#" . $contentid . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
    exit;
}

function checkmsisdn($msisdn, $abc) {
    if (strlen($msisdn) == 12 || strlen($msisdn) == 10) {
        if (strlen($msisdn) == 12) {
            if (substr($msisdn, 0, 2) == 91) {
                $msisdn = substr($msisdn, -10);
            }
        }
    } else {
        echo "Invalid Parameter";
        exit;
    }
    return $msisdn;
}

if (is_numeric($msisdn)) {
    $msisdn = checkmsisdn(trim($msisdn), $abc);


switch($serviceid)
	{
	case '1527':
			 $db = "airtel_rasoi";
			 $subtable = $db .".tbl_rasoi_subscriptionWAP";
			 $dwntable = $db .".tbl_ldr_wap_download";			
			 break;
	case '1515':
			 $db = "airtel_devo";
			 $subtable = $db .".tbl_sarnam_subscriptionWAP";
			 $dwntable = $db .".tbl_wap_download";			
			 break;
	default:
			 $db = "airtel_rasoi";
			 $subtable = $db .".tbl_rasoi_subscriptionWAP";
			 $dwntable = $db .".tbl_ldr_wap_download";			
			 break;
   }
   

	$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
	$circle1=mysql_query($getCircle);
	while($row = mysql_fetch_array($circle1)) {
		$circle = $row['circle'];
	}
	if(!$circle) { $circle='UND'; }
	
    $insQry = "insert into $dwntable (msisdn,contentid,date_time,status,contenttype,circle,device_browser) values ('$msisdn','$contentid',now(),'1','".$contenttype."','".$circle."','".mysql_real_escape_string($ua)."')";
    if(mysql_query($insQry))
		$qres='SUCCESS';
	else
		$qres=mysql_error();

	$updateQry = "update $subtable set total_no_downloads =total_no_downloads - 1 where ANI=" . $msisdn;
	$updateResult = mysql_query($updateQry);
    
	echo $response = "success";

    $logData = $msisdn . "#" . $contentid . "#" . $response . "#" . $serviceid."#".$qres."#".$contenttype."#".date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
} else {
    echo $response = "Invalid Parameter";
    $logData = $msisdn . "#" . $contentid . "#" . $response . "#" .$serviceid."#".$qres."#".$contenttype."#".date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
}
mysql_close($dbAirtelConn);
?>