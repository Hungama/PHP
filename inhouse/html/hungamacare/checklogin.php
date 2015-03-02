<?php
//ob_start();
error_reporting(1);
//$_SESSION["n1"] = $_POST["obd_form_uname"];
//$_SESSION["p1"] = $_POST["obd_form_pwd"];
$remoteAdd=$_SERVER['REMOTE_ADDR'];
include("db.php"); 
$user_name=mysql_escape_string($_POST["obd_form_uname"]);
$pass=mysql_escape_string($_POST["obd_form_pwd"]);

$logDir="/var/www/html/hungamacare/log/adminAccessLog/";
$logFile="adminAccessLog_".date('Ymh');
$logPath=$logDir.$logFile;
$filePointer=fopen($logPath,'a+');
chmod($logPath,0777);
$login_query="select id,username,password,access_service,fname,lname,access_sec from master_db.live_user_master where username = '".$user_name."' AND password= '".$pass."' and ac_flag=1";
$login_query = mysql_query($login_query,$con) or die(mysql_error());

$row = mysql_fetch_array($login_query);


if(($user_name == $row['username']) && ($pass == $row['password']))
{
session_start();
		//set session variables
		$_SESSION['usrId'] = $row['id'];
		$_SESSION['loginId'] = $row['username'];
		//$_SESSION['usrName'] = $row['name'];
		//$_SESSION['lastLogin'] = $row['last_login'];
		//$_SESSION['dbaccess'] = $row['dbaccess'];
		$_SESSION["n1"] = $row['username'];
        $_SESSION["p1"] = $row["password"];
		 $_SESSION['authid'] = true;
        $thisTime = date("Y-m-d H:i:s");
        $_SESSION["access_service"] =$row['access_service'];
        $_SESSION["access_sec"] =$row['access_sec'];
        $_SESSION["fullname"] =$row['fname']." ".$row['lname'];
		//echo  "22".$_SESSION["n1"]. "".$row['password'];
fwrite($filePointer,$user_name."|".$remoteAdd."|success|".date('his')."\r\n");
	echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=home.php">';
}
else
{
fwrite($filePointer,$user_name."|".$pass."|".$remoteAdd."|failed|".date('his')."\r\n");
echo "<script>alert('Either User name or Password is incorrect')</script>";
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.html">';
}
fclose($filePointer);
mysql_close($con);
?>