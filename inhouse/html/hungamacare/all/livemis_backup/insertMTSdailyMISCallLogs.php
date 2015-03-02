<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");

$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

//echo $date="2013-08-07";

$serviceArray=array('1102'=>'MTS54646','1103'=>'MTVMTS','11012'=>'MTSComedy','1111'=>'MTSDevo','1101'=>'MTSMU','1116'=>'MTSVA','1113'=>'MTSMND', '1110'=>'REDFMMTS');

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',' '=>'Others');


$delQuery1 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='".$date."' and service='".$serviceArray['1102']."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_54646_calllog where date(call_date)='".$date."' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis != 546461 ";
$result1 = mysql_query($airtelQuery1,$dbConn);

$callPath1="/var/www/html/kmis/mis/livemis/calllogLive/1102/MTS54646_".$date.".txt";
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1102']."\n";
	error_log($logData,3,$callPath1) ;

	//$insertQuery1 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1102']."')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath1.'" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath1);
//========================================================================================================


$delQuery1 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='".$date."' and service='".$serviceArray['1103']."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_mtv_calllog where date(call_date)='".$date."' and dnis=546461 ";
$results1 = mysql_query($airtelQuery1,$dbConn);

$callPath2="/var/www/html/kmis/mis/livemis/calllogLive/1103/MTVMTS_".$date.".txt";
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
	if(!$endTime) $endTime=$startTime;

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1103']."\n";
	error_log($logData,3,$callPath2) ;

	//$insertQuery1 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1103']."')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath2.'" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath1);
//========================================================================================================

$delQueryR = "DELETE FROM misdata.tbl_calling_redfm WHERE date(starttime)='".$date."' and service='".$serviceArray['1110']."'";
$delResultR = mysql_query($delQueryR,$LivdbConn);

$airtelQueryR = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_redfm_calllog where date(call_date)='".$date."' and dnis=55935 ";
$resultsR = mysql_query($airtelQueryR,$dbConn);

$callPath3="/var/www/html/kmis/mis/livemis/calllogLive/1110/REDFMMTS_".$date.".txt";
while($rowR = mysql_fetch_array($resultsR)) {
	$msisdn = trim($rowR[0]);
	$startTime = trim($rowR[1]);
	$endTime = trim($rowR[2]);
	$totalSec = trim($rowR[3]);
	$pulse = trim($rowR[4]);
	$dnis = trim($rowR[5]);
	$circleCode = trim($rowR[6]);
	$status= trim($rowR[7]);
	if($status == 1) $actualStatus = "Active";
	else $actualStatus = "NotActive";
	$circleName = $circle_info[strtoupper($circleCode)];
	if(!$circleName) $circleName = 'Others';
	if(!$endTime) $endTime=$startTime;

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1110']."\n";
	error_log($logData,3,$callPath3) ;

	//$insertQuery1 = "insert into misdata.tbl_calling_redfm VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1110']."')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath3.'" INTO TABLE misdata.tbl_calling_redfm 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath1);
//========================================================================================================

$delQuery1 = "DELETE FROM misdata.tbl_calling_comedy WHERE date(starttime)='".$date."' and service='".$serviceArray['11012']."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard from mis_db.tbl_radio_calllog where date(call_date)='".$date."' and dnis='5222212' ";
$result12 = mysql_query($airtelQuery1,$dbConn);

$callPath4="/var/www/html/kmis/mis/livemis/calllogLive/11012/MTSComedy_".$date.".txt";
while($row1 = mysql_fetch_array($result12)) {
	$msisdn = trim($row1[0]);
	$startTime = trim($row1[1]);
	$endTime = trim($row1[2]);
	$totalSec = trim($row1[3]);
	$pulse = trim($row1[4]);
	$dnis = trim($row1[5]);
	$circleCode = trim($row1[6]);
	$status= trim($row1[7]);
	 $lastHeard = trim($row1[8]);
	if($status == 1) $actualStatus = "Active";
	else $actualStatus = "NotActive";
	$circleName = $circle_info[strtoupper($circleCode)];
	if(!$circleName) $circleName = 'Others';
	if(!$endTime) $endTime=$startTime;

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#".$lastHeard."#0#".$serviceArray['11012']."\n";
	error_log($logData,3,$callPath4) ;

	//$insertQuery1 = "insert into misdata.tbl_calling_comedy VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['11012']."')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath4.'" INTO TABLE misdata.tbl_calling_comedy 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath1);
//========================================================================================================

$delQuery1 = "DELETE FROM misdata.tbl_calling_devo_mts WHERE date(starttime)='".$date."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_Devotional_calllog where date(call_date)='".$date."' and dnis=5432105";
$result13 = mysql_query($airtelQuery1,$dbConn);

$callPath5="/var/www/html/kmis/mis/livemis/calllogLive/1111/MTSDevo_".$date.".txt";
while($row1 = mysql_fetch_array($result13)) {
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
	error_log($logData,3,$callPath5) ;

	//$insertQuery1 = "insert into misdata.tbl_calling_devo_mts VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath5.'" INTO TABLE misdata.tbl_calling_devo_mts 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath1);
//========================================================================================================
 
$delQuery1 = "DELETE FROM misdata.tbl_calling_mu_mts WHERE date(starttime)='".$date."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard from mis_db.tbl_radio_calllog where date(call_date)='".$date."' and dnis like '52222%' and dnis!='5222212' ";
$result14 = mysql_query($airtelQuery1,$dbConn);

$callPath6="/var/www/html/kmis/mis/livemis/calllogLive/1101/MTSMU_".$date.".txt";
while($row1 = mysql_fetch_array($result14)) {
	$msisdn = trim($row1[0]);
	$startTime = trim($row1[1]);
	$endTime = trim($row1[2]);
	$totalSec = trim($row1[3]);
	$pulse = trim($row1[4]);
	$dnis = trim($row1[5]);
	$circleCode = trim($row1[6]);
	$status= trim($row1[7]);
	$lastHeard = trim($row1[8]);
	if($status == 1)
		$actualStatus = "Active";
	else
		$actualStatus = "NotActive";
	$circleName = $circle_info[strtoupper($circleCode)];
	if(!$circleName)
		$circleName = 'Others';
	if(!$endTime) 
		$endTime=$startTime;

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#".trim($row1['lastHeard'])."#0"."\n";
	error_log($logData,3,$callPath6) ;

	//$insertQuery1 = "insert into misdata.tbl_calling_mu_mts VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
} 
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath6.'" INTO TABLE misdata.tbl_calling_mu_mts 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath1);
//========================================================================================================

$delQuery1 = "DELETE FROM misdata.tbl_calling_va_mts WHERE date(starttime)='".$date."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_voicealert_calllog where date(call_date)='".$date."' and dnis like '54444%' ";
$result15 = mysql_query($airtelQuery1,$dbConn);

$callPath7="/var/www/html/kmis/mis/livemis/calllogLive/1116/MTSVA_".$date.".txt";
while($row1 = mysql_fetch_array($result15)) {
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

	//$insertQuery1 = "insert into misdata.tbl_calling_va_mts VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath7.'" INTO TABLE misdata.tbl_calling_va_mts 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath1);
//========================================================================================================

$delQuery1 = "DELETE FROM misdata.tbl_calling_mnd_mts WHERE date(starttime)='".$date."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_54646_calllog where date(call_date)='".$date."' and dnis like '54646196%' ";
$result15 = mysql_query($airtelQuery1,$dbConn);

$callPath8="/var/www/html/kmis/mis/livemis/calllogLive/1113/MTSMND_".$date.".txt";
while($row1 = mysql_fetch_array($result15)) {
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

	//$insertQuery1 = "insert into misdata.tbl_calling_mnd_mts VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath8.'" INTO TABLE misdata.tbl_calling_mnd_mts 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath1);
//========================================================================================================

$delQuery1 = "DELETE FROM misdata.tbl_calling_fmj_mts WHERE date(starttime)='".$date."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_mtv_calllog where date(call_date)='".$date."' and dnis IN (5432155,54321551,54321552,54321553)";
$result15 = mysql_query($airtelQuery1,$dbConn);

$callPath9="/var/www/html/kmis/mis/livemis/calllogLive/1105/MTSFMJ_".$date.".txt";
while($row1 = mysql_fetch_array($result15)) {
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
	error_log($logData,3,$callPath9) ;

	//$insertQuery1 = "insert into misdata.tbl_calling_fmj_mts VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath9.'" INTO TABLE misdata.tbl_calling_fmj_mts 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath1);
//========================================================================================================

//========================================================================================================

$delQueryR = "DELETE FROM misdata.tbl_calling_ac_mts WHERE date(starttime)='".$date."'";
$delResultR = mysql_query($delQueryR,$LivdbConn);

$airtelQueryR = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard from mis_db.tbl_AC_calllog where date(call_date)='".$date."'";
$resultsR = mysql_query($airtelQueryR,$dbConn);

$callPath3="/var/www/html/kmis/mis/livemis/calllogLive/1124/ACMTS_".$date.".txt";
while($rowR = mysql_fetch_array($resultsR)) {
	$msisdn = trim($rowR[0]);
	$startTime = trim($rowR[1]);
	$endTime = trim($rowR[2]);
	$totalSec = trim($rowR[3]);
	$pulse = trim($rowR[4]);
	$dnis = trim($rowR[5]);
	$circleCode = trim($rowR[6]);
	$status= trim($rowR[7]);
	$lastHeard = trim($rowR[8]);
	if($status == 1) $actualStatus = "Active";
	else $actualStatus = "NotActive";
	$circleName = $circle_info[strtoupper($circleCode)];
	if(!$circleName) $circleName = 'Others';
	if(!$endTime) $endTime=$startTime;

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#".$lastHeard."#0#"."\n";
	error_log($logData,3,$callPath3) ;
}
echo $insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath3.'" INTO TABLE misdata.tbl_calling_ac_mts 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath3);
//========================================================================================================


echo "Done";
?>
