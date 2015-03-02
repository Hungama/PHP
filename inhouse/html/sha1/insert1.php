<?php
echo "Welcome to insertion page";
 if($username=="test" && $password="test")
   {
	 echo "Create MySql Connection";
	 $con = mysql_connect("119.82.69.210:3030","Shashank","Shashank123");
	 if (!$con)
		{
		die('Could not connect: ' . mysql_error());
		}
     }
?>