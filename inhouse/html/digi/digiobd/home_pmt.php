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
			<h3>Header</h3>
			<ul class="nav">
				<li><a href="#">Add OBT Data</a></li>
<?php
/*
$checkfiletoprocess=mysql_query("select batchid,odb_filename,circle, startdate, enddate from tbl_obdrecording_log where status='0'");
$notorestore=mysql_num_rows($checkfiletoprocess);
if($notorestore==0)
{
				echo "<li><a href=\"#\">Cron Tab</a></li>";
}
else 
{
				echo "<li><a href=\"cronprocessobdfile.php\" target=\"_blank\">Cron Tab</a></li>";
}
*/
?>
				

			</ul>
			</div>
		<div id="center-column">
			<div class="top-bar">
				<a href="logout.php" class="button">Logout</a>
				<h1>Upload OBT Data</h1>
				</div><br />
		  <div class="select-bar">
		    <?php echo $_REQUEST[msg];?>
			</div>
			 <div class="table">
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
				<form name="obd_up_form" method="post" action="saveobdprompt.php"  enctype="multipart/form-data">
				<table class="listing form" cellpadding="0" cellspacing="0">
					<tr>
						<th class="full" colspan="2">Information</th>
					</tr>
					
				
					<tr class="bg">
						<td class="first"><strong>Upload Prompt</strong></td>
						<td class="last"><input type="file" name="obd_form_prompt_file" id="obd_form_prompt_file" /><span style="color:#FF0000">(* Please uplaod a mp3 file)</span></td>
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
