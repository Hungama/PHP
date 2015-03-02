<?php
ini_set('display_errors', '0');

include "includes/constants.php";
include "includes/language.php";



?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.png">

    <title><?php echo DICT_LOGIN_PAGE;?></title>
<?php
echo CONST_CSS;
?>

     </head>

<body class="bg-primary">

    <div class="container">

      <div class="row login-form">
        <div class="col-xs-12">
          <div class="col-md-6">
            <img src="images/icon-login.png" alt="<?php echo DICT_INDEX_PAGE;?>">
             </div>

          <div class="col-md-6">
          Please contact administrator.
          </div>
        </div>
      </div>
    </div> <!-- /container -->


<?php
//echo CONST_JS;
?>
</body>
</html>