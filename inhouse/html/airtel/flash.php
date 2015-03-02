<?php
$msisdn=$_REQUEST['msisdn'];
include("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");

if(strlen($msisdn)==10 && $dbConnAirtel)
	{
		//$callProcedure="call master_db.sendsms('$msisdn', 'hi testing flash','546469',3,'571811','flash')";
		$callProcedure="call master_db.sendsms('$msisdn', 'hi testing flash','546469',3, '546469','flash')";
		$qry1=mysql_query($callProcedure) or die( mysql_error() );
		echo "message send";
	}
else
	echo "msisdn should be in 10 digit";

mysql_close($dbConnAirtel);
 
?>   