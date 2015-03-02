<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");

$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

//$date="2013-02-02";

$serviceArray=array('1403'=>'MTVUninor','1402'=>'Uninor54646','1410'=>'RedFMUninor','1409'=>'RIAUninor','1412'=>'UninorRT','1416'=>'UninorAstro', '14021'=>'UninorArtistAloud','1408'=>'UninorSportsUnlimited','1418'=>'UninorComedy');

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',''=>'Others');


$delQuery1 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='".$date."' and service='".$serviceArray['1402']."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,addtime(concat(call_date,' ',call_time),duration_in_sec) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_54646_calllog where date(call_date)='".$date."' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and dnis NOT IN ('546461','5464626','5464628','5464611') and operator in ('UNIM')";
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

	$insertQuery1 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1402']."')";
	$result11 = mysql_query($insertQuery1,$LivdbConn);
}

$delQuery1 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='".$date."' and service='".$serviceArray['1403']."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,addtime(concat(call_date,' ',call_time),duration_in_sec) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_mtv_calllog where date(call_date)='".$date."' and dnis=546461 and operator in ('UNIM')";
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

	$insertQuery1 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1403']."')";
	$result11 = mysql_query($insertQuery1,$LivdbConn);
}


$delQuery1 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='".$date."' and service='".$serviceArray['1409']."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,addtime(concat(call_date,' ',call_time),duration_in_sec) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_54646_calllog where date(call_date)='".$date."' and dnis IN ('5464626','5464628','5464669') and operator in ('UNIM')";
$results1 = mysql_query($airtelQuery1,$dbConn);

while($row1 = mysql_fetch_array($results1)) {
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

	$insertQuery1 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1409']."')";
	$results11 = mysql_query($insertQuery1,$LivdbConn);
}


$delQuery1 = "DELETE FROM misdata.tbl_calling_astro WHERE date(starttime)='".$date."' and service='".$serviceArray['1416']."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,addtime(concat(call_date,' ',call_time),duration_in_sec) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_54646_calllog where date(call_date)='".$date."' and dnis like '5464627%' and operator in ('UNIM')";
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

	$insertQuery1 = "insert into misdata.tbl_calling_astro VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1416']."')";
	$result11 = mysql_query($insertQuery1,$LivdbConn);
}


$delQuery1 = "DELETE FROM misdata.tbl_calling_redfm WHERE date(starttime)='".$date."' and service='".$serviceArray['1410']."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,addtime(concat(call_date,' ',call_time),duration_in_sec) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_redfm_calllog where date(call_date)='".$date."' and dnis=55935 and operator in ('UNIM')";
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

	$insertQuery1 = "insert into misdata.tbl_calling_redfm VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1410']."')";
	$result11 = mysql_query($insertQuery1,$LivdbConn);
}

$delQuery1 = "DELETE FROM misdata.tbl_calling_comedy WHERE date(starttime)='".$date."' and service='".$serviceArray['1418']."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,addtime(concat(call_date,' ',call_time),duration_in_sec) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_azan_calllog where date(call_date)='".$date."' and dnis='5464622' and operator ='unim' ";
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

	$insertQuery1 = "insert into misdata.tbl_calling_redfm VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1418']."')";
	mysql_query($insertQuery1,$LivdbConn);
}


$delQuery1 = "DELETE FROM misdata.tbl_calling_aa_uninor WHERE date(starttime)='".$date."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,addtime(concat(call_date,' ',call_time),duration_in_sec) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_54646_calllog where date(call_date)='".$date."' and dnis='5464611' and operator in ('UNIM')";
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

	$insertQuery1 = "insert into misdata.tbl_calling_aa_uninor VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
	$result11 = mysql_query($insertQuery1,$LivdbConn);
}

$delQuery1 = "DELETE FROM misdata.tbl_calling_cri_uninor WHERE date(starttime)='".$date."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,addtime(concat(call_date,' ',call_time),duration_in_sec) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_cricket_calllog where date(call_date)='".$date."' and (dnis like '52255%' or dnis like '52299%') and operator in ('UNIM')";
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

	$insertQuery1 = "insert into misdata.tbl_calling_cri_uninor VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
	$result11 = mysql_query($insertQuery1,$LivdbConn);
}


$delQuery1 = "DELETE FROM misdata.tbl_calling_rt_uninor WHERE date(starttime)='".$date."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,addtime(concat(call_date,' ',call_time),duration_in_sec) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_rt_calllog where date(call_date)='".$date."' and dnis like '52888%' and operator in ('UNIM')";
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

	$insertQuery1 = "insert into misdata.tbl_calling_rt_uninor VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
	$result11 = mysql_query($insertQuery1,$LivdbConn);
}

echo "Done";
?>
