<?php
session_start();
error_reporting(1);
require_once("incs/db.php");
require_once("language.php");
//check for existing session
if(empty($_SESSION['loginId_voda']))
{
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
		<div class=\"alert alert-danger\">Your session has timed out. Please login again.</div></div>";
exit;
}
else
{
$uploadeby_voda=$_SESSION['loginId_voda'];
}
if(isset($_FILES['upfile']) && !empty($_FILES['upfile']['name'])) {
$bulklimit=$_POST['bulklimit'];
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
else if($count>50000)
{
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">Please upload file of less than 50,000 numbers otherwise it will not process.</div></div>";
exit;
}
			$file = $_FILES['upfile'];
			$message = addslashes($_POST['message']);
			$serviceId=trim($_REQUEST['service_info']);			
			$uploadedFor="active";
			if($_POST['upload_for']) {
				$uploadedFor=trim($_POST['upload_for']);
			}
			

			$channelDec=trim($_REQUEST['channel_dec']);
			$remoteAdd=trim($_SERVER['REMOTE_ADDR']);			
			$selMaxId="select max(batch_id)+1 from master_db.bulk_message_history";
			$qryBatch = mysql_query($selMaxId,$dbConn);
			list($batchId) = mysql_fetch_array($qryBatch);

			if($batchId == "" || $batchId == "0" || $batchId == NULL) { $batchId = 1; }

			$SafeFile = explode(".", $_FILES['upfile']['name']);
			
			$makFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".$serviceId."_".$uploadedFor.".".$SafeFile[1];

			$dbMakFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".$serviceId."_".$uploadedFor;
			
			$makLckFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".$serviceId."_".$uploadedFor.".lck";

			$uploaddir = "../smsbulkuploads/".$serviceId."/";
			if(!is_dir($uploaddir))
			{
				mkdir($uploaddir);
				chmod($uploaddir,0777);
			}

			$path = $uploaddir.$makFileName;
			$lckpath = $uploaddir.$makLckFileName;

			if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path))
			{

			$file_size=$count;
			
			
			$channelDec=trim($_REQUEST['channel_dec']);
			$currTime = date("Y-m-d H:i:s");			
			
			$message1 = str_replace("#","%23",$message);

			if($_REQUEST['dpd2'])
			$scheduleDate=$_REQUEST['dpd2'];
			else
			$scheduleDate = date("Y-m-d H:i:s");
			
			$UploadMsgQuery="insert into master_db.tbl_message_data(message, added_on, service_id) values('".$message1."', '".$currTime."', '".$serviceId."')";
			$msgQueryIns = mysql_query($UploadMsgQuery,$dbConn);

			$selMsgId="select max(msg_id) from master_db.tbl_message_data";
			$qryMsg = mysql_query($selMsgId,$dbConn);
			list($msg_id) = mysql_fetch_array($qryMsg);	
			$Uploadquery="insert into master_db.bulk_message_history(batch_id,file_name,msg_id,added_by,added_on,upload_for,status,operator,total_file_count, service_id, ip,scheduleDate) values('".$batchId."', '".$dbMakFileName."', '".$msg_id."', '".$uploadeby_voda."', '".$currTime."','active',0,'voda','".$file_size."','".$serviceId."','".$remoteAdd."','".$scheduleDate."')";
			$queryIns = mysql_query($Uploadquery,$dbConn);
			
			$msg = $orgfilename." has been successfully uploaded. Generated Reference ID is ".$batchId;
				echo "<div width=\"85%\" align=\"left\" class=\"txt\"><div class=\"alert alert-success\">$msg</div></div>";
				
			} else {
               echo "<div width=\"85%\" align=\"left\" class=\"txt\">
				<div class=\"alert alert-danger\">There seem to be error in the contents of the file. Please check the file you selected for upload.</div></div>";
			}
		  			
			
}
exit;
?>