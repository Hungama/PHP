<?php
error_reporting(0);
$db_link = mysql_connect('localhost', 'root', '');
if(!$db_link)
{
	die('Could not select database: ' . mysql_error());
}
mysql_select_db('uninor_chat', $db_link) or die('Could not connect database:'. mysql_error());
?>