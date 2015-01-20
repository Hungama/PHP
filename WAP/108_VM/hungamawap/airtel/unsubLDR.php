<?php
error_reporting(0);
include "/var/www/html/hungamawap/config/new_functions.php";
$starttime=date('Y-m-d H:i:s');
include "/var/www/html/hungamawap/airtel/db.php";

if($_REQUEST['msisdn']!='')
$msisdn=trim($_REQUEST['msisdn']);

if($msisdn){ 
//ob_start();
			if(strlen($msisdn)==12)
			$msisdn = substr($msisdn, -10);

				$db = "airtel_rasoi";
				$unsubProcedure="RASOI_UNSUBWAP";
				
			if(strtolower($msisdn)=='unknown')
			{
				$resp='FAILURE';
			}
			else
				{
				$unsubQuery = "call $db.$unsubProcedure('".trim($msisdn)."','WAP');";
				if(mysql_query($unsubQuery,$con))
				$resp='SUCCESS';
				else
				$resp='FAILURE';
				}

echo $resp;
//ob_flush();
//flush();
//api to call airtel server
$getInfo="http://119.82.69.212/airtel/airtelldrunsub.php?msisdn=".$msisdn;
$ch_result=curl_init($getInfo);
curl_setopt($ch_result,CURLOPT_RETURNTRANSFER,TRUE);
$result= curl_exec($ch_result);
curl_close($ch_result);				
		}
		else
		{
		$resp='FAILURE';
		echo $resp;
		}

mysql_close($con);		
//ob_end_flush();
$logPath = "logs/unSublog_" . date("Ymd") . ".txt";
$logData = $msisdn ."#".$result."#".$starttime."#".date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath);
?>