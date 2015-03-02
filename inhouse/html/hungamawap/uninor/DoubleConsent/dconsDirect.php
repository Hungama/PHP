<?php

include "/usr/local/apache/htdocs/hungamawap/new_functions.php3";
$stype = $_REQUEST['stype'];

//$msisdn='1234567890';
//if(!$msisdn)	$msisdn=$_REQUEST['msisdn'];

if (strlen($msisdn) == 12)
    $msisdn = substr($msisdn, -10);

if ($msisdn) {
    if ($stype == 'OMU') {
        $CPPID = 8;
        $PMARKNAME = 'MUSICUNLIMITEDDAILYPACK';
        $PRICE = '250.0';
        $SE = 'ONMOBILE';
        $PD = 'Music_Unlimited';
        $SCODE = '5755923';
        $PRODTYPE = 'rbt';
        $succUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Success.php");
        $failureUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Fail.php");
    }
    if ($stype == 'CMU') {
        $CPPID = 'COMBO_HG01_2.5';
        $PMARKNAME = 'musicunlimited';
        $PRICE = '250';
        $SE = 'COMVIVA';
        $PD = 'Music_Unlimited';
        $SCODE = '019105600674732';
        $PRODTYPE = 'sub';
        $succUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Success.php");
        $failureUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Fail.php");
    }
    if ($stype == 'CMU60') {
        $CPPID = 'COMBO_HG30_60';
        $PMARKNAME = 'musicunlimited';
        $PRICE = '6000';
        $SE = 'COMVIVA';
        $PD = 'Music_Unlimited';
        $SCODE = '019105600674732';
        $PRODTYPE = 'sub';
        $succUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/SuccessMU60.php");
        $failureUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/FailMU60.php");
    }
    if (strtoupper($stype) == 'USU' || $stype == '') {
        $CPPID = 'HUI0000007';
        $PMARKNAME = 'sports_unlimited';
        $PRICE = '3000';
        $SE = 'HUNGAMA';
        $PD = 'sports_unlimited';
        $SCODE = 'NA';
        $PRODTYPE = 'sub';
        $succUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/SuccessSU.php");
        $failureUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/FailSU.php");
    }
    if (strtoupper($stype) == 'UMY') {
        $CPPID = 'HUI0002111';
        $PMARKNAME = 'MyMusic';
        $PRICE = '3000';
        $SE = 'HUNGAMA';
        $PD = 'MyMusic';
        $SCODE = 'NA';
        $PRODTYPE = 'sub';
        $succUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/SuccessMY.php");
        $failureUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/FailMY.php");
    }
    if (strtoupper($stype) == 'UMR') {
        $CPPID = 'HUI0038007';
        $PMARKNAME = 'MissRiya';
        $PRICE = '3000';
        $SE = 'HUNGAMA';
        $PD = 'MissRiya';
        $SCODE = 'NA';
        $PRODTYPE = 'sub';
        $succUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Success.php");
        $failureUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Fail.php");
    }
    if (strtoupper($stype) == 'UBR') {
        $CPPID = 'HUI0002103';
        $PMARKNAME = 'BhaktiRaas';
        $PRICE = '3000';
        $SE = 'HUNGAMA';
        $PD = 'BhaktiRaas';
        $SCODE = 'NA';
        $PRODTYPE = 'sub';
        $succUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/SuccessUBR.php");
        $failureUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/FailUBR.php");
    }
    if (strtoupper($stype) == 'U54646') {
        $CPPID = 'HUI0038022';
        $PMARKNAME = '54646';
        $PRICE = '3000';
        $SE = 'HUNGAMA';
        $PD = '54646';
        $SCODE = 'NA';
        $PRODTYPE = 'sub';
        $succUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Success54646.php");
        $failureUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/FailU54646.php");
    }
    if (strtoupper($stype) == 'UKIJI') {
        $CPPID = 'HUI0036057';
        $PMARKNAME = urlencode('Khelo India Jeeto India');
        $PRICE = '500';
        $SE = 'HUNGAMA';
        $PD = urlencode('Contest Portal');
        $SCODE = 'NA';
        $PRODTYPE = 'sub';
        $succUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Successukiji.php");
        $failureUrl = urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Failukiji.php");
    }

    $dUrl = "http://180.178.28.63:7001/ConsentGateway/cgok.action?REQ_TYPE=Subcription&CP=Hungama&MSISDN=" . $msisdn;
    $dUrl .="&CPPID=" . $CPPID . "&PRODTYPE=" . $PRODTYPE . "&PMARKNAME=" . $PMARKNAME . "&PRICE=" . $PRICE . "&SE=" . $SE . "&CPTID=" . date('Ymdhis');
    $dUrl .="&DT=" . date('Y-m-d') . "&PD=" . $PD . "&SUCCURL=" . $succUrl;
    $dUrl .="&FAILURL=" . $failureUrl . "&SCODE=" . $SCODE . "&RSV=&RSV2=";

   echo file_get_contents($dUrl);
   // header("location:".$dUrl);
    exit;


  //$url = 'http://180.178.28.63:7001/ConsentGateway';
   $url = 'http://180.178.28.63:7001/ConsentGateway/cgok.action';

    $fields = array(
        'REQ_TYPE' => urlencode("Subcription"),
        'CP' => urlencode("Hungama"),
        'MSISDN' => $msisdn,
        'CPPID' => urlencode($CPPID),
        'PRODTYPE' => urlencode($PRODTYPE),
        'PMARKNAME' => urlencode($PMARKNAME),
        'PRICE' => urlencode($PRICE),
        'SE' => urlencode($SE),
        'CPTID' => date('Ymdhis'),
        'FAILURL' => urlencode($failureUrl),
        'SCODE' => urlencode($SCODE),
        'RSV' => '',
        'RSV2' => ''
    );

//url-ify the data for the POST
    foreach ($fields as $key => $value) {
        $fields_string .= $key . '=' . $value . '&';
    }
    rtrim($fields_string, '&');

    //echo "<pre>";
    //print_r($fields_string);
    //exit;
//open connection
    $ch = curl_init();

//set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    //curl_setopt($ch,CURLOPT_HTTPHEADER,array('Host: 180.178.28.63:7001'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

//execute post
    echo $result = curl_exec($ch);



    //header("location:http://180.178.28.63:7001/ConsentGateway/cgok.action");
    exit;
    //header("location:$dUrl");
    exit();
} else {
    echo "Msisdn not found";
}
?>