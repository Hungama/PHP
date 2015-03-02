<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");

$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

//echo $date="2013-10-30";

$serviceArray=array('1801'=>'TataDoCoMoMXvmi','1810'=>'RedFMTataDoCoMovmi','1809'=>'RIATataDoCoMovmi');

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',' '=>'Others');


$delQuery1 = "DELETE FROM misdata.tbl_calling_redfm WHERE date(starttime)='".$date."' and service='".$serviceArray['1810']."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_redfm_calllog nolock where date(call_date)='".$date."' and dnis like '55935%' and operator in ('virm')";
$result1 = mysql_query($airtelQuery1,$dbConn);

$callPath1="/var/www/html/kmis/mis/livemis/calllogLive/1810/RedFMTataDoCoMovmi_".$date.".txt";
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
	if(!$endTime) $endTime=$startTime;

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1810']."\n";
	error_log($logData,3,$callPath1) ;

	//$insertQuery1 = "insert into misdata.tbl_calling_redfm VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1810']."')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath1.'" INTO TABLE misdata.tbl_calling_redfm 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath1);
//========================================================================================================


$delQuery1 = "DELETE FROM misdata.tbl_calling_mu_tatadocomovmi WHERE date(starttime)='".$date."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_radio_calllog nolock where date(call_date)='".$date."' and dnis like '59090%' and operator in ('virm')";
$result1 = mysql_query($airtelQuery1,$dbConn);

$callPath2="/var/www/html/kmis/mis/livemis/calllogLive/1801/TataDoCoMoMXvmi_".$date.".txt";
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
	if(!$endTime) $endTime=$startTime;

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0"."\n";
	error_log($logData,3,$callPath2) ;

	//$insertQuery1 = "insert into misdata.tbl_calling_mu_tatadocomovmi VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath2.'" INTO TABLE misdata.tbl_calling_mu_tatadocomovmi 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath2);
//========================================================================================================



$delQuery2 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='".$date."' and service='".$serviceArray['1809']."'";
$delResult2 = mysql_query($delQuery2,$LivdbConn);

$airtelQuery2 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status 
from mis_db.tbl_54646_calllog nolock where date(call_date)='".$date."' and (dnis like '5464626%' or dnis like '5464646%') and operator in ('virm')";
$result2 = mysql_query($airtelQuery2,$dbConn);

$callPath3="/var/www/html/kmis/mis/livemis/calllogLive/1809/RIATataDoCoMovmi_".$date.".txt";
while($row1 = mysql_fetch_array($result2)) {
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
	if(!$endTime) $endTime=$startTime;
	
	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1809']."\n";
	error_log($logData,3,$callPath3) ;

	//$insertQuery2 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1809']."')";
	//$result12 = mysql_query($insertQuery2,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath3.'" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath3);
//========================================================================================================


mysql_close($dbConn);
mysql_close($LivdbConn);
echo "Done";
?>
