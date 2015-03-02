<?php

require_once("../../../cmis/base.php");
header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');


$Q = $_REQUEST['q'];
$Output = array();

$array = array_keys($CMAP);
$Data = preg_grep('/'.$Q.'/i', $array);


foreach($Data as $id=>$element) {
	
	array_push($Output,array('id'=>$element,'name'=>$element));
	
}
echo json_encode($Output);

?>