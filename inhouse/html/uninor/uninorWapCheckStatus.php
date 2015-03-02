<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
error_reporting(0);
$msisdn=trim($_REQUEST['msisdn']);
$contentid=trim($_REQUEST['contentid']);
$circle=trim($_REQUEST['circle']);
$zoneid=trim($_REQUEST['zoneid']);
$curdate = date("Y-m-d");

$status=0;
$mode='WAP';
$tblSubTable = "uninor_manchala.tbl_wap_contentdownload";
$logPath = "/var/www/html/Uninor/logs/wapcontentdwload/log_".date("Y-m-d").".txt";
$sql_query = "select id from ".$tblSubTable." where msisdn=".$msisdn." and contentId=".$contentid." and zoneId=".$zoneid;
$result = mysql_query($sql_query);
$noofcount= mysql_num_rows($result);
if($noofcount<2)
{
$sql_query="INSERT INTO ".$tblSubTable."(msisdn,circle,zoneId,contentId,status,date)
VALUES ('".$msisdn."','".$circle."','".$zoneid."','".$contentid."','".$status."',NOW())";
if (mysql_query($sql_query))
  {
  $response='Active';
  }
  else
  {
  $response='SERVER_ERROR';
   }
echo trim($response);
  $logData = $msisdn."#".$mode."#".$contentid."#".$circle."#".$zoneid."#".$response."#".$status."#".date('Y-m-d H:i:s')."\n";
error_log($logData,3,$logPath);
}
else
{
$response='InActive';
echo trim($response);
 $logData = $msisdn."#".$mode."#".$contentid."#".$circle."#".$zoneid."#".$response."#".$status."#".date('Y-m-d H:i:s')."\n";
error_log($logData,3,$logPath);
}
?>   