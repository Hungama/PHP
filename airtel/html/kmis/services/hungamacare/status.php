<?php

$rest = substr($service_info,0,-2);
$logoPath='images/logo.png';

include ("header.php");
?>
<html>
<head> <title>Whitelist Interface: Airtel</title>
<script type="text/javascript">
function logout()
{
	window.parent.location.href = 'index.php?logerr=logout';
}

function validateForm() {
	checkPhone(document.getElementById("ani").value,'error')
}

function checkPhone(field, errorMsg) {
	phoneRegex = "^0{0,1}[1-9]{1}[0-9]{2}[\s]{0,1}[\-]{0,1}[\s]{0,1}[1-9]{1}[0-9]{6}$";
	if (field.match(phoneRegex))  {
			return true;
	} else {
		alert('Please Enter 10 Digit Number');
		return false;
	}
}

</script>
</head>
<table  border='1' align ='center' >
<form name='statusinterface'  method='POST' action='status.php'  onsubmit="return validateForm();">
	<a href="whitelistinterface.php"><font color='red'>Back</font></a>
	<tr>
	<td><font size='2'>Insert MDN </font></td>
	<td><input type=' text' name='msisdn'  id='ani'></td></tr>
	<tr>
	<td align='center' colspan='2'><input type="submit"  value="submit"  name="submit"></td>
	</tr>
	</form>
	</table>

<?php 
include("config/dbConnect.php");

if($_POST['submit']!='' && $_POST['msisdn']!='')
{	
	$msisdn=$_POST['msisdn'];
	$query="select ANI,ShortCode,LongCode,Operator,Circle,ServiceId from master_db.tbl_master_whitelist where ANI=$msisdn";
	$queryresult=mysql_query($query);
	$count = mysql_num_rows($queryresult);
	while($rowInfo= mysql_fetch_array($queryresult))
	{ ?>
	<table  align='center'>
	<tr><td colspan='6'>&nbsp;</td></tr>
	</table>
	<table  align='center' border='2'>	
	<tr>
		<th><font size=2>ANI</font></th><th><font size=2>LongCode</font></th><th><font size=2>ShortCode</font></th><th><font size=2>Operator</font></th><th><font size=2>Circle</font></th><th><font size=2>ServiceId</font></th>
	</tr>
	<tr>
		<td align='center'><font size=2><?php echo $rowInfo['ANI'];?></font></td>
		<td align='center'><font size=2><?php echo $rowInfo['LongCode'];?></font></td>
		<td align='center'><font size=2><?php echo $rowInfo['ShortCode'];?></font></td>
		<td align='center'><font size=2><?php echo $rowInfo['Operator'];?></font></td>
		<td align='center'><font size=2><?php echo $rowInfo['Circle'];?></font></td>
		<td align='center'><font size=2><?php echo $rowInfo['ServiceId'];?></font></td>
	</tr>
	</table>
	<?php 
	} 
	if(!$count) {  ?>
		<br/><br/>
		<div align='center'>No Record found!<div>
	<?php }
}
?>
	