<?php
echo "<pre>";
print_r($_FILES);
print_r($_POST['ani']);
?>
<form name='test' action='testing.php' method='post' enctype='multipart/form-data'>
Select file:<input type='file' name='myfile'>
<br/>
ANI :<input type='text' name='ani'>
<br/>
<input type='submit' name='submit'>
</form>