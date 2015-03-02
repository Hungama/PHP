<?php
ob_start();
session_start();
include("web_admin.js");
if($_SESSION['usrId'])
{
	include("dbConnect.php");
	// validate login and password
	$get_service_name="select a.service_id,b.service_name from master_db.tbl_service_user_master a,master_db.tbl_service_master b where a.user_id='$_SESSION[usrId]' and a.service_id=b.service_id";
	
	$query = mysql_query($get_service_name, $dbConn);
	include_once("main_header.php");
	$action_page='main.php';

?>
<tr><td height="10"></td></tr>
	<table class="txt" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
	<form action=<?php echo $action_page;?> method='post' name="frm1" onSubmit="return checkfield()">
	<tr align='center'>
		<td> Select Service:
			<select name='service_info'>
			<option value='0'>Select Service</option>
			<?php while(list($serviceId, $serviceName) = mysql_fetch_array($query)) 
				echo "<option value=$serviceId>$serviceName</option>";
			?>
			</select>
		</td>
	</tr>

	<tr>
			<td height="10"></td>
	</tr>
	<tr align='center'>
		<td><input type='submit' name='submit' value='submit'></td>
	</tr> 
	<tr>
			<td height="50"></td>
	</tr>
	<tr>
			<td bgcolor="#0369b3" height="1"></td>
	</tr>
	</form>
	<?php if($_SESSION['usrId']==4){?>
	<tr align='right'>
		<td height="1">
			<a href='http://10.130.14.107/hungamacare/showReport.php'>View Report&nbsp;&nbsp;&nbsp;</a>
		</td>
	</tr>

	<?php 
} }
else
echo "<a href='index.php'>Please Log1n</a>";

?>