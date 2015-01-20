<?php
$DB_HOST_M224   = '119.82.69.214'; 
$DB_USERNAME_M224 = 'webcc';  
$DB_PASSWORD_M224 = 'webcc';  
$DB_DATABASE_M224 = 'master_db';
$db_m224 = $DB_DATABASE_M224;
date_default_timezone_set('Asia/Kolkata');
$logPath_DBError="/var/www/html/hungamawap/logs/dberror/dberror_".date("Ymd").".txt"; 
$con = mysql_connect($DB_HOST_M224,$DB_USERNAME_M224,$DB_PASSWORD_M224);
if (!$con)
 {
  $error=mysql_error();
  $logStringDbError = $DB_HOST_M224 . "|Could not connect:224 db|".$error."|".date('Y-m-d H:i:s')."\r\n";
  error_log($logStringDbError, 3, $logPath_DBError);
   die('Could not connect:224 db ' . mysql_error("could not connect to Local"));
 }
?>