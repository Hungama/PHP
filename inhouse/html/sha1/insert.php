<?php
$con = mysql_connect("119.82.69.210","Shashank","Shashank123");
if(!$con)
           {
		     die('could not connect1: ' . mysql_error());
      	  }
 mysql_select_db("test_shilpi",$con);
 $result=mysql_query("select * from tbl_jbox_subscription limit 10");
 while($row=mysql_fetch_array($result))
 {
	$a1=$row['ani'];
	$a2=$row['sub_date'];
	echo $a1;
	echo $a2;
 }
?>
