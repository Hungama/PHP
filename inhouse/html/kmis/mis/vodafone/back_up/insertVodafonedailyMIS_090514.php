<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectVoda.php");
$flag=0;

if(isset($_REQUEST['date'])) { 
	$date= $_REQUEST['date'];
	$flag=1;
} else {
	$date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

//$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
//$flag=1;
//echo $date="2013-12-29";
if($flag)
{
$isflag="AND type NOT IN ('Active_Base','Pending_Base')";
}
$serviceArray=array('1313'=>'VodafoneMND','1302'=>'Vodafone54646','1303'=>'MTVVodafone','1307'=>'VH1Vodafone','1310'=>'RedFMVodafone','130202'=>'VodafonePoet','1301'=>'VodafoneMU');

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',''=>'Others');

$airtelQuery = "select report_date,service_id,circle,type,sum(total_count),(sum(total_count))*(charging_rate) as 'Rev' from master_db.dailyReportVodafone where report_date = '".$date."' $isflag group by service_id,circle,type";
$result = mysql_query($airtelQuery,$dbConnVoda);

$delQuery = "DELETE FROM misdata.dailymis WHERE date(date)='".$date."' $isflag and service IN ('Vodafone54646','MTVVodafone','VH1Vodafone','RedFMVodafone','VodafoneMND','VodafonePoet','VodafoneMU')";
$delResult = mysql_query($delQuery,$LivdbConn);

while($row = mysql_fetch_array($result)) {
	$serviceId = trim($row[1]);
	$circleId = trim($row[2]);
	$circleName = $circle_info[strtoupper($circleId)];
	if(!$circleName) 
		$circleName ='Others';
	$serviceName = $serviceArray[$serviceId]; //Date,Service,Circle,Type,Value,Revenue
	if($row[5]=="") $row[5]=0;
	if($serviceName && $row[3]) {
		$insertQuery = "INSERT INTO misdata.dailymis VALUES ('".$date."','".$serviceName."','".$circleName."', '".$row[3]."', '".$row[4]."','".$row[5]."')";
		$result1 = mysql_query($insertQuery,$LivdbConn);
	}
}

echo "Done";
?>
