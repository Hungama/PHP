<?php
	session_start();
	error_reporting(0);
	
	if(empty($_SESSION['loginId']))
	{
	$redirect = "index.php?logerr=invalid";
	header("Location: $redirect");
	}
	include ("config/dbConnect.php");
	include("web_admin.js");
	include("header.php");
	//echo $_SESSION['loginId'];
	//$logPath = "/var/www/html/hungamacare/smsPackfile/log_".date("Y-m-d").".txt";
	$logPath = "/var/www/html/hungamacare/etisalatSMS/smsPackfile/log_".date("Y-m-d").".txt";

	$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAR'=>'Haryana','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Other','HAY'=>'Haryana','PAN'=>'PAN India');
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
</script>
<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
	   $matchday = $_REQUEST['matchday'];
		if(empty($matchday))
		{
		$matchday=0;
		}
		if($_REQUEST['service']) {
			$service = $_REQUEST['service'];
			$file = $_FILES['upfile'];
			
			$allowedExtensions = array("csv");
			function isAllowedExtension($fileName) {
				global $allowedExtensions;
				return in_array(end(explode(".", $fileName)), $allowedExtensions);
			}
			
			$tempFileName = explode(".", $_FILES['upfile']['name']) ;
			$dbfileName = str_replace(" ","_",$tempFileName[0])."_".date('Ymd');
			$makFileName = str_replace(" ","_",$tempFileName[0])."_".date('Ymd').".".$tempFileName[1];
			
			if(isAllowedExtension($file['name'])) {
				/*
				if($service == 'AST') { 
					$upDir="smsPackfile/AST/";					
					$messageTable = "";
			     	$planid=115;
				} 
				*/
				if($service == 'JOKES') { 
					$upDir="smsPackfile/JOKES/";
					//$planid=121;
					$planid=116;
				} elseif($service == 'SFL') {
					$upDir="smsPackfile/SFL/";
					$planid=119;
				} elseif($service == 'HW') {
					$upDir="smsPackfile/HW/";
					$planid=117;
				} elseif($service == 'FN') {
					$upDir="smsPackfile/FN/";
					$planid=118;
				}
				elseif($service == 'EPL') {
					$upDir="smsPackfile/EPL/";
					$planid=125;
				}
				elseif($service == 'LSP') {
					$upDir="smsPackfile/LSP/";
					$planid=174;
				}
				elseif($service == 'MOT') {
					$upDir="smsPackfile/MOT/";
					$planid=177;
				}
				elseif($service == 'HBP') {
					$upDir="smsPackfile/HBP/";
					$planid=251;// 250
				}
				elseif($service == 'DAP') {
					$upDir="smsPackfile/DAP/";
					$planid=248;// 247
				}
				elseif($service == 'CCP') {
					$upDir="smsPackfile/CCP/";
					$planid=245;// 244
				}
				elseif($service == 'LENTEN' || $service == 'LENTN' || $service == 'LNT' || $service == 'PRAYER' || $service == 'LENT')
				{ 
					$upDir="smsPackfile/LNT/";
					$planid=273;// 273(75),274(50),275(30)
				}
				
				
				
				$circleCode='NA';
				$path = $upDir.$makFileName;
				if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)) {
					$insert_query = "INSERT INTO etislat_hsep.tbl_sms_history_etisalat (servicename, serviceId, filename, date_time, status, circle, added_by,plainid,flagvalue) values ('".$service."', '2121', '".mysql_real_escape_string($dbfileName)."', NOW(), 0, '".$circleCode."', '".$_SESSION['loginId']."','".$planid."','".$matchday."')";
					mysql_query($insert_query);					
					$msg = "File uploded successfully.";
				}
				else
				{
				$msg = "Upload failed.";
				}
			} else {
				$msg = "Invalid file type, try again!!";
			}

		} else {
			$msg = "Please provide valid data, try again!!";
		}
	}
?>
<div align='center' class='txt'><FONT COLOR="#FF0000"><?php if(isset($msg)) echo $msg;?></FONT></div><br/>
<div align='left' class='txt'>&nbsp;&nbsp;&nbsp;<FONT COLOR="#FF0000"><B><a href='viewSMSpackMsg.php'>View Messages</a></B></FONT></div>
<form name="tstest" action='<?php echo $_SERVER["PHP_SELF"]; ?>' method='POST' onSubmit="return validateData();" enctype="multipart/form-data">

<table width="55%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
<tr height="30">
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<b>Service</b></td>
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='service' id="service" onchange="showHidemore()">
			<option value=''>Select Service</option>
			<!--option value='AST'>Horoscope</option-->
			<option value='DAP'>Anxiety</option>
			<option value='CCP'>Career Counselling</option>
			<option value='EPL'>English Premier League</option>
			<option value='FN'>Fun News</option>
			<option value='HW'>Hollywood</option>
			<option value='HBP'>Hygiene</option>
			<option value='JOKES'>Jokes</option>
			<option value='LSP'>Life Style</option>
			<option value='MOT'>Motivational</option>
			<option value='SFL'>Spanish Football League</option>
			<option value='LENTEN'>LENTEN</option>
			<option value='LENTN'>LENTN</option>
			<option value='LNT'>LNT</option>
			<option value='PRAYER'>PRAYER</option>
			<option value='LENT'>LENT</option>
					
		</select></td>
</tr>
<TR height="30">
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Browse File To Upload</B><br/>&nbsp;&nbsp;[<FONT COLOR="#FF0000">File format should be only .CSV and no comma(,) in the message column.<br/>&nbsp;&nbsp; Date format should be only in (Y-m-d) formate</FONT>]</TD>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<INPUT name="upfile" id='upfile' type="file" class="in"></TD>
</TR>
<TR height="30">
<td colspan="2" bgcolor="#FFFFFF" align="right">

<input type="checkbox" name="matchday" value="5">&nbsp;<b>Match Day</b>
</td>
</TR>
<tr><td bgcolor="#FFFFFF" colspan='2' align='center'><input type='Submit' name='submit' value='submit' onSubmit="return validateData();"/></tr>
</table>

</form>