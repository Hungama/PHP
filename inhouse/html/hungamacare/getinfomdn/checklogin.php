<?php 
session_start();
$_SESSION["n1"] = $_POST["obd_form_uname"];
$_SESSION["p1"] = $_POST["obd_form_pwd"];
//include("db.php"); 

$name=$_POST["obd_form_uname"];
$password=$_POST["obd_form_pwd"];
if($name=='admin' && $password='password')
{
//$qr="select id,username,password from master_db.ivr_web_user_master where username = '".$name."' AND password= '".$password."' ";
//$a=mysql_query($qr);$c=mysql_fetch_array($a);
$c=1;
}
else
{
$c=0;
}
if(!$c)
{session_unset();
echo "<script>alert('Either User name or Password is incorrect')</script>";
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.html">';
}
else
{
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=home.php">';
$_SESSION["logedinuser"] ='admin';
}
?>