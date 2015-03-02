<?php 
session_start();
$_SESSION["n1"] = $_POST["obd_form_uname"];
$_SESSION["p1"] = $_POST["obd_form_pwd"];
include("db.php"); 

$name=$_POST["obd_form_uname"];
$password=$_POST["obd_form_pwd"];
$qr="select id,username,password from master_db.interface_login_tbl where username = '".$name."' AND password= '".$password."' ";

$a=mysql_query($qr);
$c=mysql_fetch_array($a);
if(!$c)
{session_unset();
echo "<script>alert('Either User name or Password is incorrect')</script>";
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.html">';
}
else
{
$_SESSION["logedinuser"] =$c['username'];

if($name=='admin_ussd')
{
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=upload_ussdbase.php">';
}
else
{
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.html">';
}

}
?>