<?php 
include("session.php");
//activebase,albumdetail,albumtrack,billing,billing.store,calling,campaignmanager,campaignupload,cms.index,cms.loadmeta,cms.loadmetainner,cms.upload,content,contentdump,contentdump.store,lookup,mdn.store,mdnstatus,obd,pcr,pcr.addnew,recharge,recharge.myview,recharge.transactionview,revenue,revenue-live,royalty,scrub,scrub.store,social,travel,user.alerts,admin,admin.usermanager,admin.service
//$moduleArray=array('mdnstatus'=>'Customer Care','bulk'=>'Bulk Upload');
$moduleArray=array('interface.bulk'=>'Bulk Upload','interface.bulk'=>'Celebrity Deactivation','interface.contentstore'=>'Content Upload','interface.cc'=>'Customer Care','interface.bulk'=>'Event Bulk Upload','interface.bulk'=>'FollowUp Upload','interface.bulk'=>'FRC Admin','interface.wapstore'=>'IVR Reliance Wap Store','interface.bulk'=>'Single Upload','interface.bulk'=>'Single Upload Docomo','interface.smspush'=>'SMS Bulk Upload','interface.bulk'=>'Try-n-Buy Uninor Upload','interface.bulk'=>'Upload 10 Min Base');

$listmodules=$_SESSION["access_sec"];
$modules = explode(",", $listmodules);
foreach ($moduleArray as $k1 => $v1)
{
if(in_array($k1,$modules))
 { 
echo "<li><a href=\"#\">".$v1."</a></li>";					   
  }
 }
 ?>