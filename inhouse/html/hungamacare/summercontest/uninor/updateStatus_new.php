<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$reportDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh',
'UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');

$authcode_info=array('500058'=>'7191432','500055'=>'1242999','500057'=>'4730723','500054'=>'8933592','500059'=>'7649981','500056'=>'2072407','500043'=>'9091001');
$campCirlce_info=array('500058'=>'Gujarat','500055'=>'UP EAST','500057'=>'Bihar','500054'=>'Maharashtra','500059'=>'Andhra Pradesh','500056'=>'UP WEST','500043'=>'Bihar');

////////////////////////////////////////top 20 of each circle end here /////////////////////////
$logFile="logs/rechargeContest_".$date.".txt";
$get_allwinner = "select ANI,total_question_play,score,circle,level,date_time,SOU,lastChargeAmount,pulses,recharge_retry,CampaignID
from uninor_summer_contest.tbl_contest_misdaily_recharged nolock where date_time='" . $reportDate . "' and status=1 and score>=1";
$data = mysql_query($get_allwinner, $dbConn) or die(mysql_error());
$numrows = mysql_num_rows($data);
$isrtry=0;
if ($numrows==0) 
{ 
echo "NO Data to process";
}
else
{
while ($result_data = mysql_fetch_array($data))
{
	$ani=$result_data['ANI'];
	$campgId=$result_data['CampaignID'];
	$level=$result_data['level'];
	$recharge_retry=$result_data['recharge_retry'];
	$getStatus=mysql_query("select transactionId,response from master_db.tbl_recharged nolock where date(request_time)='".$rechargeDate."' and msisdn='".$ani."' and status=1 order by id desc limit 1",$dbConn);
	$rechageStatus = mysql_fetch_array($getStatus);
	$TID=$rechageStatus['transactionId'];
	$response=explode('#',$rechageStatus['response']);
	
	if($response[0]=='FAILURE' && $recharge_retry==1)
	{
	//retry
	$isrtry=1;
	$Update_status = "update uninor_summer_contest.tbl_contest_misdaily_recharged set Recharge_TID='$TID',Recharge_Status='".$response[0]."',recharge_retry=2 where date_time='".$reportDate."' and ANI='".$ani."'";
	$result2 = mysql_query($Update_status,$dbConn);	
	
	$circle = $campCirlce_info[$CampaignID];	
	$authCode = $authcode_info[$CampaignID];
    $enc_circle = urlencode($circle);
	$msisdn=$ani;
	$url = "http://192.168.100.218/MIS/API/API.Recharge.php?CampaignID=$campgId&AuthCode=$authCode&Circle=" . $enc_circle . "&MSISDN=" . $msisdn;
	$ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $fileResponse = curl_exec($ch);
	curl_close($ch);
	$logData=$msisdn."#".$level."#".$campgId."#".$url."#".$fileResponse."#".date("Y-m-d H:i:s")."\n";	
		error_log($logData,3,$logFile);
	}
	else
	{
	$Update_status = "update uninor_summer_contest.tbl_contest_misdaily_recharged set Recharge_TID='$TID',Recharge_Status='".$response[0]."' where date_time='".$reportDate."' and ANI='".$ani."'";
	$result2 = mysql_query($Update_status,$dbConn);
	}
	
}
}
if($isrtry)
{
echo "We are retrying some transaction...";
}
mysql_close($dbConn);
?>
