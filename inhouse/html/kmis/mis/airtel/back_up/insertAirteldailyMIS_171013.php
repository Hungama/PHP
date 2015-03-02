<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");

if(isset($_REQUEST['date'])) { 
	$date= $_REQUEST['date'];
} else {
	$date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

//$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

//echo $date="2013-09-12";

$serviceArray=array('1501'=>'AirtelEU','1502'=>'Airtel54646','1503'=>'MTVAirtel','1511'=>'AirtelGL','1507'=>'VH1Airtel','1509'=>'RIAAirtel', '1518'=>'AirtelComedy','1513'=>'AirtelMND','15131'=>'AirtelMNDKK','1514'=>'AirtelPD','1517'=>'AirtelSE','1515'=>'AirtelDevo','1520'=>'AirtelPK','15221'=>'AirtelRegTN', '15222'=>'AirtelRegKK');

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',''=>'Others');

$delQuery = "DELETE FROM misdata.dailymis WHERE Date='".$date."' and service IN ('AirtelEU','Airtel54646','MTVAirtel','AirtelGL','VH1Airtel','RIAAirtel', 'AirtelComedy', 'AirtelMND','AirtelPD','AirtelSE','AirtelDevo','AirtelPK','AirtelRegKK','AirtelRegTN','AirtelMNDKK')";
$delResult = mysql_query($delQuery,$LivdbConn);

$airtelQuery = "select report_date,service_id,circle,type,sum(total_count),(sum(total_count))*(charging_rate) as 'Rev' 
from mis_db.daily_report where report_date = '".$date."' and service_id!='1509' group by circle,type, service_id order by service_id,type";
$result = mysql_query($airtelQuery,$dbConnAirtel);
//echo $num=mysql_num_rows($result);
while($row = mysql_fetch_array($result)) {
	$serviceId = trim($row[1]);
	$circleId = trim($row[2]);
	$circleName = $circle_info[strtoupper($circleId)];
	if(!$circleName) $circleName ='Others';
	$serviceName = $serviceArray[$serviceId]; //Date,Service,Circle,Type,Value,Revenue
	$allowedArray = array('1503','1514','1513');
	if($row[5]=="")$row[5]=0;
	if($serviceName) {
		if($row[3] == 'Mode_Deactivation_Involuntary') 
			$type ='Mode_Deactivation_in';
		elseif($row[3] == 'Mode_Activation_IVR1') 
			$type ='Mode_Activation_IVR';
		elseif($row[3] == 'Mode_Activation_CCI') 
			$type ='Mode_Activation_CC';
		elseif($row[3] == 'Mode_Deactivation_CCI') 
			$type ='Mode_Deactivation_CC';
		elseif($row[3] == 'Mode_Deactivation_ussd') 
			$type ='Mode_Deactivation_USSD';
		elseif($row[3] == 'Deactivation_2' && in_array($serviceId,$allowedArray)) 
			$type ='Deactivation_30';
		elseif($row[3] == 'Mode_Deactivation_546461' || $row[3] == 'Mode_Deactivation_BULK' || $row[3] == 'Mode_Deactivation_SELF_REQS' || $row[3] == 'Mode_Deactivation_SELF_REQ') 
			$type ='Mode_Deactivation_IVR';
		else $type = $row[3];

		$insertQuery = "INSERT INTO misdata.dailymis VALUES ('".$date."','".$serviceName."','".$circleName."', '".$type."', '".$row[4]."','".$row[5]."')";
		$result1 = mysql_query($insertQuery,$LivdbConn);
	
	}
}

echo "Done";
?>