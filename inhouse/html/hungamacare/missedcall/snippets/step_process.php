<?php
ob_start();
session_start();
require_once("../../db.php");
function rand_string( $length ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}

	return $str;
}

$uid=$_REQUEST['uid'];
$_SESSION['suid']=$uid;

$remoteAdd=trim($_SERVER['REMOTE_ADDR']);
$action=$_REQUEST['action'];

if($action=='step1')
{
$firstname=$_REQUEST['firstname'];
$lastname=$_REQUEST['lastname'];
$email=trim($_REQUEST['email']);
$password=$_REQUEST['password'];
$city=trim($_REQUEST['city']);
$company=trim($_REQUEST['company']);
$noofemployee=trim($_REQUEST['noofemployee']);
$website=trim($_REQUEST['website']);
$coupan_code=trim($_REQUEST['coupan_code']);
$campaign_name=trim($_REQUEST['campaign_name']);
$mobile_no=trim($_REQUEST['mobile_no']);

$check_email="select email from Inhouse_IVR.tbl_missedcall_signup where email='".$email."'";
$check_email_query = mysql_query($check_email,$con);
$num_rows=mysql_num_rows($check_email_query);
if($num_rows>=1)
{
echo 'NOK1';
mysql_close($con);
exit;
}

$step1_query="insert into Inhouse_IVR.tbl_missedcall_signup(firstname, lastname, email, passwd, city, company, noofemp, website,coupancode,mobileno,registed_on,status,uid,ip)
 values('$firstname', '$lastname', '$email', '$password', '$city', '$company', '$noofemployee','$website','$coupan_code','$mobile_no',now(),'0','$uid','$remoteAdd')";
if(mysql_query($step1_query, $con))
{
echo 'OK';
$cpgid = rand_string( 5 ).date('Ymd');
$step1_cpg_query="insert into Inhouse_IVR.tbl_missedcall_cpginfo(cpgid, uid, cpgname, status)
 values('$cpgid', '$uid', '$campaign_name', '0')";
 mysql_query($step1_cpg_query, $con);
 $_SESSION['cpgid']=$cpgid;
 $_SESSION['cpgname']=$campaign_name;
}
else
{
echo 'NOK';
}
}

else if($action=='step2')
{
//$cpgid=$_SESSION['cpgid'];
$realdnis=$_REQUEST['realdnis'];
$_SESSION['dnis']=$realdnis;
$step1_query="update Inhouse_IVR.tbl_missedcall_cpginfo set mobileno='".$realdnis."' where cpgid='".$_SESSION['cpgid']."' and uid='".$_SESSION['suid']."'";
if(mysql_query($step1_query, $con))
{
echo 'OK';
}
else
{
echo 'NOK';
}
}

else if($action=='step3')
{
//$cpgid=$_SESSION['cpgid'];
$missedcall_msg=$_REQUEST['missedcall_msg'];
$step1_query="update Inhouse_IVR.tbl_missedcall_cpginfo set missed_call_text='".$missedcall_msg."',created_on=now(),status=1 where cpgid='".$_SESSION['cpgid']."' and uid='".$_SESSION['suid']."'";
if(mysql_query($step1_query, $con))
{
echo 'OK';
$final_query=mysql_query("update Inhouse_IVR.tbl_missedcall_signup set status='1' where uid='".$_SESSION['suid']."'",$con);
$block_query=mysql_query("update Inhouse_IVR.tbl_missedcall_config set cpgid='".$_SESSION['cpgid']."' where dnis='".$_SESSION['dnis']."'",$con);
}
else
{
echo 'NOK';
}
}

else if($action=='step4')
{
$orgfilename=$_FILES['upfile']['name'];
 $file = $_FILES['upfile'];
$SafeFile = explode(".", $_FILES['upfile']['name']);
$makFileName = str_replace(" ","_",$SafeFile[0])."_".date("YmdHis").".".$SafeFile[1];
	$uploaddir = "msgfile/";
	$path = $uploaddir.$makFileName;
if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path))
{
//$cpgid=$_SESSION['cpgid'];
$predefind_sms=$_REQUEST['predefind_sms'];
$step1_query="update Inhouse_IVR.tbl_missedcall_cpginfo set smsfilename='".$makFileName."',predefind_msg='".$predefind_sms."',created_on=now(),status=1 where cpgid='".$_SESSION['cpgid']."' and uid='".$_SESSION['suid']."'";
if(mysql_query($step1_query, $con))
{
$final_query=mysql_query("update Inhouse_IVR.tbl_missedcall_signup set status='1' where uid='".$_SESSION['suid']."'",$con);
echo 'Campgion has been created successfully.';
}
else
{
echo 'NOK';
}
}
else
{
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">There are some server errors while file uploading ,Please try again.</div></div>";
}
}
mysql_close($con);
?>