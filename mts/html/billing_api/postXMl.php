<?php
$urltopost="http://10.130.14.8:5000/router/callinit.do";

$data1="<?xml version='1.0' encoding='ISO-8859-1'?".">";
$data1 .="<ci-request xmlns='http://www.hp.com/ocmp/2004/07/ci-request'";
$data1 .="xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' version='1.0'>";
$data1 .="<service-id>MKR_Outdial</service-id>";
$data1 .="<connection>isup:08586967046</connection>";
$data1 .="<fields>";
$data1 .="<field name='localuri' value='8586967046'></field>";
$data1 .="</fields>";
echo $data1 .="</ci-request>";

echo $response=postData($urltopost,$data1);

function postData($urltopost,$data1)
{
	$ch = curl_init ($urltopost);
	curl_setopt ($ch, CURLOPT_POST, true);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $data1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$returndata = curl_exec ($ch);
	return $returndata;
	exit;
}



?>
