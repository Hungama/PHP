<?php
	include("web_admin.js");
	include("header.php");
	include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
	
	$logPath = "/var/www/html/kmis/services/hungamacare/log/directAct/direct_act".date("Y-m-d").".txt";

	$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAY'=>'Haryana');

if(isset($_GET['act']) && isset($_GET['id'])) {
	if($_GET['act']=='del' && is_numeric($_GET['id'])) {
		$delId=$_GET['id'];
		$query="DELETE FROM master_db.tbl_subhandle WHERE id=".$delId;		
		mysql_query($query);
		$msg="Entry Deleted Successfully.";
	}
	elseif($_GET['act']=='edt' && is_numeric($_GET['id'])) {
		$edtId=$_GET['id'];
		$query="select id,service_id,circle,starttime,endtime,mode from master_db.tbl_subhandle where id=".$edtId;		
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result)) {
			$edtSid = $row['service_id'];
			$edtCir = $row['circle'];
			$edtOpt = $row['mode'];
			$edtStime = date("d-m-Y H:i:s",strtotime($row['starttime']));
			$edtEtime = date("d-m-Y H:i:s",strtotime($row['endtime']));
		}
	}
}

if(isset($_POST['submit']))
{
	$serviceId = $_POST['service'];		

	$selectQuery="SELECT id FROM master_db.tbl_subhandle WHERE service_id='".$serviceId."' and circle='".$_REQUEST['circle']."'";
	$queryIns = mysql_query($selectQuery);
	list($id)=mysql_fetch_row($queryIns);
	if($_POST['timestamp1']) $endtime=date("Y-m-d H:i:s",strtotime($_POST['timestamp1']));
	else $endtime="";
	if($id) {		
		$Query="UPDATE master_db.tbl_subhandle SET addon=NOW(),starttime='".date("Y-m-d H:i:s",strtotime($_POST['timestamp']))."',endtime='".$endtime."',mode='".$_REQUEST['mode']."' where circle='".$_REQUEST['circle']."' and service_id='".$serviceId."'";
		$queryIns = mysql_query($Query);			
		$msg="Entry updated successfully.";
	} else {
		$Query="INSERT into master_db.tbl_subhandle values('','".$serviceId."','".$_REQUEST['circle']."',NOW(),'".date("Y-m-d H:i:s",strtotime($_POST['timestamp']))."','".$endtime."','".$_REQUEST['mode']."')";
		$queryIns = mysql_query($Query);
		$msg="Entry inserted successfully.";
	}
	
}
?>
<script language="javascript">

function validateData() {
	if(document.getElementById('service').value=="") {
		alert("Please select service");
		document.getElementById('service').focus();
		return false;
	}
	if(document.getElementById('timestamp').value=="") {
		alert("Please enter Start time.");
		document.getElementById('timestamp').focus();
		return false;
	}
	/*if(document.getElementById('timestamp').value) {
		if(!document.getElementById('timestamp1').value) { 
			alert("Please enter Endtime.");
			document.getElementById('timestamp1').focus();
			return false;
		}
	}*/
	return true;
}
</script>

<form name="tstest" action='subHandling.php' method='POST' onSubmit="return validateData();">
<div class="txt" align='center'><?php if($msg) { echo $msg;}?><br/><br/></div>
<TABLE width="30%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
<TR>
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<b>Service</b></td>
	<td bgcolor="#FFFFFF"><?php $query="select service_id,service_name from master_db.tbl_service_master order by service_name";
		$result = mysql_query($query);?>
		<select name='service' id="service">
			<option value=''>Select service</option>
		<?php while($row=mysql_fetch_array($result)) { ?>
			<option value='<?php echo $row['service_id']?>' <?php if($row['service_id']==$edtSid) echo "SELECTED"; ?>><?php echo $row['service_name']?></option>
		<?php } ?>
		</select>
	</td>
</tr>
<tr><td bgcolor="#FFFFFF">&nbsp;&nbsp;<b>Circle</b></td><td bgcolor="#FFFFFF">
<?php
	echo "<select name='circle' id='circle'>";
	foreach($circle_info as $circle_id=>$circle_val) { ?>
		<option value='<?php echo $circle_id;?>' <?php if($circle_id == $edtCir) echo "SELECTED";?>><?php echo $circle_val;?></option>
	<?php }
	echo "</select>";
?>
<tr><td width="40%" bgcolor="#FFFFFF">&nbsp;&nbsp;<b>Subscription Mode</b></td>
	<td bgcolor="#FFFFFF"><select name='mode' id='mode'>
		<option value='single' <?php if($edtOpt == 'single') echo "SELECTED";?>>Single</option>
		<option value='double' <?php if($edtOpt == 'double') echo "SELECTED";?>>Double</option>>
	</select>
</td></tr>
<tr>
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<b>Select Start Time</b>&nbsp;</td><td bgcolor="#FFFFFF"><input type="Text" name="timestamp" id="timestamp" value="<?php if($edtStime) echo $edtStime;?>">
		<a href="javascript:show_calendar('document.tstest.timestamp', document.tstest.timestamp.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
	</td>
</tr>
<tr>
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<b>Select End Time</b>&nbsp;</td><td bgcolor="#FFFFFF"><input type="Text" name="timestamp1" id="timestamp1" value="<?php if($edtEtime) echo $edtEtime;?>">
		<a href="javascript:show_calendar('document.tstest.timestamp1', document.tstest.timestamp1.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
	</td>
</tr>			
<tr><td colspan='2' align='center' bgcolor="#FFFFFF"><input type='Submit' name='submit' value='submit' onSubmit="return validateData();"/></tr>
</table>

</form>

<TABLE width="55%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
<TR height="30" align='center'>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>S.No.</B></TD>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Service</B></TD>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Circle</B></TD>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Subscription Mode</B></TD>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>StartTime</B></TD>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>EndTime</B></TD>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Delete</B></TD>
</TR>
<?php $i=0;
$query = "select service_id,circle,starttime,endtime,mode,id from master_db.tbl_subhandle";
$result = mysql_query($query);
while($row = mysql_fetch_array($result)) { 
	$circle = strtoupper($row['circle']);
	$circleName = $circle_info[$circle];
	$query1 = "select service_name from master_db.tbl_service_master where service_id='".$row['service_id']."'";
	$result1 = mysql_query($query1);
	list($serviceName) = mysql_fetch_row($result1);
?>
<TR height="25">
	<TD bgcolor="#FFFFFF" align='center'><?php echo ++$i;?></TD>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<?php echo $serviceName;?></TD>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<?php echo $circleName; ?></TD>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<?php echo ucwords($row['mode']);?></TD>
	<TD bgcolor="#FFFFFF" align='center'><?php echo $row['starttime'];?></TD>
	<TD bgcolor="#FFFFFF" align='center'><?php echo $row['endtime'];?></TD>
	<TD bgcolor="#FFFFFF" align='center'><a href='subHandling.php?id=<?php echo $row['id']?>&act=edt'>Update</a> | <a href='subHandling.php?id=<?php echo $row['id']?>&act=del'>Delete</a></TD>
</TR>
<?php } ?>
</TABLE>