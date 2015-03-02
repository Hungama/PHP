<?php
//include("db.php");
include("/var/www/html/hungamacare/db.php");
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$planid=$_REQUEST['planid'];
$amnt=intval($_REQUEST['amnt']);
$response=$_REQUEST['response'];
$trxid=$_REQUEST['trxid'];
$deviceUA=$_REQUEST['UA'];

$AFFID=$_REQUEST['AFFID'];

if($AFFID=='null' || $AFFID=='')
$AFFID = 0; 

$serviceId=1423;
//181
$mode='WAP';
$logPath = "/var/www/html/hungamawap/uninorcontest/API/logs/sub/log_".date("Y-m-d").".txt";
if($msisdn) { 
switch($serviceId)
	{
	case '1423':
			$db = "uninor_summer_contest";
			$sub = "tbl_contest_subscription_wapcontest"; 
			$srt_code = 52000;
			$planid=270;//181
			break;
   }
	$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
	$circle1=mysql_query($getCircle);
	while($row = mysql_fetch_array($circle1)) {
		$circle = $row['circle'];
	}
	if(!$circle) { $circle='UND'; }


	
	
			$getQuery1="SELECT COUNT(1) FROM $db".'.'."$sub WHERE status in(1,11,9,0) and ANI=".$msisdn;
			$countData = mysql_query($getQuery1);
			list($allSub) = mysql_fetch_array($countData);
			if($allSub)
			{
				$res="AlreadySubscribed";
				echo $res;
				$logData="msisdn#".$msisdn."#planid#".$planid."#response#".$res."#mode#".$mode."#circle#".$circle."#serviceId#".$serviceId."#amount#".$amount."#Already Subscribed#".$AFFID."#".date("Y-m-d H:i:s")."\n";
				error_log($logData,3,$logPath);
			} else 
			{
$querySUB = "insert into ". $db.".".$sub."(ANI,SUB_DATE,RENEW_DATE,STATUS,MODE_OF_SUB,DNIS,CIRCLE,SUB_TYPE,SCORE,PLAY_DATE,chrg_amount,plan_id,ques_available,ques_played,correct_ques,Redeem_points,difficulty_level,DEF_LANG,operator,affid,deviceUA)
		values('".$msisdn."',now(),now(),0,'WAP','".$srt_code."','".$circle."',null,0,now(),0,'".$planid."',5,0,0,0,1,'01','UNIM','".$AFFID."','".$deviceUA."')";
	if(mysql_query($querySUB))
	{
	$res='SUCCESS';
	$error='OK';
	}
	else
	{
	$res='FAILURE';
	$error=mysql_error();
	}
	echo $res;
	$logData="msisdn#".$msisdn."#planid#".$planid."#response#".$res."#Error".$error."#mode#".$mode."#circle#".$circle."#serviceId#".$serviceId."#amount#".$amount."#" .$querySUB."#".$AFFID."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);

		} 
} else {
	$res='MDNNOTFOUND';
	$logData="MDN NOT FOUND#planid:".$planid."#response:".$res."#Invalid Parameter#".$AFFID."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);
}
mysql_close($con); 
?>
