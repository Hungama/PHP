<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$flag=0;
error_reporting(0);
if(isset($_REQUEST['date'])) { 
	$date= $_REQUEST['date'];
		$flag=1;
} else {
	$date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}
//echo $date="2014-12-14";
//$flag=1;
echo $date;
//$service='EnterpriseMcDw';
//$service='EnterpriseMcDwOBD';
//$service='EnterpriseTiscon';
//$service='EnterpriseGSK_KENYA';
//$service='EnterpriseGSK_NIGERIA';
//$service='EnterpriseGSK_GHANA';
$service='EnterpriseGSK_AF';
$getData218= "select Date,Service,Circle,Type,Value,Revenue from misdata.dailymis nolock where service='".$service."'";
$result_218 = mysql_query($getData218,$LivdbConn);
while($row = mysql_fetch_array($result_218)) {
$insertQuery = "INSERT INTO misdata.dailymis VALUES ('".$row['Date']."','".$row['Service']."','".$row['Circle']."', '".$row['Type']."', '".$row['Value']."','".$row['Revenue']."')";
mysql_query($insertQuery,$dbConn);
	}
mysql_close($dbConn);
mysql_close($LivdbConn);
echo "Done";
?>
