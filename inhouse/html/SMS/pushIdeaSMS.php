<?php 
if($_GET['ani']) { $ani = trim($_GET['ani']); }
if($_GET['msg']) { $message = trim($_GET['msg']); }

//$message = str_replace(" ","%20",$message);		

$filePath = "/var/www/html/SMS/log/Idea/idea_log_".date("Y-m-d").".txt";

$con = mysql_connect("192.168.100.224","webcc","webcc");
if(!$con)
{
	$logdata=$ani."#FAILURE:Connection issue#".$message."#Connection Error:".mysql_error()."#".date("Y-m-d H:i:s")."\n";			
	error_log($logdata,3,$fileName);
	die('could not connect: ' . mysql_error());
}

$currTime = date("Y-m-d H:i:s");

if((strlen($ani) == 10 || strlen($ani) == 12) && is_numeric($ani)) {
	if($message) {
		$query="INSERT INTO master_db.tbl_idea_sms (msisdn,msg,operator,cli,status,date_time) VALUES (".$ani.",'".$message."','IDEA','546465','0','".$currTime."')";
		mysql_query($query);
		echo "Done";
		$filedata = $ani."#SUCCESS#".$message."#".date("d-m-Y H:i:s")."\n";
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