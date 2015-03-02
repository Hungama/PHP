<?php
include("dbconfig.php");
unlink("upload/text.txt");
unlink("upload/del.txt");
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
<title>Relince Miss Riya Disclaimer </title>
</head>

<body>
<br><br><br>
<form action="aniupload.php" method="post" enctype="multipart/form-data">
<table align="center" border="1">
  <tr width="50" height="50">
    <th scope="row">Upload Ani File for Activation : </th>
    <td><input type="file" name="file1" id="file1" /></td>
  </tr>
  <tr width="50" height="50">
	<th scope="row">Upload Ani File for Deactivate : </th>
    <td><input type="file" name="file" id="file" /></td>
  </tr>
 <tr>
    <th scope="row">&nbsp;</th>
    <td><br><center><input type="submit" name="submit" value="Submit"></center></td>
  </tr>
</table></form>
</body>
</html>