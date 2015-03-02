<?php
/* @author: Satay Tiwari 
 * @File prupose: call add details API http://omega.hungamavoice.com/hungamacare/igenius/statusCheckHun.php?msisdn=<10 DIGIT MOBILE NO>&uid=<USER Name>&childid=<Child ID> 
 * and return response in # seprated Form 
 */
error_reporting(0);

$stopdate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
if($stopdate>='2014-11-03')
{
exit;
}
$logDir = "/var/www/html/hungamacare/igenius/logs/callSubmitHun/";
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
//$dbConn
$logFile_dump = "statuscheck_" . date('Ymd');
$logPath = $logDir . $logFile_dump . ".txt";
$ipAddress = $_SERVER['REMOTE_ADDR'];
$msisdn = $_REQUEST['msisdn'];
$username = $_REQUEST['uid'];
$childid = $_REQUEST['childid'];

if ($msisdn == '') {
    $resp['response'] ="3";
	$resp['msg'] ="MSISDN missing";
	$resp=json_encode($resp);
	$logString = $resp."#".$msisdn . "#" . $username . "#" . $childid."#".$ipAddress . "#" . date('Y-m-d H:i:s') . "\r\n";
	error_log($logString, 3, $logPath);
	echo $resp;
    exit;
}
if ($username == '') {
    $resp['response'] ="3";
	$resp['msg'] ="Userid missing";
	$resp=json_encode($resp);
	$logString = $resp."#".$msisdn . "#" . $username . "#" . $childid."#".$ipAddress . "#" . date('Y-m-d H:i:s') . "\r\n";
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
	$resp['response'] ="2";
	$resp['entrydate'] ="0";
	$resp['updatedate'] ="0";
	$resp=json_encode($resp);
	$logString = $resp."#".$msisdn . "#" . $username . "#" . $childid."#".$ipAddress . "#" . date('Y-m-d H:i:s') . "\r\n";
	error_log($logString, 3, $logPath);
	echo $resp;
exit;
}


$dbTable="Hungama_Maxlife_IGenius.tbl_userstatus";
$StatusCheckqry = "select regdate,lastupdatedatechild1,regdatechild2,lastupdatedatechild2 from  $dbTable nolock where ANI='" . $msisdn . "' $cond";
$result = mysql_query($StatusCheckqry,$dbConn);
list($regdate,$lastupdatedatechild1,$regdatechild2,$lastupdatedatechild2) = mysql_fetch_array($result);

if($type=="child1") 
{
	if($regdate!='')
	{
	$resp['response'] ="1";
	$resp['entrydate'] =$regdate;
	$resp['updatedate'] =$lastupdatedatechild1;
	}
	else
	{
	$resp['response'] ="2";
	$resp['entrydate'] ="0";
	$resp['updatedate'] ="0";
	}
}
else if($type=="child2")
{
	if($regdatechild2!='')
	{
	$resp['response'] ="1";
	$resp['entrydate'] =$regdatechild2;
	$resp['updatedate'] =$lastupdatedatechild2;
	}
	else
	{
	$resp['response'] ="2";
	$resp['entrydate'] ="0";
	$resp['updatedate'] ="0";
	}
}
mysql_close($dbConn);
$resp=json_encode($resp);
$logString = $resp."#".$msisdn . "#" . $username . "#" . $childid."#".$ipAddress . "#" . date('Y-m-d H:i:s') . "\r\n";
error_log($logString, 3, $logPath);
echo $resp;
//{"response":"3","msg":"Time up"}
//{"response":"2","entrydate":"0","updatedate":"0"}

/*if ($msisdn == '' || $uid == '' || $filepath == '' || $dtime == '') {
    echo "Invalid Parameter";
    exit; // if msisdn or uid not found than exit @jyoti porwal
}
if ((is_numeric($msisdn)) && (strlen($msisdn) == 12 || strlen($msisdn) == 10)) {
    
} else {
    echo "msisdn is not valid";
    exit; // if msisdn not valid than exit @jyoti porwal
}
*/
?>