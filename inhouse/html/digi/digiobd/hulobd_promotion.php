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
	<script language="javascript" type="text/javascript" src="datetimepicker/datetimepicker.js"></script>
	<script language="javascript" type="text/javascript" src="js/validate.js"></script>
<script type="text/javascript">

function validate_hul_form( )
{
if(document.getElementById("obd_form_mob_file").value=='')
{
   alert ( "Please uplaod text file of mobile numbers." );
   document.getElementById("obd_form_mob_file").focus();
   return false;
}
else if(document.getElementById("obd_form_option").value=='')
{
alert ( "Please select service option." );
   document.getElementById("obd_form_option").focus();
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
				<h1>Upload HUL Promotional OBD Data</h1>
				</div><br />
		  <div class="select-bar">
		    <?php echo $_REQUEST[msg];?>
			</div>
			 <div class="table">
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
				<!--form name="obd_up_form" method="post" action="savehulobdfileinfo.php" onsubmit="return validate_obd_form()" enctype="multipart/form-data"-->
				<form name="obd_up_form" method="post" action="savehulobdfileinfo.php" onsubmit="return validate_hul_form()" enctype="multipart/form-data">
				<table class="listing form" cellpadding="0" cellspacing="0">
					<tr>
						<th class="full" colspan="2">Information</th>
					</tr>
									<tr>
						<td class="first" width="172"><strong>Upload File</strong></td>
						<td class="last"><input type="file"  name="obd_form_mob_file" id="obd_form_mob_file"/><span style="color:#FF0000"></span></td>
					</tr>
				
					<!--tr class="bg">
						<td class="first"><strong>Upload Prompt</strong></td>
						<td class="last"><input type="file" name="obd_form_prompt_file" id="obd_form_prompt_file" /><span style="color:#FF0000"></span></td>
					</tr-->
				
				
						<tr class="bg">
						<td class="first"><strong>Please select option</strong></td>
						<td class="last">
                       <select name="obd_form_option" id="obd_form_option">
						<option value="">Select any one--</option>
						<option value="HUL_PROMOTION">Promotional </option>
				    	
						</select>
						</td>
					</tr>
							<input type="hidden" name="promo" value="promo">		<!--tr class="bg">
						<td class="first"><strong>Start Date</strong></td>
						<td class="last"><input type="text" id="startdate" maxlength="25" size="25" name="obd_form_startdate"><a href="javascript:NewCal('startdate','ddmmmyyyy',true,24)"><img src="img/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  		<span class="descriptions">Pick start date..</span></td>
					</tr>
<tr class="bg">
						<td class="first"><strong>End Date</strong></td>
						<td class="last"><input type="text" id="enddate" maxlength="25" size="25" name="obd_form_enddate"><a href="javascript:NewCal('enddate','ddmmmyyyy',true,24)"><img src="img/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  		<span class="descriptions">Pick end date..</span></td>
					</tr-->
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
			<div class="box">Information for OBD</div>
	  </div>
	</div>
	<div id="footer"></div>
</div>


</body>
</html>
