<?php 
include("session.php");
error_reporting(0);
//include database connection file
include("db.php");
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
else if(document.getElementById("obd_form_ptid").value=='')
{
   alert ( "Please Enter PT/TT ID." );
   document.getElementById("obd_form_ptid").focus();
   return false;
}
else if(document.getElementById("obd_form_ctype").value=='')
{
   alert ( "Please Select Content Type." );
   document.getElementById("obd_form_ctype").focus();
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

				<form name="obd_up_form" method="post" action="save_unr_ussdinfo.php" onsubmit="return validate_form()" enctype="multipart/form-data">
				<table class="listing form" cellpadding="0" cellspacing="0">
					<tr>
						<th class="full" colspan="2">Information</th>
					</tr>
			<tr class="bg">
						<td class="first"><strong>Please select USSD<span style="color:red">&nbsp;*</span></strong></td>
						<td class="last">
                       <select name="obd_form_ussd" id="obd_form_ussd">
						<option value="">Select any one--</option>
						<option value="*546*31#">*546*31#</option>
						<option value="*546*32#">*546*32#</option>
						<option value="*546*33#">*546*33#</option>
						<option value="*546*34#">*546*34#</option>
						<option value="*546*35#">*546*35#</option>
						<option value="*546*36#">*546*36#</option>
						<option value="*546*37#">*546*37#</option>
						<option value="*546*38#">*546*38#</option>
						<option value="*546*39#">*546*39#</option>
						</select>
						</td>
					</tr>
					<tr class="bg">
						<td class="first"><strong>Please select Circle<span style="color:red">&nbsp;*</span></strong></td>
						<td class="last">
						<select name="obd_form_circle" id="obd_form_circle" onchange="">
						<option value="">Select any one--</option>
<?php
//$circle_info=array('PAN'=>'PAN','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
$circle_info=array('PAN'=>'PAN','GUJ'=>'Gujarat','BIH'=>'Bihar','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','MUM'=>'Mumbai');
foreach($circle_info as $key=>$value) 
{
echo "<option value=\"$key\">$value</option>";
}
?>                    </select>
						</td>
					</tr>
					<tr class="bg">
						<td class="first"><strong>Please select Content Type<span style="color:red">&nbsp;*</span></strong></td>
						<td class="last">
                       <select name="obd_form_ctype" id="obd_form_ctype">
						<option value="">Select any one--</option>
						<option value="PT">PT</option>
						<option value="TT">TT</option>
						</select>
						</td>
					</tr>
					<tr>
						<td class="first" width="172"><strong>Content ID<span style="color:red">&nbsp;*</span></strong></td>
						<td class="last"><input type="text"  name="obd_form_ptid" id="obd_form_ptid"/></td>
					</tr>
					<tr class="bg">
						<td class="first"><strong></strong></td>
						<td class="last"><input type="submit" name="submit" value="submit"/></td>
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