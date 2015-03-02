<?php
ob_start();
error_reporting(1);
require_once("../db.php");
$remoteAdd=$_SERVER['REMOTE_ADDR'];
$pass = $_POST['password'];
$login = $_POST['username'];
$logDir="/var/www/html/hungamacare/missedcall/snippets/logs/";

$logFile="adminAccessLog_".date('Ymh');
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
$login_query="select id,firstname,lastname,email,mobileno,uid,passwd,last_login from Inhouse_IVR.tbl_missedcall_signup where email = '".$user_name."' AND passwd= '".$pass."' and status=1";
$login_query = mysql_query($login_query,$con) or die(mysql_error());

$row = mysql_fetch_array($login_query);


if(($user_name == $row['email']) && ($pass == $row['passwd']))
{       
		session_start();
		//set session variables
		$_SESSION['id'] = $row['id'];
		$_SESSION['suid'] = $row['uid'];
		$_SESSION['lastLogin'] = $row['last_login'];
	    $_SESSION["fullname"] =$row['firstname']." ".$row['lastname'];
        $thisTime = date("Y-m-d H:i:s");
        $updLastLogin = mysql_query("update Inhouse_IVR.tbl_missedcall_signup set last_login='$thisTime' where id='$row[id]'", $con);
        //mysql_close($dbConn);
	   // redirect to main page after login
	   $redirection_page='dashboard.php';
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
