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


/*** Live Mis DB Connection ***/

//$LivdbConn = mysql_connect($DB_HOST_LIVE_MIS,$DB_USERNAME_LIVE_MIS,$DB_PASSWORD_LIVE_MIS) or die(mysql_error());
//if (!$LivdbConn) {
  //  die('Could not connect: ' . mysql_error());
//}

/*** live MIS  DB Connection ***/


/*** User DB Connection ***/
if(isset($_SESSION['dbaccess']))
{
	$userDbConn = mysql_connect($$userDbHost, $$userDbUname, $$userDbPassword) or die(mysql_error());
	mysql_select_db($$userDbName, $userDbConn) or die(mysql_error());
}

/*** End User DB Connection ***/



if($_POST['service_info']==1003)
{
	$finalDBConnect="docomo_hungama";

	$userDbHost = "DB_HOST_".strtoupper($finalDBConnect);
	$userDbUname = "DB_USERNAME_".strtoupper($finalDBConnect);
	$userDbPassword = "DB_PASSWORD_".strtoupper($finalDBConnect);
	$userDbName = "DB_DATBASE_".strtoupper($finalDBConnect);
	$subsTableName = "SUBS_TABLE_".strtoupper($finalDBConnect);
	$unSubsTableName = "UNSUBS_TABLE_".strtoupper($finalDBConnect);
	
	$userDbConn = mysql_connect($$userDbHost, $$userDbUname, $$userDbPassword) or die(mysql_error());
	mysql_select_db($$userDbName, $userDbConn) or die(mysql_error());
	
}
if($_POST['service_info']==1005)
{
	$finalDBConnect="docomo_starclub";

	$userDbHost = "DB_HOST_".strtoupper($finalDBConnect);
	$userDbUname = "DB_USERNAME_".strtoupper($finalDBConnect);
	$userDbPassword = "DB_PASSWORD_".strtoupper($finalDBConnect);
	$userDbName = "DB_DATBASE_".strtoupper($finalDBConnect);
	$subsTableName = "SUBS_TABLE_".strtoupper($finalDBConnect);
	$unSubsTableName = "UNSUBS_TABLE_".strtoupper($finalDBConnect);
	
	$userDbConn = mysql_connect($$userDbHost, $$userDbUname, $$userDbPassword) or die(mysql_error());
	mysql_select_db($$userDbName, $userDbConn) or die(mysql_error());
	
}
if($_POST['service_info']==1208)
{
	$finalDBConnect="reliance_cricket";
	$userDbHost = "DB_HOST_".strtoupper($finalDBConnect);
	$userDbUname = "DB_USERNAME_".strtoupper($finalDBConnect);
	$userDbPassword = "DB_PASSWORD_".strtoupper($finalDBConnect);
	$userDbName = "DB_DATBASE_".strtoupper($finalDBConnect);
	$subsTableName = "SUBS_TABLE_".strtoupper($finalDBConnect);
	$unSubsTableName = "UNSUBS_TABLE_".strtoupper($finalDBConnect);
	
	$userDbConn = mysql_connect($$userDbHost, $$userDbUname, $$userDbPassword) or die(mysql_error());
	mysql_select_db($$userDbName, $userDbConn) or die(mysql_error());
	
}
if($_POST['service_info']==1402)
{
	$finalDBConnect="uninor_hungama";
	$userDbHost = "DB_HOST_".strtoupper($finalDBConnect);
	$userDbUname = "DB_USERNAME_".strtoupper($finalDBConnect);
	$userDbPassword = "DB_PASSWORD_".strtoupper($finalDBConnect);
	$userDbName = "DB_DATBASE_".strtoupper($finalDBConnect);
	$subsTableName = "SUBS_TABLE_".strtoupper($finalDBConnect);
	$unSubsTableName = "UNSUBS_TABLE_".strtoupper($finalDBConnect);
	
	$userDbConn = mysql_connect($$userDbHost, $$userDbUname, $$userDbPassword) or die(mysql_error());
	mysql_select_db($$userDbName, $userDbConn) or die(mysql_error());
	
}


?>