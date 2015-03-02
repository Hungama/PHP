<?php
session_start();
require_once("db.php");

$obd_file=$_FILES['upfile']['name'];
$obd_name=$_REQUEST['obd_name'];
$obd_description=$_REQUEST['obd_description'];
echo $obd_description."****".$obd_name;
exit;
$filepath='';
if(isset($_FILES['upfile']) && !empty($_FILES['upfile']['name'])) {
 
$i = strrpos($obd_file,".");
$l = strlen($obd_file) - $i;
$ext = substr($obd_file,$i+1,$l);
//$ext='txt';
$selMaxId="select max(id)+1 from master_db.obd_upload_history";
			$qryBatch = mysql_query($selMaxId,$con);
			list($id) = mysql_fetch_array($qryBatch);
			
$createfilename= $id'.'.$ext;
$pathtofile= "prompt/".$createfilename;
if(copy($_FILES['upfile']['tmp_name'], $pathtofile))
{
$sql="INSERT INTO master_db.obd_upload_history (id,obd_name,description,filepath,added_on,status)
VALUES ('".$id."','".$obd_name."','".$obd_description."','".$filepath."',now(),'0')";
if (mysql_query($sql,$con))
  {
  $msg='File Uploaded Successfully.';
  echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";
  }
  else 
  {
 echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">File can not be uploaded. There are some errors in file.Please check and upload again.</div></div>";
  }
 }
}
 else
  {
  echo 'No File';
  }

exit;
?>