<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$flag=0;
$con_digi = mysql_connect("172.16.56.42","billing","billing");
if(isset($_REQUEST['date'])) { 
	$date= $_REQUEST['date'];
        $flag=1;
} else {
	$date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}
if($flag)
{
$isflag="AND type NOT IN ('Active_Base','Pending_Base','UU_Repeat','UU_New')";
}

$processlog = "/var/www/html/kmis/mis/reliance/processlog_digiRelm.txt";
$file_process_status = '***************Script start for insertRELCdailyMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
//$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
//echo $date = "2013-02-04";

$serviceArray=array('1202'=>'Reliance54646','1203'=>'MTVReliance','1202P'=>'ReliancePauseCode','1208'=>'RelianceCM','2121'=>'SMSEtisalatNigeria','1701'=>'DIGIMA');

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',' '=>'Others');

$airtelQuery = "select report_date,service_id,circle,type,sum(total_count),(sum(total_count))*(charging_rate) as 'Rev' from mis_db.dailyReportReliance nolock 
                where report_date = '".$date."' $isflag and service_id IN ('1202','1203','1208') group by service_id,circle,type";
$result = mysql_query($airtelQuery,$dbConn);

$delQuery = "DELETE FROM misdata.dailymis WHERE Date='".$date."' $isflag and service IN ('Reliance54646','MTVReliance','ReliancePauseCode','RelianceCM')";
$delResult = mysql_query($delQuery,$LivdbConn);

while($row = mysql_fetch_array($result)) {
	$serviceId = trim($row[1]);
	$circleId = trim($row[2]);
	$circleName = $circle_info[strtoupper($circleId)];
	if(!$circleName) $circleName ='Others';
	$serviceName = $serviceArray[$serviceId]; //Date,Service,Circle,Type,Value,Revenue
	if($row[5]=="") $row[5]=0;
	if($serviceName) {
		$insertQuery = "INSERT INTO misdata.dailymis VALUES ('".$date."','".$serviceName."','".$circleName."', '".$row[3]."', '".$row[4]."','".$row[5]."')";
		$result1 = mysql_query($insertQuery,$LivdbConn);
	}
}

//==============================================SMSEtisalatNigeria=========================================================
/*
$delQuery = "DELETE FROM misdata.dailymis WHERE Date='".$date."' and service IN ('SMSEtisalatNigeria')";
$delResult = mysql_query($delQuery,$LivdbConn);

$airtelQuery = "select report_date,service_id,circle,type,sum(total_count),(sum(total_count))*(charging_rate) as 'Rev' from mis_db.dailyReportEtislat nolock where report_date = '".$date."' group by circle,type, service_id order by service_id,type";
$result = mysql_query($airtelQuery,$dbConn);

while($row = mysql_fetch_array($result)) {
	$serviceId = trim($row[1]);
	$circleName = trim($row[2]);		
	if($row[5]=="")$row[5]=0;
	$serviceName = $serviceArray[$serviceId]; //Date,Service,Circle,Type,Value,Revenue
	$insertQuery = "INSERT INTO misdata.dailymis VALUES ('".$date."','".$serviceName."','".$circleName."', '".$row[3]."', '".$row[4]."','".$row[5]."')";
	$result1 = mysql_query($insertQuery,$LivdbConn);
} 

*/
//==============================================DIGIMA=========================================================

$delQuery = "DELETE FROM misdata.dailymis WHERE Date='".$date."' $isflag and service IN ('DIGIMA')";
$delResult = mysql_query($delQuery,$LivdbConn);

$digiQuery = "select report_date,service_id,circle,type,sum(total_count),(sum(total_count))*(charging_rate) as 'Rev' from mis_db.dailyReportDigi nolock 
              where report_date = '".$date."' $isflag group by circle,type, service_id order by service_id,type";
$result = mysql_query($digiQuery,$con_digi);

while($row = mysql_fetch_array($result)) {
	$serviceId = trim($row[1]);
	$circleName = trim($row[2]);		
	if($row[5]=="")$row[5]=0;
	$serviceName = $serviceArray[$serviceId]; //Date,Service,Circle,Type,Value,Revenue
	$insertQuery = "INSERT INTO misdata.dailymis VALUES ('".$date."','".$serviceName."','".$circleName."', '".$row[3]."', '".$row[4]."','".$row[5]."')";
	$result1 = mysql_query($insertQuery,$LivdbConn);
} 

mysql_close($con_digi);
$file_process_status = '***************Script end for insertRELCdailyMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
mysql_close($dbConn);
mysql_close($LivdbConn);
echo "Done";
?>
