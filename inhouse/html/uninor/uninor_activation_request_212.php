<?php
//req_type>> act/crbt
$type=$_REQUEST['req_type'];
$msisdn=$_REQUEST['msisdn'];
$service=$_REQUEST['service'];
$curdate = date("Y-m-d");
$logPath = "logs/uninor_website/requestforact_212_".$curdate.".txt";
$logPath_crbt = "logs/uninor_website/CRBT/requestforact_212_".$curdate.".txt";
if($type=='ACT')
{
//send request to 227 server
$religionid=$_REQUEST['religionid'];			
$sendreqst="http://192.168.100.227/uninor/uninor_activation_request_227.php?req_type=ACT&msisdn=$msisdn&service=$service&religionid=$religionid";
$initrequest = file_get_contents($sendreqst);
$logData="#msisdn#".$msisdn."#service#".$service."#religionid#".$religionid."#url#".$sendreqst."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);				
}

else if($type=='RTACT')
{
$contentid=$_REQUEST['contentid'];
$contentid2=$_REQUEST['contentid2'];
//$getcirclel="http://119.82.69.212/Uninor/uninorCheck.php?msisdn=".$msisdn."&reqtype=checkOP";
$getcirclel="http://192.168.100.212/Uninor/uninorCheck.php?msisdn=".$msisdn."&reqtype=checkOP";
	 $cir = file_get_contents($getcirclel);
	if($cir=='UPE' || $cir=='UPW' || $cir=='BHR'|| $cir=='DEL')
	{
	//Onmobile (Circle)
	$toneid=$contentid2;
	}
	else if($cir=='APD' || $cir=='GUJ' || $cir=='MAH')
	{
	//Comviva  (Circle)
	$toneid=$contentid;
	}
	//send request to 227 server				
$sendreqst="http://192.168.100.227/uninor/uninor_activation_request_227.php?req_type=RTACT&msisdn=$msisdn&vcode=$toneid&circle=$cir";
$initrequest = file_get_contents($sendreqst);
$logData="#msisdn#".$msisdn."#service#".$service."#url#".$sendreqst."#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logPath_crbt);		
	
//For CRBT Activation
}
?>