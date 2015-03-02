<?php
//MASTER DATABASE ACCESS VARIABLES
 $DB_HOST_M     = '10.43.248.137'; //DB HOST
 $DB_USERNAME_M = 'team_user';  //DB Username
 $DB_PASSWORD_M = 'teamuser@voda#123'; //'Te@m_us@r987';  //DB Password
 $dbConn = mysql_connect($DB_HOST_M, $DB_USERNAME_M, $DB_PASSWORD_M) or die(mysql_error());
if (!$dbConn) {
    die('Could not connect: ' . mysql_error());
}
?>