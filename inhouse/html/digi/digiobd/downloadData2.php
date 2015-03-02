<?php 
include("session.php");
error_reporting(0);
//include database connection string
$dbConn = mysql_connect("172.16.56.42","root","D1g1r00t@!23") or die('we are facing some temporarily problem please try later');

$dateStr=$_REQUEST['selDate'];
$selDate = date("Y-m-d",strtotime($dateStr));
$type=$_REQUEST['type'];

$data_query= "SELECT ANI,startdate,enddate,Circle,status FROM db_obd.TBL_User_OBD where date(CALL_DATE)='".$selDate."'";
if($type == 1) {
	$data_query .= " and status=1";
} elseif($type == 10) {
	$data_query .= " and status!=1";
} else {
	$data_query="SELECT MSISDN,KEYPRESSED,CALLSTARTTIME,CALLENDTIME,CALLDURATION,FILEPLAYED,circle FROM db_obd.usercallhistory WHERE date(CALLSTARTTIME)='".$selDate."'";
}
$obd_data = mysql_query($data_query, $dbConn);
$result_row=mysql_num_rows($obd_data);

$excellFile="OBDData-".date("Ymd").".csv";
$excellFilePath=$excellDirPath.$excellFile;

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$excellFile");
if($type==1 || $type==10) {
	echo "Msisdn,StartDate,EndDate,Circle,Status"."\r\n";
} else {
	echo "Msisdn,KeyPressed,StartDate,EndDate,Call Duration,Circle"."\r\n";
}
if($type==1 || $type==10) {
	while($mis_array=mysql_fetch_array($obd_data))
	{
		if($mis_array[4] == 1) $status="Success"; else $status=$mis_array[4];
		echo $mis_array[0].",".$mis_array[1].",".$mis_array[2].",".$mis_array[3].",".$status."\r\n";
	}
} else {
	while($mis_array=mysql_fetch_array($obd_data))
	{
		if(strstr($mis_array[5],'nepali')) $circle="Nepali";
		elseif(strstr($mis_array[5],'bengali')) $circle="Bengali";
		else $circle="Indian";
		echo $mis_array[0].",".$mis_array[1].",".$mis_array[2].",".$mis_array[3].",".$mis_array[4].",".$circle."\r\n";
	}
}

header("Pragma: no-cache");
header("Expires: 0");
?> 
