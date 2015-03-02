<?php session_start();
 session_destroy();
 //Header("location:index.html");
$redirect = "index.php?logerr=logout";
header("Location: $redirect");
 ?>