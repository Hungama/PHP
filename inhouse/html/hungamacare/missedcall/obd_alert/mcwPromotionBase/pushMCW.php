<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$filename = "basepart3.txt";//file name should be in small letter no special character & space allowed in file name.
$filenameLck = "basepart3_log.txt";//log file name should be in same as file name.
$file_to_read="http://192.168.100.212/hungamacare/missedcall/obd_alert/mcwPromotionBase/".$filename;
$file_data=file($file_to_read);
$file_size=sizeof($file_data);

$lckFilePath="/var/www/html/hungamacare/missedcall/obd_alert/mcwPromotionBase/log/".$filenameLck;
for($i=0; $i<$file_size; $i++) {
	$number = trim($file_data[$i]);
	$query = "CALL Hungama_ENT_MCDOWELL.MCDOWELL_PROMOTIONCALL_DETAILS('".$number."','1','1','SIP/TATAHUL-12345')";
	if(mysql_query($query, $dbConn))
	{
	$result="SUCCESS";
	}
	else
	{
	$result= mysql_error();
	}
	$fileLog = $number."#".$query."#".$result."#".date('Y-m-d H:i:s')."\n";
	error_log($fileLog,3,$lckFilePath);
	}
echo "Done";	
mysql_close($dbConn);
?>
