<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

$msisdn = trim($_REQUEST['msisdn']);
$planId = trim($_REQUEST['planid']);
$contentId = trim($_REQUEST['contentid']);
$pricePoint = trim($_REQUEST['price']);
$mode = trim($_REQUEST['mode']);

$serviceId="1412";

$msisdn = substr($msisdn, -10);

$type = "";
$fieldName="";

function checkstatus($planId,$pricePoint) {
	global $type, $fieldName;
	switch($planId) {
		case '69':  if($pricePoint<=7) $flag=1;
					else $flag=0;
					$type="PT";
					$fieldName="PT_ID";
		break;
		case '70': 
					if($pricePoint<=5) $flag=1;
					else $flag=0;
					$type="MT";
					$fieldName="MT_ID";
		break;
		case '71': 
					if($pricePoint<=10) $flag=1;
					else $flag=0;
					$type="TT";
					$fieldName="TT_ID";
		break;
	}
	return $flag;
}

$logPath='/var/www/html/Uninor/logs/uninor/subscription/Uninor_Ring/ringSub_'.date('Y-m-d').".txt";

if(is_numeric($msisdn) && is_numeric($planId) && $contentId && is_numeric($pricePoint)) {
	$sc='52888';
	$checkStatus = checkstatus($planId,$pricePoint);
	if($checkStatus) { 		
		$query = "SELECT SongUniqueCode FROM uninor_myringtone.tbl_song_details WHERE ".$fieldName."=".$contentId;
		$data = mysql_query($query);
		list($songId) = mysql_fetch_array($data);

		$call = "CALL uninor_myringtone.RADOI_SUBRINGTONE('".$msisdn."','01','".$mode."','".$sc."',".$pricePoint.",".$serviceId.",".$planId.", ".$contentId.", '".$songId."','".$type."')";
		mysql_query($call);
		$logData = $msisdn."#".$planId."#".$contentId."#".$pricePoint."#".$serviceId."#".$mode."#".$songId."#".$type."#".$call."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$logPath);
		echo "Success";
	} else {
		$logData = $msisdn."#".$planId."#".$contentId."#".$pricePoint."#".$serviceId."#".$mode."#".$type."#Failure:Mismatch in planId and charging amount#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$logPath);
		echo "Failure";
	}
	mysql_close($con);
} else {
	$logData = $msisdn."#".$planId."#".$contentId."#".$pricePoint."#".$serviceId."#".$mode."#Failure:Invalid Parameter#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);
	echo "Invalid Parameter";
}

?>   