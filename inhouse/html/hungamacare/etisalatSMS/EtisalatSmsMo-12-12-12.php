<?php
	session_start();
	include ("config/dbConnect.php");
	include("web_admin.js");
	include("header.php");
	
	$logPath = "/var/www/html/hungamacare/smsPackfile/log_".date("Y-m-d").".txt";

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
				if($service == 'AST') { 
					$upDir="smsPackfile/SFL/";					
					$messageTable = "";
				} elseif($service == 'JOKES') { 
					$upDir="smsPackfile/JOKES/";
				} elseif($service == 'SFL') {
					$upDir="smsPackfile/SFL/";
				} elseif($service == 'HW') {
					$upDir="smsPackfile/HE/";
				} elseif($service == 'FN') {
					$upDir="smsPackfile/FN/";
				}
				
				$path = $upDir.$makFileName;
				if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)) {
					/*$insert_query = "INSERT INTO airtel_smspack.tbl_smspack_history (servicename, serviceId, filename, date_time, status, circle, added_by) values ('".$service."', '1521', '".$dbfileName."', NOW(), 1, '".$circleCode."', '".$_SESSION['loginId']."')";
					mysql_query($insert_query);
										
					$path = "http://10.2.73.156/kmis/services/hungamacare/".$upDir.$makFileName;
					$fileData1=file($path);
					$sizeOfFile=count($fileData1);*/					
					$msg = "File uploded successfully.";
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
			<option value='AST'>Horoscope</option>
			<option value='JOKES'>Jokes</option>
			<option value='SFL'>Spanish Football League</option>
			<option value='EPL'>English Premier League</option>
			<option value='HW'>Hollywood</option>
			<option value='FN'>Fun News</option>
		</select></td>
</tr>
<TR height="30">
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Browse File To Upload</B><br/>&nbsp;&nbsp;[<FONT COLOR="#FF0000">File format should be only .CSV and no comma(,) in the message column</FONT>]</TD>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<INPUT name="upfile" id='upfile' type="file" class="in"></TD>
</TR>
<tr><td bgcolor="#FFFFFF" colspan='2' align='center'><input type='Submit' name='submit' value='submit' onSubmit="return validateData();"/></tr>
</table>

</form>