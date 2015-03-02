<?php
/*
$con = mysql_connect("10.2.73.156","billing","billing");
if(!$con)
{
	die('could not connect1: ' . mysql_error());
}
mysql_select_db("airtel_hungama",$con);
*/	

include("/var/www/html/kmis/services/hungamacare/config/dbConfig.php");
$userDbHost = "DB_HOST_".strtoupper($_SESSION['dbaccess']);
$userDbUname = "DB_USERNAME_".strtoupper($_SESSION['dbaccess']);
$userDbPassword = "DB_PASSWORD_".strtoupper($_SESSION['dbaccess']);
$userDbName = "DB_DATBASE_".strtoupper($_SESSION['dbaccess']);
$subsTableName = "SUBS_TABLE_".strtoupper($_SESSION['dbaccess']);
$unSubsTableName = "UNSUBS_TABLE_".strtoupper($_SESSION['dbaccess']);

/*** Master DB Connection ***/

$dbConn = mysql_connect($DB_HOST_M, $DB_USERNAME_M, $DB_PASSWORD_M) or die(mysql_error()); // mysql_connect('10.2.73.160','team_user','Te@m_us@r987'); 
if (!$dbConn) 
{
    die('Could not connect: ' . mysql_error());
}
mysql_select_db($DB_DATABASE_M, $dbConn) or die(mysql_error());
if($_POST['service_info']==1503)
{
	$finalDBConnect="airtel_hungama";

	$userDbHost = "DB_HOST_".strtoupper($finalDBConnect);
	$userDbUname = "DB_USERNAME_".strtoupper($finalDBConnect);
	$userDbPassword = "DB_PASSWORD_".strtoupper($finalDBConnect);
	$userDbName = "DB_DATBASE_".strtoupper($finalDBConnect);
	$subsTableName = "SUBS_TABLE_".strtoupper($finalDBConnect);
	$unSubsTableName = "UNSUBS_TABLE_".strtoupper($finalDBConnect);
	
	$userDbConn = mysql_connect($$userDbHost, $$userDbUname, $$userDbPassword) or die(mysql_error());
	mysql_select_db($$userDbName, $userDbConn) or die(mysql_error());
	
}
if($_POST['service_info']==1502)
{
	$finalDBConnect="airtel_hungama";

	$userDbHost = "DB_HOST_".strtoupper($finalDBConnect);
	$userDbUname = "DB_USERNAME_".strtoupper($finalDBConnect);
	$userDbPassword = "DB_PASSWORD_".strtoupper($finalDBConnect);
	$userDbName = "DB_DATBASE_".strtoupper($finalDBConnect);
	$subsTableName = "SUBS_TABLE_".strtoupper($finalDBConnect);
	$unSubsTableName = "UNSUBS_TABLE_".strtoupper($finalDBConnect);
	
	$userDbConn = mysql_connect($$userDbHost, $$userDbUname, $$userDbPassword) or die(mysql_error());
	mysql_select_db($$userDbName, $userDbConn) or die(mysql_error());
	
}

if($_POST['service_info']==1507)
{
	$finalDBConnect="airtel_vh1";

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
