<?php
	include("web_admin.js");
	include("header.php");
	
	$logPath = "/var/www/html/kmis/services/hungamacare/log/directAct/direct_act".date("Y-m-d").".txt";

	$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAY'=>'Haryana');
?>
<script language="javascript">

function showDateTime() {	
	if(document.getElementById('time1').style.display=='none') {
		document.getElementById('time1').style.display='block';
	} else if(document.getElementById('time2').style.display=='none') {
		document.getElementById('time2').style.display='block';
	} else if(document.getElementById('time3').style.display=='none') {
		document.getElementById('time3').style.display='block';
	} else if(document.getElementById('time4').style.display=='none') {
		document.getElementById('time4').style.display='block';
		document.getElementById('more').style.display='none';
	}
}

function validateData() {
	len = document.tstest["circle[]"].length;
	j=0;
	for(i=0; i<len; i++) {
		if (document.tstest["circle[]"][i].selected) 
			j++;
	}
	if(!j) {
		alert("Please select circle");
		return false;
	}

	if(j > 2) {
		alert('Only two circles at one time, Please try again!');
		return false;
	}
	if(document.getElementById('timestamp').value) {
		if(!document.getElementById('timestamp1').value) { 
			alert("Please enter Endtime.");
			document.getElementById('timestamp1').focus();
			return false;
		}
	}
	if(document.getElementById('timestamp2').value) {
		if(!document.getElementById('timestamp21').value) { 
			alert("Please enter Endtime.");
			document.getElementById('timestamp21').focus();
			return false;
		}
	}
	if(document.getElementById('timestamp3').value) {
		if(!document.getElementById('timestamp31').value) { 
			alert("Please enter Endtime.");
			document.getElementById('timestamp31').focus();
			return false;
		}
	}
	if(document.getElementById('timestamp4').value) {
		if(!document.getElementById('timestamp41').value) { 
			alert("Please enter Endtime.");
			document.getElementById('timestamp41').focus();
			return false;
		}
	}
	return true;
}

function showHidemore() {
	if(document.getElementById('service').value == '1518' || document.getElementById('service').value == '1509') {
		document.getElementById('more').style.display='none';
		document.getElementById('time1').style.display='block';
		document.getElementById('time2').style.display='none';
		document.getElementById('time3').style.display='none';
		document.getElementById('time4').style.display='none';
	} else {
		document.getElementById('more').style.display='block';
	}
}

</script>

<form name="tstest" action='DirectActivation.php' method='POST' onSubmit="return validateData();">

<table border='1' align='center' width="23%">
<tr>
	<td>Service</td>
	<td><!--<input type='text' name='service' value='Airtel-VH1' readonly>-->
		<select name='service' id="service" onchange="showHidemore()">
			<option value='1507'>Airtel-VH1</option>
			<option value='1518'>Airtel-CMD</option>
			<option value='1509'>Airtel-RIA</option>
		</select></td>
</tr>
<tr><td>Circle</td><td>
<?php
	echo "<select name='circle[]' id='circle1' multiple='multiple'>";
	for($i=0;$i<10;$i++) 
	{
		foreach($circle_info as $circle_id=>$circle_val)
			{
				echo "<option value=$circle_id>$circle_val</option>";
			}
	}
	echo "</select>";
?>
<tr><td width="40%">Short Code:</td><td><select name='Scode'>
		<option value='55841'>55841</option>
		<option value='5584112'>5584112</option>
		<option value='5464612'>5464612</option>
		<option value='5500169'>5500169</option>
	</select>
</td></tr>
<tr>
	<td colspan=2 width="100%">
		<div id='time1' style="display:none;">
			<table border=1>
				<tr><td>Select Start Time:&nbsp;</td><td><input type="Text" name="timestamp" id="timestamp" value="">
						<a href="javascript:show_calendar('document.tstest.timestamp', document.tstest.timestamp.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
				</td></tr>
				<tr><td>Select End Time:&nbsp;</td><td><input type="Text" name="timestamp1" id="timestamp1" value="">
						<a href="javascript:show_calendar('document.tstest.timestamp1', document.tstest.timestamp1.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
				</td></tr>
			</table>
		<div>
		<div id='time2' style="display:none;">
			<table border=1>
				<tr><td>Select Start Time:&nbsp;</td><td><input type="Text" name="timestamp2" id="timestamp2" value="">
						<a href="javascript:show_calendar('document.tstest.timestamp2', document.tstest.timestamp2.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
				</td></tr>
				<tr><td>Select End Time:&nbsp;</td><td><input type="Text" name="timestamp21" id="timestamp21" value="">
						<a href="javascript:show_calendar('document.tstest.timestamp21', document.tstest.timestamp21.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
				</td></tr>
			</table>
		<div>
		<div id='time3' style="display:none;">
			<table border=1>
				<tr><td>Select Start Time:&nbsp;</td><td><input type="Text" name="timestamp3" id="timestamp3" value="">
						<a href="javascript:show_calendar('document.tstest.timestamp3', document.tstest.timestamp3.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
				</td></tr>
				<tr><td>Select End Time:&nbsp;</td><td><input type="Text" name="timestamp31" id="timestamp31" value="">
						<a href="javascript:show_calendar('document.tstest.timestamp31', document.tstest.timestamp31.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
				</td></tr>
			</table>
		<div>
		<div id='time4' style="display:none;">
			<table border=1>
				<tr><td>Select Start Time:&nbsp;</td><td><input type="Text" name="timestamp4" id="timestamp4" value="">
						<a href="javascript:show_calendar('document.tstest.timestamp4', document.tstest.timestamp4.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
				</td></tr>
				<tr><td>Select End Time:&nbsp;</td><td><input type="Text" name="timestamp41" id="timestamp41" value="">
						<a href="javascript:show_calendar('document.tstest.timestamp41', document.tstest.timestamp41.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
				</td></tr>
			</table>
		<div>
	</td>
</tr>
<tr>
	<td colspan=2><div id="more" align='right' style='display:block'><a href="#" onclick="javascript:showDateTime();">Add more time..</div></td>
</tr>
<tr><td colspan='2' align='center'><input type='Submit' name='submit' value='submit' onSubmit="return validateData();"/></tr>
</table>

</form>
<?php
if(isset($_POST['submit']))
{
	/*echo "<pre>";
	print_r($_POST);*/
	$con = mysql_connect("10.2.73.160","billing","billing");

	foreach($_POST['circle'] as $key=>$circleValue) { 
		$serviceId = $_POST['service'];
		if($serviceId == 1507) $serviceName = 'Airtel-VH1';
		elseif($serviceId == 1518) $serviceName = 'Airtel-CMD';
		elseif($serviceId == 1509) $serviceName = 'Airtel-RIA';

		$selectQuery="SELECT id FROM master_db.tbl_direct_act WHERE circle='".$circleValue."' AND shortCode='".$_POST['Scode']."' AND servicename='".$serviceName."' and service_id='".$serviceId."' LIMIT 1";
		$queryIns = mysql_query($selectQuery);
		list($id)=mysql_fetch_row($queryIns);
		if($id) {
			$Query="UPDATE master_db.tbl_direct_act SET addon=NOW() where circle='".$circleValue."' and shortCode='".$_POST['Scode']."' and servicename='".$serviceName."' and service_id='".$serviceId."'";
			$queryIns = mysql_query($Query);
			if($_POST['timestamp'] && $_POST['timestamp1']) {
				$delQuery = "DELETE FROM master_db.tbl_direct_act_time WHERE sId='".$id."'";
				mysql_query($delQuery);
				$InsertQuery = "INSERT INTO master_db.tbl_direct_act_time(sId, start_time, end_time, addon) VALUES (".$id.",'".date("Y-m-d H:i:s",strtotime($_POST['timestamp']))."','".date("Y-m-d H:i:s",strtotime($_POST['timestamp1']))."', NOW())";
				mysql_query($InsertQuery);
				$logData = "Update#".$serviceName."#".$circleValue."#".$_POST['Scode']."#".$_POST['timestamp']."#".$_POST['timestamp1']."\n";
				error_log($logData, 3, $logPath);
			}
			if($_POST['timestamp2'] && $_POST['timestamp21']) {
				$InsertQuery1 = "INSERT INTO master_db.tbl_direct_act_time(sId, start_time, end_time, addon) VALUES (".$id.",'".date("Y-m-d H:i:s",strtotime($_POST['timestamp2']))."','".date("Y-m-d H:i:s",strtotime($_POST['timestamp21']))."', NOW())";
				mysql_query($InsertQuery1);
				$logData = "Update#".$serviceName."#".$circleValue."#".$_POST['Scode']."#".$_POST['timestamp2']."#".$_POST['timestamp21']."\n";
				error_log($logData, 3, $logPath);
			}
			if($_POST['timestamp3'] && $_POST['timestamp31']) {
				$InsertQuery2 = "INSERT INTO master_db.tbl_direct_act_time(sId, start_time, end_time, addon) VALUES (".$id.",'".date("Y-m-d H:i:s",strtotime($_POST['timestamp3']))."','".date("Y-m-d H:i:s",strtotime($_POST['timestamp31']))."', NOW())";
				mysql_query($InsertQuery2);
				$logData = "Update#".$serviceName."#".$circleValue."#".$_POST['Scode']."#".$_POST['timestamp3']."#".$_POST['timestamp31']."\n";
				error_log($logData, 3, $logPath);
			}
			if($_POST['timestamp4'] && $_POST['timestamp41']) {
				$InsertQuery3 = "INSERT INTO master_db.tbl_direct_act_time(sId, start_time, end_time, addon) VALUES (".$id.",'".date("Y-m-d H:i:s",strtotime($_POST['timestamp4']))."','".date("Y-m-d H:i:s",strtotime($_POST['timestamp41']))."', NOW())";
				mysql_query($InsertQuery3);
				$logData = "Update#".$serviceName."#".$circleValue."#".$_POST['Scode']."#".$_POST['timestamp4']."#".$_POST['timestamp41']."\n";
				error_log($logData, 3, $logPath);
			}
		} else {
			$Query="Insert into master_db.tbl_direct_act values('','".$serviceName."','".$serviceId."','".$circleValue."',NOW(),'".$_POST['Scode']."')";
			$queryIns = mysql_query($Query);
			$insertID = mysql_insert_id();		
			if($_POST['timestamp'] && $_POST['timestamp1']) {
				$InsertQuery = "INSERT INTO master_db.tbl_direct_act_time(sId, start_time, end_time, addon) VALUES (".$insertID.",'".date("Y-m-d H:i:s",strtotime($_POST['timestamp']))."','".date("Y-m-d H:i:s",strtotime($_POST['timestamp1']))."', NOW())";
				mysql_query($InsertQuery);
				$logData = "Insert#".$serviceName."#".$circleValue."#".$_POST['Scode']."#".$_POST['timestamp']."#".$_POST['timestamp1']."\n";
				error_log($logData, 3, $logPath);
			}
			if($_POST['timestamp2'] && $_POST['timestamp21']) {
				$InsertQuery1 = "INSERT INTO master_db.tbl_direct_act_time(sId, start_time, end_time, addon) VALUES (".$insertID.",'".date("Y-m-d H:i:s",strtotime($_POST['timestamp2']))."','".date("Y-m-d H:i:s",strtotime($_POST['timestamp21']))."', NOW())";
				mysql_query($InsertQuery1);
				$logData = "Insert#".$serviceName."#".$circleValue."#".$_POST['Scode']."#".$_POST['timestamp2']."#".$_POST['timestamp21']."\n";
				error_log($logData, 3, $logPath);
			}
			if($_POST['timestamp3'] && $_POST['timestamp31']) {
				$InsertQuery2 = "INSERT INTO master_db.tbl_direct_act_time(sId, start_time, end_time, addon) VALUES (".$insertID.",'".date("Y-m-d H:i:s",strtotime($_POST['timestamp3']))."','".date("Y-m-d H:i:s",strtotime($_POST['timestamp31']))."', NOW())";
				mysql_query($InsertQuery2);
				$logData = "Insert#".$serviceName."#".$circleValue."#".$_POST['Scode']."#".$_POST['timestamp3']."#".$_POST['timestamp31']."\n";
				error_log($logData, 3, $logPath);
			}
			if($_POST['timestamp4'] && $_POST['timestamp41']) {
				$InsertQuery3 = "INSERT INTO master_db.tbl_direct_act_time(sId, start_time, end_time, addon) VALUES (".$insertID.",'".date("Y-m-d H:i:s",strtotime($_POST['timestamp4']))."','".date("Y-m-d H:i:s",strtotime($_POST['timestamp41']))."', NOW())";
				mysql_query($InsertQuery3);
				$logData = "Insert#".$serviceName."#".$circleValue."#".$_POST['Scode']."#".$_POST['timestamp4']."#".$_POST['timestamp41']."\n";
				error_log($logData, 3, $logPath);
			}
		}
	}
	
}
?>