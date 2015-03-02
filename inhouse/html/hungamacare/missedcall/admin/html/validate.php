<?php
ob_start();
error_reporting(1);
require_once("../../../db.php");
$remoteAdd=$_SERVER['REMOTE_ADDR'];
$pass = $_POST['password'];
$login = $_POST['username'];
$logDir="/var/www/html/hungamacare/missedcall/admin/html/logs/";

$logFile="newadminAccessLog_".date('Ymh');
$logPath=$logDir.$logFile;
$filePointer=fopen($logPath,'a+');
chmod($logPath,0777);
fwrite($filePointer,$login."|".$pass."|".$remoteAdd."|".date('his')."\r\n");
fclose($filePointer);

// validate login and password
$user_name = mysql_escape_string($login);
$pass = mysql_escape_string($pass);
if(empty($user_name) || empty($pass))
{
$redirect = "index.php?ERROR=998";
header("Location: $redirect");
exit;
}

$login_query="select id,username,password,access_service,fname,lname,access_sec,email from master_db.live_user_master where username = '".$user_name."' AND password= '".$pass."' and ac_flag=1";


$login_query = mysql_query($login_query,$con) or die(mysql_error());

$row = mysql_fetch_array($login_query);


if(($user_name == $row['username']) && ($pass == $row['password']))
{      
		session_start();
		$_SESSION['usrId'] = $row['id'];
		$_SESSION['loginId'] = $row['username'];
		$_SESSION['usrName'] = $row['name'];
		$_SESSION['usrType'] = $row['user_type'];
		$_SESSION['lastLogin'] = $row['last_login'];
		$_SESSION['dbaccess'] = $row['dbaccess'];
		$_SESSION['authid'] = true;
		$_SESSION["access_service"] =$row['access_service'];
        $_SESSION["access_sec"] =$row['access_sec'];
		$_SESSION["email"] =$row['email'];
        $_SESSION["fullname"] =$row['fname']." ".$row['lname'];
        $thisTime = date("Y-m-d H:i:s");
		
		
		 if($row['username']=='kunalk.arora' || $row['username']=='vikrant.garg' || $row['username']=='client.robinhood' )
		$redirection_page='dashboardAd.php';
		 else if($row['username']=='client.mcd')
		 $redirection_page='dashboard_MCD_MIS.php';
		 else if($row['username']=='client.tatat')
		 $redirection_page='dashboardTataTiscon.php';
		 else if($row['username']=='client.gsk')
		 $redirection_page='dashboard_GSK_MIS.php';
	    else
	  	$redirection_page='dashboardGLC1.php';
		
	   header("Location: $redirection_page");
	   exit();
}
else
{
	// redirect back to index page with error msg
	$redirect = "index.php?ERROR=999";
	header("Location: $redirect");
} 
mysql_close($con);
?>
