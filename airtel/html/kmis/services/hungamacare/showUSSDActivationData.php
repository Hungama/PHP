<?php
	include("config/dbConnect.php");
	session_start();
	include("web_admin.js");
	include("header.php");
	
	
if($_SESSION['usrId']) {
	$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST', 'MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai', 'ORI'=>'Orissa', 'KAR'=>'Karnataka','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh', 'JNK'=>'Jammu-Kashmir', 'PUB'=>"Punjab", 'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','UND'=>'Other','HAY'=>'Haryana');
?>
<script language="javascript">

function validateData() {
	return true;
}

function showStatusConfirm(st) { 
	if(st == 'strt') {
		var answer = confirm("Are You Sure To Want Start Selected Time-Slot?");
		if(answer) return true;
		else return false;
	} 
	if(st == 'end') {
		var answer = confirm("Are You Sure To Want End Selected Time-Slot?");
		if(answer) return true;
		else return false;
	}
}

function showDeleteConfirm() {
	var answer = confirm("Are You Sure To Want Delete Selected Time-Slot?");
	if(answer) return true;
	else return false;
}
</script>
<div class='txt' align='right'><a href='directUSSDact.php'>Add Time-Slots</a>&nbsp;&nbsp;&nbsp;</div><br/>

<form name="tstest" action='showUSSDActivationData.php' method='POST' onSubmit="return validateData();">
<TABLE width="30%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
<tr>
	<td bgcolor="#FFFFFF" height="30px" width='50%'>&nbsp;&nbsp;<b>Service</b></td>
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;
		<select name='service' id="service" class="txt">			
			<option value=''>Select Service</option>
			<option value='1518' <?php if($_REQUEST['service'] == '1518') echo "SELECTED";?>>Airtel-MPMC</option>
			<option value='1507' <?php if($_REQUEST['service'] == '1507') echo "SELECTED";?>>Airtel-VH1</option>
			<option value='1515' <?php if($_REQUEST['service'] == '1515') echo "SELECTED";?>>Airtel-SARNAM</option>
			<option value='1513' <?php if($_REQUEST['service'] == '1513') echo "SELECTED";?>>Airtel-MND</option>	
		</select>
	</td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height="30px">&nbsp;&nbsp;<b>Circle</b></td>
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='circle' id='circle' class="txt">
		<option value="0">Select circle</option>
	<?php foreach($circle_info as $circle_id=>$circle_val) { ?>
		<option value='<?php echo $circle_id;?>' <?php if($_REQUEST['circle']==$circle_id) echo "SELECTED";?>><?php echo $circle_val;?></option>
	<?php } ?>
	</select></td>
</tr>
<tr><td colspan='2' align='center' bgcolor="#FFFFFF" align="center"><input type='Submit' name='submit' value='submit' onSubmit="return validateData();"/></tr>
</table>

</form>
<br/><br/><br/>
<?php
if($_REQUEST['service']) {
	$serviceId = $_REQUEST['service'];				
	
	if($_REQUEST['id'] && $_REQUEST['act']) {
		$actionId = $_REQUEST['id'];
		$actionType = $_REQUEST['act']; 
		if($actionType == 'strt') {
			$startQuery = "UPDATE master_db.tbl_ussd_activation SET status=1 WHERE id=".$actionId;	
			mysql_query($startQuery);
		} elseif($actionType == 'end') {
			$endQuery = "UPDATE master_db.tbl_ussd_activation SET status=0 WHERE id=".$actionId;	
			mysql_query($endQuery);
		} elseif($actionType == 'del') {
			$delQuery = "DELETE FROM master_db.tbl_ussd_activation WHERE id=".$actionId;	
			mysql_query($delQuery);
		} 
	}

	$query = "select id,service_id,serviceName,starttime,endtime,type,status,circle from master_db.tbl_ussd_activation WHERE service_id='".$serviceId."'";
	if($_REQUEST['circle']) { $circle = $_REQUEST['circle'];
		$query .= " and circle='".$circle."'";
	} else $circle='';
	$result = mysql_query($query);
	$count = mysql_num_rows($result);
	if($count) { $i=1;?>
		<div align="center"><b>Time-Slots</b></div></br>
		<table width="60%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">	
		<tr>
			<td bgcolor="#FFFFFF" height="30px" align="center"><b>S.No.</b></td>
			<td bgcolor="#FFFFFF" height="30px" align="center"><b>Service Name</b></td>
			<td bgcolor="#FFFFFF" height="30px" align="center"><b>Circle</b></td>
			<td bgcolor="#FFFFFF" height="30px" align="center"><b>Start Time</b></td>
			<td bgcolor="#FFFFFF" height="30px" align="center"><b>End Time</b></td>
			<td bgcolor="#FFFFFF" height="30px" align="center"><b>Status</b></td>
			<td bgcolor="#FFFFFF" height="30px" align="center"><b>Action</b></td>
		</tr>
	<?php while($row = mysql_fetch_array($result)) { 
		$serviceId = $row['service_id'];
		$sId = $row['id'];
		$serviceName = $row['serviceName'];
		$circleCode = $row['circle'];
		$circleName = $circle_info[$circleCode];
		$startTime = $row['starttime'];
		$endTime = $row['endtime'];
		if($row['status'] == 1) { $status='Start'; $action='end';}
		elseif($row['status'] == 0) { $status='Stop'; $action='strt';}
	?>	
		<tr>
			<td bgcolor="#FFFFFF" height="30px" align="center"><?php echo $i;?></td>
			<td bgcolor="#FFFFFF" height="30px">&nbsp;&nbsp;<?php echo $serviceName;?></td>
			<td bgcolor="#FFFFFF" height="30px">&nbsp;&nbsp;<?php echo $circleName;?></td>
			<td bgcolor="#FFFFFF" height="30px" align="center"><?php echo $startTime;?></td>
			<td bgcolor="#FFFFFF" height="30px" align="center"><?php echo $endTime;?></td>
			<td bgcolor="#FFFFFF" height="30px" align="center"><?php echo $status;?></td>
			<td bgcolor="#FFFFFF" height="30px" align="center"><a href='showUSSDActivationData.php?id=<?php echo $sId;?>&act=<?php echo $action;?>&service=<?php echo $serviceId;?>&circle=<?php echo $circle;?>' onclick='javascript: return showStatusConfirm("<?php echo $action;?>");'>Start/Stop</a> | <a href='showUSSDActivationData.php?id=<?php echo $sId;?>&act=del&service=<?php echo $serviceId;?>&circle=<?php echo $circle;?>' onclick='return showDeleteConfirm();'>Delete</a></td> <!-- return showStatusConfirm(<?php echo $action;?>); -->
		</tr>
	<?php $i++; } ?>
		</table>
	<?php } else { ?>
		<div class='txt' align='center'><b>No Record Found</b></div>
	<?php }
}
} else {
	echo "Please Do The Login First<Br>";
	echo "<a href='http://10.2.73.156/kmis/services/hungamacare'>Click Here to Login</a>";
}
?>