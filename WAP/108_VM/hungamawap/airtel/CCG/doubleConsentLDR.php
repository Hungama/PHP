<?php
session_start();
$old_sessionid = session_id();
include "/var/www/html/hungamawap/config/new_functions.php";
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
$cpage=curPageURL();
if($_REQUEST['msisdn']!='')
$msisdn=$_REQUEST['msisdn'];

$afid=$_REQUEST['afid'];
$Publisher_Ref_Id=$_REQUEST['Publisher_Ref_Id'];
$pubid=$_REQUEST['pubid'];
$pname = $_REQUEST['pname'];
$contentID = $_REQUEST['contentID'];
$pname = 'LDR';

$DGMResponse='NOK';
$msg='Double Consent';
if (isset($_REQUEST['productID'])) {
    $productID = $_REQUEST['productID'];
} else {
	$productID = "1515685";
}

$airtel_product=$productID;


$logdate = date("Ymd");
$refererName=$_SERVER['HTTP_REFERER'];

function aes_encrypt($val, $key = '@~ivohbnb#######') {
    //$key='@~ivohbnb#######';
    $mode = MCRYPT_MODE_ECB;
    $enc = MCRYPT_RIJNDAEL_128;
    $val = str_pad($val, (16 * (floor(strlen($val) / 16) + (strlen($val) % 16 == 0 ? 2 : 1))), chr(16 - (strlen($val) % 16)));
    return base64_encode(mcrypt_encrypt($enc, $key, $val, $mode, mcrypt_create_iv(mcrypt_get_iv_size($enc, $mode), MCRYPT_DEV_URANDOM)));
}

//$redirction_url = "/hungamawap/airtel/CCG/index3LDR.php?afid=$afid&";
$afid_dgm=$afid.'@@'.$Publisher_Ref_Id.'@@'.$pubid;
$redirction_url = "/hungamawap/airtel/CCG/index3LDR.php?afid_dgm=$afid_dgm&";

$rUrl = "http://117.239.178.108" . $redirction_url;
$findme = "?";
$flag_pos = "";
$pos = strpos($rUrl, $findme);
/*if ($pos) {
    $rUrl = $rUrl . "&airtel_res=1";
} else {
    $rUrl = $rUrl . "?airtel_res=1";
}
*/
 $rUrl = $rUrl . "?content_id=$contentID";


$encpassword = aes_encrypt('hungama'); //nazara
$conset_url = "http://in.airtellive.com/wps/portal/consent";
//$conset_url = "http://125.21.241.25/wps/portal/consent";
$method = "handleNewSubcription";
$msisdnval_count_val = strlen($msisdn);
if ($msisdnval_count_val == 12) {
    $msisdnval2 = substr($msisdn, 2);
} else {
    $msisdnval2 = $msisdn;
}

$FirstConfirmationDTTM = date("Y-m-d") . "T" . date("h:i:s.u") . "Z"; //date("c");//"2011-02-25T11:20:03.890Z";//pooja
$CpPwd = $encpassword;
$CpName = "hungama";
$CpId = 83; //8; 

$imgArray=array("100x100.jpg","120x80.jpg","160x120.jpg","240x160.jpg","320x240.jpg","480x320.jpg","600x450.jpg","800x600.jpg","480x320.jpg","480x320.gif");

$imgArray=array("1.gif","2.gif","3.gif","4.gif","5.gif","6.gif","7.gif","8.gif","9.gif","10.gif","11.gif");
$randSwitch=mt_rand(0,10);
//$randSwitch=9;
if($afid==1103)
{
$randSwitch=mt_rand(0,2);
$imgArrayBSB=array("420x220.JPG","12.jpg","13.jpg");
$imgBaseUrl='http://117.239.178.108/hungamawap/airtel/CCG/images/'.$imgArrayBSB[$randSwitch];
//$imgBaseUrl='http://117.239.178.108/hungamawap/airtel/CCG/images/420x220.JPG';
$cancelUrl="http://56789.airtel.in/";
}
else
{
$imgBaseUrl='http://117.239.178.108/hungamawap/airtel/CCG/images/'.$imgArray[$randSwitch];
$cancelUrl="http://a.ldr.mobi/genre/beauty";
}

switch ($pname) {
    case "LDR":
		if($productID=='1515685')
		{
			$pPrice = 35;
			$pVal = urlencode("7 day");
		}
		else if($productID=='1515690')
		{
			$pPrice = 5;
			$pVal = urlencode("1 day");
		}		
		else
		{
		echo "Invalid ProductId";
		exit;
		}
        $pName = urlencode("Lifestyle Dressing Room");
        $pPriceUnit = "Re";
		$pCName = urlencode("Lifestyle Dressing Room");
        $opt1 = $imgBaseUrl;
        $opt2 = "";
        $opt3 = "";
        $opt4 = $cancelUrl;
		$rtg="18+";
        $aoc = "testing";
		//$rUrl = str_replace('&', ',', $rUrl);
        //$rUrl = str_replace('?', '?finalres_trai=', $rUrl);
        break;
}

$pidArray=array('1515690'=>'96','1515689'=>'95','1515688'=>'95','1515687'=>'95','1515686'=>'95','1515685'=>'95','1515680'=>'93','1515679'=>'93','1515678'=>'93','1515677'=>'93','1515676'=>'93','1515675'=>'93','1515684'=>'93','1515683'=>'93','1515682'=>'93','1515681'=>'93','1515674'=>'93','1515673'=>'94','1515672'=>'94','1515671'=>'94','1515670'=>'94','1515669'=>'94','1515668'=>'94','1515667'=>'94','1515666'=>'94');
$planid=$pidArray[$productID];

$UA=urlencode($full_user_agent);
$call = "http://119.82.69.212/airtel/airtelWAP_New.php?msisdn=".$msisdnval2."&planid=$planid&AFFID=".$afid."&contentid=".$contentID."&UA=".$UA;
$call_224 = "http://119.82.69.212/airtel/airtelWAP_New_224.php?msisdn=".$msisdnval2."&planid=$planid&AFFID=".$afid."&contentid=".$contentID."&UA=".$UA;

$logPath_callurl="/var/www/html/hungamawap/airtel/CCG/logs/Allurlhits_".$logdate.".txt";
$callurllog1 =$call ."#"."\r\n";
$callurllog2 =$call_224 ."#"."\r\n";
//error_log($callurllog1, 3, $logPath_callurl);
//error_log($callurllog2, 3, $logPath_callurl);

$CpPwd = urlencode('//eXhwEHwAZ+50md4jxrnw==');
$conset_url = $conset_url . "?mth=" . $method . "&m=" . $msisdnval2 . "&pi=" . $productID . "&pn=" . $pName . "&pp=" . $pPrice . "&pu=" . $pPriceUnit . "&pv=" . $pVal . "&pc=" . $pCName . "&aoc=ok&dt=" . $FirstConfirmationDTTM . "&ci=" . $CpId . "&cpw=" . $CpPwd . "&cn=" . $CpName . "&ru=" . $rUrl."&opt1=".$opt1."&rtg=".$rtg."&opt4=".$opt4;

$msisdnval_count_val = strlen($msisdn);
$chkFoUnknown=strtolower($msisdn);
$circle='UND';
if($chkFoUnknown!='unknown')
{
		
	if ($msisdnval_count_val == 12) {
		$msisdnval2 = substr($msisdn, 2);
	} else {
		$msisdnval2 = $msisdn;
	}
	$msisdnval_count_val2 = strlen($msisdnval2);
	if($msisdnval_count_val2==10)
	{	
		$getCircle = "http://10.48.54.11/hungamawap/uninorldr/getCircle.php?msisdn=".$msisdnval2;
		$circle = file_get_contents($getCircle);
	}
	else
	{
		$circle='UND';
		
	}
}
//save data for live MIS purpose start here
 $logPath_MIS="/var/www/html/hungamawap/airtel/CCG/logs/AllAirtelSendCCGVisitorResponseMIS_".$logdate.".txt";
 $logString_MIS = $zone_id . "|" . date('Y-m-d H:i:s')."|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $conset_url . "|" . trim($msg) . "|" .$planid."|WAP|". $productID. "|117.239.178.108|" .urlencode($refererName). "|".$afid."|".$Publisher_Ref_Id."|".$DGMResponse."|".$dgmUrl."|".$old_sessionid."|".$circle."|WAPAirtelLDR|browsing|"."\r\n";
 error_log($logString_MIS, 3, $logPath_MIS);
$saveLiveMisWAPLogs = "http://119.82.69.212/kmis/services/hungamacare/2.0/wap/saveairtelLiveWAPlogs.php?zone_id=".$zone_id."&msisdn=".$msisdn."&msg=".urlencode($msg)."&afid=".$afid."&Publisher_Ref_Id=".urlencode($Publisher_Ref_Id)."&DGMResponse=".urlencode($DGMResponse)."&circle=".$circle."&service=WAPAirtelLDR&type=browsing";
$savelogsresponse=file_get_contents($saveLiveMisWAPLogs);
//save data for live MIS purpose end here

$logPath_MIS218_Airtel="/var/www/html/hungamawap/airtel/CCG/logs/AllAirtelVisitorRequestMISNew_".$logdate.".txt";
	
if($msisdn)
{
		$chkFoUnknown=strtolower($msisdn);
		if($chkFoUnknown=='unknown')
		{
		$logString_MIS218_Airtel = $zone_id . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $conset_url . "|" .trim($msg) . "|" .$planid."|WAP|WAPAirtelLDR|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".urlencode($Publisher_Ref_Id)."|".urlencode($DGMResponse)."|".$old_sessionid."|".$contentID."|".date('Y-m-d H:i:s')."|CGNOK|"."\r\n";
		error_log($logString_MIS218_Airtel, 3, $logPath_MIS218_Airtel);	
		$redirectUrl = "http://a.ldr.mobi/site/error?mobile_no=".$msisdn."&content_id=" . $contentID."&error_code=102&affid=".$afid."&sessionid=".$old_sessionid;
		 header("location:$redirectUrl");
		 exit;
		}
		
//status check API		
$StatusCheckUrl="http://10.48.54.11/hungamawap/airtel/checkStatusLdr.php";
$StatusCheckUrl.="?msisdn=$msisdn";
$statusCheck_result=curl_init($StatusCheckUrl);
curl_setopt($statusCheck_result,CURLOPT_RETURNTRANSFER,TRUE);
$statusapiResult= curl_exec($statusCheck_result);
curl_close($statusCheck_result);

if($statusapiResult=='CGOK')
{
 $callResponse = file_get_contents($call);
 //call api for inhouse
  $callResponse_224 = file_get_contents($call_224);
  $logString_MIS218_Airtel = $zone_id . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $conset_url . "|" .trim($msg) . "|" .$planid."|WAP|WAPAirtelLDR|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".urlencode($Publisher_Ref_Id)."|".urlencode($DGMResponse)."|".$old_sessionid."|".$contentID."|".date('Y-m-d H:i:s')."|CGOK|"."\r\n";
	error_log($logString_MIS218_Airtel, 3, $logPath_MIS218_Airtel);
	header("Location:" . $conset_url);
}
else
{
$logString_MIS218_Airtel = $zone_id . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $conset_url . "|" .trim($msg) . "|" .$planid."|WAP|WAPAirtelLDR|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".urlencode($Publisher_Ref_Id)."|".urlencode($DGMResponse)."|".$old_sessionid."|".$contentID."|".date('Y-m-d H:i:s')."|CGNOK|"."\r\n";
error_log($logString_MIS218_Airtel, 3, $logPath_MIS218_Airtel);

	if($afid==1103)
	$redirectUrl = "http://a.ldr.mobi/?afid=1103";
	else
	$redirectUrl = "http://a.ldr.mobi";
	header("location:$redirectUrl");
}
}
else
{
$redirectUrl = "http://a.ldr.mobi/site/error?mobile_no=".$msisdn."&content_id=" . $contentID."&error_code=102&affid=".$afid."&sessionid=".$old_sessionid;
$logString_MIS218_Airtel = $zone_id . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $conset_url . "|" .trim($msg) . "|" .$planid."|WAP|WAPAirtelLDR|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".urlencode($Publisher_Ref_Id)."|".urlencode($DGMResponse)."|".$old_sessionid."|".$contentID."|".date('Y-m-d H:i:s')."|CGNOK|"."\r\n";
error_log($logString_MIS218_Airtel, 3, $logPath_MIS218_Airtel);

 header("location:$redirectUrl");
}
exit;
?>
