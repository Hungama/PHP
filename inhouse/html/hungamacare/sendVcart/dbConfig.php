<?php
//MASTER DATABASE ACCESS VARIABLES
 $DB_HOST_M     = '192.168.100.224'; //DB HOST
 $DB_USERNAME_M = 'webcc';  //DB Username
 $DB_PASSWORD_M = 'webcc';//DB Password
 $dbConn = mysql_connect($DB_HOST_M, $DB_USERNAME_M, $DB_PASSWORD_M) or die(mysql_error());
if (!$dbConn) {
    die('Could not connect: ' . mysql_error());
}
?>