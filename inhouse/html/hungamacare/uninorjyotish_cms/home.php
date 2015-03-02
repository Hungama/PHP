<?php //include("session.php");
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
				<a href="logout.php" class="button">Logout</a>
				<!--h1>Upload OBT Data---Please don't use this file right now..it's under process..</h1-->
				<h1>Upload OBD Data</h1>
				</div><br />
		  <div class="select-bar">
		    <?php echo $_REQUEST[msg];?>
			</div>
			 <div class="table">
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
				<form name="obd_up_form" method="post" action="saveobdfileinfo.php" onsubmit="return validate_obd_form()" enctype="multipart/form-data">
				<table class="listing form" cellpadding="0" cellspacing="0">
					<tr>
						<th class="full" colspan="2">Information</th>
					</tr>
					<tr class="bg">
						<td class="first"><strong>Please select circle</strong></td>
						<td class="last">
                       <select name="obd_form_region" id="obd_form_region" onchange="javascript:setRegion(this.value)">
						<option value="">Select any one--</option>
						<option value="Indian">Indian</option>
						<option value="Nepali">Nepali</option>
				    	<option value="Bengali">Bengali</option>
						</select>
						</td>
					</tr>
					<tr>
						<td class="first" width="172"><strong>Upload mobile numbers</strong></td>
						<td class="last"><input type="file"  name="obd_form_mob_file" id="obd_form_mob_file"/><span style="color:#FF0000">(* Please uplaod a text file)</span></td>
					</tr>
				
					<tr class="bg">
						<td class="first"><strong>Upload Prompt</strong></td>
						<td class="last"><input type="file" name="obd_form_prompt_file" id="obd_form_prompt_file" /><span style="color:#FF0000">(* Please uplaod a mp3 file)</span></td>
					</tr>
				
					<tr class="bg">
						<td class="first"><strong>CLI</strong></td>
						<td class="last"><input type="text" class="text" name="obd_form_cli" id="obd_form_cli" readonly="true"/></td>
					</tr>
					<tr class="bg">
						<td class="first"><strong>Circle</strong></td>
						<td class="last"><input type="text" class="text" name="obd_form_circle" id="obd_form_circle" readonly="true"/>
						
						</td>
					</tr>
					<tr class="bg">
						<td class="first"><strong>Start Date</strong></td>
						<td class="last"><input type="text" id="startdate" maxlength="25" size="25" name="obd_form_startdate"><a href="javascript:NewCal('startdate','ddmmmyyyy',true,24)"><img src="img/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  		<span class="descriptions">Pick start date..</span></td>
					</tr>
<tr class="bg">
						<td class="first"><strong>End Date</strong></td>
						<td class="last"><input type="text" id="enddate" maxlength="25" size="25" name="obd_form_enddate"><a href="javascript:NewCal('enddate','ddmmmyyyy',true,24)"><img src="img/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  		<span class="descriptions">Pick end date..</span></td>
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
			<div class="box">Information for OBD</div>
	  </div>
	</div>
	<div id="footer"></div>
</div>


</body>
</html>
