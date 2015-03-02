<?php
session_start();
if(isset($_SESSION['authid']))
{
	//include("config/dbConnect.php");
	require_once("incs/db.php");
		//mysql_select_db($DB_DATABASE_M, $dbConn) or die(mysql_error());
?>
<center>
<?php
$query1 = "select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success where msisdn='".$_GET[msisdn]."' and service_id='".$_REQUEST[service_info]."' and event_type in('Recharged','Recharge Failed') order by date_time desc limit 30";
	$query=mysql_query($query1,$dbConn) or die(mysql_error());
$numofrows=mysql_num_rows($query);
if($numofrows==0)
{?>
<div width="85%" align="left" class="txt">
<div class="alert alert-block">
<FONT COLOR="#FF0000"> <B><h4>Ooops!</h4>Hey, we couldn't seem to find any record of <?php echo $_GET['msisdn']; ?></B></FONT><br/></div>
</div>
<?php
}
else
{
?>
<div width="85%" align="left" class="txt">
<div class="alert alert-block">
<FONT COLOR="#FF0000"> <B>Charging details for <?php echo $_GET['msisdn']; ?></B></FONT><br/>&nbsp;&nbsp;&nbsp;<i>Displaying last 30 transactions </i>
</div>
</div>
<center><br/>
<TABLE width="95%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="table table-condensed table-bordered">
  <thead>
  <TR height="30">
	<TD bgcolor="#FFFFFF" align="center"><B>Mobile No</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Billing ID</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Trans id</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Event Type</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Date Time</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Attempt Amount</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Aval Balance</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Chrg Amount</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Mode</B></TD>
  </TR>
    </thead>
	<?php
	//$query=mysql_query($query1,$dbConn) or die(mysql_error());
	while(list($billing_ID,$trans_id, $event_type, $date_time, $amount,$aval_amount, $chrg_amount,$MODE) = mysql_fetch_array($query)) {
	?>
	  <TR height="30">
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $_GET['msisdn']; ?></TD>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $billing_ID; ?></TD>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $trans_id; ?></TD>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $event_type; ?></TD>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $date_time; ?></TD>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $amount; ?></TD>
		<?php
		if($aval_amount==-1)
			$aval_amount='PostPaid';
		else
			$aval_amount=number_format(($aval_amount/100),2);
		if($aval_amount=='0.00')
			$aval_amount='NA';
		?>
		<TD bgcolor="#FFFFFF" align="right"><?php echo $aval_amount; ?>&nbsp;</TD>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $chrg_amount; ?></TD>
		<?php
			if($MODE=='null')
				$MODE='';

		?>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $MODE; ?></TD>
	  </TR>
	  <?php }?>
</TABLE>
<?php
	
	mysql_close($dbConn);}
}
?>
