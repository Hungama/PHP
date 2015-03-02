<?php
error_reporting(0);
require_once("/var/www/html/hungamacare/sendVcart/dbConfig.php");
$processlog = "/var/www/html/hungamacare/sendVcart/logs/log_" . date('Ymd') . ".txt";
//$anilist="and ani in('8376903442')";
$qry = "select id from Inhouse_IVR.tbl_VCard_details nolock where status=0 limit 500";
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
$batchPicked="update Inhouse_IVR.tbl_VCard_details set status=1 where id=".$id;
mysql_query($batchPicked,$dbConn);
}
$totalcount=count($idList);
$allIds = implode(",", $idList);

$qry2 = "select id,ani,circle from Inhouse_IVR.tbl_VCard_details nolock where id in($allIds)";
$checkMDN2 = mysql_query($qry2, $dbConn);

    while ($rows = mysql_fetch_array($checkMDN2)) {
		$ani = '91'.$rows['ani'];
        $id = $rows['id'];
		$circle = $rows['circle'];
		// make curl call
		$callUrl="http://223.130.4.100/whatsappgateway/api.php?username=salil&password=salil123&vcard=48";
		$callUrl.="&number=$ani";
		$result=curl_init($callUrl);
		curl_setopt($result,CURLOPT_RETURNTRANSFER,TRUE);
		$response= curl_exec($result);
		curl_close($result);

		mysql_query("update Inhouse_IVR.tbl_VCard_details set status=2,RESPONSE='".$response."' where id=$id", $dbConn);
		$logstring = $id."#".$ani . "#" . $circle . "#" . $callUrl."#".$response . "#". date('Y-m-d H:i:s') . "\r\n";
		error_log($logstring, 3, $processlog);				
   }
		
}
echo "Done";
mysql_close($dbConn);
exit;
?>