<?php
$PAGE_TAG = 'revenue-live';
include "includes/constants.php";
include "includes/language.php";

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.png">
<title><?php echo DICT_TITLE;?></title>
<?php
echo CONST_CSS;
?>

</head>

<body>
<div class="container">
<?php
include "includes/menu.php";
?>
<div class="row">
	<div class="col-md-12"><h4><?php echo DICT_TITLE;?></h4></div>
</div>    
<div class="row"><br/>
</div>    


</div>  

<?php
echo CONST_JS;
?>
</body>
</html>