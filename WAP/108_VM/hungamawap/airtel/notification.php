<?php
error_reporting(0);
include "/var/www/html/hungamawap/config/new_functions.php";
$starttime=date('Y-m-d H:i:s');
include "/var/www/html/hungamawap/airtel/db.php";

if($_REQUEST['msisdn']!='')
$msisdn=trim($_REQUEST['msisdn']);

$contentid = trim($_REQUEST['contentid']);
$contenttype = trim($_REQUEST['contenttype']);
$UA=$_REQUEST['UA'];


if (is_numeric($msisdn)) {

if (strlen($msisdn) == 12)
$msisdn = substr($msisdn, -10);
//ob_start();
  //Get Circle here
	$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
	$circle1=mysql_query($getCircle,$con);
	while($row = mysql_fetch_array($circle1)) {
		$circle = $row['circle'];
	}
	if(!$circle) { $circle='UND'; }
	
    $insQry = "insert into airtel_rasoi.tbl_ldr_wap_download (msisdn,contentid,date_time,status,contenttype,circle,device_browser)
                values ('$msisdn','$contentid',now(),'1','".$contenttype."','".$circle."','".mysql_real_escape_string($UA)."')";
    $insResult = mysql_query($insQry,$con);

	$updateQry = "update airtel_rasoi.tbl_rasoi_subscriptionWAP set total_no_downloads =total_no_downloads - 1 where ANI=" . $msisdn;
	$updateResult = mysql_query($updateQry,$con);
   echo $response = "success";
  // ob_flush();
   //flush();
   //update it on airtel server also
$getInfo="http://119.82.69.212/airtel/notification.php?msisdn=".$msisdn."&contentid=".$contentid."&contenttype=".$contenttype."&ua=".urlencode($UA);
$ch_result=curl_init($getInfo);
curl_setopt($ch_result,CURLOPT_RETURNTRANSFER,TRUE);
$result= curl_exec($ch_result);
curl_close($ch_result);
//echo $result;
		
} else {
    echo $response = "Invalid Parameter";

}

$logPath = "logs/notificationlog_" . date("Ymd") . ".txt";
$logData = $msisdn . "#" .$contentid."#".$contenttype."#".$response."#".$UA."#".$Remote_add."#".$starttime."#".date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath);
mysql_close($con);
//ob_end_flush();
?>
