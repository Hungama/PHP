<?php
ob_start();
error_reporting(1);
require_once("../2.0/incs/db.php");
$remoteAdd=$_SERVER['REMOTE_ADDR'];
$pass = $_POST['password'];
$login = $_POST['username'];
$logDir="/var/www/html/kmis/services/hungamacare/2.0/logs/adminAccessLog/";

$logFile="adminAccessLog_".date('Ymh');
$logPath=$logDir.$logFile;
$filePointer=fopen($logPath,'a+');
chmod($logPath,0777);
fwrite($filePointer,$login."|".$pass."|".$remoteAdd."|".date('his')."\r\n");
fclose($filePointer);

// validate login and password
$user_name = mysql_escape_string($login);
$pass = mysql_escape_string($pass);
$login_query="select id,username,password,access_service,fname,lname,access_sec,notin from master_db.live_user_master where username = '".$user_name."' AND password= '".$pass."' and ac_flag=1";
$login_query = mysql_query($login_query,$dbConn) or die(mysql_error());

$row = mysql_fetch_array($login_query);


if(($user_name == $row['username']) && ($pass == $row['password']))
{       
		session_start();
		//set session variables
		$_SESSION['usrId'] = $row['id'];
		$_SESSION['loginId'] = $row['username'];
		$_SESSION['usrName'] = $row['name'];
		$_SESSION['usrType'] = $row['user_type'];
		$_SESSION['lastLogin'] = $row['last_login'];
		$_SESSION['dbaccess'] = $row['dbaccess'];
		$_SESSION['authid'] = true;
		$_SESSION["access_service"] =$row['access_service'];
        $_SESSION["access_sec"] =$row['access_sec'];
		$_SESSION["notin"] =$row['notin'];
        $_SESSION["fullname"] =$row['fname']." ".$row['lname'];
        $thisTime = date("Y-m-d H:i:s");
        //$updLastLogin = mysql_query("update master_db.ivr_web_user_master set last_login='$thisTime' where id='$row[id]'", $dbConn);
        //mysql_close($dbConn);
	   // redirect to main page after login
	   //$redirection_page='SMSKCI.Services.php';
	 //  $redirection_page='../2.0/home.php';
	  if($row['username']=='tdb.bulk')
	   $redirection_page='bulk_upload_missedcall.php';
	   else
	    $redirection_page='../2.0/home.php';

	   header("Location: $redirection_page");
	   exit();
}
else
{
	// redirect back to index page with error msg
	$redirect = "login.php?ERROR=999";
	header("Location: $redirect");
} 
mysql_close($dbConn);
?>
