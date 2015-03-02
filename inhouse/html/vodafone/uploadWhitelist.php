<?php
session_start();
if(isset($_SESSION['authid']))
{
	include("dbConnect.php");
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
  
  var radioValue;
  radioValue=getRadioValue();

  if((document.getElementById('channel').value=="") && (document.getElementById('channel_dec').value=="")){
		alert("Please select a channel.");
		return false;
   }
   if(document.getElementById('price').value=="" && radioValue=='active'){
		alert("Please select a price point.");
		document.getElementById('price').focus();
		return false;
   }
   if(document.frm.upfile.value==""){
		alert("Please select a file to upload.");
		document.frm.upfile.focus();
		return false;
   }
   return true;
}

function showTable(radioname)
{
	if(radioname=='a')
	{
		document.getElementById('price12').style.display = 'table-row';
		document.getElementById('chanel12').style.display = 'table-row';
		document.getElementById('chanel13').style.display = 'none';
	}
	if(radioname=='d')
	{
		document.getElementById('channel').value='';
		document.getElementById('chanel12').style.display = 'none';
		document.getElementById('price12').style.display = 'none';
		document.getElementById('chanel13').style.display = 'table-row';
	}
}
function getRadioValue()
{
	for (index=0; index < document.frm.upfor.length; index++)
	{
		if (document.frm.upfor[index].checked) 
		{
			var radioValue = document.frm.upfor[index].value;
			return radioValue;
			break;
		}
	}
}
function openWindow()
{
	window.open("viewhistory.php","mywindow","menubar=0,resizable=1,width=650,height=500,scrollbars=yes");
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
	$msg = "";
	if($_SERVER['REQUEST_METHOD']=="POST" && (( isset($_FILES['upfile']) && !empty($_FILES['upfile']['name'])) && ($_REQUEST['upload'] ))) {	
		$uploadedFor = $_REQUEST['upload'];

		$file = $_FILES['upfile'];
		$allowedExtensions = array("txt");
		function isAllowedExtension($fileName) {
			global $allowedExtensions;
			return in_array(end(explode(".", $fileName)), $allowedExtensions);
		}
		$SafeFile = explode(".", $_FILES['upfile']['name']);
			
		$makFileName = $SafeFile[0]."_".$uploadedFor.".".$SafeFile[1];
		$logFileName = $SafeFile[0]."_".$uploadedFor."_log_".date('Ymdhis').".".$SafeFile[1];

		$uploaddir = "whitelistuploads/".$uploadedFor."/";
		$path = $uploaddir.$makFileName;
		
		if(isAllowedExtension($file['name'])) {
			if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)){

				$file_to_read="http://203.199.126.129/hungamacare/whitelistuploads/".$uploadedFor."/".$makFileName;				
				
				$file_data=file($file_to_read);
				$file_size=sizeof($file_data);
				$totalFileCount=$file_size;
				
				if($totalFileCount>5000) {
					$msg = "File contain more than 5000 numbers, Please try again.<br/><br/>";
					//unlink("whitelistuploads/".$uploadedFor."/".$makFileName);
				} else {
					$msg = "File uploaded successfully.<br/>";
					$fp = fopen($path, "r") or die("Couldn't open $filename");
					$query = "insert into master_db.tbl_whitelist_history (file_name, added_by, added_on, upload_for, total_file_count, ip) values ('".$makFileName."', '".$_SESSION['loginId']."', now(), ".$uploadedFor.", '".$file_size."', '".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($query);
					
					$logfile = "/var/www/html/hungamacare/whitelistuploads/log/".$logFileName.".txt";

					for($i=0; $i<$file_size; $i++) {
						$msisdn = trim($file_data[$i]);
						if($uploadedFor == 'insert') { 
							$actionQuery = "INSERT INTO vodafone_hungama.tbl_directactivation (ANI) VALUES ('".$msisdn."')";
						} elseif($uploadedFor == 'delete') { 
							$actionQuery = "DELETE FROM vodafone_hungama.tbl_directactivation WHERE ANI='".$msisdn."'";
						}
						$logData=$msisdn."#".$actionQuery."#".date('Y-m-d H:i:s')."\n";
						error_log($logData,3,$logfile);
						mysql_query($actionQuery);
					}
					$msg .="All numbers ".ucwords($uploadedFor)." successfully";
				} 
			} else {
				$msg = "File not uploded successfully, Please try again";
			}
		} else {
			$msg = "Invalid File Type, Please try again";
		}
	} 

?>
<TABLE width="80%" align="center" border="0" cellpadding="0" cellspacing="0" class="txt">
      <TBODY>
      <?php if(isset($msg)) { ?>
        <TR height="30" width="100%">
                <TD colspan="4" bgcolor="#FFFFFF" align="center"><?php echo $msg;?></TD>
        </TR>
      <?php } ?>	
      <TR height="30">
        <TD bgcolor="#FFFFFF" colspan=2><FONT COLOR="#FF0000"></FONT></TD>
        <TD bgcolor="#FFFFFF" COLSPAN=2><B><font color='red' size='4'>(File should not contains more than 5,000, otherwise file would not process)</font></TD>
      </TR>
</TABLE>  
 <form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()" enctype="multipart/form-data">
    <TABLE width="50%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
		<TBODY>
			<TR height="30">
				<TD bgcolor="#FFFFFF"><B>Upload For</B></TD>
				<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<INPUT TYPE="radio" NAME="upload" id="upload" value="insert" checked>Insert&nbsp;&nbsp;<INPUT TYPE="radio" id="upload" NAME="upload" value="delete">Delete</TD>
			</TR>
			<TR height="30">
				<TD bgcolor="#FFFFFF"><B>Browse File To Upload <FONT COLOR="#FF0000">[.txt file]</B><br/>(text file must contain one 10 digit msisdn per line)</FONT></TD>
				<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<INPUT name="upfile" id='upfile' type="file" class="in"></TD>
			</TR>	
			<TR height="30">
				<TD bgcolor="#FFFFFF" colspan=2 align="center">
				<input type="hidden" name="service_id" value="<?php echo $_REQUEST['service_info']?>" /> 
				<input name="Submit" type="submit" class="txtbtn" value="Upload" onSubmit="return checkfield();"/></TD>
			</TR>	  
		</TBODY>
	</TABLE>
</form>
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
