<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$flag=0;
error_reporting(1);
if(isset($_REQUEST['date'])) { 
	$date= $_REQUEST['date'];
		$flag=1;
} else {
	$date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}
//echo $date="2014-07-21";
//$flag=1;
if($flag)
{
$isflag="AND type NOT IN ('UU_Repeat','UU_New')";
}

$circle_info=array('AF'=>'GHANA');
$TisconQuery = "select Date,Service,'GHANA' as Circle,Type,Value,Revenue from Hungama_Tatasky.tbl_dailymis 
where date = '".$date."' $isflag  and service='EnterpriseGSK_GHANA'";

$result = mysql_query($TisconQuery,$dbConn);

$delQuery = "DELETE FROM misdata.dailymis WHERE Date='".$date."' $isflag  and service='EnterpriseAfricaGSK' and circle='GHANA' ";

$delResult = mysql_query($delQuery,$LivdbConn);

while($row = mysql_fetch_array($result)) {
	//$serviceName = trim($row['Service']);
	$serviceName = 'EnterpriseAfricaGSK';
	//$circleId = trim($row[2]);
	//$circleName = $circle_info[strtoupper($circleId)];
	//if(!$circleName) $circleName ='Others';
	$circleName='GHANA';
	if($row[5]=="") $row[5]=0;
	if($serviceName && $row[3]) {
	$insertQuery = "INSERT INTO misdata.dailymis VALUES ('".$date."','".$serviceName."','".$circleName."', '".$row[3]."', '".$row[4]."','".$row[5]."')";
	$result1 = mysql_query($insertQuery,$LivdbConn);
	}
}
echo "Done";
?>