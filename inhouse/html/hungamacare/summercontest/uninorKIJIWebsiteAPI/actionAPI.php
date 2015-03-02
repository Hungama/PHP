<?php
error_reporting(0);
 $dbConn = mysql_connect("192.168.100.224","webcc","webcc");
if (!$dbConn)
 {
 die('Could not connect: ' . mysql_error("could not connect to Local"));
 }
$type=$_REQUEST['rtype'];
$ANI=$_REQUEST['ani'];
$logdate = date("Y-m-d");
$logPath_process="logs/".$logdate."_log.txt";
$remoteAdd=$_SERVER['REMOTE_ADDR'];

$logString=$type."#".$ANI."#".$remoteAdd."#".date('d-m-Y h:i:s')."\r\n";
error_log($logString,3,$logPath_process);
	
if($type=='myscore')
{
$getscore_query="select ANI,score from uninor_summer_contest.tbl_contest_subscription nolock
				where ANI='".$ANI."' limit 1";
	$result_score = mysql_query($getscore_query,$dbConn);
	$result_row_score = mysql_num_rows($result_score);	
	if ($result_row_score > 0) {
	$score_details = mysql_fetch_array($result_score);
	$totalScore=$score_details['score'];
	$number=$score_details['ANI'];
	$smscli='52000';
	$msg_type='sms-promo';
	//send Score SMS start here
	$message="Hi! Your Score is ".$totalScore.".Talk to your loved ones with free talk time only on Holi ke rang Uninor ke sang contest mein. Dial 52000(Toll free)";
	$sndMsgQuery = "CALL master_db.SENDSMS_NEW('".$number."','".$message."',";
	$sndMsgQuery .= "'$smscli','UNIM','$msg_type',5)";
	$sndMsg = mysql_query($sndMsgQuery,$dbConn);
	$logString=$sndMsgQuery."#".$ANI."#".date('d-m-Y h:i:s')."\r\n";
	//send Score SMS end here
	$response='OK';
	}
	else
	{
	$logString="No Records Found#".$ANI."#".date('d-m-Y h:i:s')."\r\n";
	$response='NOK';
	}
	error_log($logString,3,$logPath_process);
}
else if($type=='lastcontestwinner')
{
	$response='In Process!';
}
else if($type=='leaderboard')
{
	$response='In Process!';
}

echo $response;
mysql_close($dbConn);
?>