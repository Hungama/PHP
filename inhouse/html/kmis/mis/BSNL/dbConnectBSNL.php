<?php
$dbConn = mysql_connect('59.90.196.159:3500', 'root', 'redhat');
if (!$dbConn) {
    die('Could not connect: ' . mysql_error());
}
else
{
echo 'DB Connection OK.';
}
mysql_close($dbConn);
 ?>
