<?php
include ("/var/www/html/digi/dbDigiConnect.php");

$date = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

//echo $date="2013-02-10";

$serviceArray=array('1701'=>'DIGIMA');

function getCircle($shortCode)
{
	if(strpos($shortCode,'131221'))
		$circle='Bangla';
	elseif(strpos($shortCode,'131222'))
		$circle='Nepali';
	elseif(strpos($shortCode,'131224'))
		$circle='Indian';
	return $circle;
}

$airtelQuery = "select report_date,service_id,circle,type,total_count,'0' from mis_db.dailyReportDigi where report_date = '".$date."'";
$result = mysql_query($airtelQuery,$dbConn);

$delQuery = "DELETE FROM misdata.dailymis2 WHERE Date='".$date."' and service IN ('DIGIMA')";
$delResult = mysql_query($delQuery,$LivdbConn);

while($row = mysql_fetch_array($result)) {
	$serviceId = trim($row[1]);
	$circleName = trim($row[2]);	
	$type=trim($row[3]);
	if(!$circleName) $circleName ='Others';
	$serviceName = $serviceArray[$serviceId]; //Date,Service,Circle,Type,Value,Revenue
	if($serviceName) {
		$insertQuery = "INSERT INTO misdata.dailymis2 VALUES ('".$date."','DIGIMA','".$circleName."', '".$type."', '".$row[4]."','0')";
		$result1 = mysql_query($insertQuery,$LivdbConn);
	}
}

echo "Done";
?>
