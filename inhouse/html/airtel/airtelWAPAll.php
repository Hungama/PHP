<?php
include("/var/www/html/airtel/dbInhousewithAirtel.php");
error_reporting(1);
$msisdn=$_REQUEST['msisdn'];
$planid=$_REQUEST['planid'];
$amnt=intval($_REQUEST['amnt']);
$response=$_REQUEST['response'];
$trxid=$_REQUEST['trxid'];
$contentid=$_REQUEST['contentid'];
$deviceUA=$_REQUEST['UA'];
$AFFID=$_REQUEST['AFFID'];
$zoneid=$_REQUEST['zoneid'];
$serviceId=$_REQUEST['serviceid'];

if($AFFID=='null' || $AFFID=='')
$AFFID = 0; 
//dbConn212
//dbConnAirtel

$mode='WAP';
$logPath = "/var/www/html/airtel/log/airtelWAP/waplog_".date("Y-m-d").".txt";
if($msisdn) { 
switch($serviceId)
	{
	case '1528':
			 $db = "airtel_devo";
			 $sub = "tbl_sarnam_subscriptionWAP";
			 $sub = "tbl_sarnam_unsubWAP";			
			 $srt_code='';
			break;
   }
	$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
	$circle1=mysql_query($getCircle,$dbConnAirtel);
	while($row = mysql_fetch_array($circle1)) {
		$circle = $row['circle'];
	}
	if(!$circle) { $circle='UND'; }

		//Save in local db 224
		$querySUB = "insert into ". $db.".".$sub."(ANI,SUB_DATE,RENEW_DATE,DEF_LANG,STATUS,MODE_OF_SUB,DNIS,USER_BAL,SUB_TYPE,plan_id,circle,total_no_downloads,affid,contentid,deviceUA,zoneid) values('".$msisdn."',now(), now(),'01',0, 'WAP',$srt_code, 0,null,'".$planid."','".$circle."',0,'".$AFFID."','".$contentid."','".$deviceUA."','".$zoneid."');";
				if(mysql_query($querySUB,$dbConn212))
				{
					$res='SUCCESS';
					$error='OK';
				}
				else
				{
					$res='FAILURE';
					$errorNo=mysql_errno();
						if($errorNo==1062)
						{
							$querySUBUpdate = "update ". $db.".".$sub." set SUB_DATE=now(),RENEW_DATE=now(),affid='".$AFFID."',contentid='".$contentid."',deviceUA='".$deviceUA."'
							where ANI='".$msisdn."'";
							mysql_query($querySUBUpdate,$dbConn212);
						}

				}
	//echo $res;
	$logData=$msisdn."#".$planid."#".$res."#Error".$errorNo."#".$mode."#".$circle."#".$serviceId."#".$querySUB."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);
	
	//Save in Airtel DB
	$querySUB_Airtel = "insert into ". $db.".".$sub."(ANI,SUB_DATE,RENEW_DATE,DEF_LANG,STATUS,MODE_OF_SUB,DNIS,USER_BAL,SUB_TYPE,plan_id,circle,total_no_downloads,affid,contentid,deviceUA,zoneid) values('".$msisdn."',now(), now(),'01',0, 'WAP',$srt_code, 0,null,'".$planid."','".$circle."',0,'".$AFFID."','".$contentid."','".$deviceUA."','".$zoneid."');";
				if(mysql_query($querySUB_Airtel,$dbConnAirtel))
				{
					$res2='SUCCESS';
					$error='OK';
				}
				else
				{
					$res2='FAILURE';
					$errorNo=mysql_errno();
							if($errorNo==1062)
							{
								$querySUBUpdate = "update ". $db.".".$sub." set SUB_DATE=now(),RENEW_DATE=now(),affid='".$AFFID."',contentid='".$contentid."',deviceUA='".$deviceUA."'
								where ANI='".$msisdn."'";
								mysql_query($querySUBUpdate,$dbConnAirtel);
							}

				}
	echo $res1."-".$res2;
	$logData_airtel=$msisdn."#".$planid."#".$res2."#Error".$errorNo."#".$mode."#".$circle."#".$serviceId."#".$querySUB_Airtel."#".date("Y-m-d H:i:s")."\n";
	error_log($logData_airtel,3,$logPath);
				
	} else {
	$res='MDNNOTFOUND';
	$logData="MDN NOT FOUND#".$serviceId."#".$res."#Invalid Parameter#" .date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);
}
mysql_close($dbConnAirtel); 
mysql_close($dbConn212); 
?>