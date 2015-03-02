<?php
session_start();
if(isset($_SESSION['authid']))
{
	include("config/dbConnect.php");	

?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>Hungama Customer Care</title>
<link rel="stylesheet" href="style.css" type="text/css">
<style type="text/css">
<!--
.style3 {font-family: "Times New Roman", Times, serif}
-->
</style>
<script language="javascript">
function logout()
{
	window.parent.location.href = 'index.php?logerr=logout';
}
</script>
<script language="javascript">

 function checkfield(){
  
   if(document.getElementById('servicename').value==""){
		alert("Please select a Service.");
		document.getElementById('servicename').focus();
		return false;
   }
   if(document.frm.upfile.value==""){
		alert("Please select a file to upload.");
		document.frm.upfile.focus();
		return false;
   }
   return true;
}

function openWindow(sid)
{
	window.open("viewhistory.php?sid="+sid,"mywindow","menubar=0,resizable=1,width=650,height=500,scrollbars=yes");
}
</script>
</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<?php 
	include("header.php");
	 if($_SERVER['REQUEST_METHOD']=="POST" && isset($_FILES['upfile']) && !empty($_FILES['upfile']['name'])) 
	{
		$file = $_FILES['upfile'];
		$allowedExtensions = array("txt");
		function isAllowedExtension($fileName) {
		global $allowedExtensions;
		 return in_array(end(explode(".", $fileName)), $allowedExtensions);
		}

		if(isAllowedExtension($file['name'])) {			

			$uploadedFor=trim($_REQUEST['upfor']);
			$serviceId=trim($_REQUEST['servicename']);
			$remoteAdd=trim($_SERVER['REMOTE_ADDR']);

			$selMaxId="select max(batch_id)+1 from master_db.bulk_remove_history";
			$qryBatch = mysql_query($selMaxId);
			list($batchId) = mysql_fetch_array($qryBatch);

			if(!$batchId) $batchId=1;
			
			$SafeFile = explode(".", $_FILES['upfile']['name']);
			
			$makFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".$serviceId.".".$SafeFile[1];

			$dbMakFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".$serviceId;
			
			$makLckFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".$serviceId.".lck";

			$uploaddir = "bulkRuploads/".$serviceId."/";
			if(!is_dir($uploaddir))
			{
				mkdir($uploaddir);
				chmod($uploaddir,0777);
			}
			$uploadlogdir = "bulkRuploads/".$serviceId."/log/";
			if(!is_dir($uploadlogdir))
			{
				mkdir($uploadlogdir);
				chmod($uploadlogdir,0777);
			}


			$path = $uploaddir.$makFileName;
			$lckpath = $uploaddir.$makLckFileName;

			if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)){

			$file_to_read="http://10.2.73.156/kmis/services/hungamacare/bulkRuploads/".$serviceId."/".$makFileName;
			
			$file_data=file($file_to_read);
			$file_size=sizeof($file_data);
				if($file_size <= 1000 || $_SESSION['usrId']==72) {
					$msg = "File uploaded successfully.<br/><br/>";
					$fp = fopen($path, "r") or die("Couldn't open $filename");
					$succCount=0;
					$failCount=0;
					$thisTime = date("Y-m-d H:i:s");
					
					$Uploadquery="insert into master_db.bulk_remove_history(batch_id, file_name, added_by, added_on, status, total_file_count, service_id, ip,process_time) values('".$batchId."', '".$makFileName."', '$_SESSION[loginId]', '$thisTime',0, '$file_size', '$serviceId', '".$remoteAdd."','')";

					$queryIns = mysql_query($Uploadquery); 
					

					$msg = "File <b>$makFileName<b> uploaded successfully.<br/>"; 
				} else {
					$msg = "File Contains more than 1000 MDN. Please try again";
				}
			} else {
                $msg = "File cannot be uploaded successfully.";
			}
		} else {
			$msg = "Invalid file type. Please upload text file only.";
		}
	}
if(!isset($_POST['Submit']))
	{
?> 
 <form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()" enctype="multipart/form-data">
    <TABLE width="50%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
      <TBODY>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Upload For</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;Remove Failure Data</TD>
      </TR>
	<?php

	// to Fetch the record for the service Name
	
	$get_service_name="select service_id,service_name from master_db.tbl_service_master";
	$result_query=mysql_query($get_service_name,$dbConn);
	
	// end codfe to fetch the record for Sevice name

	// to Fetch the record for the service Name
		
	$plan_record=array();
	$get_plan_info="select plan_id,iamount from master_db.tbl_plan_bank where sname=$_GET[service_info]";
	$plan_result_query=mysql_query($get_plan_info,$dbConn);
	
	// end codfe to fetch the record for Sevice name
	?>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Service Name</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name="servicename" id="servicename" class="in">
				<option value="">Select service name</option>
				<option value="1509">Airtel Miss Riya</option>
				<?php // while($row1=mysql_fetch_array($result_query)) { ?>
					<!-- <option value='<?php echo $row1['service_id']?>'><?php echo $row1['service_name']?></option> -->
				<?php // } ?>
			</select>
		</TD>
      </TR>		  
	  <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Browse File To Upload <FONT COLOR="#FF0000">[.txt file]</B><br/>(text file must contain one 10 digit msisdn per line)</FONT></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<INPUT name="upfile" id='upfile' type="file" class="in"></TD>
      </TR>
      <TR height="30">
        <td align="center" colspan="2" bgcolor="#FFFFFF">
			<input name="Submit" type="submit" class="txtbtn" value="Upload" onSubmit="return checkfield();"/>			
       </td>
     </TR>
  </TBODY>
  </TABLE>
  </form>
  
  <br/><br/>
<?php }?>
<?php echo "<div align='center' class='txt'><B>".$msg."</B></div>"; ?>
<br/><br/><br/><br/><br/><br/><br/><br/><br/>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody>
  <tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
  <tr> 
    <td class="footer" align="right" bgcolor="#ffffff"><b>Powered by Hungama</b></td>
  </tr><tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
</tbody></table>
</body>
</html>
<?php
	mysql_close($dbConn);
}
else
{
	header("Location:index.php");
}
?>