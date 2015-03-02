<?php 
include("session.php");
error_reporting(0);
//include database connection string
require_once("../2.0/incs/db.php");
$dateStr=$_REQUEST['selDate'];
$S_id=$_REQUEST['S_id'];
$selDate = date("Y-m-d",strtotime($dateStr));
$type=$_REQUEST['type'];
$data_query= "select S_id,msg_type,msg_desc,circle,kci_type,priority from Inhouse_IVR.tbl_smskci_serviceMsgDetails where S_id='".$S_id."'";
$obd_data = mysql_query($data_query, $dbConn);
$result_row=mysql_num_rows($obd_data);
//$excellFile="TSV-".date("Ymd").".csv";
$excellFile="TSV-".date("Ymd").".xls";
$excellFilePath='csv/'.$excellFile;
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$excellFile");
if ($result_row > 0) {
$fp=fopen($excellFile,'a+');
fwrite($fp,'Service'."\t".'MessageType'."\t".'Message'."\t".'Circle'."\t".'KCITYPE'."\t".'Priority'."\r\n");
while($mis_array=mysql_fetch_array($obd_data))
	{
	$S_id=$mis_array['S_id'];
	$msg_type=$mis_array['msg_type'];
	$msg_desc=$mis_array['msg_desc'];
	$circle=$mis_array['circle'];
	$kci_type=$mis_array['kci_type'];
	$priority =$mis_array['priority'];
	$data=$S_id."\t".$msg_type."\t".$msg_desc."\t".$circle."\t".$kci_type."\t".$priority."\r\n";
	utf8_encode($data);
	$somecontent = mb_convert_encoding($data, 'HTML-ENTITIES', "UTF-8");

	fwrite($fp,$somecontent);
	}
	}
fclose($fp);
mysql_close($dbConn);
header("Pragma: no-cache");
header("Expires: 0");
?>