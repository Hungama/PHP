<?php 
session_start();
$_SESSION["n1"] = $_POST["obd_form_uname"];
$_SESSION["p1"] = $_POST["obd_form_pwd"];
//$_SESSION["n1"] = $_POST["login"];
//$_SESSION["p1"] = $_POST["pass"];
include("db.php"); 

$name=$_POST["obd_form_uname"];
$password=$_POST["obd_form_pwd"];
//$name=$_POST["login"];
//$password=$_POST["pass"];
if($name=='admin' && $password=='password')
{
//$qr="select id,username,password from master_db.ivr_web_user_master where username = '".$name."' AND password= '".$password."' ";
//$a=mysql_query($qr);$c=mysql_fetch_array($a);
$c=1;
}
else if($name=='wap_admin' && $password=='password')
{
$c=1;
}

else if($name=='ussdadmin' && $password=='password')
{
$c=2;
}

else if($name=='admin_ussd' && $password=='hungama')
{
$c=3;
}
else if($name=='arung.ussd' && $password=='arun123')
{
$c=4;
}
else if($name=='arunsingh.ussd' && $password=='arunsingh123')
{
$c=5;
}
else if($name=='neha_ussd' && $password=='neha1345')
{
$c=6;
}
else if($name=='gadadhar.ussd' && $password=='hungama')
{
$c=7;
}
else if($name=='anand.rao.ussd' && $password=='anand123rao')
{
$c=8;
}
else if($name=='gagandeep.dhall' && $password=='gagan1234')
{
$c=9;
}
else if($name=='demo' && $password=='hungama')
{
$c=10;
}
else if($name=='ussd_menu' && $password=='hungama')
{
$c=11;
}
else if($name=='ussd_myrt' && $password=='hungama')
{
$c=12;
}
else
{
$c=0;
}
if(!$c)
{session_unset();
echo "<script>alert('Either User name or Password is incorrect')</script>";
//echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.html">';
$redirect = "index.php?logerr=invalid";
	header("Location: $redirect");
}
else
{
if($name=='wap_admin')
{
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=uploadRingtone.php">';
}
else if($name=='ussdadmin')
{

		$getcount = mysql_query("select count(*) from uninor_myringtone.tbl_ussd_mapping where ussd_string='*288#'");
	$result_count=mysql_fetch_array($getcount);
			
			if($result_count[0]>=1){

echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=showuninor_ussd.php">';
			}
			else
			{
			echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=uninor_ussd.php">';
			}



}
else if($name=='admin_ussd'||$name=='arung.ussd'||$name=='arunsingh.ussd'||$name=='neha_ussd'||$name=='gadadhar.ussd'||$name=='anand.rao.ussd'||$name=='gagandeep.dhall')
{
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=upload_ussdbase.php">';
}
else if($name=='demo')
{
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=bulk_upload.php">';
}
else if($name=='ussd_menu')
{
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=ussd_song_config.php">';
}
else if($name=='ussd_myrt')
{
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=uninor_ussd_myringtone.php">';
}
else
{
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=uninor_ussd_myringtone.php">';
}
$_SESSION["id"]='100';
$_SESSION["logedinuser"] =$name;
}
?>