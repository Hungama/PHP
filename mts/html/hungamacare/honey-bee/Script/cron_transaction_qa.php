<?php
require_once("../incs/db.php");
date_default_timezone_set('Asia/Kolkata');
$processlog = "/var/www/html/hungamacare/honey-bee/Script/logs/tranxhanguplog_" . date('Ymd') . ".txt";
//Get Msisdn for process-( SMS Window ?)
$qry = "select id from honeybee_sms_engagement.tbl_ct_message_interface_backup nolock where sms_status=1
and date(call_date)=date(now()) limit 1";
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
}

$totalcount=count($idList);
$allIds = implode(",", $idList);

$qry2 = "select ani,call_date,s_id,user_status,sms_status,song_id,circle,lang,drop_of_point,id ,dnis
from honeybee_sms_engagement.tbl_ct_message_interface_backup nolock where id in($allIds)";
$checkMDN2 = mysql_query($qry2, $dbConn);

    while ($rows = mysql_fetch_array($checkMDN2)) {
		$ani = $rows['ani'];
        $s_id = $rows['s_id'];
		$circle = $rows['circle'];
		$call_date = $rows['call_date'];
		$user_status = $rows['user_status'];
		$song_id = $rows['song_id'];
		$lang = $rows['lang'];
		$dac_code = $rows['dnis'];
		$drop_of_point = $rows['drop_of_point'];
		$trxid = $rows['id'];
		$currentdate = date('H:i');
		echo $currentdate."#".$call_date."<br>";
		$diffcall_date=strtotime($currentdate) - strtotime(date('H:i',strtotime($call_date)));
		$dif=$diffcall_date/60;
		$time_slot=date('H:i', mktime(0,$dif));
		echo  $time_slot;
		//echo preg_replace('/[0-9]+/', '',$drop_of_point);
		
//Check rule for this service & circle combo
$getRuleId = mysql_query("SELECT id,dnd_scrubbing FROM honeybee_sms_engagement.tbl_rule_engagement nolock 
where service_id='".$s_id."' and action_base='trigger_time' and status=1 and circle like '%".$circle."%' limit 1", $dbConn);
$noofrows = mysql_num_rows($getRuleId);
if($noofrows==0)
{
//Get Default rule PAN Inida
//$getRuleId = mysql_query("SELECT id,dnd_scrubbing FROM honeybee_sms_engagement.tbl_rule_engagement nolock where service_id='".$s_id."' and action_base='trigger_time' and status=1 and circle='PAN' limit 1", $dbConn);

exit;
}
//Get Rule id & dnd status
$rule_array = mysql_fetch_array($getRuleId); 
$ruleid=$rule_array[0];
//Get SMS CLI     
$cliQuery = "select sms_cli from honeybee_sms_engagement.tbl_rule_engagement_action nolock 
where rule_id='" . $ruleid . "' and time_slot='" . $time_slot . "'";
$cli_result = mysql_query($cliQuery, $dbConn);
$nofcli=mysql_num_rows($cli_result);

if($nofcli!=0)
{
$getCLI = mysql_fetch_array($cli_result);
$smsCli=$getCLI[0];
##########################transaction message formate process code start#################################
//call to procedure
$sms_procedurce="mts_mu.SONGID_CHECK";
$MsgQuery = mysql_query("CALL $sms_procedurce ('".$song_id."',@a)",$dbConn);
$msg_data = mysql_query("SELECT @a", $dbConn);
while ($row = mysql_fetch_row($msg_data)) {
$responsedata = explode("#", $row[0]);
$song_name=$responsedata[0];
$album_name=$responsedata[1];
$crbt_id=$responsedata[2]; } 

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
##############################transaction message formate process code end########################

         if ($msg != '') {
		//	$ani='7838551197';//8459059193
		 //call procedure & move it to log table		 
		 	$sms_procedurce="honeybee_sms_engagement.SENDSMS_HONYBEE_ENGMNT_DND";
			$sndMsgQuery = "CALL $sms_procedurce ('".$ani."','".$msg."','".$smsCli."','sms-promo',1,'trigger_time',$s_id,$trxid,'".$ruleid."')";
			$resp='';
			if(mysql_query($sndMsgQuery, $dbConn))
				$resp='SUCCESS';
			else
				$resp=mysql_error();
			}
			else
			{
			$resp="NOMESSAGE FOUND";
			echo "No Message found for this Service.Please check"; //Send email to admin user with service/circle details
			}
	    
	$logstring = $s_id."#".$ruleid . "#" . $smsCli . "#" . $ani."#".$msg . "#" . $sndMsgQuery . "#" .$resp."#". date('Y-m-d H:i:s') . "\r\n";
    error_log($logstring, 3, $processlog);	
}
else
{
echo 'mail to the owner';
}		
	}
echo "Done";
}	
mysql_close($dbConn);
exit;
?>