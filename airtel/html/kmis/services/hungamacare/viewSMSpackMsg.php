<?php
	session_start();
	include ("config/dbConnect.php");
	include("web_admin.js");
	include("header.php");
	
	$logPath = "/var/www/html/kmis/services/hungamacare/smsPackfile/log_".date("Y-m-d").".txt";

	$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAR'=>'Haryana','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Other','HAY'=>'Haryana','PAN'=>'PAN India');
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
	if(document.getElementById('service').value =="") {
		alert("Please select service");
		document.getElementById('service').focus();
		return false;
	}
	if(document.getElementById('circle').value =="") {
		alert("Please select circle");
		document.getElementById('circle').focus();
		return false;
	}
	if(document.getElementById('upfile').value) {
		var file_name = document.getElementById('upfile').value;
		var ext = file_name.split('.');
		if(ext[1] == 'csv') {
			return true;
		} else {
			alert('Invalid file, Please upload .csv extention file only.');
			return false;
		}
	}
	return true;
}
</script>
<div align='left' class='txt'>&nbsp;&nbsp;&nbsp;<FONT COLOR="#FF0000"><B><a href='AirtelSmsMo.php'>Upload SMS File</a></B></FONT></div>
<form name="tstest" action='<?php echo $_SERVER["PHP_SELF"]; ?>' method='POST' onSubmit="return validateData();" enctype="multipart/form-data">

<table width="40%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
<tr height="30">
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<b>Service</b></td>
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='service' id="service" onchange="showHidemore()">
			<option value=''>Select Service</option>
			<option value='AST' <?php if($_REQUEST['service']=='AST') echo "SELECTED";?>>Airtel Astro</option>
			<option value='SE' <?php if($_REQUEST['service']=='SE') echo "SELECTED";?>>Airtel Sex Education</option>
			<option value='VAS' <?php if($_REQUEST['service']=='VAS') echo "SELECTED";?>>Airtel Vastu</option>
		</select></td>
</tr>
<tr height="30">
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<b>Circle</b></td>
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='circle' id='circle'>
		<option value="">Select circle</option>
	<?php foreach($circle_info as $circle_id=>$circle_val) { ?>
		<option value=<?php echo $circle_id;?> <?php if($_REQUEST['circle'] == $circle_id) echo "SELECTED";?>><?php echo $circle_val; ?></option>
	<?php } ?>
	</select>
</tr>
<tr><td bgcolor="#FFFFFF" colspan='2' align='center'><input type='Submit' name='submit' value='submit' onSubmit="return validateData();"/></tr>
</table>
</form>
<br/><br/>
<div>
<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		if($_REQUEST['service'] && $_REQUEST['circle']) {
			$service = $_REQUEST['service'];
			$circle = $_REQUEST['circle'];
			
			if($service == 'AST') { 				
				$messageTable = "airtel_smspack.TBL_ASTRO_MESSAGE";	
			} elseif($service == 'VAS') { 
				$messageTable = "airtel_smspack.TBL_VASTU_MESSAGE";
			} elseif($service == 'SE') {
				$messageTable = "airtel_smspack.TBL_SEXEDU_MESSAGE";
			}
			/*for($i=0; $i<count($circle); $i++) {
				$circleCode=$circle[$i];
			}*/
			if($service == 'AST') $selectList = "DATE_FORMAT(SMS_DATE, '%d-%m-%Y') as date,message,sunsign";
			else $selectList = "DATE_FORMAT(SMS_DATE, '%d-%m-%Y') as date,message";

			$selectData = "SELECT ".$selectList." FROM ".$messageTable." WHERE CIRCLE='".$circle."' and date(sms_date)!='0000-00-00' ";
			if($service == 'AST') $selectData .= " order by SMS_DATE,SUNSIGN";
			else $selectData .= " order by SMS_DATE desc";
			$result = mysql_query($selectData);
			
			$count = mysql_num_rows($result);
			$totalCount = $count;
			$i=1; 
			if($totalCount > 0) {?>
			<table class="txt2" bgcolor="#e6e6e6" border="0" cellpadding="0" cellspacing="1" width="80%" align='center'>
				<tr align='center'>
					<th style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="5%">S.No.</th>
					<th style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%">Date</th>
					<th style="padding-left: 5px;" bgcolor="#ffffff" height="35">Message</th>
					<?php if($service == 'AST') { ?>
						<th style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="8%">SunSign</th>
					<?php } ?>
				</tr>
			<?php while($row = mysql_fetch_array($result)) {
				$color="#ffffff";
				/*if($row['date']>date('d-m-Y')) $color="#ffffff";
				else $color="#ffffee";*/
				?>
				<tr>
					<td style="padding-left: 5px;" bgcolor="<?php echo $color; ?>" height="35" align='center'><?php echo $i; ?></td>
					<td style="padding-left: 5px;" bgcolor="<?php echo $color; ?>" height="35" align='center'><?php echo $row['date']; ?></td>
					<td style="padding-left: 5px;" bgcolor="<?php echo $color; ?>" height="35"><?php echo $row['message']; ?></td>
					<?php if($service == 'AST') { ?>
						<td style="padding-left: 5px;" bgcolor="<?php echo $color; ?>" height="35" align='center'><?php echo $row['sunsign']; ?></td>
					<?php } ?>	
				</tr>
			<?php $i++;} ?>
			</table>
			<?php } else { ?>
				<div align='center' class='txt'> No Data Available </div>
			<?php }
		}
	}
?>
</br>