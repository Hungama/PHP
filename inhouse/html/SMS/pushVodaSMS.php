<?php
if($_GET['ani']) { $ani = trim($_GET['ani']); }
if($_GET['msg']) { $message = trim($_GET['msg']); }
if($_GET['sc'])
	$sc=$_GET['sc'];
else
	$sc='54646';
	
if($_GET['value']) { 
	$value = trim($_GET['value']); 
} else { $value=1; }

$fileName="/var/www/html/SMS/log/Voda/vodafone_log_".date("Y-m-d").".txt"; 

$con = mysql_connect("10.43.248.137","team_user","teamuser@voda#123");
		
if(!$con)
{
	$logdata=$ani."#FAILURE:Connection issue#".$message."#Connection Error:".mysql_error()."#".date("Y-m-d H:i:s")."\n";			
	error_log($logdata,3,$fileName);
	die('could not connect: ' . mysql_error());
}

if((strlen($ani) >= 10 || strlen($ani) <= 12) && is_numeric($ani)) {
	if($message) {
		if($value == 1) {
		//	$sndMsgQuery = "CALL master_db.SENDSMS(".$ani.",'".$message."','$sc')";
			$sndMsgQuery = "CALL master_db.SENDSMS_NEW('".$ani."','".$message."','$sc',1)";
			$sndMsg = mysql_query($sndMsgQuery);
			$logdata = $ani."#VALUE:1#SUCCESS#".$sndMsgQuery."#".date("Y-m-d H:i:s")."\n";			
			echo "Sent SMS";
		} elseif($value==2) {
			$message = str_replace(" ","%20",$message);		
			$vodaUrl="http://gateway.leewaysolution.co.in/saveapi.php?username=hungama&password=123123&mobile=".$ani."&message=".$message;
			//$url_response=file_get_contents($vodaUrl); 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$vodaUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$url_response = curl_exec($ch); 			
			$response = explode("=",$url_response);
			if($response[1]>0) { 
				$logdata = $ani."#VALUE:2#".$url_response."#SUCCESS#".$vodaUrl."#".$message."#".date("Y-m-d H:i:s")."\n";			
				echo "Sent SMS";
			} else {
				$logdata = $ani."#VALUE:2#".$url_response."#FAILURE#".$vodaUrl."#".$message."#".date("Y-m-d H:i:s")."\n";			
				echo "Sending Fail";
			}
		}
	} else {
		$logdata = $ani."#VALUE:".$value."#FAILURE:Blank Message#".date("Y-m-d H:i:s")."\n";
		echo "Blank message!"; 
	}
} else {
	$logdata = $ani."#VALUE:".$value."#FAILURE:Invalid Number#".$message."#".date("Y-m-d H:i:s")."\n";
	echo "Invalid number!"; 
}

error_log($logdata,3,$fileName);
?>
