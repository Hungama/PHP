<?php
include("db.php");
$msisdn=$_REQUEST['msisdn'];
$service_info=$_REQUEST['obd_form_service'];
$obd_form_pricepoint=$_REQUEST['obd_form_pricepoint'];
$obd_form_amount=$_REQUEST['obd_form_amount'];
$usersubmode=$_REQUEST['usersubmode'];
$userblance=$_REQUEST['userblance'];
$userstatus=$_REQUEST['userstatus'];
$renewdate=$_REQUEST['renewdate'];
$subdate=$_REQUEST['subdate'];

$new_renewdate = date("Y-m-d",strtotime($renewdate));
/*
$date1 = new DateTime("now");
$date2 = new DateTime("tomorrow");

var_dump($date1 == $date2);
var_dump($date1 < $date2);
var_dump($date1 > $date2);*/
if($userstatus!=1 && $new_renewdate>$subdate)
{
echo "Can not update renew date."."\n\r";
}
else
{
echo "OK"."\n\r";
}

echo $msisdn."@@".$service_info."@@".$obd_form_pricepoint."@@".$obd_form_amount."@@".$usersubmode."@@".$userblance."@@".$userstatus."@@".$new_renewdate."@@".$subdate;
exit;
?>