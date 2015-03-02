<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");

$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

$date="2013-08-07";

$serviceArray=array('1001'=>'TataDoCoMoMX','1002'=>'TataDoCoMo54646','1002P'=>'TataDoCoMo54646Pause','1003'=>'MTVTataDoCoMo','1005'=>'TataDoCoMoFMJ', '1009'=>'RIATataDoCoMo','1010'=>'REDFMTataDoCoMo','1011'=>'TataDoCoMoGL','1013'=>'TataDoCoMoMND' );

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',' '=>'Others');


$delQuery1 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='".$date."' and service='".$serviceArray['1001']."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_radio_calllog where date(call_date)='".$date."' and dnis like '59090%' and operator in ('TATM')";
$result1 = mysql_query($airtelQuery1,$dbConn);

$callPath1="/var/www/html/kmis/mis/livemis/calllogLive/1001/DoCoMoMX_".$date.".txt";
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1001']."\n";
	error_log($logData,3,$callPath1) ;

//	$insertQuery1 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1001']."')";
//	$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath1.'" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath1);

//==============================================================================================================

$delQuery1 = "DELETE FROM misdata.tbl_calling_mu_tatadocomo WHERE date(starttime)='".$date."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,dropReason from mis_db.tbl_radio_calllog where date(call_date)='".$date."' and dnis like '59090%' and operator in ('TATM')";
$result1 = mysql_query($airtelQuery1,$dbConn);

$callPath2="/var/www/html/kmis/mis/livemis/calllogLive/1002/DoCoMoMU_".$date.".txt";
while($row1 = mysql_fetch_array($result1)) {
	$msisdn = trim($row1[0]);
	$startTime = trim($row1[1]);
	$endTime = trim($row1[2]);
	$totalSec = trim($row1[3]);
	$pulse = trim($row1[4]);
	$dnis = trim($row1[5]);
	$circleCode = trim($row1[6]);
	$status= trim($row1[7]);
	$dropReason = trim($row1[8]);
	if($status == 1) $actualStatus = "Active";
	else $actualStatus = "NotActive";
	$circleName = $circle_info[strtoupper($circleCode)];
	if(!$circleName) $circleName = 'Others';
	if(!$endTime) $endTime=$startTime;

$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0"."\n";
	error_log($logData,3,$callPath2) ;

//	$insertQuery1 = "insert into misdata.tbl_calling_mu_tatadocomo VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '".$dropReason."','')";
//	$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath2.'" INTO TABLE misdata.tbl_calling_mu_tatadocomo 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath2);
//==============================================================================================================


$delQuery2 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='".$date."' and service='".$serviceArray['1002']."'";
$delResult2 = mysql_query($delQuery2,$LivdbConn);

$airtelQuery2 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_54646_calllog where date(call_date)='".$date."' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('546461','5464626','5464669','5464668') and dnis not like '%P%' and operator in ('TATM')";
$result2 = mysql_query($airtelQuery2,$dbConn);

$callPath3="/var/www/html/kmis/mis/livemis/calllogLive/1002/DoCoMo54646_".$date.".txt";
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
	
	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1002']."\n";
	error_log($logData,3,$callPath3) ;
	
	//$insertQuery2 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1002']."')";
	//$result12 = mysql_query($insertQuery2,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath3.'" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath3);
//==============================================================================================================


$delQuery3 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='".$date."' and service='".$serviceArray['1003']."'";
$delResult3 = mysql_query($delQuery3,$LivdbConn);

$airtelQuery3 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_mtv_calllog where date(call_date)='".$date."' and dnis like '546461%' and operator in ('TATM')";
$result3 = mysql_query($airtelQuery3,$dbConn);

$callPath4="/var/www/html/kmis/mis/livemis/calllogLive/1003/MTVTataDoCoMo_".$date.".txt";
while($row1 = mysql_fetch_array($result3)) {
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
	
	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1003']."\n";
	error_log($logData,3,$callPath4) ;

	//$insertQuery3 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1003']."')";
	//$result13 = mysql_query($insertQuery3,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath4.'" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath4);
//==============================================================================================================


$delQuery4 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='".$date."' and service='".$serviceArray['1009']."'";
$delResult4 = mysql_query($delQuery4,$LivdbConn);

$airtelQuery4 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_54646_calllog where date(call_date)='".$date."' and dnis in('5464669','5464668','5464626', '5464628') and operator in ('TATM')";
$result4 = mysql_query($airtelQuery4,$dbConn);

$callPath5="/var/www/html/kmis/mis/livemis/calllogLive/1009/RIATataDoCoMo_".$date.".txt";
while($row1 = mysql_fetch_array($result4)) {
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1009']."\n";
	error_log($logData,3,$callPath5) ;

	//$insertQuery4 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1009']."')";
	//$result14 = mysql_query($insertQuery4,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath5.'" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath5);
//==============================================================================================================


$delQuery5 = "DELETE FROM misdata.tbl_calling_redfm WHERE date(starttime)='".$date."' and service='".$serviceArray['1010']."'";
$delResult5 = mysql_query($delQuery5,$LivdbConn);

$airtelQuery5 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_redfm_calllog where date(call_date)='".$date."' and dnis=55935 and operator in ('TATM')";
$result5 = mysql_query($airtelQuery5,$dbConn);

$callPath6="/var/www/html/kmis/mis/livemis/calllogLive/1010/REDFMTataDoCoMo_".$date.".txt";
while($row1 = mysql_fetch_array($result5)) {
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1010']."\n";
	error_log($logData,3,$callPath6) ;

	//$insertQuery5 = "insert into misdata.tbl_calling_redfm VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1010']."')";
	//$result15 = mysql_query($insertQuery5,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath6.'" INTO TABLE misdata.tbl_calling_redfm 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath6);
//==============================================================================================================

$delQuery1 = "DELETE FROM misdata.tbl_calling_fmj_tatadocomo WHERE date(starttime)='".$date."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_starclub_calllog where date(call_date)='".$date."' and dnis in ('56666') and operator IN ('tatm')";
$result1 = mysql_query($airtelQuery1,$dbConn);

$callPath7="/var/www/html/kmis/mis/livemis/calllogLive/1005/TataDoCoMoFMJ_".$date.".txt";
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
	error_log($logData,3,$callPath7) ;

	//$insertQuery1 = "insert into misdata.tbl_calling_fmj_tatadocomo VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath7.'" INTO TABLE misdata.tbl_calling_fmj_tatadocomo 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath7);
//==============================================================================================================


$delQuery1 = "DELETE FROM misdata.tbl_calling_mnd_tatadocomo WHERE date(starttime)='".$date."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_mnd_calllog where date(call_date)='".$date."' and dnis in ('55001') and operator IN ('tatm')";
$result1 = mysql_query($airtelQuery1,$dbConn);

$callPath8="/var/www/html/kmis/mis/livemis/calllogLive/1013/TataDoCoMoMND_".$date.".txt";
unlink($callPath7);

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
	error_log($logData,3,$callPath8) ;

	/*$insertQuery1 = "insert into misdata.tbl_calling_mnd_tatadocomo VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
	$result11 = mysql_query($insertQuery1,$LivdbConn);*/
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath8.'" INTO TABLE misdata.tbl_calling_mnd_tatadocomo 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);

//unlink($callPath7);
//==============================================================================================================


echo "Done";
?>
