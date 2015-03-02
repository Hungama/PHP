<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
error_reporting(1);
$msisdn=$_REQUEST['msisdn'];
$planid=$_REQUEST['planid'];
//$amnt=intval($_REQUEST['amnt']);
//$response=$_REQUEST['response'];
$trxid=$_REQUEST['trxid'];
$contentid=$_REQUEST['contentid'];
$deviceUA=$_REQUEST['UA'];

$AFFID=$_REQUEST['AFFID'];

if($AFFID=='null' || $AFFID=='')
$AFFID = 0; 


$serviceId=1527;
$mode='WAP';
$logPath = "/var/www/html/airtel/log/airtelWAP/logNew224_".date("Y-m-d").".txt";

$logData1=$msisdn."#".$planid."#".$amnt."#".$AFFID."#".date("Y-m-d H:i:s")."\n";
error_log($logData1,3,$logPath);
	
if($msisdn) { 
switch($serviceId)
	{
	case '1527':
			$db = "airtel_rasoi";
			if($planid=='96' || $planid=='95' || $planid=='93' || $planid=='94')
			 $sub = "tbl_rasoi_subscriptionWAP";
			 else
			$sub = "tbl_rasoi_subscription"; 
			
			$srt_code = 55001;
			$cli = 'HMLIFE';
			$m_code = '55001';
		break;
   }
	$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
	$circle1=mysql_query($getCircle,$dbConn212);
	while($row = mysql_fetch_array($circle1)) {
		$circle = $row['circle'];
	}
	if(!$circle) { $circle='UND'; }

			$getQuery1="SELECT COUNT(1) FROM $db".'.'."$sub nolock WHERE ANI=".$msisdn." and status!=0";
			$countData = mysql_query($getQuery1,$dbConn212);
			list($allSub) = mysql_fetch_array($countData);
			if($allSub)
			{
				$res="AlreadySubscribed";
				//echo $res;
				$logData=$AFFID."#msisdn#".$msisdn."#planid#".$planid."#response#".$res."#mode#".$mode."#circle#".$circle."#serviceId#".$serviceId."#amount#".$amount."#Already Subscribed#" .date("Y-m-d H:i:s")."\n";
				error_log($logData,3,$logPath);
			} else 
			{
                if($planid=='96' || $planid=='95' || $planid=='93' || $planid=='94')
				 {	
$querySUB = "insert into ". $db.".".$sub."(ANI,SUB_DATE,RENEW_DATE,DEF_LANG,STATUS,MODE_OF_SUB,DNIS,USER_BAL,SUB_TYPE,plan_id,circle,total_no_downloads,affid,contentid,deviceUA) values('".$msisdn."',now(), now(),'01',0, 'WAP',$srt_code, 0,null,'".$planid."','".$circle."',0,'".$AFFID."','".$contentid."','".$deviceUA."');";
	if(mysql_query($querySUB,$dbConn212))
	{
	$res='SUCCESS';
	$error='OK';
	}
	else
	{
	$res='FAILURE';
	$error=mysql_error();
	$errorNo=mysql_errno();
		if($errorNo==1062)
		{
			$querySUBUpdate = "update ". $db.".".$sub." set SUB_DATE=now(),RENEW_DATE=now(),affid='".$AFFID."',contentid='".$contentid."',deviceUA='".$deviceUA."'
			where ANI='".$msisdn."'";
			mysql_query($querySUBUpdate,$dbConn212);
		}
	}
	//echo $res;
	$logData=$AFFID."#msisdn#".$msisdn."#planid#".$planid."#response#".$res."#Error".$error."#".$errorNo."#mode#".$mode."#circle#".$circle."#serviceId#".$serviceId."#amount#".$amount."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);
				}
		} 
} else {
	$res='MDNNOTFOUND';
	$logData="MDN NOT FOUND#planid:".$planid."#response:".$res."#Invalid Parameter#" .date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);
}
mysql_close($dbConn212); 
?>