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

 function checkfield() {  
  
   if(document.frm.message.value==""){
		alert("Please enter message.");
		document.frm.message.focus();
		return false;
   }
   if(document.frm.message.value) {
	var iChars = "^\\\'\"<>"; //"#^\\\'/\"<>";
	for (var i = 0; i < document.frm.message.value.length; i++) {
		if (iChars.indexOf(document.frm.message.value.charAt(i)) != -1) {
			alert ("The message has special characters. \nThese are not allowed.\n");
			return false;
        }
    }
   }
   if(document.frm.upfile.value==""){
		alert("Please select a file to upload.");
		document.frm.upfile.focus();
		return false;
   }
   return true;
}

function getRadioValue()
{
	for (index=0; index < document.frm.upload_for.length; index++)
	{
		if (document.frm.upload_for[index].checked) 
		{
			var radioValue = document.frm.upload_for[index].value;
			return radioValue;
			break;
		}
	}
}

function showTable(radioname)
{	
	if(radioname=='p')
	{
		document.getElementById('scrubbing').style.display = 'table-row';
	}
	if(radioname=='e')
	{
		document.getElementById('scrubbing').style.display = 'none';
	}
}

function openWindow()
{
	window.open("smsviewhistory.php","mywindow","menubar=0,resizable=1,width=650,height=500,scrollbars=yes");
}
</script>
</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<?php 
	$service_info=$_REQUEST['service_info'];
	$rest = substr($service_info,0,-2);
	if($rest==12)
		$logoPath='images/RelianceCricketMania.jpg';
	elseif($rest==14)
		$logoPath='images/uninor.jpg';
	else
		$logoPath='images/logo.png';

	include("header.php");
	$timeFrom = mktime(9,30,0);
	$timeTo = mktime(21,30,0);
	$currTime = mktime(date('H'),date('i'),date('s'));

	 if($_SERVER['REQUEST_METHOD']=="POST" && isset($_FILES['upfile']) && !empty($_FILES['upfile']['name'])) 
	{
		$file = $_FILES['upfile'];
		$message = $_POST['message'];
		$allowedExtensions = array("txt");
		function isAllowedExtension($fileName) {
		global $allowedExtensions;
		 return in_array(end(explode(".", $fileName)), $allowedExtensions);
		}

		if(isAllowedExtension($file['name'])) {
			
			$serviceId=trim($_REQUEST['service_info']);			
			$uploadedFor="active";
			if($_POST['upload_for']) {
				$uploadedFor=trim($_POST['upload_for']);
			}
			if(!$ss) $ss='scrubed';
			else $ss=trim($_POST['ss']);
			$ss='scrubed';

			$channelDec=trim($_REQUEST['channel_dec']);
			$remoteAdd=trim($_SERVER['REMOTE_ADDR']);			
			$selMaxId="select max(batch_id)+1 from master_db.bulk_message_history";
			$qryBatch = mysql_query($selMaxId);
			list($batchId) = mysql_fetch_array($qryBatch);

			if($batchId == "" || $batchId == "0" || $batchId == NULL) { $batchId = 1; }

			$SafeFile = explode(".", $_FILES['upfile']['name']);
			
			$makFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".$serviceId."_".$uploadedFor.".".$SafeFile[1];

			$dbMakFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".$serviceId."_".$uploadedFor;
			
			$makLckFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".$serviceId."_".$uploadedFor.".lck";

			$uploaddir = "smsbulkuploads/".$serviceId."/";
			if(!is_dir($uploaddir))
			{
				mkdir($uploaddir);
				chmod($uploaddir,0777);
			}

			$path = $uploaddir.$makFileName;
			$lckpath = $uploaddir.$makLckFileName;

			if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)){

			$file_to_read="http://10.2.73.156/kmis/services/hungamacare/smsbulkuploads/".$_POST['service_info']."/".$makFileName;
			$file_data=file($file_to_read);
			$file_size=sizeof($file_data);
			
			$msg = "File uploaded successfully.<br/><br/>";
			$fp = fopen($path, "r") or die("Couldn't open $filename");
			$currTime = date("Y-m-d H:i:s");			
			
			$message1 = str_replace("#","%23",$message);

			$UploadMsgQuery="insert into master_db.tbl_message_data(message, added_on, service_id) values('".$message1."', '".$currTime."', '".$_POST[service_info]."')";
			$msgQueryIns = mysql_query($UploadMsgQuery);

			$selMsgId="select max(msg_id) from master_db.tbl_message_data";
			$qryMsg = mysql_query($selMsgId);
			list($msg_id) = mysql_fetch_array($qryMsg);	
		

			$Uploadquery="insert into master_db.bulk_message_history(batch_id,file_name,msg_id,added_by,added_on,upload_for,status,operator,total_file_count, service_id, ip,scrubingStatus) values('".$batchId."', '".$dbMakFileName."', '".$msg_id."', '".$_SESSION[loginId]."', '".$currTime."','".$uploadedFor."',0,'".$_SESSION[dbaccess]."','".$file_size."','".$_POST[service_info]."','".$remoteAdd."','".$ss."')";
			$queryIns = mysql_query($Uploadquery);

			$msg = 'File <b>'.$makFileName.'<b> uploaded successfully.<br/><a href="selectservice.php">
			<B><FONT COLOR="#FF0000">Home</FONT></a></B>';

			//<a href=\"javascript:void(0);\" onclick=\"openWindow()\" class=\"blue\">View Upload History</a>
			} else {
                $msg = "File cannot be uploaded successfully.";
			}
		} else {
			$msg = "Invalid file type. Please upload text file only.";
		}
	}
if(!isset($_POST['Submit']))
	{
	if($currTime >= $timeFrom && $currTime <= $timeTo ) {
?>
<TABLE width="80%" align="center" border="0" cellpadding="0" cellspacing="0" class="txt">
      <TBODY>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><a href='selectservice.php'>
			<B><FONT COLOR="#FF0000">Home</FONT></a></B> || <B><a href="viewBulkSMShistory.php"><FONT COLOR="#FF0000">View SMS Bulk Queue</font></a></B>
		</TD>
      </TR></TABLE>	  
 <form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()" enctype="multipart/form-data">
    <TABLE width="50%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
      <TBODY>      
		<?php
		// to Fetch the record for the service Name

		$get_service_name="select servicename,serviceid from master_db.tbl_app_service_master where serviceid=".$_GET['service_info'];
		$result_query=mysql_query($get_service_name,$dbConn);
		
		// end codfe to fetch the record for Sevice name

		// to Fetch the record for the service Name
			
		$plan_record=array();
		$get_plan_info="select plan_id,iamount from master_db.tbl_plan_bank where s_id=".$_GET['service_info'];
		$plan_result_query=mysql_query($get_plan_info,$dbConn);
		?>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Service Type</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
			<?php
				$service_record=mysql_fetch_row($result_query);
				echo "<b>".$service_record[0]."</b>";
				if($_REQUEST['service_info'] == 1509) {
					echo "<b>Airtel Miss Riya</b>";
				} //non scrubbing 
			?>
			<input type='hidden' name='service_info' value="<?php echo $_GET['service_info'];?>">
		</TD>
      </TR>		
	  <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Message For</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
			<INPUT TYPE="radio" NAME="upload_for" value="promotion" checked> PROMOTIONAL <!-- onclick="showTable('p');"  onclick="showTable('e');"-->
			<INPUT TYPE="radio" NAME="upload_for" value="engagement" > ENGAGEMENT 
		</TD>
      </TR>
	  <TR height="30" id="scrubbing">
        <TD bgcolor="#FFFFFF"><B>Scrubbing Status</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
			<INPUT TYPE="radio" NAME="ss" value="scrubed"> Scrubbing
			<INPUT TYPE="radio" NAME="ss" value="nonscrubed" checked> Non-Scrubbing 
		</TD>
      </TR>
	  <TR height="30">
        <TD bgcolor="#FFFFFF" valign="top"><B>Message</B></TD>
        <TD bgcolor="#FFFFFF" valign="top">&nbsp;&nbsp;<textarea name="message" id="message" cols="40" rows="4" maxlength="400"></textarea></TD>
      </TR>
	  <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Browse File To Upload <FONT COLOR="#FF0000">[.txt file]</B><br/>(text file must contain one 10 digit msisdn per line)</FONT></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<INPUT name="upfile" id='upfile' type="file" class="in"></TD>
      </TR>
      <TR height="30">
        <TD align="center" colspan="2" bgcolor="#FFFFFF"><input name="Submit" type="submit" class="txtbtn" value="Upload" onSubmit="return checkfield();"/></TD>
     </TR>
  </TBODY>
  </TABLE>
  </form>  
  <br/><br/>
  <?php } else { ?>
	<div align='center'>You can upload files for sms in between 9:30am to 9:30pm!<br/> Please try again</div>
  <?php	}?>
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