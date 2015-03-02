<?php
ob_start();
session_start();
include("web_admin.js");
$user_id=$_SESSION['usrId'];
if(!$user_id)
	$user_id=$_REQUEST['usrId'];
if($user_id)
{
	$_SESSION['authid']='true';
	//echo $_SESSION['usrName'].'athar';
	
	//include("config/dbConnect.php");
	require_once("incs/db.php");
	// validate login and password
		
	$get_service_name="select a.service_id,b.service_name from master_db.tbl_service_user_master a,master_db.tbl_service_master b where a.user_id='$user_id' and a.service_id=b.service_id";
	
	$query1 = mysql_query($get_service_name, $dbConn);
	$serviceArray=mysql_fetch_row($query1);
	include_once("/var/www/html/kmis/services/hungamacare/2.0/main_header.php");
	
	if($_SESSION['usrId'] == 141) {
		$action_page = 'trynbuy_upload.php';
	} elseif($_SESSION['usrId'] == 245) {
		$action_page = 'bulk_upload.php?service_info=1001';
	} else {
		$action_page = 'main.php';
	}
	$query = mysql_query($get_service_name, $dbConn);
?>
	<tr><td height="10"></td></tr>
	<table class="txt" align="center" border="0" cellpadding="0" cellspacing="0" width="40%">
	<tbody>
	<form action=<?php echo $action_page;?> method='post' name="frm1" onSubmit="return checkfield()">
	<tr align='center'>
		<td> Select Service:
			<select name='service_info'>
			<option value='0'>Select Service</option>
			<?php while(list($serviceId, $serviceName) = mysql_fetch_array($query)) 
				if($_SESSION['usrId'] == 269) {
					echo "<option value=".$serviceId.">Bollywood SMS Pack</option>";
				} else {
					echo "<option value=".$serviceId.">".$serviceName."</option>";
				}
			?>						
			</select>
		</td>
		<?php if($_SESSION['usrName']=='Docomo Admin' || $_SESSION['usrName']=='Docomo CCare'){?>
		<td> Select Service Type:
			<select name='serviceType'>
				<?php if($_SESSION['usrId'] != 221 && $_SESSION['usrId'] != 227 && $_SESSION['usrId'] != 271){ ?>
				<option value='TD'>Tata Docomo</option>
				<?php } if($_SESSION['usrId'] != 219 && $_SESSION['usrId'] != 227 && $_SESSION['usrId'] != 245 && $_SESSION['usrId'] != 261 && $_SESSION['usrId'] != 267 && $_SESSION['usrId'] != 269 && $_SESSION['usrId'] != 273 && $_SESSION['usrId'] != 347) { ?>
				<option value='TI'>Tata Indicom</option>
				<?php } ?>
				<?php if($_SESSION['usrId'] != 219 && $_SESSION['usrId'] != 221 && $_SESSION['usrId'] != 229 && $_SESSION['usrId'] != 239 && $_SESSION['usrId'] != 247 && $_SESSION['usrId'] != 245 && $_SESSION['usrId'] != 261 && $_SESSION['usrId'] != 267 && $_SESSION['usrId'] != 269 && $_SESSION['usrId'] != 271 && $_SESSION['usrId'] != 273 && $_SESSION['usrId'] != 283 && $_SESSION['usrId'] != 347) { ?>
				<option value='VMI'>VMI</option>
				<?php } ?>
			</select>
		</td>
		<?php }?>
				<input type='hidden' name='usrId' value="<?php echo $user_id;?>">
	</tr>
	<tr>
			<td height="10"></td>
	</tr>
	<tr align='center'>
		<td colspan=2><input type='submit' name='submit' value='submit'></td>
	</tr> 
	<tr>
			<td height="50"></td>
	</tr>
	<tr>
			<td bgcolor="#0369b3" height="1"></td>
	</tr>
	</form>
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
<?php
}
else
{
echo "<a href='index.php'>Please Log1n</a>";
}
?>
