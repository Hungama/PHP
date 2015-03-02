<?php
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
$view_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$view_date='2015-01-13';
$get_ldr_BillingData = "select concat('91',mdn),aff from misdata.tmp_aff nolock where date(date)='" . $view_date . "'";
$query1 = mysql_query($get_ldr_BillingData, $LivdbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    while (list($msisdn,$aff) = mysql_fetch_array($query1)) {
	$update="update misdata.tbl_billing_wap_ldr_airtel set affiliate='".$aff."' where msisdn='".$msisdn."' and date(date)='".$view_date."'";
	mysql_query($update, $LivdbConn);
}
}
else
{
echo "No Data in tmp table";
}
mysql_close($dbConnAirtel);
mysql_close($LivdbConn);
echo "generated";
?>
