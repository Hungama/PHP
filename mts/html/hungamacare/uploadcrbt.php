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

			mysql_select_db($$userDbName, $userDbConn);

			$qryBatch = mysql_query("select max(batch_id) from billing_intermediate_db.bulk_upload_history", $userDbConn);
			list($batchId) = mysql_fetch_array($qryBatch);
			if($batchId)
				$batchId = $batchId + 1;
			else
				$batchId = 1;

			$SafeFile = $_FILES['upfile']['name'];
			$fileExplode=explode(".",$SafeFile);
			$makFileName = $fileExplode[0]."_".date('Ymdh').".txt";

			$uploaddir = "crbtuploads/";
			$path = $uploaddir.$makFileName;
			if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)){

			$file_to_read="http://10.130.14.107/hungamacare/crbtuploads/".$makFileName;
			$file_data=file($file_to_read);
			$file_size=sizeof($file_data);

			$msg = "File uploaded successfully.<br/><br/>";
			$fp = fopen($path, "r") or die("Couldn't open $filename");
			for($k=0;$k<$file_size;$k++)
			{
				if(trim($file_data[$k])!='')
				{
					$Uploadquery="insert into mts_radio.tbl_radiocrbt_reqs";
					$Uploadquery .=" values($file_data[$k],now(),'crbt',$fileExplode[0],0) ";
					$queryIns = mysql_query($Uploadquery, $userDbConn);
				}
			}

			$msg = "File <b>$makFileName<b> uploaded successfully.<br/><a href=\"javascript:void(0);\" onclick=\"openWindow()\" class=\"blue\">View Upload History</a>";
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
<TABLE width="80%" align="center" border="0" cellpadding="0" cellspacing="0" class="txt">
      <TBODY>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B><FONT COLOR="#FF0000">Bulk CRBT Upload Utility</FONT></B></TD>
		<TD bgcolor="#FFFFFF" COLSPAN=2><B><FONT COLOR="#FF0000"><a href="viewhistory.php" onclick=\"openWindow()\" class=\"blue\">View Upload History</a></TD>
      </TR></TABLE>
 <form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()" enctype="multipart/form-data">
    <TABLE width="50%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
      <TBODY>
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