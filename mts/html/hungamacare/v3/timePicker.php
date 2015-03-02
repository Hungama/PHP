<?php
ob_start();
session_start();
ini_set('display_errors', '0');
$PAGE_TAG = 'sms-kci';
include "includes/constants.php";
include "includes/language.php";
$loginid = $_SESSION['loginId'];
if ($loginid == '') {
    Header("location:login.php?ERROR=500");
}
$SKIP = 1;
require_once("../2.0/incs/common.php");
require_once("../2.0/incs/db.php");
require_once("../2.0/language.php");
require_once("../2.0/base.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="favicon.png">
        <title><?php echo "CREATE RULE"; ?></title>
        <?php
        echo CONST_CSS;
        echo EDITINPLACE_CSS;
        ?>

    </head>

    <body onload="javascript:viewUploadhistory('me');">
        <div class="container">
            <?php
            include "includes/menu.php";
            ?>
            <div class="row">
                <div class="col-md-12"><h4><?php echo "RULE Engine"; ?></h4></div>
            </div>    
            <div class="input-append bootstrap-timepicker">
                <input id="timepicker1" type="text" class="input-small">
                <span class="add-on"><i class="icon-time"></i></span>
            </div>


        </div>  

        <?php
        echo CONST_JS;
        echo EDITINPLACE_JS;
        ?>
        <script>
             $('#timepicker1').timepicker();
            var elem = $("#counter");
            $("#msg").limiter(160, elem);
        </script>
    </body>
</html>