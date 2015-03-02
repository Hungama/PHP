<?php
echo "welcome";
/*
session_start();
$param = "test_csrf.php?code=" . urlencode($_REQUEST['code']) . "&state=" . urlencode($_SESSION['state']);
//echo $param;
header("Location: $param") ; 
*/
exit();

/*
$link	=	mysql_pconnect("localhost","53030","53030_app") or die(mysql_error());
$select	=	mysql_select_db("facebook_enterprise") or die(mysql_error());
$error_reason		=	"";
$error				=	"";
$error_description	=	"";
$code				=	"";
$access_token		=	"";
$type				=	"";

extract($_REQUEST);

foreach($_REQUEST as $key => $val ) {
	error_log("\r\n" . $key ." => " .  $val , 3, "/var/www/html/facebook/ent/call_back_log.txt");
}



	$sqlUpdate	=	"UPDATE fp_user SET 
					error_reason	=	'". mysql_escape_string($error_reason) . "', 
					error			=	'". mysql_escape_string($error) ."', 
					error_description	=	'". mysql_escape_string($error_description) ."', 
					code				=	'". mysql_escape_string( $code ) ."', 
					access_token		=	'". mysql_escape_string($access_token) ."'
					WHERE id = $id ";
	$res	=	mysql_query($sqlUpdate) or die("<pre>" . $sqlUpdate . "<br>" . mysql_error());
	if($res) {
		echo "<h3>Thanks</h3>";
	}
	else {
		echo "<h3>Error</h3><br>Try again";
		
	}
	


function postDataToFB($server_ip,$server_port,$query_string,$app_context,$logfile) {
		$line = '';
		$url="";        
		$server = $server_ip;
		$url=$server_ip." ".$app_context." ".$query_string;
		echo "\n" . $url;
		$new_line = "\n";
		$request="POST ".$app_context." HTTPS/1.1\n";
		$request.="Host: ".$server_ip."\n";
		$request.="Content-Type: application/x-www-form-urlencoded\n";
		$request.="Content-Length: ".strlen($query_string)."\n";
		$request.="Connection: close\n";
		$request.="\n";
		$request.=$query_string;
		$result = 'FALSE';
		$retry = 0;
		do{
			$fp = fsockopen($server,$server_port,$errno, $errstr, 30);
			$retry++;
		} while((!$fp) && ($retry<1));
		// Changed to ensure that we have an open socket, or else we can go into an infinite loop of errors
		echo $fp;
		if($fp)
		{
			$result="";
			fputs($fp, $request);
			while(!feof($fp)) 
			{
				$result .= fgets($fp, 128);
			}
			fclose($fp);
		}
		error_log("\n".date("d/m/Y h:i:s || ")." : ".$url." : ".$result,3,"./log/".$logfile."_Logs_".date('Ymd').".txt");
		return  $result;
}
*/

?>