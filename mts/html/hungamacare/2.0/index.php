<?php
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['login_id']);
unset($_SESSION['username']);
unset($_SESSION['usr_type']);
unset($_SESSION['usr_status']);
unset($_SESSION['authid']);

if($_REQUEST['logerr']=="invalid")
{
	
}
else
{
	unset($_SESSION['user_id']);
	session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <title>Hungama Web - Sign In</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="assets/css/bootstrap.css" rel="stylesheet" />
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
		<script type="text/javascript" src="assets/js/jquery.js"></script>

    <style type="text/css">
      /* Override some defaults */
      html, body {
        background:url(assets/img/greybg.png);
		background-repeat:repeat;
      }
      body {
        padding-top: 40px; 
      }
      .container {
        width: 300px;
      }

      /* The white background content wrapper */
      .container > .content {
        background-color: #fff;
        padding: 20px;
        margin: 0 -20px; 
        -webkit-border-radius: 10px 10px 10px 10px;
           -moz-border-radius: 10px 10px 10px 10px;
                border-radius: 10px 10px 10px 10px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
      }

	  .login-form {
		margin-left: 65px;
	  }
	
	  legend {
		margin-right: -50px;
		font-weight: bold;
	  	color: #404040;
	  }
	  
	  

    </style>

<script language="javascript">
function checkfield()
{
	ok=true
	if(frm.login.value=="")
	{
		alert("Please enter login name.")
		frm.login.focus();
		ok=false
	}
	else if(frm.pass.value == "")
	{
		alert("Please enter password");
		frm.pass.focus();
		ok=false
	}
	return ok
}
</script>
</head>
<body>
	<div class="container" id="container">

        <div class="content">
			
             <?php
			 
	if($_REQUEST['logerr']=="invalid" || $_REQUEST['logerr']=="invalid1")
	{
	?>
		<div class="alert alert-danger">User Name or Password is incorrect.</div>
    <?php
	}
	else if($_REQUEST['logerr']=="inac")
	{
	?>
		<div class="alert alert-danger">Your login is not active, Please contact administrator.</div>
    <?php
	}
	else if($_REQUEST['logerr']=="logout")
	{
	?>
		<div class="alert alert-danger">You have successfully logged out.</div>
    <?php
	}
	?>
			
			
            <div class="row">		            

				<div class="login-form">
					<h2>Sign in</h2>
					<form name="frm" action="validate.php" method="post" onSubmit="return checkfield()">
						<fieldset>
							<div class="clearfix">
								<input type="text" placeholder="Username" name="login">
							</div>
							<div class="clearfix">
								<input type="password" placeholder="Password" name="pass">
							</div>
								<button class="btn btn-primary" type="submit">Sign in</button>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div> <!-- /container -->
<script>
jQuery.fn.center = function () 
    {
        this.css("position","absolute");
        this.css("top", ( $(window).height() - this.height() ) / 4+$(window).scrollTop() + "px");
        this.css("left", ( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + "px");
        return this;
    }
$(document).ready(function(){
    $('#container').center();
    $(window).bind('resize', function() {
        $('#container').center({transition:300});
    });
});
</script>
</body>
</html>