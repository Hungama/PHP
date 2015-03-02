<?php
ob_start();
session_start();
require_once("../../../db.php");
$id=$_REQUEST['id'];
$fname=$_REQUEST['fname'];
$lname=$_REQUEST['lname'];
$email=$_REQUEST['email'];
$city=$_REQUEST['city'];
$cname=$_REQUEST['cname'];
$noofemp=$_REQUEST['noofemp'];
$website=$_REQUEST['website'];
$mobile=$_REQUEST['mobile'];
$suid=$_REQUEST['suid'];
$msg="Profile has been updated successfully.";
$sql="Update Inhouse_IVR.tbl_missedcall_signup set firstname='".$fname."',lastname='".$lname."',city='".$city."',mobileno='".$mobile."',
company='".$cname."',noofemp='".$noofemp."',website='".$website."' where uid='".$suid."'";
			if(mysql_query($sql,$con))
			{
			echo $msg;
			}
			else
			{
			echo 'Server Error.Please try again.';
			}
mysql_close($con);
 $redirection_page='profile.php';
 header("Location: $redirection_page");
?>