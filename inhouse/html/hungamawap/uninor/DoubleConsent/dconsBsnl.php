<?php
include "/usr/local/apache/htdocs/hungamawap/new_functions.php3";
	$logdate=date("Ymd");
	$msisdn ='9488320239';
	if(!empty($msisdn))
	{
	$serviceid='07306644';
	$keyword='00';
	$shortcode='54646000';
	$authkey='hungamaIVR';
	$contentid='1';
	$reqtype='ACT';
	$cpid='73';
	$mode='WAP';
	$lang='ENG';
	$responsetype='HTML';
	$transactionid='TX'.date('ymdhis');
	$requesttimestamp=date('ymdhis');
	$seid='01';
	$redirecturl="http://202.87.41.147/hungamawap/uninor/DoubleConsent/SuccessBsnl.php";
	$dUrl  ="https://bsnlsouth.netxcell.com:14443/WEBWAP/interface/cg?msisdn=".$msisdn;
	$dUrl .="&serviceid=".$serviceid."&keyword=".$keyword."&shortcode=".$shortcode."&authkey=".$authkey;
	$dUrl .="&contentid=".$contentid."&reqtype=".$reqtype."&cpid=".$cpid."&mode=".$mode."&lang=".$lang."&responsetype=".$responsetype;
	$dUrl .="&transactionid=".$transactionid."&requesttimestamp=".$requesttimestamp."&responsetype=".$responsetype;
	$dUrl .="&seid=".$seid."&redirecturl=".$redirecturl;
//	echo $dUrl;

$logPath="/usr/local/apache/htdocs/hungamawap/uninor/DoubleConsent/CCGVisitorRequestBSNL_".$logdate.".txt";
$logString=$msisdn."|".$stype."|".$zone_id."|".$model."|".$Remote_add."|".$full_user_agent."|".trim($dUrl)."|".date('d-m-Y H:i:s')."\r\n";
error_log($logString,3,$logPath);		
	
header("location:$dUrl");
exit();
}
else
{
	echo "Msisdn not found";
}

?>