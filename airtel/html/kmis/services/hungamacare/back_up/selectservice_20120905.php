<?php
ob_start();
session_start();
include("web_admin.js");
if($_SESSION['usrId'])
{
	include("config/dbConnect.php");
	// validate login and password
	$get_service_name="select a.service_id,b.service_name from master_db.tbl_service_user_master a,master_db.tbl_service_master b where a.user_id='$_SESSION[usrId]' and a.service_id=b.service_id";
	
	$query = mysql_query($get_service_name, $dbConn);
	include_once("main_header.php");
	$action_page='main.php';
	$flag=0;
?>
	<tr><td height="10"></td></tr>
	<table class="txt" align="center" border="0" cellpadding="0" cellspacing="0" width="40%">
	<tbody>
	<form action=<?=$action_page;?> method='post' name="frm1" onSubmit="return checkfield()">
	<tr align='center'>		
		<td> Select Service:
			<select name='service_info'>
			<option value='0'>Select Service</option>
			<?php while(list($serviceId, $serviceName) = mysql_fetch_array($query)) {
				if($serviceName==54646) {
				$serviceName="Entertainment Portal 54646";			
					if($_SESSION['usrId'] != 56 && $_SESSION['usrId'] != 50) echo "<option value=15022>Mana Paata Mana Comedy</option>"; 
				}
				if($serviceId == 1511) {
					echo "<option value=1509>Miss Riya</option>";
				}
				//if($serviceId==1513) { $flag=1; }
				echo "<option value=$serviceId>$serviceName</option>";
			}
			?>
			</select>
		</td>
		<?php 
			/*if($flag == 1) { ?>
		<!--<td> Select Character:
			<SELECT NAME="ch">
				<OPTION value="ch1">Charater 1</OPTION>
				<OPTION value="ch2">Charater 2</OPTION>
				<OPTION value="ch3">Charater 3</OPTION>
				<OPTION value="ch4">Charater 4</OPTION>
				<OPTION value="ch5">Charater 5</OPTION>
			</SELECT>		
		</td>		 -->
		<?php } */ ?>			
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<tr align='center'>
		<td height="10" colspan=2><input type='submit' name='submit' value='submit'></td>
	</tr> 
	<tr>
			<td height="50"></td>
	</tr>
	<tr>
			<td bgcolor="#0369b3" height="1"></td>
	</tr>
	</form>
	<?if($_SESSION['usrId']==4){?>
	<tr align='right'>
		<td height="1">
			<a href='http://10.2.73.156/kmis/services/hungamacare/showReport.php'>View Report&nbsp;&nbsp;&nbsp;</a>
		</td>
	</tr>

	<?}?>

	<?if($_SESSION['usrId']==26){?>
	<tr align='right'>
		<td height="1">
		<? 
				header("location:http://10.2.73.156/kmis/services/hungamacare/showReport.php");
		exit;
		?>
		</td>
	</tr>

	<?}?>

	</tbody>
	</table>
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
	<?
		mysql_close($dbConn);
}
	
else
echo "<a href='index.php'>Please Log1n</a>";

?>