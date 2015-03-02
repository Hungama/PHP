<?php 
session_start();
$_SESSION["n1"] = $_POST["obd_form_uname"];
$_SESSION["p1"] = $_POST["obd_form_pwd"];
include("db.php"); 

$name=$_POST["obd_form_uname"];
$password=$_POST["obd_form_pwd"];
$qr="select id,username,password from master_db.ivr_web_user_master where username = '".$name."' AND password= '".$password."' ";
$a=mysql_query($qr);
$c=mysql_fetch_array($a);
//print_r($c);
mysql_close($con);
if(!$c)
{session_unset();
echo "<script>alert('Either User name or Password is incorrect')</script>";
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.html">';
}
else
{
 if($c['id']=="391" || $c['id']=="393")
	    {
            echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=listallCallLogs.php">';
     	}
		else
		{
		session_destroy();
		echo "<script>alert('Invalid access.')</script>";
		echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.html">';
		}
$_SESSION["id"] =$c['id'];
}
?>