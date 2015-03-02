<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectDigi.php");
if(isset($_REQUEST['date'])) { 
	$date= $_REQUEST['date'];
} else {
	$date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

//$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
//echo $date = "2013-02-04";

$serviceArray=array('1701'=>'DIGIMA');

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',' '=>'Others');
//==============================================DIGIMA=========================================================

$delQuery = "DELETE FROM misdata.dailymis WHERE Date='".$date."' and service IN ('DIGIMA')";
$delResult = mysql_query($delQuery,$LivdbConn);

$digiQuery = "select report_date,service_id,circle,type,sum(total_count),(sum(total_count))*(charging_rate) as 'Rev' from mis_db.dailyReportDigi nolock where report_date = '".$date."' group by circle,type, service_id order by service_id,type";
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
mysql_close($LivdbConn);
echo "Done";
?>
