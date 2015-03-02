<?php
error_reporting(0);
$dbConn = mysql_connect("10.43.248.137","php_promo","php@321");
$msisdn = trim($_REQUEST['msisdn']);
$service = trim($_REQUEST['service']);
$service = '1301';
switch ($service) {
    case '1301':
        $db = "vodafone_radio";
        $blacklistTable = "tbl_radio_blacklistWAP";
        break;
}

$get_data = "select ANI from $db.$blacklistTable nolock where ani='".$msisdn."' limit 1";
$query = mysql_query($get_data, $dbConn);
$numofrows = mysql_num_rows($query);
$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
					$circle1=mysql_query($getCircle,$dbConn);
					list($circle)=mysql_fetch_array($circle1);
					if(!$circle)
					{ 
					$circle='UND';
					}

$res=$numofrows."#".$circle;
echo $res;
mysql_close($dbConn);
?>