<?php
	include("config/dbConnect.php");

	include("web_admin.js");
	include("header.php");

	if($_SERVER['REQUEST_METHOD']=="POST") {
		if($_REQUEST['circle'] && $_REQUEST['religion'] && $_REQUEST['pricepoint'] && $_REQUEST['type']) {		
			$reqType = $_REQUEST['type'];
			
			$circle = $_REQUEST['circle'];
			$religion = $_REQUEST['religion'];
			$planId = $_REQUEST['pricepoint'];
			
			if(is_numeric($planId)) { 
				$amountQuery = mysql_query("SELECT iAmount FROM master_db.tbl_plan_bank WHERE Plan_id=".$planId);
				list($amount) = mysql_fetch_array($amountQuery);			
			} else {
				$amount = 0;
			}
			
			if($reqType == 'insert') { 
				$insertQuery = "INSERT INTO airtel_devo.tbl_religionPlan_detail (circle,religion,planId,amount,datetime,updatetime) VALUES ('".$circle."', '".$religion."','".$planId."','".$amount."',NOW(),NOW())";
			} elseif($reqType == 'update' && is_numeric($_REQUEST['id'])) {
				$id=$_REQUEST['id'];
				$insertQuery = "UPDATE airtel_devo.tbl_religionPlan_detail SET circle='".$circle."',religion='".$religion."',planId='".$planId."',amount='".$amount."',updatetime=NOW() WHERE id='".$id."'";
			}
			mysql_query($insertQuery);

		}
	}

	$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Other','HAY'=>'Haryana');

	if($_GET['id']) {
		$data = "SELECT circle,religion,planId FROM airtel_devo.tbl_religionPlan_detail WHERE id=".$_GET['id'];
		$result1 = mysql_query($data);
		while($row2=mysql_fetch_array($result1)) {
			$circle1=$row2['circle'];
			$religion1 = $row2['religion'];
			$planId1 = $row2['planId'];
		}
	}
?>
<script language="javascript">
</script>

<form name="tstest" action='<?php echo $_SERVER["PHP_SELF"]; ?>' method='POST' onSubmit="return validateData();">

<table border='1' align='center' width="23%">
<tr>
	<td >Circle</td>
	<td><?php  
		echo "<select name='circle' id='circle'>";
		foreach($circle_info as $circle_id=>$circle_val) {						
			if($circle1 == $circle_id) $select='SELECTED'; else $select='';
			echo "<option value=$circle_id $select>$circle_val</option>";
		}
		echo "</select>";
	?></td>
</tr>
<tr>
	<td>Religion</td>
	<td><select name='religion' id='religion'>
		<option value=''>Select Religion</option>				
		<option value='Budh' <?php if($religion1 == 'Budh') echo "SELECTED"; else "";?>>Budh</option>
		<option value='Christianity' <?php if($religion1 == 'Christianity') echo "SELECTED"; else "";?>>Christianity</option>
		<option value='Hindu' <?php if($religion1 == 'Hindu') echo "SELECTED"; else "";?>>Hindu</option>
		<option value='Jain' <?php if($religion1 == 'Jain') echo "SELECTED"; else "";?>>Jain</option>
		<option value='Muslim' <?php if($religion1 == 'Muslim') echo "SELECTED"; else "";?>>Muslim</option>
		<option value='Null' <?php if($religion1 == 'Null') echo "SELECTED"; else "";?>>Null</option>
		<option value='Sikh' <?php if($religion1 == 'Sikh') echo "SELECTED"; else "";?>>Sikh</option>
	</select></td>
</tr>
<tr>
	<td width="40%">Price Point</td>
	<td><?php $priceQuery = "SELECT Plan_id,iAmount from master_db.tbl_plan_bank where S_id='1515' order by iAmount";
		$priceData = mysql_query($priceQuery); ?>
	<select name='pricepoint' id='pricepoint'>
		<option value=''>Select Price Point</option>
		<option value='DEFAULT' <?php if($planId1 == "DEFAULT") echo "SELECTED"; else "";?>>DEFAULT</option>
		<?php while($row=mysql_fetch_array($priceData)) { ?>
			<option value="<?php echo $row['Plan_id']?>" <?php if($planId1 == $row['Plan_id']) echo "SELECTED"; else "";?>><?php echo "Rs.".$row['iAmount'];?></option>
		<?php } ?>
	</select>
	<?php if(is_numeric($_GET['id'])) { ?>
		<INPUT TYPE="hidden" name='id' id='id' value="<?php echo $_GET['id'];?>">
		<INPUT TYPE="hidden" name='type' id='type' value="update">
	<?php } else { ?>
		<INPUT TYPE="hidden" name='type' id='type' value="insert">
	<?php } ?>
	</td>
</tr>
<tr><td colspan='2' align='center'><input type='Submit' name='Add' value='Add' onSubmit="return validateData();"/></tr>
</table>
</form>
<br/><br/><br/>
<div align='center'>List</div>
<TABLE width="50%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
<TR height="30" align='center'>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>S.No.</B></TD>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Circle</B></TD>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Religion</B></TD>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Price Point</B></TD>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Update</B></TD>
</TR>
<?php $i=0;
$query = "SELECT id,circle,religion,planId,amount FROM airtel_devo.tbl_religionPlan_detail";
$result = mysql_query($query);
while($row = mysql_fetch_array($result)) { 
	$circle = strtoupper($row['circle']);
	$circleName = $circle_info[$circle];
	if(is_numeric($row['planId'])) $amount=" Rs. ".$row['amount'];
	else $amount=$row['planId'];
?>
<TR>
	<TD bgcolor="#FFFFFF" align='center'><?php echo ++$i;?></TD>
	<TD bgcolor="#FFFFFF"><?php echo $circleName; ?></TD>
	<TD bgcolor="#FFFFFF"><?php echo $row['religion'];?></TD>
	<TD bgcolor="#FFFFFF"><?php echo $amount;?></TD>
	<TD bgcolor="#FFFFFF"><a href='<?php echo $_SERVER["PHP_SELF"]."?id=".$row['id']; ?>'>Edit</a></TD>
</TR>
<?php } ?>
</TABLE>