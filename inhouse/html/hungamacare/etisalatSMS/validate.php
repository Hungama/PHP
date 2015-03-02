<?php
ob_start();
include("config/dbConnect.php");
$remoteAdd=$_SERVER['REMOTE_ADDR'];
$pass = $_POST['pass'];
$login = $_POST['login'];

$logDir="/var/www/html/kmis/services/hungamacare/log/adminAccessLog/";
$logFile="adminAccessLog_".date('Ymh');
$logPath=$logDir.$logFile;
$filePointer=fopen($logPath,'a+');
chmod($logPath,0777);
fwrite($filePointer,$login."|".$pass."|".$remoteAdd."|".date('his')."\r\n");
fclose($filePointer);

// validate login and password
$user_name = mysql_escape_string($login);
$pass = mysql_escape_string($pass);

$login_query="select id, username, password, name, dbaccess, user_type, last_login from master_db.ivr_web_user_master where username='".$user_name."' and password='".$pass."' and status=1";
$login_query = mysql_query($login_query, $dbConn) or die(mysql_error());

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
        $thisTime = date("Y-m-d H:i:s");
        $updLastLogin = mysql_query("update master_db.ivr_web_user_master set last_login='$thisTime' where id='$row[id]'", $dbConn);
        mysql_close($dbConn);
	   // redirect to main page after login
		$whitelist=array('131','136');
		
		if($row['id']==353)
		{
		$redirection_page="viewSMSpackMsg.php";
		}
		else
		{
		$redirection_page="EtisalatSmsMo.php?usrId=".$row['id'];
		}
		
	   
	   header("Location: $redirection_page");
        exit();
}
else
{
	// redirect back to index page with error msg
	$redirect = "index.php?logerr=invalid";
	header("Location: $redirect");
} 
mysql_close($dbConn);
?>
