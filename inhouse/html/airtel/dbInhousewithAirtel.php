<?php
date_default_timezone_set('Asia/Calcutta');
//Inhouse DB Connect
 $DB_HOST_My     = '192.168.100.224'; //DB HOST
 $DB_USERNAME_My = 'webcc';  //DB Username //'Archana_db
 $DB_PASSWORD_My = 'webcc';  //DB Password //Archana@123
  
$dbConn212 = mysql_connect($DB_HOST_My, $DB_USERNAME_My, $DB_PASSWORD_My);
if (!$dbConn212) {
 //   die('Could not connect1: ' . mysql_error());
}

//Inhouse DB Connect
$DB_HOST_AIRM     = '10.2.73.160'; //DB HOST
$DB_USERNAME_AIRM = 'billing';  //DB Username
$DB_PASSWORD_AIRM = 'billing';  //DB Password
$dbConnAirtel = mysql_connect($DB_HOST_AIRM, $DB_USERNAME_AIRM, $DB_PASSWORD_AIRM);
if(!$dbConnAirtel) {
   //die('Could not connect to AIRTEL: ' . mysql_error());
 }
?>
