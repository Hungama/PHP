<?php

date_default_timezone_set('Asia/Calcutta');


/*** VODA Master DB Connection ***/
//MASTER DATABASE ACCESS VARIABLES
 $DB_HOST_VODA     = '203.199.126.129';		//'10.43.248.137'; //DB HOST
 $DB_USERNAME_VODA = 'team_user';  //DB Username
 $DB_PASSWORD_VODA = 'teamuser@voda#123'; //'Te@m_us@r987';  //DB Password
 $DB_DATABASE_VODA = 'master_db';  //Datbase Name
 $db_VODA = $DB_DATABASE_VODA;

$dbConnVoda = mysql_connect($DB_HOST_VODA, $DB_USERNAME_VODA, $DB_PASSWORD_VODA) or die(mysql_error());
if (!$dbConnVoda) {
    die('Could not connect to Voda: ' . mysql_error());
}

/*** End Master DB Connection ***/

// LIVE MIS Database

 $DB_HOST_LIVE_MIS     = '192.168.100.218'; //DB HOST
 $DB_USERNAME_LIVE_MIS = 'amit.khurana';  //DB Username
 $DB_PASSWORD_LIVE_MIS = 'hungama';  //DB Password
 $DB_DATBASE_LIVE_MIS = 'misdata';  //Datbase Name
 $db_LIVE_MIS = $DB_DATBASE_LIVE_MIS;

/*** Live Mis DB Connection ***/

$LivdbConn = mysql_connect($DB_HOST_LIVE_MIS,$DB_USERNAME_LIVE_MIS,$DB_PASSWORD_LIVE_MIS); // or die(mysql_error());
if (!$LivdbConn) {
   //die('Could not connect: ' . mysql_error());
   echo "Live Database could not connect";
}

?>