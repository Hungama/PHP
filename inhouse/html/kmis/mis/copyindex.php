<?php
if($_REQUEST['submit']!=''){
if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
  }
else
  {
  echo "Upload: " . $_FILES["file"]["name"] . "<br>";
  echo "Type: " . $_FILES["file"]["type"] . "<br>";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
  //echo "Stored in: " . $_FILES["file"]["tmp_name"];
  
   if(move_uploaded_file($_FILES["file"]["tmp_name"],"/var/www/html/kmis/mis/activeBase/" . $_FILES["file"]["name"]))
   echo "Stored in: " . "/var/www/html/kmis/mis/activeBase/" . $_FILES["file"]["name"];
   else
       echo "athar";
  
  }
}
else{?>
  <html>
<body>

<form action="copyindex.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file"><br>
<input type="submit" name="submit" value="Submit">
</form>

</body>
</html> 
<?}
 ?> 