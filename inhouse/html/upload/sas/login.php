<?php
include("dbconfig.php");
$username = $_POST['username'];
$password = $_POST['password'];

echo "Welcome ".$username;
echo "<br>";

 $user = mysql_escape_string($username);
 $pass = mysql_escape_string($password);

$loginq="SELECT count(1) FROM master_db.ivr_web_user_master where username='$user' and password='$pass'";
$login = mysql_query($loginq, $con) or die(mysql_error());
list($count)=mysql_fetch_array($login);
		if($count)
		{ 
		$redirect = "tunetalk.php";
		header("Location: $redirect");
		}
		else
		{
		$redirect = "index.php";
		header("Location: $redirect");
		}
mysql_close($con);
?>

