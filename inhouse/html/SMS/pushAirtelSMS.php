<?php 
if($_GET['ani']) { $ani = trim($_GET['ani']); }
if($_GET['msg']) { $message = $_GET['msg']; }

$con = mysql_connect("10.2.73.160","team_user","Te@m_us@r987");

//$message = str_replace(" ","%20",$message);	
//$message = str_replace("%","%25",$message);	
$message = urldecode($message);

$filePath = "/var/www/html/SMS/log/Airtel/airtel_log_".date("Y-m-d").".txt";

if(!$con)
{
	$filedata=$ani."#FAILURE:Connection issue#".$message."#Connection Error:".mysql_error()."#".date("Y-m-d H:i:s")."\n";			
	error_log($filedata,3,$filePath);
	die('could not connect: ' . mysql_error());
}

if((strlen($ani) == 10 || strlen($ani) == 12) && is_numeric($ani)) {
	if($message) {
		if($_GET['CLI']) {
			$sndMsgQuery = "CALL master_db.SENDSMS('".trim($ani)."','".$message."','55001',1,'HMLIFE','promo')"; 
		} else {
			$sndMsgQuery = "CALL master_db.SENDSMS_BULK(".trim($ani).",'".$message."','54646',0,'601666')"; 
		}
		$sndMsg = mysql_query($sndMsgQuery);		
		//$sndMsgQuery1 = "CALL master_db.SENDSMS_NEW(".$ani.",'".$message."','HMMUSC',1,'546461')"; 
		//$sndMsg1 = mysql_query($sndMsgQuery1);
		$filedata = $ani."#SUCCESS#".$sndMsgQuery."#".date("d-m-Y H:i:s")."\n";
		error_log($filedata,3,$filePath);
		echo "Sent SMS!"; 
	} else {
		$filedata = $ani."#FAILURE:Blank message!#".date("d-m-Y H:i:s")."\n";
		error_log($filedata,3,$filePath);
		echo "Blank message!"; 
	}
} else {
	$filedata = $ani."#FAILURE:Invalid Number#".$message."#".date("d-m-Y H:i:s")."\n";
	error_log($filedata,3,$filePath);
	echo "Invalid number!"; 
}

?>

