<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");

$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

//echo $date="2013-10-29";

$serviceArray=array('1602'=>'TataIndicom54646','1601'=>'TataDoCoMoMXcdma','1603'=>'MTVTataDoCoMocdma','1605'=>'TataDoCoMoFMJcdma','1609'=>'RIATataDoCoMocdma', '1610'=>'REDFMTataDoCoMocdma','1611'=>'TataDoCoMoGLcdma','1613'=>'TataDoCoMoMNDcdma');

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',''=>'Others');


$delQuery1 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='".$date."' and service='".$serviceArray['1602']."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_54646_calllog nolock where date(call_date)='".$date."' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis like '5464646%') and dnis  not in ('546461','5464626','5464669','5464668') and operator in('TATC')";
$result1 = mysql_query($airtelQuery1,$dbConn);

$callPath1="/var/www/html/kmis/mis/livemis/calllogLive/1602/TataIndicom54646_".$date.".txt";
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1602']."\n";
	error_log($logData,3,$callPath1) ;

	//$insertQuery1 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1602']."')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath1.'" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath1);
//=======================================================================================================

$delQuery1 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='".$date."' and service='".$serviceArray['1603']."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_mtv_calllog nolock where date(call_date)='".$date."' and dnis=546461 and operator in('TATC')";
$result1 = mysql_query($airtelQuery1,$dbConn);

$callPath2="/var/www/html/kmis/mis/livemis/calllogLive/1603/MTVTataDoCoMocdma_".$date.".txt";
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1603']."\n";
	error_log($logData,3,$callPath2) ;

	//$insertQuery1 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1603']."')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath2.'" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath2);
//=======================================================================================================



$delQuery1 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='".$date."' and service='".$serviceArray['1609']."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_54646_calllog nolock where date(call_date)='".$date."' and dnis in('5464669','5464668','5464626') and operator in('TATC')";
$result1 = mysql_query($airtelQuery1,$dbConn);

$callPath3="/var/www/html/kmis/mis/livemis/calllogLive/1609/RIATataDoCoMocdma_".$date.".txt";
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1609']."\n";
	error_log($logData,3,$callPath3) ;

	//$insertQuery1 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1609']."')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath3.'" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath3);
//=======================================================================================================


$delQuery1 = "DELETE FROM misdata.tbl_calling_mu_tatadocomocdma WHERE date(starttime)='".$date."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_radio_calllog nolock where date(call_date)='".$date."' and dnis like '59090%' and operator in('TATC','tatc')";
$result1 = mysql_query($airtelQuery1,$dbConn);

$callPath4="/var/www/html/kmis/mis/livemis/calllogLive/1601/TataDoCoMoMXcdma_".$date.".txt";
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
	error_log($logData,3,$callPath4) ;

	//$insertQuery1 = "insert into misdata.tbl_calling_mu_tatadocomocdma VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath4.'" INTO TABLE misdata.tbl_calling_mu_tatadocomocdma 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath4);
//=======================================================================================================



$delQuery2 = "DELETE FROM misdata.tbl_calling_redfm WHERE date(starttime)='".$date."' and service='".$serviceArray['1610']."'";
$delResult2 = mysql_query($delQuery2,$LivdbConn);

$airtelQuery2 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_redfm_calllog nolock where date(call_date)='".$date."' and dnis=55935 and operator in('TATC')";
$result2 = mysql_query($airtelQuery2,$dbConn);

$callPath5="/var/www/html/kmis/mis/livemis/calllogLive/1610/REDFMTataDoCoMocdma_".$date.".txt";
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1610']."\n";
	error_log($logData,3,$callPath5) ;

	//$insertQuery2 = "insert into misdata.tbl_calling_redfm VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1610']."')";
	//$result12 = mysql_query($insertQuery2,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath5.'" INTO TABLE misdata.tbl_calling_redfm 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath5);
//=======================================================================================================


$delQuery1 = "DELETE FROM misdata.tbl_calling_fmj_tatadocomocdma WHERE date(starttime)='".$date."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_starclub_calllog nolock where date(call_date)='".$date."'  and dnis=56666 and operator in('TATC','tatc')";
$result1 = mysql_query($airtelQuery1,$dbConn);

$callPath6="/var/www/html/kmis/mis/livemis/calllogLive/1605/TataDoCoMoFMJcdma_".$date.".txt";
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
	error_log($logData,3,$callPath6) ;

	//$insertQuery1 = "insert into misdata.tbl_calling_fmj_tatadocomocdma VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath6.'" INTO TABLE misdata.tbl_calling_fmj_tatadocomocdma 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath6);
//=======================================================================================================


$delQuery1 = "DELETE FROM misdata.tbl_calling_mnd_tatadocomocdma WHERE date(starttime)='".$date."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_mnd_calllog nolock where date(call_date)='".$date."'  and dnis=55001 and operator in('TATC','tatc')";
$result1 = mysql_query($airtelQuery1,$dbConn);

$callPath7="/var/www/html/kmis/mis/livemis/calllogLive/1605/TataDoCoMoMNDcdma_".$date.".txt";
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
	error_log($logData,3,$callPath7) ;

	//$insertQuery1 = "insert into misdata.tbl_calling_fmj_tatadocomocdma VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
	//$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath7.'" INTO TABLE misdata.tbl_calling_mnd_tatadocomocdma 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);

//=======================================================================================================

mysql_close($dbConn);
mysql_close($LivdbConn);
echo "Done";
?>