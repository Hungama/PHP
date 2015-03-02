<?php
error_reporting(0);
$msisdn = trim($_REQUEST['msisdn']);
if ($msisdn == '') {
    echo $response = "Incomplete Parameter";
    exit;
}
////////////////// start function for check msisdn length @rahul.tripathi ///////////////
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

/////////////////// end function for check msisdn length @rahul.tripathi ///////////////
if (is_numeric($msisdn)) {
	 $msisdn = checkmsisdn(trim($msisdn), $abc);
	 include("db.php");//to reduce db connection issue
    $selectData = "select count(*) from uninor_ldr.tbl_ldr_subscription nolock where ani=" . $msisdn." and status!=0";
    $result = mysql_query($selectData);
    list($count) = mysql_fetch_array($result);

    if ($count) {
        echo $response = "subscribed";
    } else {
        echo $response = "not subscribed";
    }
mysql_close($con); // close db connection @rahul.tripathi
} else {
    echo $response = "Invalid Parameter";
}
?>