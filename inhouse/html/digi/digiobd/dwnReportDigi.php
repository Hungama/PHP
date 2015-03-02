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
				<h1>Download DIGI OBD Data</h1>
				
				</div><br />
		  <div class="select-bar">
		    <?php echo $_REQUEST[msg];?>
			</div>			
			 <div class="table">
				
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />

				<form name="dwlForm" method="post" action="downloadData2.php" onsubmit="return validateDwlForm();">
				<table class="listing form" cellpadding="0" cellspacing="0">
					<tr>
						<th class="full" colspan="2">Information</th>
					</tr>
					<tr class="bg">
						<td class="first"><strong>Please Select Date</strong></td>
						<td class="last" valign='bottom'><input type="text" id="selDate" name="selDate" maxlength="25" size="25" readonly>&nbsp;<a href="javascript:NewCal('selDate','DDMMYYYY',true,24)"><img src="img/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td>
					</tr>
					<tr class="bg">
						<td class="first"><strong>Please select Type </strong></td>
						<td class="last">
                       <select name="type" id="type">
						<option value="">Select Type</option>
						<option value="1">Success</option>
						<option value="10">Failure</option>
						<option value="11">Key Press Data</option>
				  		</select>
						</td>
					</tr>					
					<!--<tr class="bg">
						<td class="first"><strong>Key Press Data</strong></td>
						<td class="last"></td>
					</tr>-->
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