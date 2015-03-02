<?php
include("db.php");
//get circle
$msisdn=$_REQUEST['msisdn'];
$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
$circle1=mysql_query($getCircle);
list($circle)=mysql_fetch_array($circle1);
if(!$circle)
{ 
$circle='UND';
}
echo $circle;
mysql_close($con); 
?>
