<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$msisdn=$_REQUEST['msisdn'];
$type=$_REQUEST['rtype'];

$mode=$_REQUEST['mode'];
if($mode=='') $mode='wap';

$serviceId="1412";
$lang='01';
$dnis="52888";
$amount=$_REQUEST['amount'];
$ringId = $_REQUEST['ringid'];

$curdate = date("Y-m-d");
$msisdn = substr($msisdn, -10);
$outStr ="";

$logDir='/var/www/html/Uninor/logs/uninor/subscription/Wap/';
$logFile='rtLogs_'.date('Y-m-d').".txt";
$logPath=$logDir.$logFile;
if($msisdn)
{
	switch($type) {
	case 'tt': $planid="71"; 
			   $sQuery = "select SongUniqueCode from uninor_myringtone.tbl_song_details where TT_ID='".$ringId."'";
			   $sResult = mysql_query($sQuery) or die(mysql_error());			   
			   list($songId) = mysql_fetch_array($sResult); 
		break;
	case 'mt': $planid="70"; 			   
			   $songId="";		
		break;
	case 'pt': $planid="69"; 
			   $songId="";	
		break;
	}	
	
	$query = "CALL uninor_myringtone.RADOI_SUBRINGTONE('".$msisdn."','".$lang."','".$mode."','".$dnis."','".$amount."', '".$serviceId."', '".$planid."', '".$ringId."','".$songId."','".$type."',@a)";
	mysql_query($query);
	$logData = $msisdn."#".$query."#SUCCESS#".date('Y-m-d H:i:s')."\n";	
	error_log($logData,3,$logPath);
	echo "SUCCESS";
} else {
	echo "FAILURE";
	$logData = $msisdn."#".$planid."#".$ringId."#".$type."#FAILURE#".date('Y-m-d H:i:s')."\n";	
	error_log($logData,3,$logPath);
}

mysql_close($dbConn);
?>   