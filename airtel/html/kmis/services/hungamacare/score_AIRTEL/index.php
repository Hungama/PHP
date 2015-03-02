<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbconfigairtel.php");
unlink("upload/score.csv");
$valid=$_REQUEST['logerr'];
if($valid=="sec")
{
?>
		<script language="javascript">
		alert("thanks for uploading file");
		</script>
<?php	
}
else if($valid=="notup")
{
?>
		<script language="javascript">
		alert("File Not Upload");
		</script>
<?php
}
?>

<html>
<head>
<title>AIRTEL SCORE UPDATION</title>
<style type="text/css">
<!--
.style1 {
	color: #0066CC;
	font-style: italic;
	font-weight: bold;
}
-->
</style>
<script language="javascript">
function checkfield() 
{ 
	if(document.frm.file.value  == "") {
		alert("Please Upload CSV File.");
		document.frm.file.focus();
		return false;
	}
	return true;
}
</script>
</head>
<body>
<p>&nbsp;</p>
<blockquote>
  <h1><p align="center" class="style1">AIRTEL SCORE UPDATION </p></h1>
</blockquote>
<hr align="center" class="style1" />
<p>&nbsp;</p>
<p>&nbsp;</p>
 <form name="frm" method="post" action="read.php" onSubmit="return checkfield()" enctype="multipart/form-data">
<table width="600" height="150" border="1" align="center" bordercolor="#00CCFF" class="style1">
  <tr>
    <td width="289"><div align="center" class="style1">Upload CSV File : </div></td>
    <td width="290"><center><input align="absmiddle" name="file" type="file" class="style1" id="file" /></center></td>
  </tr>
  <tr>
    <td colspan="2"><center><input name="submit" type="submit" class="style1" value="Submit" onSubmit="return checkfield();"></center></td>
  </tr>
</table></form>
<p>&nbsp;</p>
</body>
</html>