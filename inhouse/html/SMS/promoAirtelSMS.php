<?php 
if($_GET['ani']) { $ani = trim($_GET['ani']); }
if($_GET['msg']) { $message = $_GET['msg']; }

$con = mysql_connect("10.2.73.160","team_user","Te@m_us@r987");

//$message = str_replace(" ","%20",$message);		

$filePath = "/var/www/html/SMS/log/Airtel/promo_airtel_log_".date("Y-m-d").".txt";

if(!$con)
{
	$filedata=$ani."#FAILURE:Connection issue#".$message."#Connection Error:".mysql_error()."#".date("Y-m-d H:i:s")."\n";			
	error_log($filedata,3,$filePath);
	die('could not connect: ' . mysql_error());
}

if((strlen($ani) == 10 || strlen($ani) == 12) && is_numeric($ani)) {
	if($message) {
		/*$status = file_get_contents("http://192.168.100.217/SMS/promoAirtelSMS.php?ani=".$ani."&msg=".$message);		
		if($status == 'done') { 
			$filedata = $ani."#SUCCESS#".date("d-m-Y H:i:s")."\n";
			error_log($filedata,3,$filePath);			
		} else { 
			$filedata = $ani."#FAILURE#".date("d-m-Y H:i:s")."\n";
			error_log($filedata,3,$filePath);
			echo "Sending Fail!"; 
		}*/
		$sndMsgQuery = "CALL master_db.SENDSMS_NEW(".$ani.",'".$message."','HMMUSC',1,'546461')"; 
		$sndMsg = mysql_query($sndMsgQuery);
		$filedata = $ani."#SUCCESS#".$sndMsgQuery."#".date("d-m-Y H:i:s")."\n";		
		echo "Sent SMS!"; 
	} else {
		$filedata = $ani."#FAILURE:Blank message!#".date("d-m-Y H:i:s")."\n";
		echo "Blank message!"; 
	}
} else {
	$filedata = $ani."#FAILURE:Invalid Number#".$message."#".date("d-m-Y H:i:s")."\n";
	echo "Invalid number!"; 
}
error_log($filedata,3,$filePath);

?>
