<?php
$host = "10.130.14.106";
$uname = "ivr";
$pass = "ivr";
$database = "Mts_tmp";

$connection=mysql_connect($host,$uname,$pass) or die("connection in not ready <br>");
$result=mysql_select_db($database) or die("database cannot be selected <br>");

if (isset($_REQUEST['query'])) {

	$query = $_REQUEST['query'];
	
	$sql = mysql_query ("SELECT * FROM country WHERE country LIKE '%{$query}%'");
	$array = array();
	
	while ($row = mysql_fetch_assoc($sql)) {
		$array[] = $row['country'];
	}
	
	echo json_encode ($array); //Return the JSON Array

}

?>
