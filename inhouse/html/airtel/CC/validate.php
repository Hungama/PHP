<?php
ob_start();
//include("config/dbConnect.php");
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");

$pass = $_POST['pass'];
$login = $_POST['login'];

// validate login and password
$user_name = mysql_escape_string($login);
$pass = mysql_escape_string($pass);
$login_query="select id, username, password, name, dbaccess, user_type, last_login from master_db.ivr_web_user_master where username='".$user_name."' and password='".$pass."' and status=1";
$login_query = mysql_query($login_query, $dbConnAirtel) or die(mysql_error());

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
        $updLastLogin = mysql_query("update master_db.ivr_web_user_master set last_login='$thisTime' where id='$row[id]'", $dbConnAirtel);
        mysql_close($dbConnAirtel);
		
	   // redirect to main page after login

	  // if($user_name=='docomo1' && $pass='docomotest')
	  if($_SESSION['usrId'] == 49) {
		  $redirection_page='allReport.php';
	  } elseif($_SESSION['usrId'] == 58) { 
		  $redirection_page='whitelistinterface.php';	
	  } elseif($_SESSION['usrId'] == 5) { 
		  $redirection_page='autorenewalInterface.php';	
	  } elseif($_SESSION['usrId'] == 7) { 
		  $redirection_page='AirtelSmsMo.php';	
	  } elseif($_SESSION['usrId'] == 8) { 
		  $redirection_page='directUSSDact.php';	
	  } elseif($_SESSION['usrId'] == 94) { 
		  $redirection_page='removeFailureData.php';	
	  } elseif($_SESSION['usrId'] == 95) { 
		  $redirection_page='bulk_whitelist.php';	
	  } else {
		  $redirection_page='selectservice.php';
	  }
	   //else $redirection_page='main.php';
	   
	   header("Location: $redirection_page");
        exit();
}
else
{
	// redirect back to index page with error msg
	$redirect = "index.php?logerr=invalid";
	header("Location: $redirect");
} 
mysql_close($dbConnAirtel);
?>