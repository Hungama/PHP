<?php 
include("session.php");
error_reporting(1);
//include database connection file
include("db.php");
$uploadedby='ringt_admin';
$ipaddress=$_SERVER['REMOTE_ADDR'];
$service='ringtone';
$logPath = "logs/ringtone_file_upload_".date("Y-m-d").".txt";
?>
<?php  

		if($_SERVER['REQUEST_METHOD']=="POST" && $_REQUEST['ringtype']  && $_REQUEST['content_id']) {
			$rType = $_REQUEST['ringtype'];		
			$contentId = $_REQUEST['content_id'];
			$smsStatus=1;
			$serviceId = $_REQUEST['service_id'];
			$mode = $_REQUEST['channel'];
			
			$file = $_FILES['upfile'];
			$allowedExtensions = array("txt");
//echo $rType." ".$contentId." ".$serviceId." ".$mode ;
			function isAllowedExtension($fileName) {
					global $allowedExtensions;
					return in_array(end(explode(".", $fileName)), $allowedExtensions);
			}

			if(isAllowedExtension($file['name'])) {
				$uploaddir = "RBTBulkUpload/";
				if(!is_dir($uploaddir))
				{
					mkdir($uploaddir);
						chmod($uploaddir,0777);
				}

				$tempFileName = explode(".", $_FILES['upfile']['name']) ;
				$dbfileName = $tempFileName[0]."_ring"."_".date('YmdHis');
				$fileName = $dbfileName.".".$tempFileName[1];
				
				$makFileName = $fileName;
				$dbMakFileName = $tempFileName[0];
				
				$path = $uploaddir.$makFileName;
				//exit;
				
				if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)) {
	
	$lines = file($path);
$i=0;
foreach ($lines as $line_num => $mobno) 
{
$mno=trim($mobno);
if(!empty($mno))
{
$i++;
}
}
$totalcount=$i;
	
			$msg = "File uploaded successfully.<br/><br/>";
$insert_query = "INSERT INTO master_db.bulk_rbtsendsms_history (file_name, added_by, added_on, total_file_count,content_type, contentId,ip,service_id,mode) VALUES ('".$makFileName."', '".$uploadedby."',now(), '".$totalcount."','".$rType."','".$contentId."','".$ipaddress."','".$serviceId."','".$mode."')";
								
		mysql_query($insert_query,$con);
		$logData="uploadedby#".$uploadedby."#ipaddress#".$ipaddress."#filename#".$makFileName."#".date("Y-m-d H:i:s")."\r\n";;
	error_log($logData,3,$logPath);

					
			} else {
					$msg ="File not upload successfully, Please try again!";
				}
			} else {
				$msg = "Invalid file type, Please uplaod text file only";
			}
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<style media="all" type="text/css">@import "css/all.css";</style>
	<script language="javascript">

function checkfield() { 
	if(document.frm.ringtype.value  == "") {
		alert("Please select content type.");
		document.frm.ringtype.focus();
		return false;
	}
	if(document.frm.content_id.value  == "") {
		alert("Please enter content Id.");
		document.frm.content_id.focus();
		return false;
	}
	if(document.frm.upfile.value == "") {
		alert("Please upload text file.");
		document.frm.upfile.focus();
		return false;
	}
	if(document.frm.upfile.value) {
		var file_name = document.frm.upfile.value;
		var ext = file_name.split('.');
		if(ext[1] == 'txt') {
			return true;
		} else {
			alert('Invalid file, Please upload text file only.');
			return false;
		}
	}
	return true;
}

</script>
</head>
<body>
<div id="main">
	<div id="header">
		<a href="index.html" class="logo"><img src="img/Hlogo.png" width="282" height="80" alt=""/></a>
		</div>
	<div id="middle">
		<div id="left-column">
			<?php include('left-sidebar.php');?>
			</div>
		<div id="center-column">
			<div class="top-bar">
				<!--h1>Upload OBT Data---Please don't use this file right now..it's under process..</h1-->
				<h1>Admin-Home</h1>
				
				</div><br />
		  <div class="select-bar">
		    <?php echo $_REQUEST[msg];?>
			</div>
			 <div class="table">
				
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />

<form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()" enctype="multipart/form-data">
				<table class="listing form" cellpadding="0" cellspacing="0">
					<tr>
						<th class="full" colspan="2" style="text-align:center;font-size:14px">
						<?php  if($msg) { ?>
  			<?php echo ucwords($msg); ?>
		<?php } ?>
						</th>
					</tr>
			<tr class="bg">

				<td class="first"><strong>Content Type<span style="color:red">&nbsp;*</span></strong></td>
						<td class="last">
                       <select  name='ringtype' class='in'>
					<option value="">Select Type</option>
					<option value="pt">PolyTone</option>
					<option value="tt">TrueTone</option>
						</select>
						</td>
					</tr>
					<tr class="bg">
						<td class="first"><strong>Service Type<span style="color:red">&nbsp;*</span></strong></td>
						<td class="last">
						<B>Ringtone</B><INPUT TYPE='HIDDEN' value="1412" name="service_id">
						</td>
					</tr>
					<tr class="bg">
						<td class="first"><strong>Content Id :<span style="color:red">&nbsp;*</span></strong></td>
						<td class="last">
                       <INPUT TYPE="text" NAME="content_id">
						<span id="pricepoint_dd"></span>
						</td>
					</tr>
					
					<tr class="bg">
						<td class="first"><strong>Mode<span style="color:red">&nbsp;*</span></strong></td>
						<td class="last">
                     <select name="channel" id="channel" class="in">
				<option value='IVR'>IVR</option>
				<option value='OBD'>OBD</option>
				<option value='TC'>TELECALLING</option>
				<option value='USSD'>USSD</option>
				<option value='CCI'>CCI</option>
				<option value='IBD'>IBD</option>
				</select>
						</td>
					</tr>
		<tr class="bg">
			<td bgcolor="#FFFFFF"><B>Browse File To Upload <FONT COLOR="#FF0000">[.txt file]</B><br/>&nbsp;&nbsp;&nbsp;(text file must contain one 10 digit msisdn per line)</FONT></td>
			<td bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;<INPUT name="upfile" id='upfile' type="file" class="in"></td>
		  </tr>
					<tr class="bg">
						<td class="first"><strong></strong></td>
						<td class="last">
					<input name="Submit" type="submit" class="txtbtn" value="Submit" onSubmit="return checkfield();">
				&nbsp;<INPUT TYPE="reset" name="Reset">
					</td>
					</tr>
					</table>
					</form>
	        <span id="show_status"></span>
		  </div>
		</div>
		<div id="right-column">
			<strong class="h">INFO</strong>
			<div class="box">Information for Uninor</div>
	  </div>
	</div>
	<div id="footer"></div>
</div>


</body>
</html>