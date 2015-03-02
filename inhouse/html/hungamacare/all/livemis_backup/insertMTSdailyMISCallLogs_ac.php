<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");

$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

//echo $date="2013-02-19";

$serviceArray=array('1124'=>'MTSAC');

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',' '=>'Others');


//========================================================================================================
//========================================================================================================

$delQueryR = "DELETE FROM misdata.tbl_calling_ac_mts WHERE date(starttime)='".$date."'";
$delResultR = mysql_query($delQueryR,$LivdbConn);

$airtelQueryR = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_AC_calllog where date(call_date)='".$date."'";
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
	if($status == 1) $actualStatus = "Active";
	else $actualStatus = "NotActive";
	$circleName = $circle_info[strtoupper($circleCode)];
	if(!$circleName) $circleName = 'Others';
	if(!$endTime) $endTime=$startTime;

	$logData = $msisdn."#".$startTime."#".$endTime."#".$totalSec."#".$pulse."#".$dnis."#".$circleName."#".$actualStatus."#0#0#"."\n";
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
