<?php
include("session.php");
error_reporting(0);
//include database connection file
include("db.php");
$sql_getussdlist=mysql_query("select id,ussd_string,circle,waplink,added_on,message,status,contentid,contenttype from uninor_myringtone.tbl_ussd_mapping order by id DESC");
$notorestore=mysql_num_rows($sql_getussdlist);
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
				<h1>All Mapping Data</h1>
				</div>
		  <div class="select-bar">
		    <?php echo $_REQUEST[msg];?>
			</div>
			 <div class="table">
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
		<table class="listing" cellpadding="0" cellspacing="0">
									

	<tr>
					<th class="first">USSD</th>
					<th>Circle</th>
					<th>Content ID</th>
					<th>Content Type</th>
					<th>Status</th>					
					<th>Added On</th>
					</tr>
		<?php
	while($result_list = mysql_fetch_array($sql_getussdlist))
				{
				?>
					<tr>
				<td><?=$result_list['ussd_string']?></td>
				<td><?=$result_list['circle']?></td>
				<td><?=$result_list['contentid']?></td>
				<td><?=$result_list['contenttype']?></td>				
				<td><?=$result_list['status']?></td>									
				<td><?=date("Y-m-d",strtotime($result_list['added_on']))?></td>		
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