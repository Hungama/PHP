<?php

//-------------inhouse connection-------------------//
$con=mysql_connect("192.168.100.224","ivr","ivr");
if(mysql_error($con))
{
	echo "Failed to connect to MYSQL of Inhouse: " .mysql_error();
}
//-------------Tunetalk connection-------------------//

$livecon=mysql_connect("10.151.41.83","ivr","ivr@123");
if(mysql_error($livecon))
{
	echo "Failed to connect to MYSQL of Tunetalk: " .mysql_error();
}

?>


