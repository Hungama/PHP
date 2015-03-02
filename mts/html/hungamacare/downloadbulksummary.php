<?
$file_name=$_GET['filename'];
$service_id=$_GET['service_id'];
header("Location: http://10.130.14.107/hungamacare/status/".$service_id."/".$file_name);
?>