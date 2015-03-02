<?php
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['login_id']);
unset($_SESSION['username']);
unset($_SESSION['usr_type']);
unset($_SESSION['usr_status']);
unset($_SESSION['authid']);

if(isset($_REQUEST['logerr']) && $_REQUEST['logerr']!="invalid")
{
	unset($_SESSION['user_id']);
	session_destroy();
}
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>Hungama Customer Care</title>
<link rel="stylesheet" href="style.css" type="text/css">
<style type="text/css">
<!--
.style3 {font-family: "Times New Roman", Times, serif}
-->
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
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
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
	if(isset($_REQUEST['logerr']) && ($_REQUEST['logerr']=="invalid" || $_REQUEST['logerr']=="invalid1"))
	{
	?>
		<font color="#FF0000">User Name or Password is incorrect.</font> 
    <?php
	}
	else if( isset($_REQUEST['logerr']) && $_REQUEST['logerr']=="inac")
	{
	?>
		<font color="#FF0000">Your login is not active, Please contact administrator.</font> 
    <?php
	}
	else if(isset($_REQUEST['logerr']) && $_REQUEST['logerr']=="logout")
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
  </tbody></table>
<br>
<br>
<br>
<br>
<br>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody>
  <tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
  <tr> 
    <td class="footer" align="right" bgcolor="#ffffff"><b>Powered by Hungama</b></td>
  </tr><tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
</tbody></table>
</body>
</html>
