<?php
session_start();
//ini_set('session.gc_maxlifetime', 3*24*60*60);
//setcookie("GLCLogged","True",time()+7200,"/",".goodlifeclub.in",1,1);
//echo $_COOKIE['GLCLogged'];
if (!empty($_SESSION['loginId'])) {
    Header("location:../missedcall/admin/html/dashboardGLC1.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GoodLife Club</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
$(document).ready(function(e) {
    $('.img img').css({width:$(window).width(),height:$(window).height()})
	$('.section').css({height:$(window).height()-80})
});
$(window).resize(function(e) {
    $('.img img').css({width:$(window).width(),height:$(window).height()})
});

function doSubmit()
{
document.loginForm.submit();
}
</script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="logo"><img src="images/good-life-club.png"  alt="" /></div>
<div class="section">
  <div class="img"><img src="images/bg.jpg" alt="" /></div>
  <div class="login"><img src="images/login-img.png" class="lgin" />
    <div class="form">
	<form class="form-horizontal" action="validate.php" method="post" id="loginForm" name="loginForm" role="form" >
      <h2>Sign in</h2>
      <input name="username" type="text" placeholder="Username" class="user" />
      <input name="password" type="password" placeholder="Password" class="pass" />
      <a href="javascript:doSubmit()" class="signin">SIGN IN</a><p class="kli"><input name="kli" type="checkbox" value="kli" /><label>Keep me logged in.</label></p>
	  </form>
	  <p class="kli">
	   <?php echo (strlen($_GET['ERROR']) > 0 ? ErrorLogin($_GET['ERROR']) : "");?>
	  </p>
	  </div>
	   
  </div>
</div>
</body>
<?php
function ErrorLogin($Code)
{

    switch ($Code) {
        case "999":
            return "You seem to have tried an invalid username/password combination";
            break;
		case "901":
            return "Page access denied.";
            break;
        case "0":
            return "Your account is locked, please contact administrator";
            break;
        case "500":
            return "You have been successfully signed out";
            break;
		case "998":
            return "Username/password combination can not be left blank.";
            break;
		case "502":
            return "You session has timed out. Please login.";
            break;
        default:
            return "Unknown Error. (Error Code: " . $Code . ")";

    }

}
?>
</html>
