<?php
//sample url- 
//http://10.2.73.156/airtel/airtelCrbt.php?msisdn=9810123123&vcode=009110000000100&circle=DEL
//http://10.2.89.203/URLIntegration/helloTune.jsp?msisdn=9810123123&vcode=009110000000100&u
//id=test&pass=test&flag=0&sFree=1&dFree=1
error_reporting(0);
$msisdn='';
$vcode='';
$ctype='';
$mainurltocurl='';
$ip_url='';
$midurl='';
$msisdn=$_REQUEST['msisdn'];
$vcode=$_REQUEST['vcode'];
$ctype=strtoupper($_REQUEST['circle']);
$mode='crbt';
$reqtype=$_REQUEST['reqtype'];
$curdate = date("Y-m-d");
$logPath = "logs/crbt/crbt_subscription_".$curdate.".txt";
//$log_file_path="logs/crbt/crbt_subscription_".$curdate.".txt";
/*****************************check msisdn start*****************/

function checkmsisdnonly($msisdn)
{
	if(strlen($msisdn)==12 || strlen($msisdn)==10 )
	{
		if(strlen($msisdn)==12)
		{
			if(substr($msisdn,0,2)==91)
			{
				$msisdn = substr($msisdn, -10);
			}
		}
		
	}
	else
	{
	$msisdn='';
	}
	return $msisdn;
}
/*****************************check msisdn end*****************/
$msisdn=checkmsisdnonly(trim($msisdn));
if (!is_numeric ($msisdn)) 
 {
 $msisdn='';
 }

//Create array for East circle code
$east_cir=array('ASM','NES','WBL','KOL','ORI');

//Create array for West circle code
$west_cir=array('MUM','MAH','GUJ','MP');

//Create array for North circle code
$north_cir=array('JNK','HPD','PUN','HAY','DEL','RAJ','UPW','UPE','BIH');

//Create array for South circle code
$south_cir=array('APD','AP','CHN','KK','KAR','TN','TNU','KER');


if (($msisdn == "") || ($vcode=="") || ($ctype==""))
{
$response="Please provide the complete parameter";
echo "Please provide the complete parameter";
$logData="#msisdn#".$msisdn."#mode#".$mode."#vcode#".$vcode."#circle#".$ctype."#apiresponse#".$response."#".date("Y-m-d H:i:s")."\n";;
	error_log($logData,3,$logPath);
}
else
{
if (in_array($ctype, $east_cir)) {
//echo "Find****".$ctype."**** in East circle";
//make custom url based on circle
$ip_url="10.133.23.190";
$midurl="URLIntegration/helloTune.jsp?msisdn=".$msisdn."&vcode=".$vcode."&uid=HUN_IVR&pass=hun_ivr&flag=0&sFree=1&dFree=1";
}
else if (in_array($ctype, $west_cir)) {
 // echo "Find****".$ctype."****in West circle";
	//make custom url based on circle
$ip_url="10.49.5.90";
$midurl="URLIntegration/helloTune.jsp?msisdn=".$msisdn."&vcode=".$vcode."&uid=HUN_IVR&pass=hun_ivr&flag=0&sFree=1&dFree=1";
}
else if (in_array($ctype, $north_cir)) {
  //  echo "Find****".$ctype."****in North circle";
	//make custom url based on circle
$ip_url="10.2.89.202";
//$midurl="URLIntegration/helloTune.jsp?msisdn=".$msisdn."&vcode=".$vcode."&uid=HUN_IVR&pass=hun_ivr&flag=0&sFree=1&dFree=1";
$midurl="URLIntegration/helloTune.jsp?msisdn=".$msisdn."&vcode=".$vcode."&uid=HUN_IVR&pass=hun_ivr&flag=0&sFree=default&dFree=default";
}
else if (in_array($ctype, $south_cir)) {
 //   echo "Find****".$ctype."****in South circle";
$midurl="rbt/rbt_promotion.jsp?MSISDN=".$msisdn."&REQUEST=SELECTION&SUB_TYPE=Prepaid&CATEGORY_ID=27&WAV_FILE=rbt_".$vcode."_rbt
&SELECTED_BY=HUNGAMA&ISACTIVATE=TRUE&SUBSCRIPTION_CLASS=DEFAULT&REDIRECT_NATIONAL=TRUE&ISACTIVATE=True";

if($ctype=='APD' || $ctype=='AP')
{
//APD |AP
$ip_url="10.105.55.36:8080";
}
else if($ctype=='CHN')
{
//CHN
$ip_url="10.111.15.46:8080";
}
else if($ctype=='KK'||$ctype=='KAR')
{
//KK|KAR
$ip_url="10.89.8.73:8080";
}
else if($ctype=='TN'||$ctype=='TNU')
{
//TN |TNU
$ip_url="10.111.15.46:8080";
}
else if($ctype=='KER')
{
//KER
$ip_url="10.127.7.4:8080";
}
}
else
{
//echo "Invalid Circle Code";
}
if(!empty($ip_url))
{
$mainurltocurl="http://".$ip_url."/".$midurl;

//make curl call for this request start here

$api_call= curl_init($mainurltocurl);
	curl_setopt($api_call,CURLOPT_RETURNTRANSFER,TRUE);
	$api_exec= curl_exec($api_call);
	curl_close($api_call);
	//echo "Curl response is ".$api_exec;
	$crl_resp=trim($api_exec);
	//echo "<br>".$crl_resp;
	//$exp_response=explode('#',$api_exec);
//make curl call for this request end here
//save log for each request
//save log here
$logData="#msisdn#".$msisdn."#mode#".$mode."#vcode#".$vcode."#circle#".$ctype."#apiresponse#".$crl_resp."#".$mainurltocurl."#".date("Y-m-d H:i:s")."\n";;
	error_log($logData,3,$logPath);
/*
$log_file_path="logs/crbt/crbt_subscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $vcode . "#" . $ctype . "#" . date('H:i:s') ."#" .$crl_resp."\r\n" );
					fclose($file);
					*/
}
else
{
echo "Invalid request";
}
}
?>