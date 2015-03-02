<?php 
ob_start();
session_start();
require_once("../../db.php");
$type=$_REQUEST['type'];
$fromdate1=$_REQUEST['fromdate1'];
$todate1=$_REQUEST['todate1'];
$selDate = date("Y-m-d",strtotime($dateStr));

$cpgid=$_REQUEST['cpgid'];

$data_query= "select msisdn,processed_at,cpgid,sms from Inhouse_IVR.tbl_missedcall_smslist where cpgid='".$cpgid."' and date(processed_at) between '".$fromdate1."' and '".$todate1."' and status=1";
$data_query .=" order by processed_at desc ";
$obd_data = mysql_query($data_query, $con);
$result_row=mysql_num_rows($obd_data);
//$excellFile="TSV-".date("Ymd").".csv";
$excellFile="CampgionId($cpgid)-".date("Ymd").".xls";
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$excellFile");
if ($result_row > 0) {
$fp=fopen($excellFile,'a+');
fwrite($fp,'Cpgid'."\t".'Msisdn'."\t".'TimeStamp'."\t".'SMS-Text'."\r\n");
while($mis_array=mysql_fetch_array($obd_data))
	{
	$cpgid=$mis_array['cpgid'];
	$msisdn=$mis_array['msisdn'];
	$processed_at=$mis_array['processed_at'];
	$sms=$mis_array['sms'];
	$data=$cpgid."\t".$msisdn."\t".$processed_at."\t".$sms."\r\n";
	utf8_encode($data);
	$somecontent = mb_convert_encoding($data, 'HTML-ENTITIES', "UTF-8");

	fwrite($fp,$somecontent);
	}
	}
fclose($fp);
mysql_close($dbConn);
header("Pragma: no-cache");
header("Expires: 0");
?>