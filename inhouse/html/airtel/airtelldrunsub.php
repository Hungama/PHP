<?php
include("/var/www/html/kmis/services/hungamacare/config/db_airtel.php");
error_reporting(1);
$msisdn=$_REQUEST['msisdn'];
$mode='WAP';
$serviceid = trim($_REQUEST['sid']);
$logPath = "/var/www/html/airtel/log/airtelWAP/unsublog_".date("Y-m-d").".txt";

if (is_numeric($msisdn)) {
			if(strlen($msisdn)==12)
			$msisdn = substr($msisdn, -10);

	switch($serviceid)
	{
		case '1527':
				 $db = "airtel_rasoi";
				 $unsubProcedure=$db.".RASOI_UNSUBWAP";	
				 break;
		case '1515':
				 $db = "airtel_devo";
				 $unsubProcedure=$db.".SARNAM_UNSUBWAP";	
				  break;
		default:
				 $db = "airtel_rasoi";
				 $unsubProcedure=$db.".RASOI_UNSUBWAP";		
				 break;
   }
   
			if(strtolower($msisdn)=='unknown')
			{
				$resp='FAILURE';
			}
			else
			{
				$unsubQuery = "call $unsubProcedure('".trim($msisdn)."','WAP');";
				if(mysql_query($unsubQuery))
				{
					$resp='SUCCESS';
				}
				else
				{
					$resp='FAILURE';
					$error=mysql_error();
				}
		   }
				echo $resp;
				$logData=$serviceid."#".$msisdn."#".$unsubQuery."#".$resp."#".$error."#".date("Y-m-d H:i:s")."\n";
				error_log($logData,3,$logPath);
}
else
{
		$resp='FAILURE';
		echo $resp;
		$logData=$serviceid."#".$msisdn."#".$unsubQuery."#".$resp."#".$error."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$logPath);
}
mysql_close($dbConnAirtel); 
?>