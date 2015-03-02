<?php
include("dbconfig.php");
?>
<script language="javascript">
function checkfield()
{
	ok=true
	if(form.username.value=="")
	{
		alert("Please enter login name.")
		form.username.focus();
		ok=false
	}
	else if(form.password.value == "")
	{
		alert("Please enter password");
		form.password.focus();
		ok=false
	}
	return ok
}
function setFocus()
{
	document.getElementById("text1").focus();
}
</script>
</script>
<html>
<head>

</head>
<body onload="setFocus()">
<form name="form" action="login.php" method="post" onSubmit="return checkfield()">
 <div>
	<div>User Name</div>
  <div>
	<input name="username" id="text1" size="20" type="text"></div>
  </div>
  <div>
	<div>Password</div>
  <div>
	<input name="password" id="text2" size="20" type="password"></div>
  </div>
  <div>
	  <input class="submit" type="submit" value="">
  </div>
</body>
</html>
