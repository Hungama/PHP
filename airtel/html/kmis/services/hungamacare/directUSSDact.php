<?php
	session_start();
	//include("config/dbConnect.php");	
	include("web_admin.js");
	include("header.php");

	
if($_SESSION['usrId']) {
	$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAR'=>'Haryana','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAY'=>'Haryana');

	if(isset($_POST['submit']))
	{
		$con = mysql_connect("10.2.73.160","billing","billing");	
		$serviceId = $_POST['service'];
		if($serviceId == 1518) $serviceName = 'Airtel-MPMC';
		elseif($serviceId == 1507) $serviceName = 'Airtel-VH1';
		elseif($serviceId == 1515) $serviceName = 'Airtel-SARNAM';
		elseif($serviceId == 1513) $serviceName = 'Airtel-MND';

		$Stdate=date("Y-m-d H:i:s",strtotime($_POST['timestamp']));
		$Endate=date("Y-m-d H:i:s",strtotime($_POST['timestamp1']));
		$circle=$_REQUEST['circle'];
		$type=$_REQUEST['type'];

		$query="SELECT count(*) FROM master_db.tbl_ussd_activation WHERE circle='".$circle."' and service_id='".$serviceId."'";
		$result = mysql_query($query);
		$count = mysql_fetch_row($result);
		if($count[0]) {
			$updateQuery = "UPDATE master_db.tbl_ussd_activation SET type='".$type."',starttime='".$Stdate."',endtime='".$Endate."',added_on=NOW() WHERE circle='".$circle."' and service_id='".$serviceId."'";
		} else {
			$updateQuery = "INSERT INTO master_db.tbl_ussd_activation VALUES('','".$serviceId."','".$serviceName."','".$type."','".$Stdate."', '".$Endate."', '".$circle."','1',NOW())";
		}
		mysql_query($updateQuery);
	}
?>
<script language="javascript">

function validateData() {
	if(document.getElementById('timestamp').value=='') {
		alert("Please enter Time Slot.");
		document.getElementById('timestamp').focus();
		return false;
	}
	if(document.getElementById('timestamp').value) {
		if(!document.getElementById('timestamp1').value) { 
			alert("Please enter Endtime.");
			document.getElementById('timestamp1').focus();
			return false;
		}
	}
	return true;
}

</script>
<div class='txt' align='right'><a href='showUSSDActivationData.php'>Show USSD Time-Slots</a>&nbsp;&nbsp;&nbsp;</div>
<form name="tstest" action='directUSSDact.php' method='POST' onSubmit="return validateData();">
<table width="30%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
<tr>
	<td bgcolor="#FFFFFF" height="30px" width='50%'>Service</td>
	<td bgcolor="#FFFFFF" height="30px">&nbsp;<select name='service' id="service" class='txt'>			
			<option value=''>Select Service</option>
			<option value='1518'>Airtel-MPMC</option>
			<option value='1507'>Airtel-VH1</option>
			<option value='1515'>Airtel-SARNAM</option>
			<option value='1513'>Airtel-MND</option>
		</select></td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height="30px" width='50%'>Activation Type</td>
	<td bgcolor="#FFFFFF" height="30px">&nbsp;<select name='type' id="type" class='txt'>			
			<option value=''>Select Type</option>
			<option value='single'>Single</option>
			<option value='direct'>Direct</option>
		</select></td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height="30px">Circle</td><td bgcolor="#FFFFFF" height="30px">&nbsp;<select name='circle' id='circle' class='txt'>
		<option value=''>Select Circle</option>
	<?php foreach($circle_info as $circle_id=>$circle_val) { ?>
		<option value=<?php echo $circle_id;?>><?php echo $circle_val;?></option>
	<?php } ?></select>
	</td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" width="50%" height="30px">Select Start Time:&nbsp;</td><td bgcolor="#FFFFFF">&nbsp;<input type="Text" name="timestamp" id="timestamp" value="" class='txt'>&nbsp;<a href="javascript:show_calendar('document.tstest.timestamp', document.tstest.timestamp.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
	</td>
</tr>
<tr>
	<td bgcolor="#FFFFFF">Select End Time:&nbsp;</td><td bgcolor="#FFFFFF">&nbsp;<input type="Text" name="timestamp1" id="timestamp1" value="" class='txt'>&nbsp;<a href="javascript:show_calendar('document.tstest.timestamp1', document.tstest.timestamp1.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
	</td>
</tr>
<tr><td colspan='2' align='center' bgcolor="#FFFFFF"><input type='Submit' name='submit' value='submit' onSubmit="return validateData();"/></tr>
</table>

</form>
<?php //mysql_close($dbConn); 
} else {
	echo "Please Do The Login First<Br>";
	echo "<a href='http://10.2.73.156/kmis/services/hungamacare'>Click Here to Login</a>";
}
?>