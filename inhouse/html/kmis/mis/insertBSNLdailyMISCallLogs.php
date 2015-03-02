<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
#include("/var/www/html/kmis/services/hungamacare/config/dbConnectBSNL.php");

$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

//echo $date="2014-11-24";

$serviceArray=array('2202'=>'BSNL54646');

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',''=>'Others');


$delQuery1 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='".$date."' and service='".$serviceArray['2202']."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);
/*
$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,addtime(concat(call_date,' ',call_time),duration_in_sec) as et,duration_in_sec,pulse,
    dnis, circle,status from mis_db.tbl_bsnl_54646_calllog where date(call_date)='".$date."' and dnis like '54646%' and operator in ('bsnl')";*/
	$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time),INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,
    dnis, circle,status from mis_db.tbl_bsnl_54646_calllog where date(call_date)='".$date."' and dnis like '54646%' and operator in ('bsnl')";
	
	
$result1 = mysql_query($airtelQuery1,$dbConn);

while($row1 = mysql_fetch_array($result1)) {
	$msisdn = trim($row1[0]);
	$startTime = trim($row1[1]);
	$endTime = trim($row1[2]);
	$totalSec = trim($row1[3]);
	$pulse = trim($row1[4]);
	$dnis = trim($row1[5]);
	$circleCode = trim($row1[6]);
	$status= trim($row1[7]);
	if($status == 1) $actualStatus = "Active";
	else $actualStatus = "NotActive";
	$circleName = $circle_info[strtoupper($circleCode)];
	if(!$circleName) $circleName = 'Others';

	$insertQuery1 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['2202']."')";
	$result11 = mysql_query($insertQuery1,$LivdbConn);
}


// insert the calling data of bsnl mnd

$airtelQuery2 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode from mis_db.tbl_mnd_calllog where date(call_date)='" . $date . "' and dnis='546464' and operator in ('bsnl')";
$result2 = mysql_query($airtelQuery2, $dbConn);

while ($row1 = mysql_fetch_array($result2)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
	$mode=trim($row1[8]);
	$plan_id='MND_';
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';
    if (!$endTime)
        $endTime = $startTime;
    if($mode)
	   $plan_id="MND_".$mode;

    $insertQuery2 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','".$plan_id."','".$serviceArray['2202']."')";
    $result12 = mysql_query($insertQuery2,$LivdbConn);
}




echo "Done";
?>
