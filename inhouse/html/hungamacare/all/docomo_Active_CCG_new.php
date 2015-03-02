<?php

$dbConn = mysql_connect("192.168.100.224", "webcc", "webcc");
//echo "<pre>";print_r($_REQUEST);die('here');
$msisdn = $_REQUEST['msisdn'];
$planid = $_REQUEST['planid'];
$mode = $_REQUEST['mode'];
$amount = $_REQUEST['amount'];
$service_id = $_REQUEST['serviceid'];
$service_id = $_REQUEST['serviceid'];

$logDir = "/var/www/html/docomo/logs/docomo/active_ccg/";
$curdate = date("Ymd");
$logPath2 = $logDir . "docomo_active_ccg_new" . $curdate . ".txt";

switch ($planid) {
    case '1':
        $dbname = "docomo_radio";
        $sc = '59090';
        $subscriptionProcedure = "RADIO_SUB";
        $planid = 1;
        $lang = '01';
        $productID = 'GSMENDLESSDAILY2';
        break;
    case '2':
        $dbname = "docomo_radio";
        $sc = '590907';
        $subscriptionProcedure = "RADIO_SUB";
        $planid = 2;
        $lang = '01';
        $productID = 'GSMENDLESSWEEKLY14';
        break;
    case '3':
        $dbname = "docomo_radio";
        $sc = '590906';
        $subscriptionProcedure = "RADIO_SUB";
        $planid = 3;
        $lang = '01';
        $productID = 'GSMENDLESSMONTHLY60';
        break;
    case '12':
        $dbname = "docomo_radio";
        $sc = '590909';
        $subscriptionProcedure = "RADIO_SUB";
        $planid = 12;
        $lang = '01';
        $productID = 'GSMENDLESS10';
        break;
    case '46':
        $dbname = "docomo_radio";
        $sc = '5909060';
        $subscriptionProcedure = "RADIO_SUB";
        $planid = 46;
        $lang = '01';
        $productID = 'GSMENDLESS45';
        break;
    case '44':
        $dbname = "docomo_radio";
        $sc = '5909075';
        $subscriptionProcedure = "RADIO_SUB";
        $planid = 44;
        $lang = '01';
        $productID = 'GSMENDLESS75';
        break;
    case '45':
        $dbname = "docomo_radio";
        $sc = '5909075';
        $subscriptionProcedure = "RADIO_SUB";
        $planid = 45;
        $lang = '01';
        $productID = 'GSMENDLESS75';
        break;
    case '14':
        $dbname = "docomo_radio";
        $sc = '5909030';
        $subscriptionProcedure = "RADIO_SUB";
        $planid = 14;
        $lang = '01';
        $productID = 'ENDLESS30';
        break;
    case '88':
        $dbname = "docomo_radio";
        $sc = '5909011';
        $subscriptionProcedure = "RADIO_SUB";
        $planid = 88;
        $lang = '01';
        $productID = 'ENDLESS01';
        break;
    case '99':
        $dbname = "docomo_manchala";
        $sc = '5464626';
        $subscriptionProcedure = "RIYA_SUB";
        $planid = 99;
        $lang = '01';
        $productID = 'GSMENDLESSMONTHLY60';
        break;
    case '154':
        $dbname = "docomo_hungama";
        $sc = '54646';
        $subscriptionProcedure = "JBOX_SUB";
        $planid = 154;
        $lang = '01';
        $productID = 'GSMHMP75';
        break;
}

$transId = date('YmdHis');
$call = "call " . $dbname . "." . $subscriptionProcedure . "('$msisdn','$lang','$mode','$sc','$amount',$service_id,$planid,'$transId')";
sleep(1);
$qry1 = mysql_query($call) or die(mysql_error());
$pVal = $amount;
$pPrice = $amount;
//$pVal = $amount;
//$pPrice = $amount * 100;
if ($mode == 'TC') {
    $mode1 = 'TELECALL';
}
$url = "http://182.156.191.80:8091/API/CCG?MSISDN=$msisdn&productID=$productID&pName=Endlessmusic&reqMode=$mode1&reqType=SUBSCRIPTION&ismID=16&transID=$transId&pPrice=$pPrice&pVal=$pVal&CpId=hug&CpName=Hungama&CpPwd=hug@8910";
$logurl = "#url#" . $url . "#" . date("Y-m-d H:i:s") . "\n";
error_log($logurl, 3, $logPath2);
// init curl call here
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($ch);

$logresponse = "#Response#" . $response . "#" . date("Y-m-d H:i:s") . "\n";
error_log($logresponse, 3, $logPath2);

$response = explode("|", $response);
if($response[0] == 'ACCEPTED'){
    echo '100';
}else{
   echo '101';
}
mysql_close($dbConn);
exit;
?>