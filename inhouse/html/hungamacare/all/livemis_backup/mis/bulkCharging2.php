<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

$filePath="/var/www/html/kmis/services/hungamacare/chargingLog2.txt";
$fp=fopen($filePath,'a+');
chmod($filePath,0777);

$selQuery="select ani from mis_db.tbl_reliance_1re where status=0 limit 50001,100000";
$charResult = mysql_query($selQuery,$dbConn);
while(list($msisdn) = mysql_fetch_array($charResult))
{	
	$msisdn=trim($msisdn);
	$chargingUrl="http://119.82.69.210/billing/reliance_billing/reliance_billing_interface.php?";
	$chargingUrl.="action=1&mdn=".$msisdn."&appid=46";
	$chargingResult=file_get_contents($chargingUrl);
	fwrite($fp,$msisdn."|".$chargingResult."|".date("d:H:i:s")."\r\n");
	$updateResult="update mis_db.tbl_reliance_1re set status=1 where ani=".$msisdn;
	$charResult1 = mysql_query($updateResult,$dbConn);
	
}

?>
