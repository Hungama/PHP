<?php
ob_start();
error_reporting(1);
require_once("../db.php");
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
//$login_query="select id,firstname,lastname,email,mobileno,uid,passwd,last_login from Inhouse_IVR.tbl_missedcall_signup where email = '".$user_name."' AND passwd= '".$pass."' and status=1";

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
		
		$lusername=$row['username'];
		 if($lusername=='kunalk.arora' || $lusername=='vikrant.garg' || $lusername=='client.robinhood' || $lusername=='client.glc' || $lusername=='client.hds1' || $lusername=='client.hds2' || $lusername=='client.hds3' || $lusername=='client.hds4' || $lusername=='client.hds5' || $lusername=='client.hul1' || $lusername=='client.hul2' || $lusername=='client.hul3' || $lusername=='client.hul4' || $lusername=='client.hul5' || $lusername=='gaurav.talwar' || $lusername=='gaurav.bhatnagar' ||$lusername=='satay.tiwari')
		$redirection_page='../missedcall/admin/html/dashboardGLC1.php';
		else
	  	$redirection_page='index.php?ERROR=901';
		
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

<script type="text/javascript">
setCookie('mymdn',<?php echo $lusername;?>);
function setCookie(c_name,value,exdays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name)
{
var c_value = document.cookie;
var c_start = c_value.indexOf(" " + c_name + "=");
if (c_start == -1)
  {
  c_start = c_value.indexOf(c_name + "=");
  }
if (c_start == -1)
  {
  c_value = null;
  }
else
  {
  c_start = c_value.indexOf("=", c_start) + 1;
  var c_end = c_value.indexOf(";", c_start);
  if (c_end == -1)
  {
c_end = c_value.length;
}
c_value = unescape(c_value.substring(c_start,c_end));
}
return c_value;
}
</script>