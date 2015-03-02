<?php
include("session.php");
error_reporting(0);
//include database connection file
/*
if($_SESSION["id"]=="279")
     	{
		 // echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=listallmissed-client.php">';
		}
		else
		{
		*/
include("db.php");
$today=date("Y-m-d");
$displaydate;
/*
$sql_getmsisdnlist = mysql_query("select a.ANI as ANI,date(a.date_time) as date_time,a.DNIS as DNIS,a.circle as circle,a.operator as operator, b.customer_name as customer_name,b.town as town,b.verification_done as verification_done,b.memebership_card_dp as memebership_card_dp,b.memebership_card_rv as memebership_card_rv,c.amount as amount from newseleb_hungama.tbl_max_bupa_details as a LEFT JOIN newseleb_hungama.msdn_info as b ON  a.ANI=b.mobile_no LEFT JOIN newseleb_hungama.tbl_mnd_recharge as c
     ON a.ANI = c.mdn  WHERE  date(a.date_time) = '$today'");	
	*/ 
	 $sql_getmsisdnlist = mysql_query("select count(*) as totalno, ANI from newseleb_hungama.tbl_max_bupa_details group by ANI");
$displaydate=$today;
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
	<div id="middle" >
		<div id="left-column">
		<?php include('left-sidebar.php');?>	
		</div>
		<div id="center-column1" style="width:600px">
			<div class="top-bar">
				<h1>List MSISDN </h1>
				</div>
		  <div class="select-bar">
		    <?php //echo $_REQUEST[msg];?>
			</div>
			 <div class="table" style="width:600px">
				<!--img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" /-->
			
			<table class="listing" cellpadding="0" cellspacing="0" style="width:600px" >
								

<?php

if($totalrecord>0)
{?>
	<!--tr><th colspan="2">Total no of <?//= $totalrecord;?> records found of date <?//=$displaydate;?>.</th></tr-->
	 <thead><tr>
					<th>Msisdn</th>
					<th>Total No</th>
	</tr> </thead>
		<?php
	while($result_list = mysql_fetch_array($sql_getmsisdnlist))
				{
if(!empty($result_list['ANI']))
{
?>
<tr>
<td width="50%"><?=$result_list['ANI']?></td>
<td width="50%"><?=$result_list['totalno']?></td>
</tr>
<?php
}
				}
}
else
{?>
<tr><th colspan="2">No records found.</th></tr>
<?php
}			
?></table>
				    
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
<?php
//}?>