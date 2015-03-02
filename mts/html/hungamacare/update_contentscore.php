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

function checkUpdatefield() {
	if(document.getElementById('upfile').value != "" && document.getElementById('searchtxt').value == "") {
		alert("Please select search keyword.");
		document.getElementById('skeyword').focus();
		return false;
	}
	return true;
}

</script>
</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<?php
		$logoPath='images/logo.png';

        include("header.php");		
		if($_SERVER['REQUEST_METHOD']=="POST") {
			$file = $_FILES['upfile'];
			$tableName = "master_db.tbl_content_score";
			
			$SafeFile = explode(".", $_FILES['upfile']['name']);
			
			$makFileName = $SafeFile[0]."_".date("Ymd").".".$SafeFile[1];
			$logFile = $SafeFile[0]."_log_".date("Ymd").".txt";
			$uploaddir = "contentScore/";

			$path = $uploaddir.$makFileName;
			$allowedExtensions = array("csv");
			function isAllowedExtension($fileName) {
				global $allowedExtensions;
				return in_array(end(explode(".", $fileName)), $allowedExtensions);
			}

			if(isAllowedExtension($file['name'])) {
				if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)) {
					$file_to_read="http://10.130.14.107/hungamacare/contentScore/".$makFileName; //$folder."/".
				
					$file_data=file($file_to_read);
					$file_size=sizeof($file_data);
					$logFileWrite = "/var/www/html/hungamacare/contentScore/log/".$logFile; //$folder.
					
					$msg = "File uploaded successfully.<br/>";
					$fp = fopen($path, "r") or die("Couldn't open $makFileName");
					
					for($i=1; $i<$file_size; $i++) {						
						$fileData = explode(",",$file_data[$i]);	
						
						$songname = trim($fileData[1]);
						$updateQuery = "UPDATE ".$tableName." SET score='".trim($fileData[3])."' WHERE id='".trim($fileData[0])."' and servicename='".trim($fileData[4])."'"; //,rating='".$fileData[2]."' song_name like '%".$songname."'			
						$queryIns = mysql_query($updateQuery, $userDbConn);

						$logWrite = $fileData[1]."#".$fileData[0]."#MTS#Query:".$updateQuery."\n";
						error_log($logWrite,3,$logFileWrite);						
					} 
					$msg .="Content Score data updated successfully!!<br/><br/>";
				} else {
					$msg = "File not uploaded successfully, Please Try Again!!";
				}
			} else {
				$msg = "Invalid File Type, Please Upload CSV file Only.";
			}
		}
?>
<TABLE width="96%" border="0" cellpadding="0" cellspacing="0" class="txt">
	<TBODY>
		<TR height="30" width="100%">
			<TD colspan="4" bgcolor="#FFFFFF" align="right"><a href='content_score.php'><B><FONT COLOR="#FF0000">Download Content</FONT></a></B></TD>
		</TR>
		<TR height="30" width="100%">
			<TD colspan="4" bgcolor="#FFFFFF" align="center">
				<?php if($msg) echo $msg;?>
			</TD>
		</TR>
	</TBODY>
</TABLE>
<div align='center' style="font-size:17px;" class='txt'><b>Update Content Score</b><br/></div><br/>
 <form name="frmup" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkUpdatefield()" enctype="multipart/form-data">
    <TABLE width="45%" align="center"  bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" style="font-size:15px;" class='txt'>
      <TBODY>
		<TR>
			<td bgcolor="#ffffff" height="30"><b>Upload File :</b></td>
			<td bgcolor="#ffffff" height="30">&nbsp;<INPUT name="upfile" id='upfile' type="file" class="in" size="40"></td>
		</TR>
		<TR>
			<TD colspan="2" align='center' bgcolor="#ffffff">
				<input name="Submit" type="submit" class="txtbtn" value="Upload" onSubmit="return checkUpdatefield();">
			</TD>
		</TR>
	  </TBODY>
	</TABLE>
</form>
<br/><br/>
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