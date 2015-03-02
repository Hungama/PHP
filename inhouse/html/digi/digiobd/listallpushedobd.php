<?php
include("session.php");
error_reporting(0);
//include database connection file
include("db.php");


if($_POST['action'] == 1) {
	
		//$StartDate=$_POST['obd_form_startdate'];
$StartDate = date("Y-m-d",strtotime($_POST['obd_form_startdate']));
$sql_getmsisdnlist = mysql_query("select * from hul_hungama.tbl_hulobd_success_fail_details WHERE  date(date_time) = '$StartDate'");
}
	else
	{
 $sql_getmsisdnlist = mysql_query("select * from hul_hungama.tbl_hulobd_success_fail_details order by date_time DESC");	
 }
	$totalrecord=mysql_num_rows($sql_getmsisdnlist);
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<style media="all" type="text/css">@import "css/all.css";</style>
	<script language="javascript" type="text/javascript" src="datetimepicker/datetimepicker.js"></script>
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
				<h1>OBD Pushed  Details </h1>
				</div>
		  <div class="select-bar">
		    <?php echo $_REQUEST[msg];?>
			</div>
			 <div class="table">
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
		<table class="listing" cellpadding="0" cellspacing="0">
				<tr><td colspan="6" id="txtHint" style="color:#FF0000;display:none"></td></tr>
				<form action="listallpushedobd.php" method="post">
				<tr class="bg">
					<td class="first" colspan="6"><strong>Select Date</strong> <input type="text" id="startdate" maxlength="25" size="25" name="obd_form_startdate">
						<a href="javascript:NewCal('startdate','ddmmmyyyy',true,24)"><img src="img/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
						<td colspan="2">
						<input type="hidden" name="action" value="1" />
						<input type="submit" name="submit" value="Go"/>
						&nbsp;&nbsp;
				<?php
/*
if($totalrecord>0)
{?>
				<a href="xls_listallmissed.php?sdate=<?=$StartDate?>&dtype=missedno" title="Click to download file.">
						<img src="img/download-icon.png" width="32" height="32" alt="" /></a>
<?php
} 
*/
?>
						</td>
						
	 
		</td>
					</tr>
					</form>
					

<?php

if($totalrecord>0)
{?>
	<tr><th colspan="8">Total no of <?= $totalrecord;?> records found.</th></tr>
	<tr>
					<th class="first">Msisdn</th>
					<th>Service</th>
					<!--th>Status</th-->
					<th>Duration</th>
					<th>Operator</th>
					<th>Circle</th>
					<th>Odb Name</th>
					<th>Date & Time</th>
				</tr>
		<?php
	while($result_list = mysql_fetch_array($sql_getmsisdnlist))
				{
					//$i++;
if(!empty($result_list['ANI']))
{
					?>
					<tr>
						<td><?=$result_list['ANI']?></td>
						<td><?=$result_list['service']?></td>
						<!--td><?=$result_list['status']?></td-->
						<td><?=$result_list['duration']?></td>
						<td><?=$result_list['operator']?></td>
						<td><?=$result_list['circle']?></td>
						<td><?=$result_list['odb_name']?></td>
						<td><?=$result_list['date_time']?></td>
						
						
						
					</tr>
				<?php
}
				}
}
else
{?>
<tr><th colspan="4">No records found.</th></tr>
<?php
}
				
?>
			
					</table>
				        <p>&nbsp;</p>
		  </div>
		</div>
		<div id="right-column">
<?php include('right-sidebar.php');
//close database connection
mysql_close($con);
?>
	  </div>
	</div>
	<div id="footer"></div>
</div>


</body>
</html>