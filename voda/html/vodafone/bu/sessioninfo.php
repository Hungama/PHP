<?php
$user_name='kunalk.arora';
$pass='hello';
$login_query="select id,username,password,access_service,fname,lname,access_sec from master_db.live_user_master where username = '".$user_name."' AND password= '".$pass."' and ac_flag=1";
$login_query = mysql_query($login_query,$dbConn) or die(mysql_error());
$row = mysql_fetch_array($login_query);		
session_start();
		$_SESSION['usrId'] = $row['id'];
		$_SESSION['loginId'] = $row['username'];
     	$_SESSION["n1"] = $row['username'];
        $_SESSION["p1"] = $row["password"];
		 $_SESSION['authid'] = true;
        $thisTime = date("Y-m-d H:i:s");
        $_SESSION["access_service"] =$row['access_service'];
        $_SESSION["access_sec"] =$row['access_sec'];
        $_SESSION["fullname"] =$row['fname']." ".$row['lname'];			
?>