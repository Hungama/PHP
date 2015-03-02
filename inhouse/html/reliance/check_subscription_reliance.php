<?php
$msisdn =$_REQUEST['msisdn'];
$flag=$_REQUEST['flag'];
$service=$_REQUEST['service'];
$con = mysql_connect("database.master","weburl","weburl");
if(!$con)
{
	die('There are some temporarily problem please try later');
}

$check_query="select * from ";
switch($service)
{
	case '1202':
		$check_query .="reliance_hungama.tbl_jbox_subscription";
		break;
	case '1203':
		$check_query .="reliance_hungama.tbl_mtv_subscription";
		break;
	case '1208':
		$check_query .="reliance_cricket.tbl_cricket_subscription";
		break;
}
$check_query .=" where ANI='$msisdn' and STATUS='1'";

$execute_query=mysql_query($check_query);
if(mysql_num_rows($execute_query))
{
	if($flag==1)
		$msg="Success";
	else
		$msg="reliance";
}
else
{
	if($flag==1)
		$msg="Failed";
	else
		$msg=" ";
}
echo $msg;
?>