<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$flag=0;
if(isset($_REQUEST['date'])) { 
	$date= $_REQUEST['date'];
		$flag=1;
} else {
	$date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

//$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
//echo $date = "2013-10-09";
if($flag)
{
$isflag="AND type NOT IN ('Active_Base','Pending_Base','UU_Repeat','UU_New')";
}

$serviceArray=array('1602'=>'TataIndicom54646','1601'=>'TataDoCoMoMXcdma','1603'=>'MTVTataDoCoMocdma','1605'=>'TataDoCoMoFMJcdma','1609'=>'RIATataDoCoMocdma', '1610'=>'RedFMTataDoCoMocdma','1611'=>'TataDoCoMoGLcdma','1613'=>'TataDoCoMoMNDcdma');

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',''=>'Others');

$airtelQuery = "select report_date,service_id,circle,type,sum(total_count),(sum(total_count))*(charging_rate) as 'Rev' from mis_db.daily_report where report_date = '".$date."' $isflag and service_id like '16%' and service_id NOT IN ('1603','1611') group by circle,type, service_id order by service_id,type";
$result = mysql_query($airtelQuery,$dbConn);

$delQuery = "DELETE FROM misdata.dailymis WHERE Date='".$date."' $isflag and service IN ('TataIndicom54646','TataDoCoMoMXcdma','MTVTataDoCoMocdma', 'TataDoCoMoFMJcdma','RIATataDoCoMocdma','RedFMTataDoCoMocdma','TataDoCoMoGLcdma')";
$delResult = mysql_query($delQuery,$LivdbConn);

while($row = mysql_fetch_array($result)) {
	$serviceId = trim($row[1]);
	$circleId = trim($row[2]);
	$circleName = $circle_info[strtoupper($circleId)];
	if(!$circleName) $circleName ='Others';
	if($row[5]=="") $row[5]=0;
	$serviceName = $serviceArray[$serviceId]; //Date,Service,Circle,Type,Value,Revenue
	if($serviceName) {
		$insertQuery = "INSERT INTO misdata.dailymis VALUES ('".$date."','".$serviceName."','".$circleName."', '".$row[3]."', '".$row[4]."','".$row[5]."')";
		$result1 = mysql_query($insertQuery,$LivdbConn);
	}
}

echo "Done";
?>
