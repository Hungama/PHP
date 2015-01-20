<?php
session_start();
$old_sessionid = session_id();
include "/var/www/html/hungamawap/config/new_functions.php";
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');
function aes_decrypt($val, $key = '@~ivohbnb#######') {
    $mode = MCRYPT_MODE_ECB;
    $enc = MCRYPT_RIJNDAEL_128;
    //$val    =    str_pad($val, (16*(floor(strlen($val) / 16)+(strlen($val) % 16==0?2:1))), chr(16-(strlen($val) % 16)));    
    $val = base64_decode($val);
    $val = mcrypt_decrypt($enc, $key, $val, $mode, mcrypt_create_iv(mcrypt_get_iv_size($enc, $mode), MCRYPT_DEV_URANDOM));
    $block = mcrypt_get_block_size($enc, $mode);
    $pad = ord($val[($len = strlen($val)) - 1]);

    return substr($val, 0, strlen($val) - $pad);
}

$logdate = date("Ymd");
$logPath = "/var/www/html/hungamawap/airtel/sarnam/CCG/logs/sConsentResponse_" . $logdate . ".log";

$msg = trim($_REQUEST['msg']);
$code = aes_decrypt(trim($_REQUEST['code']));
$MSISDN1 = aes_decrypt(trim($_REQUEST['MSISDN']));
$msisdn = "91" . $MSISDN1;
$productId = trim($_REQUEST['productId']);
$amount = trim($_REQUEST['amount']);
$time = trim($_REQUEST['time']);
$temp1 = trim($_REQUEST['temp1']);
$temp2 = trim($_REQUEST['temp2']);
$content_id = trim($_REQUEST['content_id']);
$PHPSESSID = trim($_REQUEST['PHPSESSID']);
$refererName=$_SERVER['HTTP_REFERER'];

$pidArray=array('1515690'=>'96','1515689'=>'95','1515688'=>'95','1515687'=>'95','1515686'=>'95','1515685'=>'95','1515680'=>'93','1515679'=>'93','1515678'=>'93','1515677'=>'93','1515676'=>'93','1515675'=>'93','1515684'=>'93','1515683'=>'93','1515682'=>'93','1515681'=>'93','1515674'=>'93','1515673'=>'94','1515672'=>'94','1515671'=>'94','1515670'=>'94','1515669'=>'94','1515668'=>'94','1515667'=>'94','1515666'=>'94');
$planid=$pidArray[$productId];
$afiddgm=$_REQUEST['afid_dgm'];
//$Publisher_Ref_Id=$_REQUEST['Publisher_Ref_Id'];
$affid_dgm_data=explode("@@",$afiddgm);
$afid=$affid_dgm_data[0];
$Publisher_Ref_Id=$affid_dgm_data[1];


if($afid==1105)
{
$switchInfoUrl="http://119.82.69.212/kmis/services/hungamacare/2.0/wap/getswitchinfoWap.php";
$switchInfoUrl.="?sname=WAPAirtelLDR&operator=Airtel&msisdn=$msisdn";
$switch_result=curl_init($switchInfoUrl);
curl_setopt($switch_result,CURLOPT_RETURNTRANSFER,TRUE);
$switchId= curl_exec($switch_result);
curl_close($switch_result);
$switchData=explode("#",$switchId);
$switchId=$switchData[0];
$switchType=$switchData[1];
$randSwitch=mt_rand(1,5);
$isDGM=true;
if($switchId==1)
{
#type1- 1,3-Pass 2,4,5-Park
#type2- 1,3,5 -Pass 2,4-Park
#type3-1,3,4,5-Pass 2-Park
#type4 1-Pass  2,3,4,5-Park
#type5-1,2,3,4,5-Park, No Pass

if($switchType=='type1')
{
	if($randSwitch==1 || $randSwitch==3)
	{
	$isDGM=true;
	}
}
else if($switchType=='type2')
{
	if($randSwitch==1 || $randSwitch==3 || $randSwitch==5)
		{
		$isDGM=true;
		}
}
else if($switchType=='type3')
{
	if($randSwitch==1 || $randSwitch==3 || $randSwitch==4 || $randSwitch==5)
		{
		$isDGM=true;
		}
}
else if($switchType=='type4')
{
	if($randSwitch==1)
		{
		$isDGM=true;
		}
}
else if($switchType=='type5')
{
	if($randSwitch==1 || $randSwitch==2 || $randSwitch==3 || $randSwitch==4 || $randSwitch==5)
		{
		$isDGM=false;
		}
}
}
		if($isDGM)
		{
		//hit S2S API
		$DGMResponse='NOK';
			switch($afid)
				{
				case '1105'://DGM
						$dgmUrl="http://tracker.dgmobix.com/track/?t=$Publisher_Ref_Id";
						break;
				case '1114': // ripple
						$dgmUrl="http://rat.ripple.ad/rat/postback/?tid=$Publisher_Ref_Id";
						break;
				case '1040': // tyro
						$dgmUrl="https://tda.tyroo.com/sdk/lead.php?cac=$Publisher_Ref_Id&leadid=&amount=$amount&status=confirmed";
						break;
			  }
				if (trim(strtoupper($msg)) == 'SUCCESS') {
						if($amount>0)
						{
						$DGMResponse = file_get_contents($dgmUrl);
						$DGMResponse = str_replace(array("\n", "\r","\r\n"), '', $DGMResponse);
						$DGMResponse = trim($DGMResponse);				
						}
				}
		}

}

//$msg='SUCCESS';
if (trim(strtoupper($msg)) == 'SUCCESS') {
           $redirectUrl = "http://a.ldr.mobi/site/usersubscription_callback?mobile_no=" . $MSISDN1 . "&content_id=" . $content_id."&error_code=".$code."&afid=".$afid."&sessionid=".$old_sessionid;
		   sleep(1);
		   $call_224 = "http://119.82.69.212/airtel/airtelWAPPostCCG.php?msisdn=" . $MSISDN1 . "&amnt=" . $amount."&serviceid=1515";
		   $callResponse_224 = file_get_contents($call_224);
		   
} else {
    	$redirectUrl = "http://a.ldr.mobi/site/error?mobile_no=".$MSISDN1."&content_id=" . $content_id."&error_code=".$code."&afid=".$afid."&sessionid=".$old_sessionid;
}
			
$log_str_new = date("his") . "|" . $MSISDN1 . "|" . $code . "|" . $msg . "|" . $time . "|" . $temp1 . "|" . $temp2 . "|" . $productId . "|" . $amount ."|" . $content_id ."|".$redirectUrl."|".$afid."|".date('Y-m-d H:i:s')."|"."\r\n";
error_log($log_str_new, 3, $logPath);

$msisdnval_count_val = strlen($MSISDN1);
$chkFoUnknown=strtolower($MSISDN1);
if($chkFoUnknown!='unknown')
{
		
	if ($msisdnval_count_val == 12) {
		$msisdnval2 = substr($MSISDN1, 2);
	} else {
		$msisdnval2 = $MSISDN1;
	}
$msisdnval_count_val2 = strlen($msisdnval2);
	if($msisdnval_count_val2==10)
	{	
	$getCircle = "http://10.48.54.11/hungamawap/uninorldr/getCircle.php?msisdn=".$msisdnval2;
	$circle = file_get_contents($getCircle);
	}
	else
	{
	if(!$circle)
	{ 
	$circle='UND';
	}
	}
}
	
	$logPath_MIS218_Airtel="/var/www/html/hungamawap/airtel/sarnam/CCG/logs/AllAirtelVisitorRequestMISNew_".$logdate.".txt";
	$logString_MIS218_Airtel = $zone_id . "|".$MSISDN1 . "|" . $Remote_add . "|" . $full_user_agent . "|" . $redirectUrl . "|" .trim($msg) . "|" .$planid."|WAP|WAPAirtelLDR|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".urlencode($Publisher_Ref_Id)."|".urlencode($DGMResponse)."|".$old_sessionid."|".$content_id."|".date('Y-m-d H:i:s')."|CGCOMPLETE|"."\r\n";
	error_log($logString_MIS218_Airtel, 3, $logPath_MIS218_Airtel);
	
session_destroy();
if ($redirectUrl) {
    header("location:$redirectUrl");
    exit;
}
?>