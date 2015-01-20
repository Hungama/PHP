<?php
error_reporting(0);
include "/var/www/html/hungamawap/config/new_functions.php";
include "/var/www/html/hungamawap/airtel/db.php";
include "/var/www/html/hungamawap/airtel/sarnam/baseConfig.php";

if($_REQUEST['msisdn']!='')
$msisdn=trim($_REQUEST['msisdn']);

if (is_numeric($msisdn)) {
//ob_start();
			if(strlen($msisdn)==12)
			$msisdn = substr($msisdn, -10);

			if(strtolower($msisdn)=='unknown')
			{
				$resp='FAILURE';
			}
			else
				{
				$unsubQuery = "call $unsubProcedure('".trim($msisdn)."','WAP');";
				if(mysql_query($unsubQuery,$con))
				$resp='SUCCESS';
				else
				$resp='FAILURE';
				}

echo $resp;
//ob_flush();
//flush();
//api to call airtel server
$getInfo="http://119.82.69.212/airtel/airtelldrunsub.php?sid=1515&msisdn=".$msisdn;
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
$logData = $msisdn ."#".$result."#".date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath);
?>