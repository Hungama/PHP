<?php
require_once("../../../Public/database.class.php");
header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');


$Q = $_REQUEST['q'];
$Output = array();
$Query = mysql_query("select concat(fname, ' ', IF(lname IS NOT NULL,lname,'')) as Name, username from usermanager where username like '".$Q."%' order by username asc") or die(mysql_error());
while($Data = mysql_fetch_array($Query)) {
	
	array_push($Output,array('id'=>$Data['username'],'name'=>$Data['username']));
	
}
echo json_encode($Output);

?>