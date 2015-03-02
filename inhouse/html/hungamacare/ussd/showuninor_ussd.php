<?php 
include("session.php");
error_reporting(0);
//include database connection file
include("db.php");
if($_POST['action'] == 1)
 {
 $obd_form_ussd=$_REQUEST['obd_form_ussd'];
$obd_form_circle=$_REQUEST['obd_form_circle'];
$obd_form_ctype=$_REQUEST['obd_form_ctype'];
$curdate = date("Y_m_d-H_i_s");
$obd_form_ptid=$_REQUEST['obd_form_ptid'];
$obd_form_cid=$_REQUEST['obd_form_cid'];
//print_r ($obd_form_ptid)."<br>";
//print_r ($obd_form_cid);
for($i=0;$i<10;$i++)
{
$update_contentid = "UPDATE uninor_myringtone.tbl_ussd_mapping set contentid='".$obd_form_ptid[$i]."' where id='".$obd_form_cid[$i]."' and ussd_string='".$obd_form_ussd."'";
mysql_query($update_contentid);
}
$getdata = mysql_query("select * from uninor_myringtone.tbl_ussd_mapping where ussd_string='*288#'");
	$fileData='';
	$j=0;
	$contenttype='';
	while($row = mysql_fetch_array($getdata)) { 
	$contenttype=$row['contenttype'];
	$fileData[$j]['contentid'] = $row['contentid'];
	$fileData[$j]['id'] = $row['id'];
	$j++;
	}
 } 
 else
{
$getdata = mysql_query("select * from uninor_myringtone.tbl_ussd_mapping where ussd_string='*288#'");
	$fileData='';
	$j=0;
	$contenttype='';
	while($row = mysql_fetch_array($getdata)) { 
	$contenttype=$row['contenttype'];
	$fileData[$j]['contentid'] = $row['contentid'];
	$fileData[$j]['id'] = $row['id'];
	$j++;
	}
}

	?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<style media="all" type="text/css">@import "css/all.css";</style>
	<script language="javascript" type="text/javascript">
	function validate_form( )
{
if(document.getElementById("obd_form_ussd").value=='')
{
   alert ( "Please Select USSD." );
   document.getElementById("obd_form_ussd").focus();
   return false;
}
else if(document.getElementById("obd_form_circle").value=='')
{
   alert ( "Please Select Circle." );
   document.getElementById("obd_form_circle").focus();
   return false;
}
else if(document.getElementById("obd_form_ctype").value=='')
{
   alert ( "Please Select Content Type." );
   document.getElementById("obd_form_ctype").focus();
   return false;
}
else if(document.getElementById("obd_form_ptid_1").value=='')
{
   alert ( "Please Enter Content ID-1." );
   document.getElementById("obd_form_ptid_1").focus();
   return false;
}
else if(document.getElementById("obd_form_ptid_2").value=='')
{
   alert ( "Please Enter Content ID-2." );
   document.getElementById("obd_form_ptid_2").focus();
   return false;
}
else if(document.getElementById("obd_form_ptid_3").value=='')
{
   alert ( "Please Enter Content ID-3." );
   document.getElementById("obd_form_ptid_3").focus();
   return false;
}
else if(document.getElementById("obd_form_ptid_4").value=='')
{
   alert ( "Please Enter Content ID-4." );
   document.getElementById("obd_form_ptid_4").focus();
   return false;
}else if(document.getElementById("obd_form_ptid_5").value=='')
{
   alert ( "Please Enter Content ID-5." );
   document.getElementById("obd_form_ptid_5").focus();
   return false;
}else if(document.getElementById("obd_form_ptid_6").value=='')
{
   alert ( "Please Enter Content ID-6." );
   document.getElementById("obd_form_ptid_6").focus();
   return false;
}else if(document.getElementById("obd_form_ptid_7").value=='')
{
   alert ( "Please Enter Content ID-7." );
   document.getElementById("obd_form_ptid_7").focus();
   return false;
}else if(document.getElementById("obd_form_ptid_8").value=='')
{
   alert ( "Please Enter Content ID-8." );
   document.getElementById("obd_form_ptid_8").focus();
   return false;
}else if(document.getElementById("obd_form_ptid_9").value=='')
{
   alert ( "Please Enter Content ID-9." );
   document.getElementById("obd_form_ptid_9").focus();
   return false;
}
else if(document.getElementById("obd_form_ptid_10").value=='')
{
   alert ( "Please Enter Content ID-10." );
   document.getElementById("obd_form_ptid_10").focus();
   return false;
}
return true;
}
	</script>

</head>
<body>
<div id="main">
	<div id="header">
		<a href="index.html" class="logo"><img src="img/Hlogo.png" width="282" height="80" alt=""/></a>
		<!--ul id="top-navigation">
			<li class="active"><span><span>Home</span></span></li>
		</ul-->
	</div>
	<div id="middle">
		<div id="left-column">
			<?php include('left-sidebar.php');?>
			</div>
		<div id="center-column">
			<div class="top-bar">
				<!--h1>Upload OBT Data---Please don't use this file right now..it's under process..</h1-->
				<h1>USSD- Uninor My Ringtones</h1>
				
				</div><br />
		  <div class="select-bar">
		    <?php echo $_REQUEST[msg];?>
			</div>
			 <div class="table">
				
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />

				<form name="obd_up_form" method="post" action="showuninor_ussd.php" onsubmit="return validate_form()">
				<table class="listing form" cellpadding="0" cellspacing="0">
					<tr>
						<th class="full" colspan="2">Information</th>
					</tr>
			<tr class="bg">
						<td class="first"><strong>Please select USSD<span style="color:red">&nbsp;*</span></strong></td>
						<td class="last">
                       <select name="obd_form_ussd" id="obd_form_ussd">
						<option value="">Select any one--</option>
						<option value="*288#" selected>*288#</option>
						</select>
						</td>
					</tr>
					<tr class="bg">
						<td class="first"><strong>Please select Circle<span style="color:red">&nbsp;*</span></strong></td>
						<td class="last">
						<select name="obd_form_circle" id="obd_form_circle" onchange="">
						<option value="">Select any one--</option>
<?php
$circle_info=array('PAN'=>'PAN');
foreach($circle_info as $key=>$value) 
{
echo "<option value=\"$key\" selected>$value</option>";
}
?>                    </select>
						</td>
					</tr>
					<tr class="bg">
						<td class="first"><strong>Please select Content Type<span style="color:red">&nbsp;*</span></strong></td>
						<td class="last">
                       <select name="obd_form_ctype" id="obd_form_ctype">
						<option value="">Select any one--</option>
						<option value="PT" <?php if($contenttype=='PT') echo 'selected';?>>PT</option>
						<option value="TT" <?php if($contenttype=='TT') echo 'selected';?>>TT</option>
						</select>
						</td>
					</tr>
					<?php
					$i=1;
					foreach($fileData as $key=>$value) {?>
										<tr class="bg">
						<td class="first" width="172"><strong>Content ID-<?=$i?><span style="color:red">&nbsp;*</span></strong></td>
						<td class="last"><input type="text"  name="obd_form_ptid[]" id="obd_form_ptid_<?=$i?>" value='<?php echo $value['contentid'];?>'/></td>
						<input type="hidden"  name="obd_form_cid[]" id="obd_form_cid<?=$i?>" value='<?php echo $value['id'];?>'/>
					</tr>	
					<?php
					$i++;
					}
					
				/*
				while($result_list = mysql_fetch_array($getdata))
				{?>
				<tr class="bg">
						<td class="first" width="172"><strong>Content ID-<?=$i?><span style="color:red">&nbsp;*</span></strong></td>
						<td class="last"><input type="text"  name="obd_form_ptid[]" id="obd_form_ptid_<?=$i?>" value='<?php echo $result_list['contentid'];?>'/></td>
						<input type="hidden"  name="obd_form_cid[]" id="obd_form_cid<?=$i?>" value='<?php echo $result_list['id'];?>'/>
					</tr>
				<?php
				$i++;
				}		
				*/	
					?>
					<tr class="bg">
						<td class="first"><strong></strong></td>
						<input type="hidden" name="action" value="1" />
						<td class="last"><input type="submit" name="submit" value="Update"/></td>
					</tr>
					</table>
					</form>
	        <p>&nbsp;</p>
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
<?php
//close database connection
mysql_close($con);
?>