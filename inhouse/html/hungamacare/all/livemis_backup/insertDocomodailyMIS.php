<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");

if(isset($_REQUEST['date'])) { 
	$date= $_REQUEST['date'];
} else {
	$date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

//$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
//echo $date = "2013-02-04";

$serviceArray=array('1001'=>'TataDoCoMoMX','1002'=>'TataDoCoMo54646','1002P'=>'TataDoCoMo54646Pause','1003'=>'MTVTataDoCoMo','1005'=>'TataDoCoMoFMJ', '1009'=>'RIATataDoCoMo','1010'=>'RedFMTataDoCoMo','1011'=>'TataDoCoMoGL');

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',' '=>'Others');

$airtelQuery = "select report_date,service_id,circle,type,sum(total_count),(sum(total_count))*(charging_rate) as 'Rev' from mis_db.daily_report where report_date = '".$date."' and service_id like '10%' and service_id NOT IN ('1002P','1011') group by service_id,circle,type";
$result = mysql_query($airtelQuery,$dbConn);

$delQuery = "DELETE FROM misdata.dailymis WHERE Date='".$date."' and service IN ('TataDoCoMoMX','TataDoCoMo54646','TataDoCoMo54646Pause','MTVTataDoCoMo', 'TataDoCoMoFMJ','RIATataDoCoMo','RedFMTataDoCoMo','TataDoCoMoGL')";
$delResult = mysql_query($delQuery,$LivdbConn);

while($row = mysql_fetch_array($result)) {
	$serviceId = trim($row[1]);
	$circleId = trim($row[2]);
	$circleName = $circle_info[strtoupper($circleId)];
	if(!$circleName) $circleName ='Others';
	$serviceName = $serviceArray[$serviceId]; //Date,Service,Circle,Type,Value,Revenue
	if($row[5]=="") $row[5]=0;
	if($serviceName && ($serviceId != "1002P" || $serviceId != "1011" )) {
		$insertQuery = "INSERT INTO misdata.dailymis VALUES ('".$date."','".$serviceName."','".$circleName."', '".$row[3]."', '".$row[4]."','".$row[5]."')";
		$result1 = mysql_query($insertQuery,$LivdbConn);
	}
}
echo "Done";
?>
