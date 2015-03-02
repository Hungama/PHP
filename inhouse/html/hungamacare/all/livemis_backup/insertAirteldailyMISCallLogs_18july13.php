<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");

$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

//echo $date="2013-05-18";

$serviceArray=array('1501'=>'AirtelEU','1502'=>'Airtel54646','1503'=>'MTVAirtel','1511'=>'AirtelGL','1507'=>'VH1Airtel','1509'=>'RIAAirtel', '1518'=>'AirtelComedy','1513'=>'AirtelMND','1514'=>'AirtelPD','1517'=>'AirtelSE','1515'=>'AirtelDevo','1520'=>'AirtelPK');

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',' '=>'Others');


$delQuery = "DELETE FROM misdata.tbl_calling_comedy WHERE date(starttime)='".$date."' and service='".$serviceArray['1518']."'";
$delResult = mysql_query($delQuery,$LivdbConn);

$airtelQuery41 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard from mis_db.tbl_54646_calllog where date(call_date)='".$date."' and dnis in ('5464612') and operator='airm' ";
$result41 = mysql_query($airtelQuery41,$dbConnAirtel);

$callPath1="/var/www/html/kmis/mis/livemis/calllogLive/1518/AirtelComedy_".$date.".txt";
unlink($callPath1);
while($row1 = mysql_fetch_array($result41)) {
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#".$lastHeard."#0#".$serviceArray['1518']."\n";
	error_log($logData,3,$callPath1) ;

	//$insertQuery = "insert into misdata.tbl_calling_comedy VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1518']."')";
	//$result2 = mysql_query($insertQuery,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath1.'" INTO TABLE misdata.tbl_calling_comedy 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath1);
//========================================================================================================

$airtelQuery2 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard from mis_db.tbl_54646_calllog where date(call_date)='".$date."' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis='54646' or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('546461','546461000','5464612') and dnis not like '%P%' and operator='airm'";
$result31 = mysql_query($airtelQuery2,$dbConnAirtel);

$delQuery = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='".$date."' and service='Airtel54646'";
$delResult = mysql_query($delQuery,$LivdbConn);

$callPath2="/var/www/html/kmis/mis/livemis/calllogLive/1502/Airtel54646_".$date.".txt";
unlink($callPath2);
while($row1 = mysql_fetch_array($result31)) {
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#".$lastHeard."#0#"."Airtel54646"."\n";
	error_log($logData,3,$callPath2) ;

	//$insertQuery = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1502']."')";
	//$result21 = mysql_query($insertQuery,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath2.'" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath2);
//========================================================================================================

$airtelQuery2 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard from mis_db.tbl_54646_calllog where date(call_date)='".$date."' and dnis='55841' and operator='airm'";
$result32 = mysql_query($airtelQuery2,$dbConnAirtel);

$delQuery = "DELETE FROM misdata.tbl_calling_vh1 WHERE date(starttime)='".$date."' and service='VH1Airtel'";
$delResult = mysql_query($delQuery,$LivdbConn);

$callPath3="/var/www/html/kmis/mis/livemis/calllogLive/1507/VH1Airtel_".$date.".txt";
unlink($callPath3);

while($row1 = mysql_fetch_array($result32)) {
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#".$lastHeard."#0#"."VH1Airtel"."\n";
	error_log($logData,3,$callPath3) ;

	//$insertQuery = "insert into misdata.tbl_calling_vh1 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1507']."')";
	//$result22 = mysql_query($insertQuery,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath3.'" INTO TABLE misdata.tbl_calling_vh1 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath3);
//========================================================================================================


$airtelQuery3 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard from mis_db.tbl_radio_calllog where date(call_date)='".$date."' and dnis like '5464613%' and operator='airm'";
$result3 = mysql_query($airtelQuery3,$dbConnAirtel);

$delQuery = "DELETE FROM misdata.tbl_calling_pk WHERE date(starttime)='".$date."' and service='AirtelPK'";
$delResult = mysql_query($delQuery,$LivdbConn);

$callPath4="/var/www/html/kmis/mis/livemis/calllogLive/1520/AirtelPK_".$date.".txt";
unlink($callPath4);
while($row1 = mysql_fetch_array($result3)) {
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#".$lastHeard."#0#"."AirtelPK"."\n";
	error_log($logData,3,$callPath4) ;

	//$insertQuery = "insert into misdata.tbl_calling_pk VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1520']."')";
	//$result24 = mysql_query($insertQuery,$LivdbConn);
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath4.'" INTO TABLE misdata.tbl_calling_pk 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath4);
//========================================================================================================

$airtelQuery41 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard from mis_db.tbl_edu_calllog where date(call_date)='".$date."' and dnis like '53222345%' and operator ='airm'";
$result41 = mysql_query($airtelQuery41,$dbConnAirtel);

$delQuery = "DELETE FROM misdata.tbl_calling_pd_airtel WHERE date(starttime)='".$date."'";
$delResult = mysql_query($delQuery,$LivdbConn);

$callPath5="/var/www/html/kmis/mis/livemis/calllogLive/1514/AirtelPD_".$date.".txt";
unlink($callPath5);
while($row1 = mysql_fetch_array($result41)) {
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#".$lastHeard."#0"."\n";
	error_log($logData,3,$callPath5) ;

	//$insertQuery = "insert into misdata.tbl_calling_pd_airtel VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."','','')";
	//$result24 = mysql_query($insertQuery,$LivdbConn);
} 
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath5.'" INTO TABLE misdata.tbl_calling_pd_airtel 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath5);
//========================================================================================================

$airtelQuery5 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard from mis_db.tbl_SPKNG_calllog where date(call_date)='".$date."' and dnis like '571811%' and operator ='airm'";
$result5 = mysql_query($airtelQuery5,$dbConnAirtel);

$delQuery = "DELETE FROM misdata.tbl_calling_se_airtel WHERE date(starttime)='".$date."'";
$delResult = mysql_query($delQuery,$LivdbConn);

$callPath6="/var/www/html/kmis/mis/livemis/calllogLive/1517/AirtelSE_".$date.".txt";
unlink($callPath6);
while($row1 = mysql_fetch_array($result5)) {
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#".$lastHeard."#0"."\n";
	error_log($logData,3,$callPath6) ;

	//$insertQuery = "insert into misdata.tbl_calling_se_airtel VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."','','')";
	//$result25 = mysql_query($insertQuery,$LivdbConn);
} 
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath6.'" INTO TABLE misdata.tbl_calling_se_airtel 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath6);

//========================================================================================================

$airtelQuery6 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard from mis_db.tbl_devotional_calllog where date(call_date)='".$date."' and dnis like '51050%' and operator ='airm'";
$result6 = mysql_query($airtelQuery6,$dbConnAirtel);

$delQuery = "DELETE FROM misdata.tbl_calling_devo_airtel WHERE date(starttime)='".$date."'";
$delResult = mysql_query($delQuery,$LivdbConn);

$callPath7="/var/www/html/kmis/mis/livemis/calllogLive/1515/AirtelDevo_".$date.".txt";
unlink($callPath7);
while($row1 = mysql_fetch_array($result6)) {
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#".$lastHeard."#0"."\n";
	error_log($logData,3,$callPath7) ;

	//$insertQuery = "insert into misdata.tbl_calling_devo_airtel VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."','','')";
	//$result25 = mysql_query($insertQuery,$LivdbConn);
} 
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath7.'" INTO TABLE misdata.tbl_calling_devo_airtel 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath7);
//========================================================================================================

$airtelQuery7 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard from mis_db.tbl_riya_calllog where date(call_date)='".$date."' and dnis IN ('5500169','54646169') and operator ='airm'";
$result7 = mysql_query($airtelQuery7,$dbConnAirtel);

$delQuery = "DELETE FROM misdata.tbl_calling_ria_airtel WHERE date(starttime)='".$date."'";
$delResult = mysql_query($delQuery,$LivdbConn);

$callPath8="/var/www/html/kmis/mis/livemis/calllogLive/1509/RIAAirtel_".$date.".txt";
unlink($callPath8);
while($row1 = mysql_fetch_array($result7)) {
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#".$lastHeard."#0"."\n";
	error_log($logData,3,$callPath8) ;

	//$insertQuery = "insert into misdata.tbl_calling_ria_airtel VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."','','')";
	//$result27 = mysql_query($insertQuery,$LivdbConn);
} 
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath8.'" INTO TABLE misdata.tbl_calling_ria_airtel 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath8); 
//========================================================================================================

$airtelQuery8 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time),INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis,circle,status,lastSection,language from mis_db.tbl_AMU_calllog where date(call_date)='".$date."' and dnis like '546469%' and operator ='airm'";
$result8 = mysql_query($airtelQuery8,$dbConnAirtel);

$delQuery = "DELETE FROM misdata.tbl_calling_mu_airtel WHERE date(starttime)='".$date."'";
$delResult = mysql_query($delQuery,$LivdbConn);

$callPath9="/var/www/html/kmis/mis/livemis/calllogLive/1501/AirtelEU_".$date.".txt";

unlink($callPath9);

while($row1 = mysql_fetch_array($result8)) {
	$msisdn = trim($row1[0]);
	$startTime = trim($row1[1]);
	$endTime = trim($row1[2]);
	$totalSec = trim($row1[3]);
	$pulse = trim($row1[4]);
	$dnis = trim($row1[5]);
	$circleCode = trim($row1[6]);
	$status= trim($row1[7]);
	$lastSection= trim($row1[8]);
	$lang= trim($row1[9]);
	if($status == 1) $actualStatus = "Active";
	else $actualStatus = "NotActive";
	$circleName = $circle_info[strtoupper($circleCode)];
	if(!$circleName) $circleName = 'Others';

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#".$lastSection."#".$lang."\n";
	error_log($logData,3,$callPath9) ;

	//$insertQuery = "insert into misdata.tbl_calling_mu_airtel VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."','','')";
	//$result28 = mysql_query($insertQuery,$LivdbConn);
} 
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath9.'" INTO TABLE misdata.tbl_calling_mu_airtel 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath9);

//========================================================================================================

$airtelQuery9 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard from mis_db.tbl_mnd_calllog where date(call_date)='".$date."' and (dnis like '5500196%' OR dnis like '54646196') and operator ='airm'";
$result9 = mysql_query($airtelQuery9,$dbConnAirtel);

$delQuery = "DELETE FROM misdata.tbl_calling_mnd_airtel WHERE date(starttime)='".$date."'";
$delResult = mysql_query($delQuery,$LivdbConn);

$callPath10="/var/www/html/kmis/mis/livemis/calllogLive/1513/AirtelMND_".$date.".txt";
unlink($callPath10);
while($row1 = mysql_fetch_array($result9)) {
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#".$lastHeard."#0"."\n";
	error_log($logData,3,$callPath10) ;

	//$insertQuery = "insert into misdata.tbl_calling_mnd_airtel VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."','','')";
	//$result29 = mysql_query($insertQuery,$LivdbConn);
} 
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath10.'" INTO TABLE misdata.tbl_calling_mnd_airtel 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath10);
//========================================================================================================

$airtelQuery10 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard from mis_db.tbl_edu_calllog where date(call_date)='".$date."' and dnis like '5464614%' and operator='airm' and circle IN ('CHN','TNU')";
$result10 = mysql_query($airtelQuery10,$dbConnAirtel);

$delQuery = "DELETE FROM misdata.tbl_calling_comedy WHERE date(starttime)='".$date."' and service='AirtelRegTN'";
$delResult = mysql_query($delQuery,$LivdbConn);

$callPath11="/var/www/html/kmis/mis/livemis/calllogLive/1518/AirtelRegTN_".$date.".txt";
unlink($callPath11);
while($row1 = mysql_fetch_array($result10)) {
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#".$lastHeard."#0#"."AirtelRegTN"."\n";
	error_log($logData,3,$callPath11) ;

	//$insertQuery = "insert into misdata.tbl_calling_comedy VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."','','','AirtelRegTN')";
	//$result210 = mysql_query($insertQuery,$LivdbConn);
} 
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath11.'" INTO TABLE misdata.tbl_calling_comedy 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath11);
//========================================================================================================

$airtelQuery11 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard from mis_db.tbl_edu_calllog where date(call_date)='".$date."' and dnis like '5464614%' and operator='airm' and circle IN ('KAR')";
$result11 = mysql_query($airtelQuery11,$dbConnAirtel);

$delQuery = "DELETE FROM misdata.tbl_calling_comedy WHERE date(starttime)='".$date."' and service='AirtelRegKK'";
$delResult = mysql_query($delQuery,$LivdbConn);

$callPath12="/var/www/html/kmis/mis/livemis/calllogLive/1518/AirtelRegKK_".$date.".txt";
unlink($callPath12);
while($row1 = mysql_fetch_array($result11)) {
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

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#".$lastHeard."#0#"."AirtelRegKK"."\n";
	error_log($logData,3,$callPath12) ;

	//$insertQuery = "insert into misdata.tbl_calling_comedy VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."','','','AirtelRegKK')";
	//$result210 = mysql_query($insertQuery,$LivdbConn);
} 
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath12.'" INTO TABLE misdata.tbl_calling_comedy 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath12);
//========================================================================================================

echo "Done";
?>
