<?php 
if($_GET['ani']) { $ani = trim($_GET['ani']); }
if($_GET['msg']) { $message = $_GET['msg']; }

$con = mysql_connect("10.2.73.156","team_user","Te@m_us@r987");

$message = str_replace(" ","%20",$message);		

if(!$con)
{
	die('could not connect: ' . mysql_error());
}

$filePath = "/var/www/html/SMS/log/Airtel/airtel_log_".date("Y-m-d").".txt";

if((strlen($ani) == 10 || strlen($ani) == 12) && is_numeric($ani)) {
	if($message) {
		$status = file_get_contents("http://192.168.100.217/SMS/pushAirtelSMS.php?ani=".$ani."&msg=".$message);		
		if($status == 'done') { 
			$filedata = $ani."#SUCCESS#".date("d-m-Y H:i:s")."\n";
			error_log($filedata,3,$filePath);
			echo "Sent SMS!"; 
		} else { 
			$filedata = $ani."#FAILURE#".date("d-m-Y H:i:s")."\n";
			error_log($filedata,3,$filePath);
			echo "Sending Fail!"; 
		}
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