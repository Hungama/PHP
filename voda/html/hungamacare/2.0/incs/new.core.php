<?php


if(isset($_REQUEST['Service'])) {
	$Service = "'".join("','", $_REQUEST['Service'])."'";
	$GRP_Service = "Service[]=".str_replace(" ","+",join("&Service[]=",$_REQUEST['Service']))."";
} else{
    $Service = '';
	$GRP_Service = '';
}


if(isset($_REQUEST['Circle'])) {
	$Circle = "'".join("','", $_REQUEST['Circle'])."'";
	$GRP_Circle = "Circle[]=".str_replace(" ","+",join("&Circle[]=",$_REQUEST['Circle']))."";
    //$Circle = '';
} else {
    $Circle = '';
	$GRP_Circle = '';
    
}

?>