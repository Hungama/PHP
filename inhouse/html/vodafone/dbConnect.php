<?php	
date_default_timezone_set('Asia/Calcutta');
include("dbConfig.php");

/*** Master DB Connection ***/

$dbConn = mysql_connect($DB_HOST_M,$DB_USERNAME_M,$DB_PASSWORD_M) or die(mysql_error());
if (!$dbConn) {
    die('Could not connect1: ' . mysql_error());
}
mysql_select_db($DB_DATABASE_M, $dbConn) or die(mysql_error());

?>
