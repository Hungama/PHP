<?php
require_once("../incs/db.php");
$processlog = "/var/www/html/hungamacare/honey-bee/Script/logs/hanguplog_" . date('Ymd') . ".txt";
//Get Msisdn for process-
$qry = "select id from honeybee_sms_engagement.tbl_ct_message_interface nolock where sms_status=0 limit 50";
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
$batchPicked="update honeybee_sms_engagement.tbl_ct_message_interface set sms_status=1 where id=".$id;
mysql_query($batchPicked,$dbConn);
}
$totalcount=count($idList);
$allIds = implode(",", $idList);

$qry2 = "select ani,call_date,s_id,user_status,sms_status,song_id,circle,lang,drop_of_point,id from honeybee_sms_engagement.tbl_ct_message_interface nolock where id in($allIds)";
$checkMDN2 = mysql_query($qry2, $dbConn);

    while ($rows = mysql_fetch_array($checkMDN2)) {
		$ani = $rows['ani'];
        $s_id = $rows['s_id'];
		$circle = $rows['circle'];
		$call_date = $rows['call_date'];
		$user_status = $rows['user_status'];
		$song_id = $rows['song_id'];
		$lang = $rows['lang'];
		$drop_of_point = $rows['drop_of_point'];
		$trxid = $rows['id'];
		
//Check rule for this service & circle combo
	//$ani='8459506442';//testing number
    mysql_query("CALL honeybee_sms_engagement.HB_ENGMNT_SMS('".$ani."' ,'call_hang_up','" . $s_id . "',@msgdata)", $dbConn);
    $msg_data = mysql_query("SELECT @msgdata", $dbConn);
     while ($row = mysql_fetch_row($msg_data)) {
	 $responsedata = explode("#", $row[0]);
	 $smsCli=$responsedata[0];
	 $msg=$responsedata[1];
	 $dndstatus=$responsedata[2];
	 $ruleid=$responsedata[3];
  }

$resp='';
if(!empty($msg))
{  
			$sndMsgQuery = "CALL honeybee_sms_engagement.SENDSMS_HONYBEE_ENGMNT_DND('".$ani."','".$msg."','".$smsCli."',0,0,'call_hang_up','".$s_id."','".$trxid."','".$ruleid."')";
		
			if(mysql_query($sndMsgQuery, $dbConn))
				$resp='SUCCESS';
			else
				$resp=mysql_error();
}
else
{
$resp='NO MESSAGE FOUND FOR THIS SERVICE';
}				
		$logstring = $s_id."#".$ruleid . "#" . $smsCli . "#" . $ani."#".$msg . "#" . $sndMsgQuery . "#" .$resp."#". date('Y-m-d H:i:s') . "\r\n";
        error_log($logstring, 3, $processlog);				
	}
echo "Done";
}	
mysql_close($dbConn);
exit;
?>