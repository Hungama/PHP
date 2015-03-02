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
          <?php echo (strlen($_GET['ERROR']) > 0 ? "<div class=\"alert alert-danger\">" . ErrorLogin($_GET['ERROR']) . "</div>" : "");?>
          <form action="validate.php" method="post">
            <div class="control-group">
              <input type="text" name="username" class="form-control login-field" value="" placeholder="Enter your username" id="login-name">
              <label class="login-field-icon fui-user" for="login-name"></label>
            </div>

            <div class="control-group">
              <input type="password" name="password" class="form-control login-field" value="" placeholder="Password" id="login-pass">
              <label class="login-field-icon fui-lock" for="login-pass"></label>
            </div><input type="hidden" name="URL" id="URL" value="<?php echo $_REQUEST['URL']; ?>">
           

            <button class="btn btn-primary btn-large btn-block" type="submit">Login</button>
             </form><a class="login-link" href="#">Lost your password?</a>
          </div>
        </div>
      </div>
    </div> <!-- /container -->


<?php
echo CONST_JS;
?>
</body>
</html>
<?php
function ErrorLogin($Code)
{

    switch ($Code) {
        case "999":
            return "You seem to have tried an invalid username/password combination";
            break;

        case "0":
            return "Your account is locked, please contact administrator";
            break;
        case "500":
            return "You have been successfully signed out";
            break;

        default:
            return "Unknown Error. (Error Code: " . $Code . ")";

    }

}

?>