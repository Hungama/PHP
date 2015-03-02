<?php

//////////////// File Pupose -> return total download attempts left for specified content of user for airtel gud life service @jyoti.porwal //////////////////////
//include("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php"); // airtel db connection @jyoti.porwal
include("/var/www/html/kmis/services/hungamacare/config/db_airtel.php");
$msisdn = trim($_REQUEST['msisdn']);
$contentid = trim($_REQUEST['contentid']);

$logPath = "/var/www/html/airtel/log/returnDwnldAttempt/returnDwnldAttemptlog_" . date("Y-m-d") . ".txt";

$logData = $msisdn . "#" . $contentid . "#" . date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath); // write all getting parameter @jyoti.porwal

if ($msisdn == '' || $contentid == '') {
    echo $response = "Incomplete Parameter";
    $logData = $msisdn . "#" . $contentid . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
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
//////////////////////////////////// start code for total no of downloads attampts here @jyoti.porwal ///////////////////////////////////////////////////////    
    $msisdn = checkmsisdn(trim($msisdn), $abc);
    $selectData = "select count(*) from airtel_rasoi.tbl_ldr_wap_download nolock where status=1 and msisdn=" . $msisdn . " and contentid=" . $contentid;
    $result = mysql_query($selectData);
    list($count) = mysql_fetch_array($result);

    
    if($count>=3)
	$left=0;
	else if($count==2)
	$left=1;
	else if($count==1)
	$left=2;
	
	if ($count == '' || $count == 0) {
        $left=3;
    }
	echo $left;
	
    $logData = $msisdn . "#" . $contentid . "#" . $count . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
//////////////////////////////////// end code for total no of downloads attampts here @jyoti.porwal ///////////////////////////////////////////////////////    
} else {
    echo $response = "Invalid Parameter";
    $logData = $msisdn . "#" . $contentid . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
}

mysql_close($dbAirtelConn); // close db connection @jyoti.porwal
?>