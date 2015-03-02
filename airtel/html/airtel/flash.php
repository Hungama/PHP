<?php
$msisdn=$_REQUEST['msisdn'];

include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
if(!$dbConn)
	die('could not connect: ' . mysql_error());

if(strlen($msisdn)==10)
	{
		$callProcedure="call master_db.sendsms('$msisdn', 'hi testing flash','571811',4,'571811','flash')";
		$qry1=mysql_query($callProcedure) or die( mysql_error() );
		echo "message send";
	}
else
	echo "msisdn should be in 10 digit";

mysql_close($dbConn);
 
?>   