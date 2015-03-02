<?php

///////////////////////// File Pupose -> check msisdn subscribed or not for airtel gud life service @jyoti.porwal /////////////////////////////////////////
//include("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php"); // airtel db connection @jyoti.porwal
include("/var/www/html/kmis/services/hungamacare/config/db_airtel.php");
$msisdn = trim($_REQUEST['msisdn']);

$logPath = "/var/www/html/airtel/log/checkStatus/accountAccesslog_" . date("Y-m-d") . ".txt";

$logData = $msisdn . "#" . date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath); // write all getting parameter @jyoti.porwal

if ($msisdn == '') {
    echo $response = "Incomplete Parameter";
    $logData = $msisdn . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
    exit;
}

///////////////////////////////////////////////////////// start function for check msisdn length @jyoti.porwal /////////////////////////////////////////////////
function checkmsisdn($msisdn, $abc) {
    if (strlen($msisdn) == 12 || strlen($msisdn) == 10) {
        if (strlen($msisdn) == 12) {
            if (substr($msisdn, 0, 2) == 91) {
                $msisdn = substr($msisdn, -10);
            }
        }
    } else {
        echo "Invalid Parameter";
        exit;
    }
    return $msisdn;
}

//////////////////////////////////////////////////////// end function for check msisdn length @jyoti.porwal ///////////////////////////////////////////////
if (is_numeric($msisdn)) {
    $msisdn = checkmsisdn(trim($msisdn), $abc);
	 $selectData = "select contentid from airtel_rasoi.tbl_ldr_wap_download nolock where msisdn='".$msisdn."' and status=1";
    $result = mysql_query($selectData);
	$totalCount=mysql_num_rows($result);
	$contentidArray=array();
	
	if($totalCount>=1)
	{
    while($data = mysql_fetch_array($result))
	{
	$contentidArray[]=$data['contentid'];
	}
	$comma_separated = implode("#", $contentidArray);
	}
	else
	{
	$comma_separated =0;
	}
	
	echo $comma_separated; // lastname,email,phone

     $logData = $msisdn . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
} else {
    echo $response = "Invalid Parameter";
    $logData = $msisdn . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
}
mysql_close($dbAirtelConn); // close db connection @jyoti.porwal
?>