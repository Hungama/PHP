<?php
ob_start();
session_start();
require_once("../../2.0/incs/db.php");
$user_id=$_SESSION['loginId'];
$message=$_REQUEST['msg'];
$remoteAdd=trim($_SERVER['REMOTE_ADDR']);
$orgfilename=$_FILES['upfile']['name'];
$added_by='tdb.bulk';

	 if(isset($_FILES['upfile']) && !empty($_FILES['upfile']['name'])) {
	 $orgfilename=$_FILES['upfile']['name'];
	 //check for valid file content start here 
$lines = file($_FILES['upfile']['tmp_name']);
$isok;
$count=0;
foreach ($lines as $line_num => $mobno) 
{
$mno=trim($mobno);
if(!empty($mno))
{
if(is_numeric($mno) && strlen($mno)==10) {
$isok=1;
$count++;
    } else {
$isok=2;
break;
  }
}
  }
if($isok==2)
{
echo "<div width=\"85%\" align=\"left\" class=\"txt\">"; ?>
<div class="alert alert-danger"><?php echo FILEUPLOADEERROR;?></div></div>
<?php
exit;
}
else if($count>20000)
{
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">Please upload file of less than 20,000 numbers otherwise it will not process.</div></div>";
exit;
}
	 
	 $file = $_FILES['upfile'];
		$allowedExtensions = array("txt");
		
		function isAllowedExtension($fileName) {
			global $allowedExtensions;
			return in_array(end(explode(".", $fileName)), $allowedExtensions);
		}
		if(isAllowedExtension($file['name']) && $_REQUEST['upfor']) {			
			$uploadedFor=trim($_REQUEST['upfor']);
			
			$remoteAdd=trim($_SERVER['REMOTE_ADDR']);
			$selMaxId="select max(batch_id)+1 from master_db.bulk_tdbsms_history";
			$qryBatch = mysql_query($selMaxId,$dbConn);
			list($batchId) = mysql_fetch_array($qryBatch);
			
			$SafeFile = explode(".", $_FILES['upfile']['name']);
			
			$makFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".$uploadedFor.".".$SafeFile[1];
			$dbmakFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".$uploadedFor;
		
			$uploaddir = "/var/www/html/kmis/services/hungamacare/smsbulkuploads/TDB/";
			if(!is_dir($uploaddir))
			{
				mkdir($uploaddir);
				chmod($uploaddir,0777);
			}
			$fileCount=$count;
			$path = $uploaddir.$makFileName;
		if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)) {

					$msg = "File uploaded successfully.<br/><br/>";
					$thisTime = date("Y-m-d H:i:s");
	$Uploadquery="insert into master_db.bulk_tdbsms_history(batch_id, file_name, message,added_by, added_on, upload_for,status,total_file_count,ip) values('$batchId', '$dbmakFileName', '$message','$added_by', '$thisTime', '$_POST[upfor]',0,'$fileCount','$remoteAdd')";
					$queryIns = mysql_query($Uploadquery, $dbConn);
 		
$msg = "$orgfilename has been successfully uploaded. Generated Reference ID is $batchId";
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";
				
			} else {
            echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">There seem to be error in the contents of the file. Please check the file you selected for upload.</div></div>";
			}
		} else {
		echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">There seem to be error in the contents of the file. Please check the file you selected for upload.</div></div>";
		}	 
	} 
mysql_close($dbConn);
?>