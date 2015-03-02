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
<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		if($_REQUEST['service'] && $_REQUEST['circle']) {
			$service = $_REQUEST['service'];
			$circle = $_REQUEST['circle'];
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
					$upDir="smsPackfile/AST/";					
					$messageTable = "airtel_smspack.TBL_ASTRO_MESSAGE";	
				} elseif($service == 'VAS') { 
					$upDir="smsPackfile/VAS/";
					$messageTable = "airtel_smspack.TBL_VASTU_MESSAGE";
				} elseif($service == 'SE') {
					$upDir="smsPackfile/SE/";
					$messageTable = "airtel_smspack.TBL_SEXEDU_MESSAGE";
				}
				
				$path = $upDir.$makFileName;
				if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)) {
					for($i=0; $i<count($circle); $i++) {
						$circleCode=$circle[$i];
						$insert_query = "INSERT INTO airtel_smspack.tbl_smspack_history (servicename, serviceId, filename, date_time, status, circle, added_by) values ('".$service."', '1521', '".$dbfileName."', NOW(), 1, '".$circleCode."', '".$_SESSION['loginId']."')";
						mysql_query($insert_query);
											
						$path = "http://10.2.73.156/kmis/services/hungamacare/".$upDir.$makFileName;
						$fileData1=file($path);
						$sizeOfFile=count($fileData1);
						
						if($circleCode == 'PAN') {
							foreach($circle_info as $circleCode1=>$circleName) {
								if($circleCode1!='PAN') {
									for($k=0;$k<$sizeOfFile;$k++) {
										$fileData =  explode(",",$fileData1[$k]);
										$message1 = str_replace("'","\'",$fileData[1]);
										$message = str_replace('"','\"',$message1);
										if($service == 'AST') $sunsign = strtoupper(substr($fileData[2],0,3)); else $sunsign="";
										$tempDate = explode("/",$fileData[0]);
										$updateDate = $tempDate[2]."-".$tempDate[0]."-".$tempDate[1];
										$circle1 = $circleCode1;

										$selectData = "SELECT count(*) FROM ".$messageTable." WHERE date(SMS_DATE)='".$updateDate."' AND CIRCLE='".$circle1."'";
										if($service == 'AST') $selectData .= " AND SUNSIGN='".$sunsign."'";

										$result1= mysql_query($selectData);
										$countData = mysql_fetch_row($result1);
										if($countData[0]>0) {
											$insertData = "UPDATE ".$messageTable." SET MESSAGE='".trim($message)."' WHERE date(SMS_DATE)='".$updateDate."' AND CIRCLE='".$circle1."' ";
											if($service == 'AST') $insertData .= " AND SUNSIGN='".$sunsign."'";
										} else {
											$insertData = "INSERT INTO ".$messageTable." VALUES ('".$updateDate."','".$message."'";
											if($service == 'AST') $insertData .= ",'".$sunsign."'";
											$insertData .= ",'".$circle1."')";
										}
										mysql_query($insertData);
									}
								}
							}
						} else {
							for($k=0;$k<$sizeOfFile;$k++) {
								$fileData =  explode(",",$fileData1[$k]);
								$message1 = str_replace("'","\'",$fileData[1]);
								$message = str_replace('"','\"',$message1);
								if($service == 'AST') $sunsign = strtoupper(substr($fileData[2],0,3)); else $sunsign="";
								$tempDate = explode("/",$fileData[0]);
								$updateDate = $tempDate[2]."-".$tempDate[0]."-".$tempDate[1];
								
								$selectData = "SELECT count(*) FROM ".$messageTable." WHERE date(SMS_DATE)='".$updateDate."' AND CIRCLE='".$circleCode."'";
								if($service == 'AST') $selectData .= " AND SUNSIGN='".$sunsign."'";

								$result1= mysql_query($selectData);
								$countData = mysql_fetch_row($result1);
								if($countData[0]>0) {
									$insertData = "UPDATE ".$messageTable." SET MESSAGE='".trim($message)."' WHERE date(SMS_DATE)='".$updateDate."' AND CIRCLE='".$circleCode."' ";
									if($service == 'AST') $insertData .= " AND SUNSIGN='".$sunsign."'";
								} else {
									$insertData = "INSERT INTO ".$messageTable." VALUES ('".$updateDate."','".$message."'";
									if($service == 'AST') $insertData .= ",'".$sunsign."'";
									$insertData .= ",'".$circleCode."')";
								}
								mysql_query($insertData);
							}
						}
					}
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

<table width="40%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
<tr height="30">
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<b>Service</b></td>
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='service' id="service" onchange="showHidemore()">
			<option value=''>Select Service</option>
			<option value='AST'>Airtel Astro</option>
			<option value='SE'>Airtel Sex Education</option>
			<option value='VAS'>Airtel Vastu</option>
		</select></td>
</tr>
<tr height="30">
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<b>Circle</b></td>
	<td bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='circle[]' id='circle' multiple size=10>
		<option value="">Select circle</option>
	<?php foreach($circle_info as $circle_id=>$circle_val) {
		echo "<option value=$circle_id>$circle_val</option>";
	} ?>
	</select>
</tr>
<TR height="30">
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Browse File To Upload</B><br/>&nbsp;&nbsp;[<FONT COLOR="#FF0000">File format should be only .CSV and no comma(,) in the message column</FONT>]</TD>
	<TD bgcolor="#FFFFFF">&nbsp;&nbsp;<INPUT name="upfile" id='upfile' type="file" class="in"></TD>
</TR>
<tr><td bgcolor="#FFFFFF" colspan='2' align='center'><input type='Submit' name='submit' value='submit' onSubmit="return validateData();"/></tr>
</table>

</form>