<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");

$msisdn = $_REQUEST['msisdn'];
$service = $_REQUEST['service'];

$serviceArray = array('55841001','55001001','546461001');

if($service == '55841001') { // VH1
	$tableName = "mis_db.tbl_54646_calllog";
	$condition = " and dnis ='55841001' order by id desc limit 1";
	$pulse_rate = "Rs.0.3";
} elseif($service == '55001001') { //GoodLife
	$tableName = "mis_db.tbl_54646_calllog";
	$condition = " and dnis ='55001001' order by id desc limit 1";
	$pulse_rate = "Rs.0.2";
} elseif($service == '546461001') { //MTV
	$tableName = "mis_db.tbl_mtv_calllog";
	$condition = " and dnis ='546461001' order by id desc limit 1";
} 

$date = date('Y-m-d');

$flag = 0;
$pflag = 0;
if(is_numeric($msisdn) && (strlen($msisdn)==10 || strlen($msisdn)==12) && in_array($service, $serviceArray)) {
	$query= "SELECT call_date,call_time,duration_in_sec,msisdn,pulse,circle FROM ".$tableName." WHERE msisdn='".$msisdn."' ";	
	$query .= $condition;	
	$CallData = mysql_query($query);
	
	while($row = mysql_fetch_array($CallData)) {
		$call_time = $row['call_time'];
		$totalSec = $row['duration_in_sec'];		
		$pulse = $row['pulse'];
		$msisdn1 = $row['msisdn'];
		$call_date = $row['call_date'];
		// $status = $row['status'];
		$circle = $row['circle'];		
		$flag = 1;
		if($service == '55841001' && (strtoupper($circle)!='DEL' && strtoupper($circle)!='NES' && strtoupper($circle)!='ASM')) {
			$pflag=1;
		}
		if($service == '55001001' && strtoupper($circle)!='DEL') {
			$pflag=1;
		}
	}
	
	$timeData = mysql_query("select addtime('".$date." ".$call_time."', '".$totalSec."') as endtime");
	list($endCallTime) = mysql_fetch_array($timeData);
	
	$timeData = explode(" ",$endCallTime);
	$endTime = $timeData[1];
	if($flag == 1) {
	echo "<div>";
		echo "<b>Msisdn: </b>".$msisdn;
		echo "<br/><b>Call Start Time: </b>".$call_date." ".$call_time;
		echo "<br/><b>Call End Time: </b>".$call_date." ".$endTime;
		echo "<br/><b>Pulse: </b>".$pulse;
		if($pflag) 
		echo "<br/><b>Pulse Rate: </b>".$pulse_rate;
	echo "</div>";
	} else {
		echo "No Record Found";
	}
} else {
	echo "Invalid Parameter";
}
 
mysql_close($dbAirtelConn);
?>