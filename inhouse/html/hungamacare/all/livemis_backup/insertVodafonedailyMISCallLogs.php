<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectVoda.php");

$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

//echo $date="2013-08-06";

$serviceArray=array('1302'=>'Vodafone54646','1303'=>'VodafoneMTV','1307'=>'VH1Vodafone','1310'=>'REDFMVodafone');

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',' '=>'Others');

//echo $LivdbConn." ".$dbConnVoda;
$delQuery = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='".$date."' and service='".$serviceArray['1302']."'";
$delResult = mysql_query($delQuery,$LivdbConn);

//$airtelQuery41 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from master_db.tbl_voda_calllog where date(call_date)='".$date."' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis like '52010' or dnis like '52323%') and dnis !='546461' and operator in('vodm')";
$airtelQuery41 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from master_db.tbl_voda_calllog where date(call_date)='".$date."' and (dnis NOT LIKE '55935%' and dnis NOT LIKE '55841%' and dnis!='546461') and operator in('vodm')";

$result41 = mysql_query($airtelQuery41,$dbConnVoda);

$callPath1="/var/www/html/kmis/mis/livemis/calllogLive/1302/Vodafone54646_".$date.".txt";
while($row1 = mysql_fetch_array($result41)) {
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

	if($endTime && $serviceArray['1302']) { 
	
	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1302']."\n";
	error_log($logData,3,$callPath1) ;

		$insertQuery = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1302']."')";
	//	mysql_query($insertQuery,$LivdbConn) or die(mysql_error());
	}
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath1.'" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath1);
//========================================================================================================

$airtelQuery2 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from master_db.tbl_voda_calllog where date(call_date)='".$date."' and dnis in (546461) and operator in('vodm')";
$result31 = mysql_query($airtelQuery2,$dbConnVoda);

$delQuery = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='".$date."' and service='".$serviceArray['1303']."'";
$delResult = mysql_query($delQuery,$LivdbConn);

$callPath2="/var/www/html/kmis/mis/livemis/calllogLive/1303/VodafoneMTV_".$date.".txt";
while($row1 = mysql_fetch_array($result31)) {
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

	if($endTime && $serviceArray['1303']) { 

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1303']."\n";
	error_log($logData,3,$callPath2) ;

		$insertQuery = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1303']."')";
		//mysql_query($insertQuery,$LivdbConn);
	}
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath2.'" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath2);
//========================================================================================================

//$callPath1="/var/www/html/kmis/mis/livemis/calllogLive/1307/VH1Vodafone_".$date.".txt";
$airtelQuery2 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from master_db.tbl_voda_calllog where date(call_date)='".$date."' and dnis='55841' and operator IN ('vodm')";
$result32 = mysql_query($airtelQuery2,$dbConnVoda);

$delQuery = "DELETE FROM misdata.tbl_calling_vh1 WHERE date(starttime)='".$date."' and service='".$serviceArray['1307']."'";
$delResult = mysql_query($delQuery,$LivdbConn);

$callPath3="/var/www/html/kmis/mis/livemis/calllogLive/1307/VH1Vodafone_".$date.".txt";
while($row1 = mysql_fetch_array($result32)) {
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

	if($endTime && $serviceArray['1307']) {  

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1307']."\n";
	error_log($logData,3,$callPath3) ;

		$insertQuery = "insert into misdata.tbl_calling_vh1 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1307']."')";
		//mysql_query($insertQuery,$LivdbConn);
	}
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath3.'" INTO TABLE misdata.tbl_calling_vh1 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath3);
//========================================================================================================

$airtelQuery3 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from master_db.tbl_voda_calllog where date(call_date)='".$date."' and dnis like '55935' and operator IN ('vodm')";
$result3 = mysql_query($airtelQuery3,$dbConnVoda);

$$delQuery = "DELETE FROM misdata.tbl_calling_redfm WHERE date(starttime)='".$date."' and service='".$serviceArray['1310']."'";
$delResult = mysql_query($delQuery,$LivdbConn);

$callPath4="/var/www/html/kmis/mis/livemis/calllogLive/1310/REDFMVodafone_".$date.".txt";
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

	if($endTime && $serviceArray['1310']) {  

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#".$serviceArray['1310']."\n";
	error_log($logData,3,$callPath4) ;

		$insertQuery = "insert into misdata.tbl_calling_redfm VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1310']."')";
		//mysql_query($insertQuery,$LivdbConn);
	}
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath4.'" INTO TABLE misdata.tbl_calling_redfm 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath4);
//========================================================================================================

echo "Done";
?>
