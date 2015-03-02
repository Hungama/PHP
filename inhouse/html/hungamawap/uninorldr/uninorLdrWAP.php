<?php
include("db.php");
error_reporting(1);
$msisdn=$_REQUEST['msisdn'];
$planid=$_REQUEST['planid'];
$amnt=intval($_REQUEST['amnt']);
$response=$_REQUEST['response'];
$trxid=$_REQUEST['trxid'];
$contentid=$_REQUEST['contentid'];
$deviceUA=$_REQUEST['UA'];

$AFFID=$_REQUEST['AFFID'];

if($AFFID=='null' || $AFFID=='')
$AFFID = 0; 

$serviceId=1411;
//266
$mode='WAP';
$logPath = "/var/www/html/hungamawap/uninorldr/logs/sub/logNew_".date("Y-m-d").".txt";
if($msisdn) { 
switch($serviceId)
	{
	case '1411':
			$db = "uninor_ldr";
			$sub = "tbl_ldr_subscription"; 
			$srt_code = 55001;
			break;
   }
	$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
	$circle1=mysql_query($getCircle);
	while($row = mysql_fetch_array($circle1)) {
		$circle = $row['circle'];
	}
	if(!$circle) { $circle='UND'; }


	
	
			$getQuery1="SELECT COUNT(1) FROM $db".'.'."$sub WHERE status in(1,11,9) and ANI=".$msisdn;
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
$querySUB = "insert into ". $db.".".$sub."(ANI,SUB_DATE,RENEW_DATE,DEF_LANG,STATUS,MODE_OF_SUB,DNIS,USER_BAL,SUB_TYPE,plan_id,circle,total_no_downloads,affid,contentid,deviceUA) values('".$msisdn."',now(), now(),'01',0, 'WAP',$srt_code, 0,null,'".$planid."','".$circle."',0,'".$AFFID."','".$contentid."','".$deviceUA."');";
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