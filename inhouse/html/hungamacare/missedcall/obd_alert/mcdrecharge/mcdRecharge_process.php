<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbcon/dbConnect212.php");

 $circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra',
        'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai',
        'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir',
        'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', '' => 'Other');
$logFile="/var/www/html/hungamacare/missedcall/obd_alert/mcdrecharge/logs/rechargelog_".date('Ymd').".txt";
$reponseLog1="/var/www/html/hungamacare/missedcall/obd_alert/mcdrecharge/logs/processlog_".date('Ymd').".txt";
 
//$getMsisdnId="select id from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(EntryDate)=date(now()) and status=0 order by id DESC limit 50";
$getMsisdnId="select id from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(EntryDate)>='2015-01-20' and status=0 order by id DESC limit 50";
$result_id=mysql_query($getMsisdnId,$dbConn212);
$ReachargeList=array();
while(list($id1)=mysql_fetch_array($result_id))
{
$ReachargeList[]=$id1;
$aniPicked="update Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE set status=1 where id=".$id1;
if(mysql_query($aniPicked,$dbConn212))
	{
	$BlockStatus=$aniPicked."|SUCCESS"."\r\n";
	}
	else
	{
	$error= mysql_error();
	$BlockStatus=$aniPicked."|".$error."|Failed"."\r\n";
	}
error_log($BlockStatus,3,$reponseLog1);	
}
$totalcount=count($ReachargeList);

if($totalcount>=1)
{
$allIds = implode(",", $ReachargeList);

$query = "select id,ANI,circle,rtrim(operator) as operator from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE  where id in($allIds)";
$result = mysql_query($query, $dbConn212);
$result_row = mysql_num_rows($result);

if ($result_row > 0) {
while ($smsRecord = mysql_fetch_array($result)) 
{
	$circle_org=$smsRecord['circle'];
    $operator=strtolower($smsRecord['operator']);
	$fileResponse = '';
	$msisdn=$smsRecord['ANI'];
	$id=$smsRecord['id'];
	$campgId='';
	$authCode='';
	$circle='';
	echo $operator;
	switch($operator)
	{
	case 'airtel':
	case 'airm':
			$campgId='500070';
			$authCode='536722';
			$circle = "Bihar";
			break;
	case 'aircel':
	case 'airc':
			$campgId='500071';
			$authCode='572889';
			$circle = "Bihar";
			break;
	case 'mts':
	case 'mtsm':
			$campgId='500072';
			$authCode='526782';
			$circle = "Bihar";
			break;
	case 'uninor':
	case 'unim':
			$campgId='500073';
			$authCode='571891';
			$circle = "Gujarat";
			break;
	case 'reliance':
	case 'relc':
			$campgId='500074';
			$authCode='571992';
			$circle = "Bihar";
			break;
	case 'tata':
	case 'tatm':
			$campgId='500075';
			$authCode='671811';
			$circle = "Bihar";
			break;
	case 'tatc':
			$campgId='500083';
			$authCode='637789';
			$circle = "Bihar";
			break;
	case 'idea':
			$campgId='500076';
			$authCode='518622';
			$circle = "Bihar";
			break;
	case 'vodafone':
	case 'vodm':
			$campgId='500077';
			$authCode='561782';
			$circle = "Bihar";
			break;
	case 'bsnl':
			$campgId='500078';
			$authCode='517289';
			$circle = "Bihar";
			break;
	case 'videocon':
			$campgId='500081';
			$authCode='673711';
			$circle = "Haryana";
			break;
	case 'loop':
			$campgId='500082';
			$authCode='537881';
			$circle = "Delhi";
			break;
	case 'mtnl':
			if($circle_org=='DEL')
				{	
					$campgId='500079';
					$authCode='783929';
					$circle = "Delhi";
				}
			else if($circle_org=='MUM')
				{			
					$campgId='500080';
					$authCode='728991';
					$circle = "Mumbai";
				}
		break;		
		
	}
	
	if($campgId=='')
	{ // Invalid campgion ID
	   $Update_status = "update Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE set status=9 where id='".$id."' and ANI='".$msisdn."'";
       $result2 = mysql_query($Update_status,$dbConn212);
	   echo 'Invalid campgID';
	   $logData=$msisdn."#".$operator."#".$url."#Invalid campgID#".date("Y-m-d H:i:s")."\n";			  
	   error_log($logData,3,$logFile);
	   //exit;
	}
	else
	{
	$enc_circle = urlencode($circle);
	$url = "http://192.168.100.218/MIS/API/API.Recharge.php?CampaignID=$campgId&AuthCode=$authCode&Circle=" . $enc_circle . "&MSISDN=" . $msisdn;
    
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $fileResponse = curl_exec($ch);
		curl_close($ch);
		$apiResponse=explode("@@",$fileResponse);
		$apiResponseStatus=$apiResponse[0];
		$apiResponseTrxId=$apiResponse[1];
		//$fileResponse ='Success';
	 $logData=$msisdn."#".$operator."#".$url."#".$fileResponse."#".date("Y-m-d H:i:s")."\n";			  
	  if ($apiResponseStatus == 'Success') {
       $Update_status = "update Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE set status=11,campgId='".$campgId."',trxid='".$apiResponseTrxId."' where id='".$id."' and ANI='".$msisdn."'";
       $result2 = mysql_query($Update_status,$dbConn212);
		  }
		  else
		  {
		  $Update_status = "update Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE set status=10,campgId='".$campgId."',trxid='".$apiResponseTrxId."',Response='".$apiResponseStatus."' where id='".$id."' and ANI='".$msisdn."'";
       $result2 = mysql_query($Update_status,$dbConn212);
		  }
	error_log($logData,3,$logFile);
	}
}

echo "Done";
}
else
{
echo "Recharge not applicable";
}
}
else
{
echo "No Records Found";
}
mysql_close($dbConn212);
?>