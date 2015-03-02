<?php	
//include("dbConfig.php");
/*** Master DB Connection ***/

$dbConn = mysql_connect("119.82.69.210","weburl","weburl") or die(mysql_error());
if (!$dbConn) {
    die('Could not connect: ' . mysql_error());
}
//mysql_select_db($DB_DATABASE_M, $dbConn) or die(mysql_error());

/*** End Master DB Connection ***/


/*** User DB Connection ***/
/*if(isset($_SESSION['dbaccess']))
{
	$userDbConn = mysql_connect($$userDbHost, $$userDbUname, $$userDbPassword) or die(mysql_error());
	mysql_select_db($$userDbName, $userDbConn) or die(mysql_error());
}

/*** End User DB Connection ***/




	
/*
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
*/


?>