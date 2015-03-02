<?php
if($_GET['ani']) { $ani = trim($_GET['ani']); }
if($_GET['msg']) { $message = trim($_GET['msg']); }
if($_GET['sc'])
	$sc=$_GET['sc'];
else
	$sc='54646';
$fileName="/var/www/html/SMS/log/MTS/mts_log_".date("Y-m-d").".txt"; 

$con = mysql_connect("10.130.14.106","ivr","ivr");
		
if(!$con)
{
	$logdata=$ani."#FAILURE:Connection issue#".$message."#Connection Error:".mysql_error()."#".date("Y-m-d H:i:s")."\n";			
	error_log($logdata,3,$fileName);
	die('could not connect: ' . mysql_error());
}

if((strlen($ani) >= 10 || strlen($ani) <= 12) && is_numeric($ani)) {
	if($message) {		
		//$sndMsgQuery = "CALL master_db.SENDSMS_BULK(".$ani.",'".$message."','$sc')";
		$sndMsgQuery = "CALL master_db.SENDSMS_DND(".$ani.",'".$message."','$sc','recharge','5')";
		$sndMsg = mysql_query($sndMsgQuery);
		$logdata = $ani."#SUCCESS#".$sndMsgQuery."#".date("Y-m-d H:i:s")."\n";
		echo "Sent SMS!";
	} else {
		$logdata = $ani."#FAILURE:Blank Message#".date("Y-m-d H:i:s")."\n";
		echo "Blank message!"; 
	}
} else {
	$logdata = $ani."#FAILURE:Invalid Number#".$message."#".date("Y-m-d H:i:s")."\n";
	echo "Invalid number!"; 
}

error_log($logdata,3,$fileName);
?>
