<?php
/* @author: Satay Tiwari 
 * @File prupose: call add details API http://omega.hungamavoice.com/hungamacare/igenius/callSubmitDetailsHun.php?msisdn=<10 DIGIT MOBILE NO>&uid=<USER Name>&childid=<Child ID>&filepath=<PATH OF FILE>&dtime=<DATE TIME YYYY-M-D H:i:s> 
 * and return response in # seprated Form 
 */
error_reporting(0);
$stopdate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
if($stopdate>='2014-11-03')
{
exit;
}
//$logDir = "/var/www/html/hungamacare/igenius/logs/callAddDetails/";
$logDir = "/var/www/html/hungamacare/igenius/logs/callSubmitHun/";

include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$logFile_dump = "reqsLog_" . date('Ymd');
$logPath = $logDir . $logFile_dump . ".txt";
$ipAddress = $_SERVER['REMOTE_ADDR'];
$msisdn = $_REQUEST['msisdn'];
$username = $_REQUEST['uid'];
$childid = $_REQUEST['childid'];
$filepath = $_REQUEST['filepath'];
$dtime = $_REQUEST['dtime'];
if ($msisdn == '') {
    $resp['response'] ="2";
	$resp['msg'] ="MSISDN missing";
	$resp=json_encode($resp);
	$logString = $resp."#".$msisdn . "#" . $username . "#" . $filepath."#".$dtime."#".$ipAddress . "#".$childid."#" . date('Y-m-d H:i:s') . "\r\n";
	error_log($logString, 3, $logPath);
	echo $resp;
    exit;
}
if ($username == '') {
    $resp['response'] ="2";
	$resp['msg'] ="Userid missing";
	$resp=json_encode($resp);
	$logString = $resp."#".$msisdn . "#" . $username . "#" . $filepath."#".$dtime."#".$ipAddress . "#".$childid."#" . date('Y-m-d H:i:s') . "\r\n";
	error_log($logString, 3, $logPath);
	echo $resp;
    exit;
}
/*
if ($filepath == '') {
    $resp['response'] ="2";
	$resp['msg'] ="Invalid file path";
	$resp=json_encode($resp);
	$logString = $resp."#".$msisdn . "#" . $username . "#" . $filepath."#".$dtime."#".$ipAddress . "#".$childid."#" . date('Y-m-d H:i:s') . "\r\n";
	error_log($logString, 3, $logPath);
	echo $resp;
    exit;
}
*/
if ($dtime == '') {
    $resp['response'] ="2";
	$resp['msg'] ="Datetime missing";
	$resp=json_encode($resp);
	$logString = $resp."#".$msisdn . "#" . $username . "#" . $filepath."#".$dtime."#".$ipAddress . "#".$childid."#" . date('Y-m-d H:i:s') . "\r\n";
	error_log($logString, 3, $logPath);
	echo $resp;
    exit;
}
$dbTable="Hungama_Maxlife_IGenius.tbl_userstatus";
$StatusCheck = "select regdate,lastupdatedatechild1,regdatechild2,lastupdatedatechild2,child1username,child2username from  $dbTable nolock where ANI='" . $msisdn ."'";
$result = mysql_query($StatusCheck,$dbConn);
list($regdate,$lastupdatedatechild1,$regdatechild2,$lastupdatedatechild2,$child1username,$child2username) = mysql_fetch_array($result);

if($username==$child1username)
{
$type="child1";
$cond="and child1username='".$username."'";
}
else if($username==$child2username)
{
$type="child2";
$cond="and child2username='".$username."'";
}


else
{
	if(empty($child1username))
	{
	$insert_queryCh = "INSERT INTO $dbTable (ANI,regdate,status,child1username,child1lastupdatedativr) VALUES ('".$msisdn."', '".$dtime."', '1','".$username."','0')";
	$result = mysql_query($insert_queryCh,$dbConn);
	$resp['response'] ="1";
	$resp['msg'] ="Successfully inserted";
	}
	else if(empty($child2username))
	{
	$insert_queryCh = "update $dbTable set regdatechild2='".$dtime."',child2username='".$username."',child2lastupdatedativr=0 where ani='".$msisdn."'";
	$result = mysql_query($insert_queryCh,$dbConn);
	$resp['response'] ="1";
	$resp['msg'] ="Successfully inserted";
	}
	else
	{
	$resp['response'] ="2";
	$resp['msg'] ="limit exceeded.";
	}
	//echo $insert_queryCh;
	$resp=json_encode($resp);
	$logString = $resp."#".$msisdn . "#" . $username . "#" . $filepath."#".$dtime."#".$ipAddress . "#".$childid."#" . date('Y-m-d H:i:s') . "\r\n";	error_log($logString, 3, $logPath);
	echo $resp;
exit;
}

$StatusCheckqry = "select regdate,lastupdatedatechild1,regdatechild2,lastupdatedatechild2 from  $dbTable nolock where ANI='" . $msisdn . "' $cond";
$result = mysql_query($StatusCheckqry,$dbConn);
$num=mysql_num_rows($result);
list($regdate,$lastupdatedatechild1,$regdatechild2,$lastupdatedatechild2) = mysql_fetch_array($result);

if($type=="child1") 
{
	if($num>=1)
	{
		if($regdate!='')
		{
		$updateStatus = "update  $dbTable set lastupdatedatechild1='".$dtime."',child1lastupdatedativr=0 where ANI='" . $msisdn . "' $cond";	
		}
		else
		{
		$updateStatus = "update  $dbTable set lastupdatedatechild1='".$dtime."',regdate='".$dtime."',child1lastupdatedativr=0 where ANI='" . $msisdn . "' $cond";	
		}
		mysql_query($updateStatus,$dbConn);
		$resp['response'] ="1";
		$resp['msg'] ="Successfully updated";
	}
	else
	{
	$resp['response'] ="2";
	$resp['msg'] ="Server Error. Please try again";
	}
}
else if($type=="child2")
{
	if($num>=1)
	{
		if($regdatechild2!='')
		{
		$updateStatus = "update  $dbTable set lastupdatedatechild2='".$dtime."',child2lastupdatedativr=0 where ANI='" . $msisdn . "' $cond";	
		}
		else
		{
		$updateStatus = "update  $dbTable set lastupdatedatechild2='".$dtime."',regdatechild2='".$dtime."',child2lastupdatedativr=0 where ANI='" . $msisdn . "' $cond";	
		}
		mysql_query($updateStatus,$dbConn);
		$resp['response'] ="1";
		$resp['msg'] ="Successfully updated";
		
	}
	else
	{
	$resp['response'] ="2";
	$resp['msg'] ="Server Error. Please try again";
	}
}
	$resp=json_encode($resp);
	$logString = $resp."#".$msisdn . "#" . $username . "#" . $filepath."#".$dtime."#".$ipAddress . "#".$childid."#" . date('Y-m-d H:i:s') . "\r\n";
	error_log($logString, 3, $logPath);
	echo $resp;
mysql_close($dbConn);
?>