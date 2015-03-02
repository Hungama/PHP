<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

 $circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra',
        'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai',
        'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir',
        'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', '' => 'Other');
if(isset($_REQUEST['date'])) { 
	$date= $_REQUEST['date'];
	
	} else {
	$date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}
$logFile="/var/www/html/hungamacare/summercontest/uninor/logs/rechargeContest_".date("Y-m-d").".txt";
$query = "select id,ANI,level,circle from uninor_summer_contest.tbl_contest_misdaily_recharged
			where date(date_time)='".$date."' and status=0";
$result = mysql_query($query, $dbConn);
$result_row = mysql_num_rows($result);

if ($result_row > 0) {

while ($smsRecord = mysql_fetch_array($result)) 
{
	$fileResponse = '';
	$msisdn=$smsRecord['ANI'];
	$level=$smsRecord['level'];
	$id=$smsRecord['id'];
	
	$circle_org=$smsRecord['circle'];
		
	switch ($level) {
        case '4':
		case '5':
		case '6':
		    switch ($circle_org) {
			case 'GUJ':
					$campgId='500058';
					$authCode='7191432';
					$campgcircle = "Gujarat";
			break;
			case 'UPE':
					$campgId='500055';
					$authCode='1242999';
					$campgcircle = "UP EAST";
			break;
			case 'BIH':
					$campgId='500057';
					$authCode='4730723';
					$campgcircle = "Bihar";
			break;
			case 'MAH':
					$campgId='500054';
					$authCode='8933592';
					$campgcircle = "Maharashtra";
			break;
			case 'APD':
					$campgId='500059';
					$authCode='7649981';
					$campgcircle = "Andhra Pradesh";
			break;
			case 'UPW':
					$campgId='500056';
					$authCode='2072407';
					$campgcircle = "UP WEST";
			break;
				 }
				 break;
		case '1':
		case '2':
		case '3':
					$campgId='500043';
					$authCode='9091001';
					$campgcircle = "Bihar";
					break;
		}

		
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
		
	$logData=$msisdn."#".$level."#".$url."#".$fileResponse."#".date("Y-m-d H:i:s")."\n";			  
	  if ($apiResponseStatus == 'Success') {
       $Update_status = "update uninor_summer_contest.tbl_contest_misdaily_recharged set status=1,CampaignID='".$campgId."' where id='".$id."' and ANI='".$msisdn."'";
       mysql_query($Update_status,$dbConn);
		  }
		  else
		  {
		  $Update_status = "update uninor_summer_contest.tbl_contest_misdaily_recharged set status=10,CampaignID='".$campgId."' where id='".$id."' and ANI='".$msisdn."'";
       mysql_query($Update_status,$dbConn);
		  }
	error_log($logData,3,$logFile);
	
}

echo "Done";
}
else
{
echo "Recharge not applicable";
}
?> 