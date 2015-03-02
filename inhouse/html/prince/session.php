<?php session_start();
$a=$_SESSION["n1"];
$b=$_SESSION["p1"];
if(empty($a) || empty($b))
{
session_destroy(); 
Header("location:index.html");
}
?>