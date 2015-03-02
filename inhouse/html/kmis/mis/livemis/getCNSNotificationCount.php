<?php
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
function getServiceName($service_id)
{
	switch($service_id)
	{
			case '1501':
				$service_name='AirtelEU';
			break;
			case '1502':
				$service_name='Airtel54646';
			break;
			case '1503':
				$service_name='MTVAirtel';
			break;
			case '1511':
				$service_name='AirtelGL';
			break;
			case '1507':
				$service_name='VH1Airtel';
			break;
			case '1509':
				$service_name='RIAAirtel';
			break;
			case '1513':
				$service_name='AirtelMND';
			break;
			case '1514':
				$service_name='AirtelPD';
			break;
			case '1518':
				$service_name='AirtelComedy';
			break;
			case '1517':
				$service_name='AirtelSE';
			break;
			case '1515':
				$service_name='AirtelDevo';
			break;
			case '1520':
				$service_name='AirtelPK';
			break;
			case '15221':
				$service_name='AirtelRegKK'; //planid-64 (21)
			break;
			case '15222':
				$service_name='AirtelRegTN'; //planid-63 (22)
			break;
	}
		return $service_name;
}
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
if($_GET['time']) {
$DateFormat[0] = $_GET['time'];
}
else
{
$DateFormat[0] = '2013-10-21 11:00:00';
}
/*$getQuery = "select ANI,circle,service,date_time
from Airtel_IVR.tbl_consent_log
where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
and service in(1501,1502,1503,1511,1507,1513,1518,1514,1517,1515,1520,1522)
 and consent='secondconsent' and response ='submitPackChosen'";
 */
 $getQuery = "select ANI,circle,service,date_time
from Airtel_IVR.tbl_consent_log
where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
and service in(1501)
 and consent='secondconsent' and response ='submitPackChosen'";
$bulkResult = mysql_query($getQuery,$dbConnAirtel);
echo "Total Secondconsent with submitPackChosen>>".mysql_num_rows($bulkResult)."<br>";
while($row = mysql_fetch_array($bulkResult)) {
	$count=0;
	$ANI = $row['ANI'];
	$circle = $row['circle'];
	$service_id = $row['service'];
	$date_time = $row['date_time'];
	$service_name=getServiceName($service_id);
	$totalStatusQuery = "SELECT 'Success' as type,count(*) as total FROM master_db.tbl_billing_success WHERE msisdn='".$ANI."'
	and service_id='".$service_id."' and event_type='SUB' and response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
	UNION 
	SELECT 'Failure' as type, count(*) as total FROM master_db.tbl_billing_failure WHERE msisdn='".$ANI."'
	and service_id='".$service_id."' and event_type='SUB' and response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' ";

	//echo $totalStatusQuery."<br>";
	$statusResult = mysql_query($totalStatusQuery,$dbConnAirtel);
	while($row1 = mysql_fetch_array($statusResult)) {
		$type = $row1['type'];
		$status[$type] = $row1['total'];
	}
	
	if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$consent_str1="CNS_NOTIF";
		if($status['Success']||$status['Failure'])
		{
		$count=1;
		}
		if($count)
		{
	echo $DateFormat[0]."#".$ANI."#".$service_name."#".$circle_info[strtoupper($circle)]."#".$consent_str1."#".$count."<br>";
		}

}

mysql_close($dbConnAirtel);
?>