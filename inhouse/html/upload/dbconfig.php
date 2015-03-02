<?php

$con=mysql_connect("192.168.100.224","ivr","ivr");


if(mysql_error($con))
{
	echo "Failed to connect to MYSQL: " .mysql_error();
}

?>
