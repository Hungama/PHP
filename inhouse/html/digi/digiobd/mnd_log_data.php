<?php
//include("session.php");
error_reporting(0);
//include database connection file
//include("db.php");
 $DB_HOST_M224     = '10.2.73.160'; //'172.28.106.4'; //DB HOST
 $DB_USERNAME_M224 = 'billing';  //DB Username
 $DB_PASSWORD_M224 = 'billing';  //DB Password 'Te@m_us@r987';
 $con = mysql_connect($DB_HOST_M224,$DB_USERNAME_M224,$DB_PASSWORD_M224);
if (!$con)
 {
  die('Could not connect: ' . mysql_error("could not connect to Local"));
 }
$today=date("Y-m-d");
$displaydate;
if($_POST['action'] == 1) {
	
		//$StartDate=$_POST['obd_form_startdate'];
		$StartDate = date("Y-m-d",strtotime($_POST['obd_form_startdate']));
		$displaydate=$StartDate;
		$sql_getmsisdnlist = mysql_query("select ANI,service,status,date_time,dtmf,doc_name,circle from mis_db.tbl_dtmf_logging WHERE  date(date_time) = '$StartDate'");
	}
	else
	{
	$sql_getmsisdnlist = mysql_query("select ANI,service,status,date_time,dtmf,doc_name,circle from mis_db.tbl_dtmf_logging WHERE  date(date_time) = '$today'");	
    $displaydate=$today;
 }
 if(empty($StartDate))
 {
 $viewdate=$displaydate;
 }
 else
 {
  $viewdate=$StartDate;
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
		 <div class="table" style="width:900px">
			<center>
		<table  cellpadding="6" cellspacing="6" style="border:1px solid #666;background: #eee;"  width="100%" border="1">
				<tr><td colspan="7" id="txtHint" style="color:#FF0000;display:none"></td></tr>
				<form action="mnd_log_data.php" method="post">
				<tr class="bg">
					<td class="last" colspan="7"><strong>Select Date</strong> &nbsp; &nbsp; &nbsp;
					<input type="text" id="startdate" maxlength="25" size="25" name="obd_form_startdate" value="<?php echo $viewdate;?>">
						<a href="javascript:NewCal('startdate','ddmmmyyyy',true,24)"><img src="img/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
						<input type="hidden" name="action" value="1" />
						<input type="submit" name="submit" value="Go"/>
						&nbsp;&nbsp;
					</td>
						
			</tr>
					</form>
				

<?php

if($totalrecord>0)
{?>
	<tr><th colspan="7">Total no of <?= $totalrecord;?> records found of date <?=$displaydate;?>.</th></tr>
	<tr style="background:#6495ED;color:#ffffff">
					<th class="first">Msisdn</th>
					<th>Service</th>
					<th>Status</th>
					<th>DTMF</th>
					<th>DOC_Name</th>
					<th>Circle</th>
					<th>Date-Time</th>
				</tr>
		<?php
	while($result_list = mysql_fetch_array($sql_getmsisdnlist))
				{
					//$i++;
if(!empty($result_list['ANI']))
{
if($result_list['status']=='1')
{
$type='Active User';
}
else if($result_list['status']=='-1')
{
$type='Non Active User';
}
else if($result_list['status']=='11')
{
$type='Grace User';
}
else
{
$type=$result_list['status'];
}
?>
					<tr style="">
						<td><?=$result_list['ANI']?></td>
						<td>
						<?php if($result_list['service']=='1513') echo 'Airtel MND'; else echo $result_list['service'];?></td>
    					<td><?=$type?></td>
						<td><?=$result_list['dtmf']?></td>
						<td><?php echo wordwrap($result_list['doc_name'], 8, "\n", true)?></td>
						<td><?=$result_list['circle']?></td>
						<td><?=$result_list['date_time']?></td>
					</tr>
				<?php
}
				}
}
else
{?>
<tr><th colspan="7">No records found.</th></tr>
<?php
}
				
?>
			
					</table></center>
				        <p>&nbsp;</p>
		  </div>

		<?php include('right-sidebar.php');
//close database connection
mysql_close($con);
?>
	  </div>
	<div id="footer"></div>
</div>


</body>
</html>