<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectVoda.php");

$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

$date="2013-05-15";

$serviceArray=array('1302'=>'Vodafone54646','1303'=>'VodafoneMTV','1307'=>'VH1Vodafone','1310'=>'REDFMVodafone');

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',' '=>'Others');

$callPath1="/var/www/html/kmis/mis/livemis/calllogLive/1307/VH1Vodafone_".$date.".txt";

//========================================================================================================

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

		
	}
}
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$callPath1.'" INTO TABLE misdata.tbl_calling_vh1 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1,$LivdbConn);
unlink($callPath1);
//========================================================================================================


echo "Done";
?>
