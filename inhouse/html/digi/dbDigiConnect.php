<?php

date_default_timezone_set('Asia/Calcutta');

/*** Master DB Connection ***/
//MASTER DATABASE ACCESS VARIABLES
 $DB_HOST_M     = '172.16.56.42'; //'172.28.106.4'; //DB HOST //172.16.56.42
 $DB_USERNAME_M = 'root';  //DB Username
 $DB_PASSWORD_M = 'D1g1r00t@!23';  //DB Password 'Te@m_us@r987';
 $DB_DATABASE_M = 'master_db';  //Datbase Name
 $db_m = $DB_DATABASE_M;

$dbConn = mysql_connect($DB_HOST_M, $DB_USERNAME_M, $DB_PASSWORD_M) or die(mysql_error());
if (!$dbConn) {
    die('Could not connect1: ' . mysql_error());
}
mysql_select_db($DB_DATABASE_M, $dbConn) or die(mysql_error());


// LIVE MIS Database

 $DB_HOST_LIVE_MIS     = '192.168.100.218';//'119.82.69.218'; //DB HOST
 $DB_USERNAME_LIVE_MIS = 'php'; //'amit.khurana';  //DB Username
 $DB_PASSWORD_LIVE_MIS = 'php'; //'hungama';  //DB Password
 $DB_DATBASE_LIVE_MIS = 'misdata';  //Datbase Name
 $db_LIVE_MIS = $DB_DATBASE_LIVE_MIS;

/*** Live Mis DB Connection ***/

$LivdbConn = mysql_connect($DB_HOST_LIVE_MIS,$DB_USERNAME_LIVE_MIS,$DB_PASSWORD_LIVE_MIS) or die(mysql_error());
if (!$LivdbConn) {
   die('Could not connect: ' . mysql_error());
}

?>
