<?php
include("session.php");
error_reporting(0);
//include database connection file
include("db.php");
//echo "select odb_filename,uploadtime,processedtime,servicetype,capsuleid,prcocess_status from master_db.tbl_obdrecording_log  where date(processedtime)>='2012-12-01' and  servicetype !='DIGI' order by batchid DESC";
$sql_getmsisdnfilelist=mysql_query("select odb_filename,uploadtime,processedtime,servicetype,capsuleid,prcocess_status,status from master_db.tbl_obdrecording_log  where date(processedtime)>='2012-12-01' and  servicetype !='DIGI' order by batchid DESC");
$notorestore=mysql_num_rows($sql_getmsisdnfilelist);
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
				<h1>List Uploaded Files </h1>
				</div>
		  <div class="select-bar">
		    <?php echo $_REQUEST[msg];?>
			</div>
			 <div class="table">
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
		<table class="listing" cellpadding="0" cellspacing="0">
									

	<tr><th colspan="6">Total no of <?= $notorestore;?> files found.</th></tr>
	<tr>
					<th class="first">File Name</th>
					<th>Upload Time</th>
					<!--th>Processed Time</th-->
					<th>Service Type</th>
					<th>Capsule Name</th>
					<th>Prcocess Status</th>
				</tr>
		<?php
	while($result_list = mysql_fetch_array($sql_getmsisdnfilelist))
				{
				if($result_list['capsuleid']==1)
				{
				$capsulename='Capsule-1';
				}
				else if($result_list['capsuleid']==2)
				{
				$capsulename='Capsule-2';
				}
				else if($result_list['capsuleid']==3)
				{
				$capsulename='Capsule-3';
				}
				else if($result_list['capsuleid']==4)
				{
				$capsulename='Capsule-4';
				}
				else if($result_list['capsuleid']==5)
				{
				$capsulename='Capsule-5';
				}
				else if($result_list['capsuleid']==6)
				{
				$capsulename='Capsule-6';
				}
				else if($result_list['capsuleid']==7)
				{
				$capsulename='Rajnikanth Capsule';
				}
				else if($result_list['capsuleid']==8)
				{
				$capsulename='Newyear Capsule';
				}
				else if($result_list['capsuleid']==9)
				{
				$capsulename='Pongal Capsule';
				}
				?>
					<tr>
						<td>
						
<?php if($result_list['status']==3){ 
?>
<a href="obdrecording/hul/report/<?php echo $result_list['odb_filename']?>" target="_blank" style="color:#0000FF;font-weight:bold"><?php echo $result_list['odb_filename'];?></a>
<?php
} else { echo $result_list['odb_filename'];} ?>
						
						</td>

						<!--td><?=date("Y-m-d",strtotime($result_list['date_time']))?></td-->
						<td><?=$result_list['uploadtime']?></td>
						
						<!--td><?//=$result_list['processedtime']?></td-->
						<td><?=$result_list['servicetype']?></td>
		<td><?php if($result_list['servicetype']=='HUL_PROMOTION')	{ echo 'HULOBDRajnikanth';} else { echo $capsulename;}?> </td>
						<td><?=$result_list['prcocess_status']?></td>					
						
					</tr>
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