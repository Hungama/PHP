<?php
include("session.php");
error_reporting(0);
//include database connection file
include("db.php");
$today=date("Y-m-d");
$displaydate;
if($_POST['action'] == 1) {
	
		//$StartDate=$_POST['obd_form_startdate'];
		$StartDate = date("Y-m-d",strtotime($_POST['obd_form_startdate']));
		$displaydate=$StartDate;
$sql_getmsisdnlist = mysql_query("select a.ANI as ANI,date(a.date_time) as date_time,a.DNIS as DNIS,a.circle as circle,a.operator as operator, b.customer_name as customer_name,b.town as town,b.verification_done as verification_done,b.memebership_card_dp as memebership_card_dp,b.memebership_card_rv as memebership_card_rv from newseleb_hungama.tbl_max_bupa_details as a LEFT JOIN newseleb_hungama.msdn_info as b ON  a.ANI=b.mobile_no WHERE  date(a.date_time) = '$StartDate'");
//$sql_getmsisdnlist = mysql_query("select a.ANI as ANI,date(a.date_time) as date_time,a.DNIS as DNIS,a.circle as circle,a.operator as operator, b.customer_name as customer_name,b.town as town,b.verification_done as verification_done,b.memebership_card_dp as memebership_card_dp,b.memebership_card_rv as memebership_card_rv from newseleb_hungama.tbl_max_bupa_details as a ,newseleb_hungama.msdn_info as b WHERE  date(a.date_time) = '$StartDate' and a.ANI=b.mobile_no");
	}
	else
	{
	//$sql_getmsisdnlist = mysql_query("select a.ANI as ANI,date(a.date_time) as date_time,a.DNIS as DNIS,a.circle as circle,a.operator as operator, b.customer_name as customer_name,b.town as town,b.verification_done as verification_done,b.memebership_card_dp as memebership_card_dp,b.memebership_card_rv as memebership_card_rv from newseleb_hungama.tbl_max_bupa_details as a, newseleb_hungama.msdn_info as b WHERE  date(a.date_time) = '$today' and a.ANI=b.mobile_no");	
	$sql_getmsisdnlist = mysql_query("select a.ANI as ANI,date(a.date_time) as date_time,a.DNIS as DNIS,a.circle as circle,a.operator as operator, b.customer_name as customer_name,b.town as town,b.verification_done as verification_done,b.memebership_card_dp as memebership_card_dp,b.memebership_card_rv as memebership_card_rv from newseleb_hungama.tbl_max_bupa_details as a LEFT JOIN newseleb_hungama.msdn_info as b ON  a.ANI=b.mobile_no WHERE  date(a.date_time) = '$today'");	
$displaydate=$today;
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
	<div id="middle" >
		<div id="left-column">
		<?php include('left-sidebar.php');?>	
		</div>
		<div id="center-column1" style="width:700px">
			<div class="top-bar">
				<h1>List MSISDN </h1>
				</div>
		  <!--div class="select-bar">
		    <?php //echo $_REQUEST[msg];?>
			</div-->
			 <div class="table" style="width:700px">
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
		<table class="listing" cellpadding="0" cellspacing="0" style="width:700px" >
				<form action="listallmissed_new.php" method="post">
				<tr class="bg">
						<td colspan="9"><strong>Select Date &nbsp;&nbsp;&nbsp;</strong>
						<input type="text" id="startdate" maxlength="25" size="25" name="obd_form_startdate">
						<a href="javascript:NewCal('startdate','ddmmmyyyy',true,24)"><img src="img/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
						<input type="hidden" name="action" value="1" />
						<input type="submit" name="submit" value="Go"/>
						&nbsp;&nbsp;
				<?php

if($totalrecord>0)
{?>
				<a href="xls_listallmissed_new.php?sdate=<?=$StartDate?>&dtype=missedno" title="Click to download file.">
						<img src="img/download-icon.png" width="32" height="32" alt="" /></a>
<?php
} 
?>
						</td>
						
	 
		</tr>
					</form>
					

<?php

if($totalrecord>0)
{?>
	<tr><th colspan="9">Total no of <?= $totalrecord;?> records found of date <?=$displaydate;?>.</th></tr>
	<tr>
					<th>Msisdn</th>
					<th>Date</th>
					<th>Circle</th>
					<th>Operator</th>
					<th>Customer Name</th>
					<th>Town</th>
					<th>Verification</th>
					<th>Mcard_dp</th>
					<th>Mcard_rv</th>
				</tr>
		<?php
	while($result_list = mysql_fetch_array($sql_getmsisdnlist))
				{
if(!empty($result_list['ANI']))
{?>
<tr>
<td><?=$result_list['ANI']?></td>
<td width="100"><?=trim($result_list['date_time'])?></td>
<td><?php if(!empty($result_list['circle'])) {echo $result_list['circle'];} else {echo "--";}?></td>
<td><?php if(!empty($result_list['operator'])) {echo $result_list['operator'];} else {echo "--";}?></td>		
<td><?php if(!empty($result_list['customer_name'])) {echo $result_list['customer_name'];} else {echo "--";}?></td>
<td><?php if(!empty($result_list['town'])) {echo $result_list['town'];} else {echo "--";}?></td>
<td><?php if(!empty($result_list['verification_done'])) {echo $result_list['verification_done'];} else {echo "--";}?></td>
<td><?php if(!empty($result_list['memebership_card_dp'])) {echo $result_list['memebership_card_dp'];} else {echo "--";}?></td>
<td><?php if(!empty($result_list['memebership_card_rv'])) {echo $result_list['memebership_card_rv'];} else {echo "--";}?></td>
</tr>
<?php
}
				}
}
else
{?>
<tr><th colspan="9">No records found.</th></tr>
<?php
}			
?></table>
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