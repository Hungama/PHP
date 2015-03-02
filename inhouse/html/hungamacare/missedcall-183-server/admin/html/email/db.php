<?php
$DB_HOST_M224   = '192.168.100.224'; 
$DB_USERNAME_M224 = 'Vinod_Ops';  
$DB_PASSWORD_M224 = 'Vinod@123';  
$DB_DATABASE_M224 = 'master_db';
$db_m224 = $DB_DATABASE_M224;
 
 $con = mysql_connect($DB_HOST_M224,$DB_USERNAME_M224,$DB_PASSWORD_M224);
if (!$con)
 {
  die('Could not connect:224 db ' . mysql_error("could not connect to Local"));
 }
 error_reporting(0);
?>