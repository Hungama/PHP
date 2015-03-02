<?php
error_reporting(0);
require_once("/var/www/html/vodafone/missedCall_vodaru/dbConfig.php");
$processlog = "/var/www/html/vodafone/missedCall_vodaru/logs/vodalog_" . date('Ymd') . ".txt";
$anilist="and ani in('9820888345','9930069654','9711300416','9999245707','8587800665','8587900178','9999195002','9819818204','8586967042','7838884633','8586967045')";
$qry = "select id from master_db.tbl_RU_SMS nolock where status=0 $anilist";
$checkMDN = mysql_query($qry, $dbConn);
$noofrows = mysql_num_rows($checkMDN);
if ($noofrows == 0) {
    $logData = 'No MSISDN For Process' . "\n\r";
    echo $logData;
    mysql_close($dbConn);
    exit;
} else {
//update status to 1 to make it in process state
while(list($id)=mysql_fetch_array($checkMDN)) {
$idList[]=$id;
$batchPicked="update master_db.tbl_RU_SMS set status=1 where id=".$id;
mysql_query($batchPicked,$dbConn);
}
$totalcount=count($idList);
$allIds = implode(",", $idList);

$qry2 = "select id,ani,circle from master_db.tbl_RU_SMS nolock where id in($allIds)";
$checkMDN2 = mysql_query($qry2, $dbConn);

    while ($rows = mysql_fetch_array($checkMDN2)) {
		$ani = $rows['ani'];
        $id = $rows['id'];
		$circle = $rows['circle'];
		// make curl call
		//check for blacklist start here
		$callUrl="http://103.16.47.38/vodafonemusic_cm/sms_push_xml.php";
		$callUrl.="?msisdn=$ani";
		$result=curl_init($callUrl);
		curl_setopt($result,CURLOPT_RETURNTRANSFER,TRUE);
		$response= curl_exec($result);
		curl_close($result);

		mysql_query("update master_db.tbl_RU_SMS set status=2 where id=$id", $dbConn);
		$logstring = $id."#".$ani . "#" . $circle . "#" . $callUrl."#".$response . "#". date('Y-m-d H:i:s') . "\r\n";
		error_log($logstring, 3, $processlog);				
   }
		
}
echo "Done";
mysql_close($dbConn);
exit;
?>