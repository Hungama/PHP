<?php	
date_default_timezone_set('Asia/Calcutta');
include("/var/www/html/kmis/services/hungamacare/config/dbConfig.php");
$userDbHost = "DB_HOST_".strtoupper($_SESSION['dbaccess']);
$userDbUname = "DB_USERNAME_".strtoupper($_SESSION['dbaccess']);
$userDbPassword = "DB_PASSWORD_".strtoupper($_SESSION['dbaccess']);
$userDbName = "DB_DATBASE_".strtoupper($_SESSION['dbaccess']);
$subsTableName = "SUBS_TABLE_".strtoupper($_SESSION['dbaccess']);
$unSubsTableName = "UNSUBS_TABLE_".strtoupper($_SESSION['dbaccess']);

/*** Master DB Connection ***/

$dbConn = mysql_connect($DB_HOST_M, $DB_USERNAME_M, $DB_PASSWORD_M) or die(mysql_error());
if (!$dbConn) {
    die('Could not connect1: ' . mysql_error());
}
mysql_select_db($DB_DATABASE_M, $dbConn) or die(mysql_error());

/*** End Master DB Connection ***/



?>