<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbcon/dbConnect212.php");
 $circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra',
        'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai',
        'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir',
        'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', '' => 'Other');
if(isset($_REQUEST['date'])) { 
	$date= $_REQUEST['date'];
	
	} else {
	$date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}
$logFile="/var/www/html/hungamacare/summercontest/uninor54646/logs/rechargeLog_".date("Y-m-d").".txt";
$query = "select id,ANI,circle from uninor_hungama.tbl_GUJ_recharge nolock where date(date_time)='".$date."' and recharge_flag=0";
$result = mysql_query($query, $dbConn212);
$result_row = mysql_num_rows($result);
if ($result_row > 0) {

while ($smsRecord = mysql_fetch_array($result)) 
{
$fileResponse = '';
$msisdn=$smsRecord['ANI'];
$id=$smsRecord['id'];
$circle_org=$smsRecord['circle'];
					$campgId='500087';
					$authCode='648781';
					$campgcircle = $circle_info[$circle_org];
	$enc_circle = urlencode($campgcircle);
	$url = "http://192.168.100.218/MIS/API/API.Recharge.php?CampaignID=$campgId&AuthCode=$authCode&Circle=" . $enc_circle . "&MSISDN=" . $msisdn;
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $fileResponse = curl_exec($ch);
	curl_close($ch);
//$fileResponse = 'Success';
$apiResponse=explode("@@",$fileResponse);
$apiResponseStatus=$apiResponse[0];
$apiResponseTrxId=$apiResponse[1];

$logData=$msisdn."#".$url."#".$fileResponse."#".date("Y-m-d H:i:s")."\n";			  
if ($apiResponseStatus == 'Success') {
$Update_status = "update uninor_hungama.tbl_GUJ_recharge set recharge_flag=1,campaign_id='".$campgId."',trxid='".$apiResponseTrxId."' where id='".$id."'";
mysql_query($Update_status,$dbConn212);
}
else
{
$Update_status = "update uninor_hungama.tbl_GUJ_recharge set recharge_flag=10,campaign_id='".$campgId."',trxid='".$apiResponseTrxId."' where id='".$id."'";
mysql_query($Update_status,$dbConn212);
}
	error_log($logData,3,$logFile);
	
}

echo "Done";
}
else
{
echo "Recharge not applicable";
}
mysql_close($dbConn212);
?>
