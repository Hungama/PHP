<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link type="text/css" rel="stylesheet" href="style.css"  />
</head>		
<?php
	$pname=$_REQUEST['pname'];
	$pname='LS';
		function aes_encrypt($val,$key='@~ivohbnb#######')
	{ 
		//$key='@~ivohbnb#######';
		$mode    =   MCRYPT_MODE_ECB;  
		$enc    =    MCRYPT_RIJNDAEL_128; 
		$val    =    str_pad($val, (16*(floor(strlen($val) / 16)+(strlen($val) % 16==0?2:1))), chr(16-(strlen($val) % 16)));    
		return base64_encode(mcrypt_encrypt($enc, $key, $val, $mode, mcrypt_create_iv( mcrypt_get_iv_size($enc, $mode), MCRYPT_DEV_URANDOM)));
	}

$rUrl="http://119.82.69.212/hungamacare/wapstream/stream.html";
$rUrl=$rUrl."?airtel_res=1";

//$encpassword = aes_encrypt('hungama');//nazara
$encpassword ="nazara";
$conset_url="http://airtellive.com/wps/portal/consent";
$method="handleNewSubcription";
$msisdnval_count_val = strlen($msisdn);
if($msisdnval_count_val==12)
{
	$msisdnval2=substr($msisdn, 2);
}
else
{
	$msisdnval2=$msisdn;
}

$FirstConfirmationDTTM=date("Y-m-d")."T".date("h:i:s.u")."Z";//date("c");//"2011-02-25T11:20:03.890Z";//pooja
$CpPwd=$encpassword;
$CpName="hungama";
$CpId=83;//8; 

$logPath="/var/www/html/hungamacare/wapstream/".$logdate."_log1.log";

$log_str_new = date("his")."|TRAI REQUEST START|PARAMETERS::PRODUCT:".$airtel_product."|MSISDN:".$msisdn."|REDIRECTION URL:".$rUrl."|cpw:".$encpassword."|CONSET_URL:".$conset_url."|METHOD:".$method."|FIRSTCONFIRMATIONDTTM::".$FirstConfirmationDTTM."|CPPWD::".$CpPwd."|CPNAME:".$CpName."|CPID:".$CpId."end|\n";
error_log($log_str_new,3,$logPath);

switch ($pname)
{
	case "LS":
		$productID = "1515674";	//"48116"; //1515666  //74128
		//$pName = "GOOD_LIFE"; 
		$pName = urlencode("Lifestyle Dressing Room"); 
		$pPrice = 99;  //5
		$pPriceUnit = "Re";
		$pVal = urlencode("30 day"); //1 day
		$pCName = urlencode("Lifestyle Dressing Room");
		$opt1="";
		$opt2="";
		$opt3="";
		$opt4="";
		$aoc="testing";
		$rUrl = str_replace('&',',',$rUrl);
		$rUrl = str_replace('?','?finalres_trai=',$rUrl);
	break;
}
$CpPwd=urlencode('//eXhwEHwAZ+50md4jxrnw==');
$conset_url=$conset_url."?mth=".$method."&m=".$msisdnval2."&pi=".$productID ."&pn=".$pName."&pp=".$pPrice."&pu=".$pPriceUnit."&pv=".$pVal."&pc=".$pCName."&aoc=ok&dt=".$FirstConfirmationDTTM."&ci=".$CpId."&cpw=".$CpPwd."&cn=".$CpName."&ru=".$rUrl;

$log_str_new = date("his")."|TRAI FINAL CONSENT URL|PARAMETERS::PRODUCT:".$airtel_product."|MSISDN:".$msisdn."|REDIRECTION URL:".$rUrl."|cpw:".$encpassword."|CONSET_URL:".$conset_url."|METHOD:".$method."|FIRSTCONFIRMATIONDTTM::".$FirstConfirmationDTTM."|CPPWD::".$CpPwd."|CPNAME:".$CpName."|CPID:".$CpId."|FINAL CONSENT URL:".$conset_url."|\n";
$logdate=date("Ymd");
$logPath="/var/www/html/hungamacare/wapstream/".$logdate."_log1.log";
error_log($log_str_new,3,$logPath);
//header("Location:".$conset_url);
echo $conset_url;
exit;