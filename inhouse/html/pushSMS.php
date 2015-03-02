<?php
if($_GET['ani']) { $ani = $_GET['ani']; }
if($_GET['msg']) { $message = $_GET['msg']; }

$con = mysql_connect("192.168.100.224","webcc","webcc");
		
if(!$con)
{
	die('could not connect: ' . mysql_error());
}

if(strlen($ani) >= 10) {
	if($message) {
		$sndMsgQuery = "CALL master_db.SENDSMS_NEW('".$ani."','".$message."','HUNVOC','TATM','TATMSMS',5)";
		$sndMsg = mysql_query($sndMsgQuery);
		echo "Send SMS!";
	} else {
		echo "Blank message!"; die;
	}
} else {
	echo "Invalid number!"; die;
}

?>