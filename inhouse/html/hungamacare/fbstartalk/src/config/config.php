<?php
//DB Credentials
$mysql_hostname='192.168.100.224';
$mysql_user='webcc';
$mysql_password='webcc';
$mysql_dbName='facebook';

//App Specific Settings
$baseDir="/var/www/html/hungamacare/fbstartalk/src/";
$logDir="/var/www/html/hungamacare/fbstartalk/Logs/";
$temp_ConvertPath="content/temp/";
$AppFormat=".wav";
$fb_supportFormat=".3gp";

$callback_url = "http://119.82.69.212/hungamacare/fbstartalk/src/call_back.php?appid=1";
//$callback_url = "http://124.153.73.2/endless/web/FB/";
$server_url = "http://119.82.69.212/hungamacare/fbstartalk/src/";

$central_url = "http://10.89.4.30:8080/TalkToMeStandard/TalkToMeController?";
//$central_url = "http://10.0.8.66:9191/TalkToMeStandard/TalkToMeController?";
$forward_url1="http://117.99.128.25:8080/HTTPForwarder/simplehttp?";
$forward_url2="http://220.226.188.60/HTTPForwarder/simplehttp?";
$before_promo_day=7;
$defaultProfileName='Ttm Airtel';
?>
