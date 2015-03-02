<?php 
//include("session.php");
//$moduleArray=array('interface.bulk'=>'Bulk Upload','interface.bulk'=>'Celebrity Deactivation','interface.contentstore'=>'Content Upload','interface.cc'=>'Customer Care','interface.bulk'=>'Event Bulk Upload','interface.bulk'=>'FollowUp Upload','interface.bulk'=>'FRC Admin','interface.wapstore'=>'IVR Reliance Wap Store','interface.bulk'=>'Single Upload','interface.bulk'=>'Single Upload Docomo','interface.smspush'=>'SMS Bulk Upload','interface.bulk'=>'Try-n-Buy Uninor Upload','interface.bulk'=>'Upload 10 Min Base');
$bulkarray=array('Bulk Upload','Celebrity Deactivation','Event Bulk Upload','FollowUp Upload','FRC Admin','Single Upload','Single Upload Docomo','Try-n-Buy Uninor Upload','Upload 10 Min Base');
$moduleArray=array('interface.bulk'=>$bulkarray,'interface.contentstore'=>'Content Upload','interface.cc'=>'Customer Care','interface.wapstore'=>'IVR Reliance Wap Store','interface.smspush'=>'SMS Bulk Upload');

$listmodules=$_SESSION["access_sec"];
$serviceid = $_REQUEST["serviceid"];
$mainurl='';

$modules = explode(",", $listmodules);
foreach ($moduleArray as $k1 => $v1)
{
if($k1=='interface.bulk')
{
//echo "<li><a href=\"http://119.82.69.212/kmis/services/hungamacare/bulk_upload.php?service_info=$serviceid\" target='_blank'>Bulk Upload</a></li>";
echo "<li><a href=\"bulk_upload_new.php?service_info=$serviceid\" target='_blank' >Bulk Upload</a></li>";
echo "<li><a href=\"http://119.82.69.212/kmis/services/hungamacare/celebrityDeactivation.php?service_info=$serviceid\" target='_blank'>Celebrity Deactivation</a></li>";
echo "<li><a href=\"#\">Event Bulk Upload</a></li>";
echo "<li><a href=\"#\">FollowUp Upload</a></li>";
echo "<li><a href=\"http://119.82.69.212/kmis/services/hungamacare/frcAdmin.php?service_info=$serviceid\" target='_blank'>FRC Admin</a></li>";
echo "<li><a href=\"http://119.82.69.212/kmis/services/hungamacare/single_upload.php?service_info=$serviceid\" target='_blank'>Single Upload</a></li>";
echo "<li><a href=\"http://119.82.69.212/kmis/services/hungamacare/single_upload_docomo.php?service_info=$serviceid\" target='_blank'>Single Upload Docomo</a></li>";
echo "<li><a href=\"http://119.82.69.212/kmis/services/hungamacare/trynbuy_upload.php?service_info=$serviceid\" target='_blank'>Try-n-Buy Uninor Upload</a></li>";
echo "<li><a href=\"#\">Upload 10 Min Base</a></li>";
}
if($k1=='interface.contentstore')
{
echo "<li><a href=\"#\">Content Upload</a></li>";
}
if($k1=='interface.cc')
{
echo "<li><a href=\"customer_care.php?service_info=$serviceid\" target='_blank'>Customer Care</a></li>";
}
if($k1=='interface.wapstore')
{
echo "<li><a href=\"#\">IVR Reliance Wap Store</a></li>";
}
if($k1=='interface.smspush')
{
echo "<li><a href=\"
http://119.82.69.212/kmis/services/hungamacare/sms_bulk_upload.php?service_info=1206\" target='_blank'>SMS Bulk Upload</a></li>";
}

/***********************added for list mmodules start here *************************/
if(in_array($k1,$modules))
{ 
/*
if(count($v1)>1){
foreach($v1 as $k2=>$v2)
{
echo "<li><a href=\"#\">".$v2."</a></li>";
}
}
else
{
echo "<li><a href=\"#\">".$v1."</a></li>";
}
/*
/***********************added for list mmodules end here *************************/
}
 }
?>