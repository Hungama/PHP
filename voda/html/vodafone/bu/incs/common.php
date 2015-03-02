<?php
$SList=$_SESSION["access_service"];
$CList=$_SESSION["access_circle"];
$PList=$_SESSION["access_sec"];


	$AR_SList = explode(",",$SList);
	$AR_PList = explode(",",$PList);
	$AR_CList = explode(",",$CList);
	if($SKIP != 1) {
	if(!in_array($PAGE_TAG,$AR_PList)) {
	header("Location: index.php?ERROR=98");exit;		
	}
	}
	
function CurrentPageURL() 
{
return $_SERVER['REQUEST_URI'];

}
?>