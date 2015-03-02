<?php
//setcookie("mts_107_user", "Satay Tiwari1", time()+3600);
// Print a cookie
session_start();
		//set session variables
		$_SESSION['usrId1'] = 'Satay Tiwari123';
		echo $_SESSION['usrId1'];
//echo $_COOKIE["mts_107_user"];

// A way to view all cookies
//print_r($_COOKIE);
?>