<?php

date_default_timezone_set('Asia/Calcutta');

// LIVE MIS Database

 $DB_HOST_LIVE_MIS     = '192.168.100.218'; //DB HOST
 $DB_USERNAME_LIVE_MIS = 'php'; //'amit.khurana';  //DB Username
 $DB_PASSWORD_LIVE_MIS = 'php';  //DB Password
 $DB_DATBASE_LIVE_MIS = 'misdata';  //Datbase Name
 $db_LIVE_MIS = $DB_DATBASE_LIVE_MIS;

/*** Live Mis DB Connection ***/

$LivdbConn = mysql_connect($DB_HOST_LIVE_MIS,$DB_USERNAME_LIVE_MIS,$DB_PASSWORD_LIVE_MIS); // or die(mysql_error());
if (!$LivdbConn) {
   //die('Could not connect: ' . mysql_error());
   echo "Live Database could not connect";
}

/*** live MIS  DB Connection ***/

/*** AIRTEL Master DB Connection ***/
//MASTER DATABASE ACCESS VARIABLES
$DB_HOST_AIRM     = '10.2.73.160'; //DB HOST
$DB_USERNAME_AIRM = 'team_user';  //DB Username
$DB_PASSWORD_AIRM = 'Te@m_us@r987';  //DB Password
$DB_DATABASE_AIRM = 'master_db';  //Datbase Name
$db_AIRM = $DB_DATABASE_AIRM;

$dbConnAirtel = mysql_connect($DB_HOST_AIRM, $DB_USERNAME_AIRM, $DB_PASSWORD_AIRM) or die(mysql_error());
if(!$dbConnAirtel) {
    die('Could not connect to AIRTEL: ' . mysql_error());
}

/*** End Master DB Connection ***/

?>
