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

function checkfield()
{
	var radioValue;
	radioValue=getRadioValue();
	if(document.getElementById('service').value=="" && radioValue=='active')
	{
		alert("Please select a price point.");
		document.getElementById('price').focus();
		return false;
    }
    return true;
}
</script>
</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<?php 
include("header.php");
if($_SERVER['REQUEST_METHOD']=="POST" && isset($_FILES['upfile']) && !empty($_FILES['upfile']['name'])) 
{
	$service=$_POST['service'];
	switch ($service)
	{
		case 'rmtv':
			$dbtbl='reliance_hungama.tbl_jbox_message1';
			break;
		case 'dmtv':
			$dbtbl='docomo_hungama.tbl_jbox_message1';
		break;
		case 'umtv':
			$dbtbl='uninor_hungama.tbl_jbox_message1';
		break;
	}
	$deleteQuery="delete from ".$dbtbl." where type='Hangupmtv'";
	mysql_query($deleteQuery);
	$file = $_FILES['upfile'];
	$allowedExtensions = array("txt");
	function isAllowedExtension($fileName) 
	{
		global $allowedExtensions;
		return in_array(end(explode(".", $fileName)), $allowedExtensions);
	}
	if(isAllowedExtension($file['name'])) {
	$SafeFile = explode(".", $_FILES['upfile']['name']);
	$makFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".date("YmdHis").".".$SafeFile[1];
	$uploaddir = "file/";
	$path = $uploaddir.$makFileName;
	if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)){				
	$file_to_read="http://119.82.69.212/mtvmsginterface/file/".$makFileName;
	$channel=$_POST['channel'];
	$file_data=file($file_to_read);
	$file_size=sizeof($file_data);
	for($i=0;$i<$file_size;$i++)
	{
		$msgtxt=trim($file_data[$i]);
		$insertQuery="insert into ".$dbtbl." values ('".$i."','".$msgtxt."','Hangupmtv','pan','3')";
		mysql_query($insertQuery,$dbConn);
	}
	$msg = "File uploaded successfully.<br/><br/>";
	$thisTime = date("Y-m-d H:i:s");
	} else 
		{
			$msg = "File cannot be uploaded successfully.";
		}
	} else 
	{
		$msg = "Invalid file type. Please upload text file only.";
	}
}
if(!isset($_POST['Submit']))
{
?>
<TABLE width="80%" align="center" border="0" cellpadding="0" cellspacing="0" class="txt">
      <TBODY>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B><FONT COLOR="#FF0000">Message Upload Utility</FONT></B></TD>
		</TABLE>	  
 <form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()" enctype="multipart/form-data">

    <TABLE width="50%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
	
      <TBODY>
       
	

	<TR height="30" id='price12'>
        <TD bgcolor="#FFFFFF"><B>Select Service</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
		<select name="service" id='service' class="in">
			<option value=''>--select--</option>
			<option value="rmtv">Reliance MTV</option>
			<option value="dmtv">Docomo MTV</option>
			<option value="umtv">Uninor MTV</option>
		</select>
		</TD>
      </TR>
	  <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Browse File To Upload <FONT COLOR="#FF0000">[.txt file]</B><br/>(text file must contain one message per line)</FONT></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<INPUT name="upfile" id='upfile' type="file" class="in"></TD>
      </TR>
      <TR height="30">
        <td align="center" colspan="2" bgcolor="#FFFFFF">
			<input name="Submit" type="submit" class="txtbtn" value="Upload" onSubmit="return checkfield();"/></td>
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