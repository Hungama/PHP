<?php
include("session.php");
error_reporting(0);
//include database connection file
$addno=rand(50, 120);
$addno=60;
include("db.php");
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<style media="all" type="text/css">@import "css/all.css";</style>
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
				<h1>Total content usages </h1>
				</div>
		  <div class="select-bar">
		    <?php echo $_REQUEST[msg];?>
			<b>*Description of short code-</b>
				<p>Content modules accessed (Yes/No) - CMA</p>
				<p>Content modules accessed frequency - CMAF</p>
				<p>Average Time Spent On The Content (Yes/No) - ATS</p>
				<div style="float:left;padding:3px">
				<a href="xls_listall_usedcontent.php" title="Click to download file.">
						<img src="img/download-icon.png" width="32" height="32" alt="" /></a>
				</div>
			</div>
		
				
				<?php
				$sql_getmsisdnlist = mysql_query("select count(*) as totalno, ANI,SUM(duration) as duration ,operator,circle from hul_hungama.tbl_hulobd_success_fail_details where service='HUL' group by ANI");
				$totalrecord=mysql_num_rows($sql_getmsisdnlist);
				?>
			<table class="listing" cellpadding="0" cellspacing="0" style="width:600px" >

			  <thead>
					  <tr>
					<th class="first">Msisdn</th>
					<th>Duration(Till date -in sec)</th>
					<th>Total No of Missed Call</th>
					<th>CMA</th>
					<th>CMAF</th>
					<th>ATS</th>
					
				</tr>
</thead>
<?php
	while($result_list = mysql_fetch_array($sql_getmsisdnlist))
				{
				if($result_list['ANI']!='') {
 $sql_getmissedmsisdn = mysql_query("select count(*) as totalmissedno, ANI from newseleb_hungama.tbl_max_bupa_details where ANI='".$result_list['ANI']."'");
				 $result_list_missed = mysql_fetch_array($sql_getmissedmsisdn);
	if(!empty($result_list['duration'])) 
{
if($result_list['duration']==0) { $cmy='NO';} else {$cmy='YES';}
				if(!empty($result_list['totalno'])) {$cmyF=$result_list['totalno'];} else { $cmyF="--";}
$avgvalue=$result_list['duration']/$result_list['totalno'];
$avgfrq=round($avgvalue, 0, PHP_ROUND_HALF_UP);
$atsc=$avgfrq.' sec';
} else {
if($result_list['duration']==0) { $cmy='NO';} else {$cmy='YES';}
$atsc="--";
}

					?>
					<tr>
						
						<td><?=$result_list['ANI']?></td>
						<td><?=$result_list['duration']?></td>
						<td><?=$result_list_missed['totalmissedno']?></td>
						<td><?=$cmy?></td>
						<td><?=$cmyF?></td>
						<td><?=$atsc?></td>
     				</tr>
				<?php
				}	}
				
?>
		
					</table>
				
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