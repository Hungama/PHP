<?php
if($_GET['ani'])
	$ani = trim($_GET['ani']); 
if($_GET['msg'])
 $message = trim($_GET['msg']); 
if($_GET['sc'])
	$sc=$_GET['sc'];
else
	$sc='546465';

$con = mysql_connect("192.168.100.224","webcc","webcc");
		
$fileName="/var/www/html/SMS/log/Docomo/docomo_log_".date("Y-m-d").".txt"; 

if(!$con)
{
	$logdata=$ani."#FAILURE:Connection issue#".$message."#Connection Error:".mysql_error()."#".date("Y-m-d H:i:s")."\n";			
	error_log($logdata,3,$fileName);
	die('could not connect: ' . mysql_error());
}

if((strlen($ani) == 10 || strlen($ani) == 12) && is_numeric($ani)) 
{
	if($message) 
		{
			$sndMsgQuery = "CALL master_db.SENDSMS_NEW('".$ani."','".$message."','$sc','TATM','TATMSMS',1)";
			$sndMsg = mysql_query($sndMsgQuery);
			$logdata =  $ani."#".$sndMsgQuery."#SUCCESS#".date("Y-m-d H:i:s")."\n";
			echo "Sent SMS!";		
		}
	else
		{
			$logdata = $ani."#FAILURE:Blank Message#".date("Y-m-d H:i:s")."\n";
			echo "Blank message!"; 
	}
}
else 
	{
	$logdata = $ani."#FAILURE:Invalid Number#".$message."#".date("Y-m-d H:i:s")."\n";
	echo "Invalid number!"; 
}
error_log($logdata,3,$fileName);
?>