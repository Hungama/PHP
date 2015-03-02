<html>
<head>
<title>ShotDev.Com Tutorial</title>
</head>
<body>
	<form action="php_sendmail_attach_zip2.php" method="post" name="form1" enctype="multipart/form-data">
	<table width="343" border="1">
		<tr>
		<td>To</td>
		<td><input name="txtTo" type="text" id="txtTo"></td> 
	</tr> 
	<tr>
		<td>Subject</td>
		<td><input name="txtSubject" type="text" id="txtSubject"></td>
	</tr>
	<tr>
		<td>Description</td>
		<td><textarea name="txtDescription" cols="30" rows="4" id="txtDescription"></textarea></td>
	</tr>
	<tr>
		<td>Form Name</td>
		<td><input name="txtFormName" type="text"></td>
	</tr>
	<tr>
	<tr>
		<td>Form Email</td>
		<td><input name="txtFormEmail" type="text"></td>
	</tr>
	<tr>
	  <td>Attachment</td>
	  <td>
			<input name="fileAttach[]" type="file"><br>
			<input name="fileAttach[]" type="file"><br>
			<input name="fileAttach[]" type="file"><br>
			<input name="fileAttach[]" type="file"><br>
			<input name="fileAttach[]" type="file"><br>
			<input name="fileAttach[]" type="file"><br>	  
	  </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="Submit" value="Send"></td>
	</tr>
	</table>
	</form>
</body>
</html>
<!--- This file download from www.shotdev.com -->