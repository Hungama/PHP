<?php
$file = $_SERVER["SCRIPT_NAME"];
$break = explode('/', $file);
$pfile = $break[count($break) - 1];
?>
<table class="txt" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody>
  <tr>
    <td><img src="images/logo.png" alt="Hungama" align="left" border="0" hspace="0" vspace="15"><div style="margin-top: 20px; margin-right: 20px;" align="right"><b><font color="#0000cc">Welcome <?php echo ucwords(strtolower($_SESSION["usrName"])); ?> | </font><a href="javascript:void(0)" onClick="logout()"><font color="#0000cc">Logout</font></a> <br/> <?php if($_SESSION['lastLogin']!="0000-00-00 00:00:00") { ?>Last Login :: <?php echo $_SESSION['lastLogin']; } ?></b><br/><br/>
	</td></tr>
	<tr>
		<td bgcolor="#0369b3" height="1"></td>
	</tr>
	<tr>
		<td height="20"></td>
	</tr>
	
</tbody></table>
