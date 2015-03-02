<?php

$dbConn = mysql_connect('10.2.73.160','team_user','Te@m_us@r987');
if (!$dbConn)
{
    die('Could not connect: ' . mysql_error());
}

?>