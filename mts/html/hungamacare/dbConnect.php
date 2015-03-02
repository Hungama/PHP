<?php	
date_default_timezone_set('Asia/Calcutta');
include_once("dbConfig.php");
$userDbHost = "DB_HOST_".strtoupper($_SESSION['dbaccess']);

$userDbUname = "DB_USERNAME_".strtoupper($_SESSION['dbaccess']);
$userDbPassword = "DB_PASSWORD_".strtoupper($_SESSION['dbaccess']);
$userDbName = "DB_DATBASE_".strtoupper($_SESSION['dbaccess']);
$subsTableName = "SUBS_TABLE_".strtoupper($_SESSION['dbaccess']);
$unSubsTableName = "UNSUBS_TABLE_".strtoupper($_SESSION['dbaccess']);


/*** Master DB Connection ***/

$dbConn = mysql_connect($DB_HOST_M, $DB_USERNAME_M, $DB_PASSWORD_M) or die(mysql_error());

if (!$dbConn) {
    die('Could not connect: ' . mysql_error());
}
//mysql_select_db($DB_DATABASE_M, $dbConn) or die(mysql_error());

/*** End Master DB Connection ***/


/*** User DB Connection ***/
if(isset($_SESSION['dbaccess']))
{
	$userDbConn = mysql_connect($$userDbHost, $$userDbUname, $$userDbPassword) or die(mysql_error());
	//mysql_select_db($userDbName, $userDbConn) or die(mysql_error());
}

/*** End User DB Connection ***/

 $DB_HOST_LIVE_MIS     = '192.168.100.218'; //DB HOST
 $DB_USERNAME_LIVE_MIS = 'php'; //'amit.khurana';  //DB Username
 $DB_PASSWORD_LIVE_MIS = 'php'; //'hungama';  //DB Password
 $DB_DATBASE_LIVE_MIS = 'misdata';  //Datbase Name
 $db_LIVE_MIS = $DB_DATBASE_LIVE_MIS;


$LivdbConn = mysql_connect($DB_HOST_LIVE_MIS,$DB_USERNAME_LIVE_MIS,$DB_PASSWORD_LIVE_MIS);
if (!$LivdbConn) {
  //  die('Could not connect: ' . mysql_error());
}
?>
