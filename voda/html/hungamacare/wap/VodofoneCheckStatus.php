<?php
error_reporting(0);
//include ("/var/www/html/hungamacare/dbConnect.php");
$dbConn = mysql_connect("10.43.248.137","php_promo","php@321");
$msisdn = trim($_REQUEST['msisdn']);
$service = '1301';
switch ($service) {
    case '1301':
        $db = "vodafone_radio";
        $subscriptionTable = "tbl_radio_subscription";
        break;
}
$query = "select ANI from " . $db . "." . $subscriptionTable . " nolock where ani='" . $msisdn . "' and status=1";
$result = mysql_query($query, $dbConn);
$num=mysql_num_rows($result);
if($num==0)
$response = 0;
else
$response = 1;

echo $response;
mysql_close($dbConn);
exit;
?>   