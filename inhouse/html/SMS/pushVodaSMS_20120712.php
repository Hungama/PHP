<?php
if($_GET['ani']) { $ani = trim($_GET['ani']); }
if($_GET['msg']) { $message = trim($_GET['msg']); }
if($_GET['value']) { $value = trim($_GET['value']); }

$message = str_replace(" ","%20",$message);
$fileName="/var/www/html/SMS/log/Voda/vodafone_log_".date("Y-m-d").".txt"; 

if((strlen($ani) >= 10 || strlen($ani) <= 12) && is_numeric($ani)) {
	if($message) {
		$status = file_get_contents("http://192.168.100.217/SMS/pushVodaSMS.php?ani=".$ani."&msg=".$message."&val=".$value);
		if($status == 'done') { 
			$logdata = $ani."#SUCCESS#".date("Y-m-d H:i:s")."\n";	
			echo "Sent SMS!";
		} else { 
			$logdata = $ani."#FAILURE#".date("Y-m-d H:i:s")."\n";	
			echo "Sending Fail!";
		}
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