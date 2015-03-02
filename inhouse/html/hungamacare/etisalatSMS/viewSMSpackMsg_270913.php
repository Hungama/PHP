<?php
	session_start();
	include ("config/dbConnect.php");
	include("web_admin.js");
	include("header.php");
	
	$logPath = "/var/www/html/hungamacare/smsPackfile/log_".date("Y-m-d").".txt";

	$circle_info=array();
?>
<link rel="stylesheet" href="style.css" type="text/css">
<style type="text/css">
<!--
.style3 {font-family: "Times New Roman", Times, serif}
-->
</style>
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
function deleteMessage(msgid){
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}	
	xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) { 
			alert(xmlhttp.responseText);
					}
		}	

		var url = "deleteMessage.php?msgid="+msgid;
	
	xmlhttp.open("GET",url,true);
		xmlhttp.send();	

}
</script>
<div align='left' class='txt'>&nbsp;&nbsp;&nbsp;<FONT COLOR="#FF0000"><B>
<?php 
if($_SESSION['usrId']=='287')
{
?>
<a href='EtisalatSmsMo.php'>Upload SMS File</a>
<?php } ?>
</B></FONT></div>
<form name="tstest" action='<?php echo $_SERVER["PHP_SELF"]; ?>' method='POST' onSubmit="return validateData();" enctype="multipart/form-data">

<table width="40%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
<tr height="30">
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<b>Service</b></td>
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='service' id="service" onchange="showHidemore()">
			<option value=''>Select Service</option>
			<option value='AST' <?php if($_REQUEST['service']=='AST') echo "SELECTED";?>>Horoscope</option>
			<option value='JOKES' <?php if($_REQUEST['service']=='JOKES') echo "SELECTED";?>>Jokes</option>
			<option value='SFL' <?php if($_REQUEST['service']=='SFL') echo "SELECTED";?>>Spanish Football League</option>
			<option value='EPL' <?php if($_REQUEST['service']=='EPL') echo "SELECTED";?>>English Premier League</option>
			<option value='HW' <?php if($_REQUEST['service']=='HW') echo "SELECTED";?>>Hollywood</option>
			<option value='FN' <?php if($_REQUEST['service']=='FN') echo "SELECTED";?>>Fun News</option>
			<option value='LSP' <?php if($_REQUEST['service']=='LSP') echo "SELECTED";?>>Life Style</option>
			<option value='MOT' <?php if($_REQUEST['service']=='MOT') echo "SELECTED";?>>Motivational</option>
		</select></td>
</tr>
<!--<tr height="30">
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<b>Circle</b></td>
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='circle' id='circle'>
		<option value="">Select circle</option>
	<?php foreach($circle_info as $circle_id=>$circle_val) { ?>
		<option value=<?php echo $circle_id;?> <?php if($_REQUEST['circle'] == $circle_id) echo "SELECTED";?>><?php echo $circle_val; ?></option>
	<?php } ?>
	</select>
</tr>-->
<tr><td bgcolor="#FFFFFF" colspan='2' align='center'><input type='Submit' name='submit' value='submit' onSubmit="return validateData();"/></tr>
</table>
</form>
<br/><br/>
<div>
<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
	
		if($_REQUEST['service']) {
			$service = $_REQUEST['service'];
					
			if($service == 'AST') { 				
					$messageTable = "etislat_hsep.tbl_sms_astro";
				} elseif($service == 'JOKES') { 
					$messageTable="etislat_hsep.tbl_sms_service";
				} elseif($service == 'SFL') {
					$messageTable="etislat_hsep.tbl_sms_service";
				} elseif($service == 'HW') {
					$messageTable="etislat_hsep.tbl_sms_service";
				} elseif($service == 'FN') {
					$messageTable="etislat_hsep.tbl_sms_service";
				} elseif($service == 'EPL') {
					$messageTable="etislat_hsep.tbl_sms_service";
				}
				elseif($service == 'LSP') {
					$messageTable="etislat_hsep.tbl_sms_service";
				}
				elseif($service == 'MOT') {
					$messageTable="etislat_hsep.tbl_sms_service";
				}
			/*for($i=0; $i<count($circle); $i++) {
				$circleCode=$circle[$i];
			}*/
			
			//sun_sign
			//if($service == 'AST') $selectList = "DATE_FORMAT(date_time, '%d-%m-%Y') as date,message,sun_sign";
			//else $selectList = "DATE_FORMAT(date_time, '%d-%m-%Y') as date,message";
			if($service == 'AST') $selectList = "date_time as date,message,sun_sign,msg_id";
			else $selectList = "date_time as date,message,msg_id";

			$selectData = "SELECT ".$selectList." FROM ".$messageTable." WHERE service='".$service."' and date(date_time)!='0000-00-00' and date(date_time)!='01-01-1970'";
			if($service == 'AST') $selectData .= " order by date_time,sun_sign";
			else $selectData .= " order by msg_id DESC";
			
			//echo $selectData;
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
			<?php while($row = mysql_fetch_array($result)) { ?>
				<tr>
					<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center' onclick="deleteMessage('<?php echo $row['msg_id']; ?>')"><?php echo $i; ?></td>
					<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $row['date']; ?></td>
					<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><?php echo $row['message']; ?>
					</td>
					<?php if($service == 'AST') { ?>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $row['sun_sign']; ?></td>
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