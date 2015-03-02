<?php
ob_start();
error_reporting(0);
//require_once("incs/db.php");
$remoteAdd=$_SERVER['REMOTE_ADDR'];
$pass = $_POST['pass'];
$login = $_POST['login'];

$logDir="/var/www/html/hungamacare/logs/adminAccessLog/";

$logFile="adminAccessLog_".date('Ymd');
$logPath=$logDir.$logFile;
$filePointer=fopen($logPath,'a+');
chmod($logPath,0777);
fwrite($filePointer,$login."|".$pass."|".$remoteAdd."|".date('H:i:s')."\r\n");
fclose($filePointer);

// validate login and password
$user_name = mysql_escape_string($login);
$pass = mysql_escape_string($pass);

/*$login_query="select id,username,password,access_service,fname,lname,access_sec from misdata.usermanager where username = '".$user_name."' AND password= '".$pass."' and ac_flag=1";
$login_query = mysql_query($login_query,$dbConn_218) or die(mysql_error());

$row = mysql_fetch_array($login_query);
*/

//if(($user_name == $row['username']) && ($pass == $row['password']))
if(($user_name == 'demo') && ($pass == 'hungama'))
{       
		session_start();
		//set session variables
		//$_SESSION['usrId'] = $row['id'];
		//$_SESSION['loginId'] = $row['username'];
		$_SESSION['loginId'] =$user_name;
		//$_SESSION['usrName'] = $row['name'];
		$_SESSION['usrName'] = $user_name;
		//$_SESSION['usrType'] = $row['user_type'];
		//$_SESSION['lastLogin'] = $row['last_login'];
		$_SESSION['dbaccess'] = $row['dbaccess'];
		$_SESSION['authid'] = true;
//		$_SESSION["access_service"] =$row['access_service'];
  //      $_SESSION["access_sec"] =$row['access_sec'];
		$_SESSION["access_service"] ='cc,bulk';
        $_SESSION["access_sec"] ='';

      //  $_SESSION["fullname"] =$row['fname']." ".$row['lname'];
	   $_SESSION["fullname"] =$user_name;
        $thisTime = date("Y-m-d H:i:s");
	   $redirection_page='home.php';
	   header("Location: $redirection_page");
	   
	    exit();
}
else
{
	// redirect back to index page with error msg
	$redirect = "index.php?logerr=invalid";
	header("Location: $redirect");
} 
//mysql_close($dbConn_218);
?>