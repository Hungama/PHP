<?php
//exit;
$timeFrom = mktime(8, 30, 0);
$timeTo = mktime(19, 45, 0);
$currTime = mktime(date('H'), date('i'), date('s'));
//echo "CurrentTime is - ".$currTime." SMS Allowed From ".$timeFrom." To".$timeTo."<br>";
if ($currTime >= $timeFrom && $currTime <= $timeTo) {
    echo "SMS Window Open" . "<br>";
} else {
    echo "SMS Not Allowed after 7:45 PM to 8:30 AM" . "<br>";
    exit;
}
require_once("../incs/db.php");
//date_default_timezone_set('Asia/Kolkata');
$processlog = "/var/www/html/hungamacare/honey-bee/Script/logs/tranxhanguplog_" . date('Ymd') . ".txt";
//Get Msisdn for process-( SMS Window ?)
$qry = "SELECT a.id,a.dnd_scrubbing,b.sms_cli,b.time_slot 
FROM honeybee_sms_engagement.tbl_rule_engagement as a,honeybee_sms_engagement.tbl_rule_engagement_action as b
where a.service_id='1101' and a.action_base='trigger_time' and a.id=b.rule_id ORDER BY RAND() limit 1";
$checkRule= mysql_query($qry, $dbConn);
$noofrows = mysql_num_rows($checkRule);
if ($noofrows == 0) {
    $logData = 'No Rule For Process' . "\n\r";
    echo $logData;
    mysql_close($dbConn);
    exit;
} else {
//update status to 1 to make it in process state
while(list($ruleid,$isdnd,$smscli,$timeslot)=mysql_fetch_array($checkRule)) {
//echo $ruleid."#".$isdnd."#".$smscli."#".$timeslot."<br>";
$mindata=explode(":",$timeslot);
$hourtomin=$mindata[0];
$min=$mindata[1]+($mindata[0]*60);

//Get Msisdn for process-( SMS Window ?)
$qryTogetMDN = "select trxid from honeybee_sms_engagement.tbl_ct_message_interface_backup nolock 
where sms_status=1 and ceil(TIME_TO_SEC(TIMEDIFF(NOW(),call_date))/60)=$min limit 50";
$checkMDN_Block = mysql_query($qryTogetMDN, $dbConn);
$noofrows_Block = mysql_num_rows($checkMDN_Block);
if ($noofrows_Block == 0) {
    $logData = 'No MSISDN For Process' . "\n\r";
    echo $logData;
    mysql_close($dbConn);
    exit;
} else {
//update status to 1 to make it in process state
while(list($id_Block)=mysql_fetch_array($checkMDN_Block)) {
$idList[]=$id_Block;
$batchPicked="update honeybee_sms_engagement.tbl_ct_message_interface_backup set sms_status=2 where trxid=".$id_Block;
mysql_query($batchPicked,$dbConn);
}

$totalcount=count($idList);
$allIds = implode(",", $idList);


$qry2 = "select id,ani,call_date,s_id,user_status,sms_status,song_id,circle,lang,drop_of_point,id ,dnis,trxid
from honeybee_sms_engagement.tbl_ct_message_interface_backup nolock where trxid in($allIds)";
$checkMDN2 = mysql_query($qry2, $dbConn);
    while ($rows = mysql_fetch_array($checkMDN2)) {
		$ani = $rows['ani'];
        $s_id = $rows['s_id'];
		$circle = $rows['circle'];
		$call_date = $rows['call_date'];
		$song_id = $rows['song_id'];
		$dac_code = $rows['dnis'];
		$drop_of_point = $rows['drop_of_point'];
		$trxid = $rows['trxid'];
		##########################transaction message formate process code start#################################
		//call to procedure to get SMS Data
		$sms_procedurce="mts_mu.SONGID_CHECK";
		$MsgQuery = mysql_query("CALL $sms_procedurce ('".$song_id."',@a)",$dbConn);
		$msg_data = mysql_query("SELECT @a", $dbConn);
		while ($row = mysql_fetch_row($msg_data)) {
		$responsedata = explode("#", $row[0]);
		$song_name=$responsedata[0];
		$album_name=$responsedata[1];
		$crbt_id=$responsedata[2];
		} 

		if($drop_of_point=='MU_DAC_SONG' || $drop_of_point=='DAC_SONG_PLAY' && $song_name!='')
		{
			$s_name=$song_name; //MU_DAC_SONG or DAC LINK
			$a_name=$album_name;
			$dac_link=$dac_code;	
			//DAC
			$song_like="SONG NAME|DAC LINK";
			$SMSquery = "select message from honeybee_sms_engagement.tbl_new_sms_engagement nolock 
			where rule_id='" . $ruleid . "' and message_type like '%" . $drop_of_point . "%' ORDER BY RAND() limit 1";
			$smsresult = mysql_query($SMSquery, $dbConn);
			$smsData = mysql_fetch_array($smsresult);
			$msg = $smsData[0];
			$msg = str_replace(array('%SONG NAME%','%DAC CODE%'), array($s_name,$dac_link), $msg);
		}
		elseif($drop_of_point=='CRBT_SECTION' && $song_name!='')  //CRBT_SECTION
		{
			$s_name=$song_name;
			$a_name=$album_name;
			$crbt_link=$crbt_id;	
			//CRBT
			//$song_like="SONG NAME|RBT LINK";
			$SMSquery = "select message from honeybee_sms_engagement.tbl_new_sms_engagement nolock 
			where rule_id='" . $ruleid . "' and message_type like '%" . $drop_of_point . "%' ORDER BY RAND() limit 1";
			$smsresult = mysql_query($SMSquery, $dbConn);
			$smsData = mysql_fetch_array($smsresult);
			$msg = $smsData[0];
			$msg = str_replace(array('%SONG NAME%','%RBT LINK%'), array($s_name,$crbt_link), $msg);
		}
		//preg_replace('/[0-9]+/', '',
		elseif(preg_replace('/_.*/','',$drop_of_point)=='SONGPLAY' && $song_name!='')
		{
			$s_name=$song_name;
			$a_name=$album_name;
			$song_like="SONGPLAY";
			$SMSquery = "select message from honeybee_sms_engagement.tbl_new_sms_engagement nolock 
			where rule_id='" . $ruleid . "' and message_type like '%" . $song_like . "%' ORDER BY RAND() limit 1";
			$smsresult = mysql_query($SMSquery, $dbConn);
			$smsData = mysql_fetch_array($smsresult);
			$msg = $smsData[0];
			$msg = str_replace(array('%SONG NAME%','%ALBUM NAME%'), array($s_name,$a_name), $msg);
		}
		else
		{
			$SMSquery = "select message from honeybee_sms_engagement.tbl_new_sms_engagement nolock 
			where rule_id='" . $ruleid . "' and message_type='NORM' ORDER BY RAND() limit 1";
			$smsresult = mysql_query($SMSquery, $dbConn);
			$smsData = mysql_fetch_array($smsresult);
			$msg = $smsData[0];
		}
//echo $ani."#".$drop_of_point."#".$msg;
//echo "<br>";

         if ($msg != '') {
			//$ani='7838551197';
		  	$sms_procedurce="honeybee_sms_engagement.SENDSMS_HONYBEE_ENGMNT_DND";
			$sndMsgQuery = "CALL $sms_procedurce ('".$ani."','".$msg."','".$smscli."','sms-promo',1,'trigger_time','".$s_id."','".$trxid."','".$ruleid."')";
			$resp='';
			//echo $sndMsgQuery."<br>";
			if(mysql_query($sndMsgQuery, $dbConn))
				$resp='SUCCESS';
			else
				$resp=mysql_error();
			}
			else
			{
			$resp='NOK';
			$batchPicked="update honeybee_sms_engagement.tbl_ct_message_interface_backup set sms_status=5 where id=".$trxid;
			mysql_query($batchPicked,$dbConn);
			}
			
	$logstring = $s_id."#".$ruleid . "#" . $smscli . "#" . $ani."#".$msg . "#" . $sndMsgQuery . "#" .$resp."#". date('Y-m-d H:i:s') . "\r\n";
    error_log($logstring, 3, $processlog);	
	##############################transaction message formate process code end########################

}

}
}
}
echo "done";
mysql_close($dbConn);
exit;
?>