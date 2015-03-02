<?php
session_start()
?>

<html>
<head>
<title>PHP File Upload Chander </title>
</head>
<body>
<form enctype="multipart/form-data" method="post" action="chander.php">
<input type="file" name="fileToUpload" /><br />
<input type="submit" value="Upload File" />
</form>
</body>
</html>

<?php
echo "<table border=\"1\">";
echo "<tr><td>Client Filename: </td>
   <td>" . $_FILES["fileToUpload"]["name"] . "</td></tr>";
echo "<tr><td>File Type: </td>
   <td>" . $_FILES["fileToUpload"]["type"] . "</td></tr>";
echo "<tr><td>File Size: </td>
   <td>" . ($_FILES["fileToUpload"]["size"] / 1024) . " Kb</td></tr>";
echo "<tr><td>Name of Temp File: </td>
   <td>" . $_FILES["fileToUpload"]["tmp_name"] . "</td></tr>";
echo "</table>";

move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "/var/www/html/chander/log/" . $_FILES["fileToUpload"]["name"]);

//echo "/var/www/html/chander/log/",$_FILES["fileToUpload"]["name"]
?>


