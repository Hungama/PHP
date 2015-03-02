<?php
include 'db.php';
$optid=$_REQUEST['p'];

if($optid=='' || $optid=='#')
	include("mainMenu.php");
elseif($optid=='01' || $optid=='1')
	include("menu1.php");
elseif($optid=='02' || $optid=='2')
	include("menu2.php");
elseif($optid=='03' || $optid=='3')
	include("menu3.php");
elseif($optid=='04' || $optid=='4')
	include("menu4.php");
else
	echo "Invalid option";

?>