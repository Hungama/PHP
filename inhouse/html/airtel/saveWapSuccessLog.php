<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
error_reporting(0);
$msisdn = trim($_REQUEST['msisdn']);
$affId = trim($_REQUEST['affId']);
$refurl = trim($_REQUEST['refurl']);
$handset = trim($_REQUEST['handset']);
$productid = trim($_REQUEST['productid']);
$response = trim($_REQUEST['response']);
$amt = trim($_REQUEST['amt']);
$trxid = trim($_REQUEST['trxid']);

$logPath = "/var/www/html/airtel/log/notification/SuccessNotification_" . date("Y-m-d") . ".txt";

$logData = $msisdn."|".$affId."|".$refurl."|".$handset."|".$productid."|".$response.date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath);

if($response=='Success')
{
$chrgdate=date('Y-m-d H:i:s');
$status=1;
  $insQry = "insert into master_db.tbl_wapLogging_subscription (ANI,ACT_REQS_DATE,Chrg_DATE,STATUS,Ref_URL,Product_ID,Handset1,Affilate_ID,response,amount,transId)
                   values ('".$msisdn."',now(),now(),'".$status."','".$refurl."','".$productid."','".$handset."','".$affId."','".$response."','".$amt."','".$trxid."')";

}
else
{
$chrgdate='';
$status=0;
  $insQry = "insert into master_db.tbl_wapLogging_subscription (ANI,ACT_REQS_DATE,Chrg_DATE,STATUS,Ref_URL,Product_ID,Handset1,Affilate_ID,response,amount,transId)
                   values ('".$msisdn."',now(),'".$chrgdate."','".$status."','".$refurl."','".$productid."','".$handset."','".$affId."','".$response."','".$amt."','".$trxid."')";

}

if (is_numeric($msisdn)) {
   
/*   $insQry = "insert into master_db.tbl_wapLogging_subscription (ANI,ACT_REQS_DATE,Chrg_DATE,STATUS,Ref_URL,Product_ID,Handset1,Affilate_ID,response,amount,transId)
                   values ('".$msisdn."',now(),'".$chrgdate."','".$status."','".$refurl."','".$productid."','".$handset."','".$affId."','".$response."','".$amt."','".$trxid."')";
	*/			   
				   
  mysql_query($insQry);
	} else {
   //$response = "Invalid Parameter";
   }
mysql_close($dbAirtelConn);
?>