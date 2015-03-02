<?php
$logdate=date("Ymd");
$msisdn=$_REQUEST['ani'];
$op=$_REQUEST['op'];
$circle=$_REQUEST['circle'];
$input=array("1463908","1463907","1463906","1463905","1463904","1704014");
$rand_keys = array_rand($input, 2);
//$wallpaperid=$input[$rand_keys[0]];
$wallpaperid='3307626';
$logPath="/var/www/html/kmis/services/hungamacare/wallpaper_ragniMMS/log_".$logdate.".txt";
//$url="http://202.87.41.147/waphung/common_download/1704014?znid=190885";
$url="http://54646.co/RMMS2/$wallpaperid";
if($msisdn){
echo $url;
$logString=$msisdn."|".$op."|".$circle."|".$url."|".date('h:i:s')."\r\n";
error_log($logString,3,$logPath);
}
?>