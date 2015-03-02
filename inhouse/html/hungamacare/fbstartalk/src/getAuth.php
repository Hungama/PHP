<?php
include("config/config.php");
include("dbquery.php");
include ("commonfn.php");

session_start();
$link           =       mysql_pconnect("$mysql_hostname","$mysql_user","$mysql_password") or die(mysql_error());
$select         =       mysql_select_db("$mysql_dbName") or die(mysql_error());

extract($_REQUEST);
//echo("Session appid-->".$_SESSION['appid']);

$appid=$_SESSION['appid'];

$user_msisdn=$phone_no;
if ($user_msisdn=='' || $user_msisdn==null){
    $user_msisdn=$_SESSION['mno'];
//echo("Session user_msisdn-->".$user_msisdn);

}

log_action("!!!!!getAuth!!!!!!---appid --->$appid----Mobile number entered--?$user_msisdn");
$retAccessToken	=	getAccessToken( $user_msisdn,$appid);

//echo("retAccessToken-->".$retAccessToken['FOUND']."value->".$retAccessToken['ROW']['access_token']);

if($retAccessToken['FOUND'] ==  1){
	if ($retAccessToken['ROW']['access_token']!=''){
		echo("You are already registered with given Mobile No.");
		exit();
	}
}
log_action("!!!!!getAuth!!!!!!---retAccessToken --->".$retAccessToken['ROW']['access_token']."----");

$sql	=	"INSERT INTO fp_user(mno, req_time,appid,app_id , status) VALUES('". mysql_escape_string($user_msisdn) ."',NOW(),'".$_SESSION['appid']."','".$_SESSION['fb_appid']."', -1) ";
log_action("!!!!!getAuth!!!!!!---insert query for fp_user --->$sql");
$res	=	mysql_query($sql) or die(mysql_error());
$insId	=	mysql_insert_id($link);
$_SESSION['id'] = $insId;
log_action("!!!!!getAuth!!!!!!---Session ID --->$insId ----going to test_csrf");
header("Location: test_csrf.php");

exit();

?>
