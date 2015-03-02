<?php

header('Content-type: text/xml');
//if ($_REQUEST['submit'] == 1) {
    $con = mysql_connect("10.130.14.106", "billing", "billing");

    $xml_post = file_get_contents('php://input');

    $xml = simplexml_load_string($xml_post);
    $msisdn = $xml->msisdn;
    $vas_id = $xml->vas_id;
    $transid = $xml->trx_id;
    $ccgid = $xml->cg_id;
    $error_code = $xml->error_code;
    $error_desc = $xml->error_desc;
    $consnt_status = $xml->consnt_status;
    $consnt_time = $xml->consnt_time;

    $mode = 'TELEM';

    $logDir = "/var/www/html/MTS/logs/XML/";
    $logFile = date('dmY') . "_log";
    $logFilePath = $logDir . $logFile . ".txt";
$Hungama_BS_array=array('808','818','833','834','848','858','925','929');
$Hungama_MU_array=array('803','814','825','826','844','854','923','927');
    //if ($vas_id == 'Hungama_BS') {
	if ($vas_id == '808' || $vas_id =='818' || $vas_id =='833' || $vas_id =='834' || $vas_id =='848' || $vas_id =='858' || $vas_id =='925' || $vas_id =='929') {
        $DB = 'dm_radio';
        $subscriptionProcedure = "DIGI_SUB";
        $langValue = '01';
        $sc = '5432105';
        $amount = '30';
        $s_id = '1111';
        $planid = '53';
   // } else if ($vas_id == 'Hungama_MU') {
    } else if ($vas_id == '803' || $vas_id =='814' || $vas_id =='825' || $vas_id =='826' || $vas_id =='844' || $vas_id =='854' || $vas_id =='923' || $vas_id =='927') {
        $DB = 'mts_radio';
        $subscriptionProcedure = "RADIO_SUB";
        $langValue = '01';
        $sc = '52222';
        $amount = '60';
        $s_id = '1101';
        $planid = '24';
    } else {
        $error_code = '1';
        $error_desc = 'accepted with Error';
        error_log($xml_post."#".$msisdn . "#" . $vas_id . "#" . $transid . "#" . $error_code . "#" . $error_desc . "#" . date('dmY:his') . "\n", '3', $logFilePath);
        $data = "<cg_response>";
        $data .= "<error_code>$error_code</error_code>";
        $data .= "<error_desc>$error_desc</error_desc>";
        $data .= "<opt1></opt1>";
        $data .= "</cg_response>";
        echo $data;
        exit;
    }
    $qry = "call " . $DB . "." . $subscriptionProcedure . " ('" . $msisdn . "','" . $langValue . "','" . $mode . "','" . $sc . "','" . $amount . "'," . $s_id . ",'" . $planid . "','" . $transid . "','" . $ccgid . "')";
    $qry1 = mysql_query($qry, $con) or die(mysql_error());
    if ($qry1 == '1') {
        $error_code = '0';
        $error_desc = 'Success';
    } else {
        $error_code = '2';
        $error_desc = 'System error, Retry Requires';
    }
    error_log($xml_post."#".$msisdn . "#" . $vas_id . "#" . $transid . "#" . $ccgid."#".$error_code . "#" . $error_desc . "#" . $qry."#".date('dmY:his') . "\n", '3', $logFilePath);

    $data = "<cg_response>";
    $data .= "<error_code>$error_code</error_code>";
    $data .= "<error_desc>$error_desc</error_desc>";
    $data .= "<opt1></opt1>";
    $data .= "</cg_response>";
    echo $data;
    exit;
//}
/*
$xml_builder = '<?xml version="1.0" encoding="UTF-8"?>
<cg_request>
	<msisdn>98766543210</msisdn>
	<vas_id>Hungama_BS</vas_id>
	<trx_id>mg1234</trx_id>
	<cg_id>cgw987888</cg_id>
	<error_code>0</error_code>
	<error_desc>Success_waitingNotify</error_desc>
	<consnt_status>1</consnt_status>
	<consnt_time>17-09-2013 11:23:07</consnt_time>
	<opt1></opt1>
	<opt2></opt2>
	<opt3></opt3>
</cg_request>';
// We send XML via CURL using POST with a http header of text/xml.
$ch = curl_init('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '?submit=1');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_builder);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$ch_result = curl_exec($ch);
curl_close($ch);
echo $ch_result;
*/
?>