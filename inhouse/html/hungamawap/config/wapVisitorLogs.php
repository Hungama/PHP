<?php
//================================================ Variable Declaration =================================================
$mode='WAP';
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
function saveVisitorLogs($msisdn,$type,$amount,$chrgingurl,$contentId,$operator,$serviceid,$affid,$Remote_add,$full_user_agent)
{
$date=date('Ymd');
$time_stamp=date('His');
$cpage=curPageURL();
	switch($serviceid)
	{
		case '1423':
				$header_log = "/var/www/html/hungamawap/logs/WAPLOGS/1423/log_".$date.".txt";	
		break;
		case '1411':
				$header_log = "/var/www/html/hungamawap/logs/WAPLOGS/1411/log_".$date.".txt";	
		break;
		case '1511':
				$header_log = "/var/www/html/hungamawap/logs/WAPLOGS/1511/log_".$date.".txt";	
		break;
	}

//$_SERVER['REQUEST_URI'];
$datalog =$msisdn."|".$type."|".$amount."|".$cpage."|".$chrgingurl."|".$contentId."|".$operator."|".$affid."|".$Remote_add."|".$full_user_agent."|".date('Y-m-d H:i:s')."|".$serviceid."\n";
//error_log($datalog, 3, $header_log);
}
?>