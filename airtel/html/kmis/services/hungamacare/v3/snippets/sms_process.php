<?php
ob_start();
session_start();
require_once("../../2.0/incs/db.php");
$circle=$_REQUEST['circle'];
$msg=$_REQUEST['msg'];
$optionsRadios=$_REQUEST['service_base'];

$msg = $circle."***".$msg."***".$optionsRadios;
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";
?>