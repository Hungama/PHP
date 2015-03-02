<?php
include ("/var/www/html/digi/dbDigiConnect.php");

$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

//echo $date="2013-02-10";

$serviceArray=array('1701'=>'DIGIMA');

function getCircle($shortCode)
{
	if(strpos($shortCode,'131221'))
		$circle='Bangla';
	elseif(strpos($shortCode,'131222'))
		$circle='Nepali';
	elseif(strpos($shortCode,'131224'))
		$circle='Indian';
	return $circle;
}


$delQuery = "DELETE FROM misdata.tbl_calling_mod_digi WHERE date(starttime)='".$date."'";
$delResult = mysql_query($delQuery,$LivdbConn);

$airtelQuery41 = "select msisdn,concat(call_date,' ',call_time) as st,addtime(concat(call_date,' ',call_time),duration_in_sec) as et,duration_in_sec,pulse,dnis, 'Indian',status from mis_db.tbl_digi_calllog where date(call_date)='".$date."' and dnis like '131224%'";
$result41 = mysql_query($airtelQuery41,$dbConn);

while($row1 = mysql_fetch_array($result41)) {
	$msisdn = trim($row1[0]);
	$startTime = trim($row1[1]);
	$endTime = trim($row1[2]);
	$totalSec = trim($row1[3]);
	$pulse = trim($row1[4]);
	$dnis = trim($row1[5]);
	$circleName = trim($row1[6]);
	$status= trim($row1[7]);
	if($status == 1) $actualStatus = "Active";
	else $actualStatus = "NotActive";
	
	if(!$circleName) $circleName = 'Others';
	if(!$endTime) $endTime=$startTime;
	$insertQuery = "insert into misdata.tbl_calling_mod_digi VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
	$result2 = mysql_query($insertQuery,$LivdbConn);
}

$airtelQuery41 = "select msisdn,concat(call_date,' ',call_time) as st,addtime(concat(call_date,' ',call_time),duration_in_sec) as et,duration_in_sec,pulse,dnis, 'Bangla',status from mis_db.tbl_digi_calllog where date(call_date)='".$date."' and dnis like '131221%'";
$result41 = mysql_query($airtelQuery41,$dbConn);

while($row1 = mysql_fetch_array($result41)) {
	$msisdn = trim($row1[0]);
	$startTime = trim($row1[1]);
	$endTime = trim($row1[2]);
	$totalSec = trim($row1[3]);
	$pulse = trim($row1[4]);
	$dnis = trim($row1[5]);
	$circleName = trim($row1[6]);
	$status= trim($row1[7]);
	if($status == 1) $actualStatus = "Active";
	else $actualStatus = "NotActive";
	
	if(!$circleName) $circleName = 'Others';
	if(!$endTime) $endTime=$startTime;
	$insertQuery = "insert into misdata.tbl_calling_mod_digi VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
	$result2 = mysql_query($insertQuery,$LivdbConn);
}

$airtelQuery41 = "select msisdn,concat(call_date,' ',call_time) as st,addtime(concat(call_date,' ',call_time),duration_in_sec) as et,duration_in_sec,pulse,dnis, 'Nepali',status from mis_db.tbl_digi_calllog where date(call_date)='".$date."' and dnis like '131222%'";
$result41 = mysql_query($airtelQuery41,$dbConn);

while($row1 = mysql_fetch_array($result41)) {
	$msisdn = trim($row1[0]);
	$startTime = trim($row1[1]);
	$endTime = trim($row1[2]);
	$totalSec = trim($row1[3]);
	$pulse = trim($row1[4]);
	$dnis = trim($row1[5]);
	$circleName = trim($row1[6]);
	$status= trim($row1[7]);
	if($status == 1) $actualStatus = "Active";
	else $actualStatus = "NotActive";
	
	if(!$circleName) $circleName = 'Others';
	if(!$endTime) $endTime=$startTime;

	$insertQuery = "insert into misdata.tbl_calling_mod_digi VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
	$result2 = mysql_query($insertQuery,$LivdbConn);
}

echo "Done";
?>
