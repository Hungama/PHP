<?php
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$mode=$_REQUEST['mode'];
$reqtype=$_REQUEST['reqtype'];
$planid=$_REQUEST['planid'];
$subchannel =$_REQUEST['subchannel'];
$rcode =$_REQUEST['rcode'];
$curdate = date("Y-m-d");
$queryString="http://119.82.69.212/docomo/endlessmusic.php?msisdn=$msisdn&mode=$mode&reqtype=$reqtype&planid=$planid&subchannel=$subchannel&servicename=MTVLive_Hungama&rcode=100,101,102";
header("location:$queryString");
exit;

?>   