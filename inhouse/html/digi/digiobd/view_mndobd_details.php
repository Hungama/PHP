<?php
include("session.php");
error_reporting(0);
$mnd=$_GET['msisdn'];
//include database connection file
include("db.php");
$today=date("Y-m-d");
$displaydate;
//LEFT JOIN newseleb_hungama.tbl_mnd_recharge as b ON  a.ANI=b.mdn WHERE a.ANI='9344642823'
	//$sql_getmsisdnlist = mysql_query("select a.ANI as ANI,date(a.date_time) as date_time,a.DNIS as DNIS,a.circle as circle,a.operator as operator, b.customer_name as customer_name,b.town as town,b.verification_done as verification_done,b.memebership_card_dp as memebership_card_dp,b.memebership_card_rv as memebership_card_rv from newseleb_hungama.tbl_max_bupa_details as a LEFT JOIN newseleb_hungama.msdn_info as b ON  a.ANI=b.mobile_no WHERE a.ANI=$mnd");	
	$sql_getmsisdnlist = mysql_query("select count(*) as totalno, odb_name as odb_name,sum(duration) as duration from hul_hungama.tbl_hulobd_success_fail_details where ANI=$mnd and service='HUL_PROMOTION' and status=2 group by odb_name");
	//select odb_name,sum(duration) from hul_hungama.tbl_hulobd_success_fail_details where ANI='9787709889' and service='HUL_PROMOTION' group by odb_name
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
	<div id="middle" >
	<div id="center-column1" style="width:600px">
			<div class="top-bar">
				<h1>OBD Details Of - <?=$mnd?></h1>
				</div>
		 			 <div class="table" style="width:600px">
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
		<table class="listing" cellpadding="0" cellspacing="0" style="width:600px" >
						

<?php

if($totalrecord>0)
{?>
<tr>
					<th>OBD List</th>
					<th>Content modules accessed (y/n)</th>
					<th>Content module access frequency</th>
					<th>Average time spent on content module per access</th>
				</tr>
		<?php
	while($result_list = mysql_fetch_array($sql_getmsisdnlist))
				{
?>
<tr>
<td width="100"><b><?=($result_list['odb_name'])?></b></td>
<td><?php if(!empty($result_list['duration'])) {echo 'Y';} else {echo "N";}?></td>		
<td><?php if(!empty($result_list['totalno'])) {echo $result_list['totalno'];} else {echo "--";}?></td>
<!--td><?php //if(!empty($result_list['duration'])) {echo $result_list['duration'];} else {echo "--";}?></td-->
<td><?php 
if(!empty($result_list['duration'])) 
{
$avgvalue=$result_list['duration']/$result_list['totalno'];
$avgfrq=round($avgvalue, 0, PHP_ROUND_HALF_UP);
echo $avgfrq;
} else {echo "--";}
?></td>
</tr>
<?php
 	}
}
else
{?>
<tr><th colspan="5">No records found.</th></tr>
<?php
}			
?></table>
				        <p>&nbsp;</p>
		  </div>
		</div>
		<div id="right-column">
<?php
//close database connection
mysql_close($con);
?>
	  </div>
	</div>
	</div>
</body>
</html>