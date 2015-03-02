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
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>Hungama Customer Care</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../2.0/assets/css/bootstrap.css" rel="stylesheet" />
<link href="../2.0/assets/css/bootstrap-responsive.css" rel="stylesheet">
<script type="text/javascript" src="../2.0/assets/js/jquery.js"></script>

    <style type="text/css">
      /* Override some defaults */
      html, body {
        background:url(../2.0/assets/img/greybg.png);
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
	if(frm.obd_form_uname.value=="")
	{
		alert("Please enter login name.")
		frm.obd_form_uname.focus();
		ok=false
	}
	else if(frm.obd_form_pwd.value == "")
	{
		alert("Please enter password");
		frm.obd_form_pwd.focus();
		ok=false
	}
	return ok
}
</script>
</head>
<body leftmargin="0" topmargin="0">
	<div class="container" id="container">

        <div class="content">
			
            <?php// echo (strlen($_GET['ERROR']) > 0 ? "<div class=\"alert alert-danger\">".ErrorLogin($_GET['ERROR'])."</div>": "");?>
			
			
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
					<form name="frm" action="checklogin.php" method="post" onSubmit="return checkfield()">
						<fieldset>
							<div class="clearfix">
								<input type="text" placeholder="Username" name="obd_form_uname">
							</div>
							<div class="clearfix">
								<input type="password" placeholder="Password" name="obd_form_pwd"><?php if($_REQUEST['URL']) {?>  <input type="hidden" name="URL" id="URL" value="<?php echo $_REQUEST['URL'];?>"><?php } ?>
							</div>
								<button class="btn btn-primary" type="submit">Sign in</button>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div> <!-- /container -->
<!--table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<table class="txt" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr> 
    <td style="padding-left:20px"><img src="images/logo.png" alt="Hungama" align="left" border="0" hspace="0" vspace="15"></td>
  </tr>
  <tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
</tbody></table>
<br><br><br>
  <div class="txt" align="center">
    <?php 
	if($_REQUEST['logerr']=="invalid" || $_REQUEST['logerr']=="invalid1")
	{
	?>
		<font color="#FF0000">User Name or Password is incorrect.</font> 
    <?php
	}
	else if($_REQUEST['logerr']=="inac")
	{
	?>
		<font color="#FF0000">Your login is not active, Please contact administrator.</font> 
    <?php
	}
	else if($_REQUEST['logerr']=="logout")
	{
	?>
		<font color="#FF0000">You have successfully logged out.</font> 
    <?php
	}
	?>
  </div><BR/>
  <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" width="40%">
    <tbody><tr> 
      <td align="center" bgcolor="#ffffff"> 
        <table class="txt2" bgcolor="#e6e6e6" border="0" cellpadding="0" cellspacing="1" width="100%">
          <tbody><tr> 
            <td colspan="2" align="center" bgcolor="#ffffff" height="25"><strong>Admin 
              Login </strong> </td>
          </tr><form name="frm" action="validate.php" method="post" onSubmit="return checkfield()">
          <tr> 
            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">User Name 
              : </td>
            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"> 
              <input name="login" class="in" size="25" type="text">
            </td>
          </tr>
          <tr> 
            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">Password 
              : </td>
            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"> 
              <input name="pass" class="in" size="25" type="password">
            </td>
          </tr>
          <tr align="center"> 
            <td style="padding-left: 5px;" colspan="2" bgcolor="#ffffff" height="35"> 
              <input name="submit" class="in" value="Submit" type="submit">
              &nbsp;&nbsp;&nbsp;
              <input class="in" value="Reset" type="reset">
             </td>
          </tr></form>
        </tbody></table>
      </td>
    </tr>
  </tbody></table-->
<br>
<br>
<br>
<br>
<br>
<br>
<script>
jQuery.fn.center = function () 
    {
        this.css("position","absolute");
        this.css("top", ( $(window).height() - this.height() ) / 2+$(window).scrollTop() + "px");
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
<!--table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody>
  <tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
  <tr> 
    <td class="footer" align="right" bgcolor="#ffffff"><b>Powered by Hungama</b></td>
  </tr><tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
</tbody></table-->
</body>
</html>
