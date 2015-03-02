<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectTune.php");

if(isset($_REQUEST['date'])) { 
	$date= $_REQUEST['date'];
} else {
	$date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

//$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

//echo $date="2013-03-10";

$serviceArray=array('1901'=>'TuneTalkIVR','2121'=>'SMSEtisalatNigeria');

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',''=>'Others');

/*$delQuery = "DELETE FROM misdata.dailymis WHERE Date='".$date."' and service IN ('TuneTalkIVR')";
$delResult = mysql_query($delQuery,$LivdbConn);

$airtelQuery = "select report_date,service_id,circle,type,sum(total_count),(sum(total_count))*(charging_rate) as 'Rev' from mis_db.dailyReport where report_date = '".$date."' group by circle,type, service_id order by service_id,type";
$result = mysql_query($airtelQuery,$dbConnAirtel);

while($row = mysql_fetch_array($result)) {
	$serviceId = trim($row[1]);
	$circleId = trim($row[2]);	
	$circleName ='TUNE';
	if($row[5]=="")$row[5]=0;
	$serviceName = $serviceArray[$serviceId]; //Date,Service,Circle,Type,Value,Revenue
	$insertQuery = "INSERT INTO misdata.dailymis VALUES ('".$date."','".$serviceName."','".$circleName."', '".$type."', '".$row[4]."','".$row[5]."')";
	$result1 = mysql_query($insertQuery,$LivdbConn);
} */

//=======================================================================================================

$delQuery1 = "DELETE FROM misdata.tbl_calling_mod_tunetalk WHERE date(starttime)='".$date."'";
$delResult1 = mysql_query($delQuery1,$LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_tune_calllog where date(call_date)='".$date."' and dnis=13131 and operator in('tune')";
$result1 = mysql_query($airtelQuery1,$dbConn);

$callPath7="/var/www/html/kmis/mis/livemis/calllogLive/TT/TT_".$date.".txt";
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

}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath7.'" INTO TABLE misdata.tbl_calling_mod_tunetalk 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1,$LivdbConn);

//=======================================================================================================

echo "Done";
?>
