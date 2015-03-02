<?php 
include("session.php");
error_reporting(0);
//include database connection string
require_once("../2.0/incs/db.php");
require_once("../2.0/language.php");
$dateStr=$_REQUEST['selDate'];
$S_id=$_REQUEST['S_id'];
$selDate = date("Y-m-d",strtotime($dateStr));
$type=$_REQUEST['type'];
$f_array = array_flip($serviceArray);
$data_query= "select S_id,msg_type,msg_desc,circle,kci_type,priority from Inhouse_IVR.tbl_smskci_serviceMsgDetails where S_id='".$S_id."'";

$obd_data = mysql_query($data_query, $dbConn);
$result_row=mysql_num_rows($obd_data);

$excellFile="TSV-".date("Ymd").".txt";
$excellFilePath=$excellDirPath.$excellFile;

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$excellFile");
echo "Service#MessageType#Message#Circle#KCITYPE#Priority"."\r\n";

while($mis_array=mysql_fetch_array($obd_data))
	{
	$S_id=$mis_array['S_id'];
	$msg_type=$mis_array['msg_type'];
	$msg_desc=trim($mis_array['msg_desc']);
	$circle=$mis_array['circle'];
	$kci_type=$mis_array['kci_type'];
	$priority =$mis_array['priority'];
	echo $f_array[$S_id]."#".$msg_type."#".$msg_desc."#".$circle."#".$kci_type."#".$priority."\r\n";
	}
mysql_close($dbConn);
header("Pragma: no-cache");
header("Expires: 0");
?>