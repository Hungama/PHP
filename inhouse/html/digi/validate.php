<?php
ob_start();
include("dbDigiConnect.php");
$remoteAdd=$_SERVER['REMOTE_ADDR'];
$pass = $_POST['pass'];
$login = $_POST['login'];

/*** Master DB Connection ***/
/*
//MASTER DATABASE ACCESS VARIABLES
 $DB_HOST_M     = '172.16.56.42'; //'172.28.106.4'; //DB HOST
 $DB_USERNAME_M = 'root';  //DB Username
 $DB_PASSWORD_M = 'D1g1r00t@!23';  //DB Password 'Te@m_us@r987';
 $DB_DATABASE_M = 'master_db';  //Datbase Name
 $db_m = $DB_DATABASE_M;

$dbConn = mysql_connect($DB_HOST_M, $DB_USERNAME_M, $DB_PASSWORD_M) or die(mysql_error());
if (!$dbConn) {
    die('Could not connect1: ' . mysql_error());
}
mysql_select_db($DB_DATABASE_M, $dbConn) or die(mysql_error());
*/
/*$data = mysql_query("SELECT * FROM master_db.ivr_web_user_master", $dbConn);
$result = mysql_fetch_array($data);
print_r($result);
exit;*/

/*$logDir="/var/www/html/kmis/services/hungamacare/log/adminAccessLog/";
$logFile="adminAccessLog_".date('Ymh');
$logPath=$logDir.$logFile;
$filePointer=fopen($logPath,'a+');
chmod($logPath,0777);
fwrite($filePointer,$login."|".$pass."|".$remoteAdd."|".date('his')."\r\n");
fclose($filePointer);*/

// validate login and password
$user_name = mysql_escape_string($login);
$pass = mysql_escape_string($pass);

$login_query="select id, username, password, name, dbaccess, user_type, last_login from master_db.ivr_web_user_master where username='".$user_name."' and password='".$pass."' and status=1";

$login_query = mysql_query($login_query, $dbConn) or die(mysql_error());

$row = mysql_fetch_array($login_query);
if(($user_name == $row['username']) && ($pass == $row['password']))
{
		session_start();
		$redirection_page = "";
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
		if($_SESSION['usrId']==1)
			$redirection_page='sms_bulk_upload.php';
		elseif($_SESSION['usrId']==2)
			$redirection_page='interface_liveMIS.php';
		else 
			$redirection_page='login.php?logerr=invalid';
	   header("Location: $redirection_page");
        exit();
}
else
{
	// redirect back to index page with error msg
	$redirect = "login.php?logerr=invalid";
	header("Location: $redirect");
}
mysql_close($dbConn);
?>
