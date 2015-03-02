<?php
session_start();
error_reporting(1);
	require_once("incs/db.php");
	require_once("language.php");
	$service_info_duration=$_REQUEST['subsrv'];
	$msisdn=$_REQUEST['msisdn'];
$query1 = "select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success where msisdn='".$msisdn."' and service_id='".$_REQUEST['service_info']."' and event_type in('MCoupon','MCoupon Failed') order by date_time desc limit 30";
	
?>
<div width="85%" align="left" class="txt">
<div class="alert"><a href="javascript:viewchargingDetails('<?= $msisdn; ?>','<?= $_REQUEST['service_info']?>')" id="Refresh"><i class="icon-refresh"></i></a>&nbsp;Charging details for <?php echo $_REQUEST['msisdn']; ?>&nbsp;displaying last 30 transactions </i>
</div></div>
 <?php
  $query=mysql_query($query1,$dbConn) or die(mysql_error());
	$num=mysql_num_rows($query1);
	if($num>1)
	{
	?>
	<TABLE width="95%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="table table-condensed table-bordered">
  <thead>
  <TR height="30">
<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_ANI;?></B></TD>
<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_BILLINGID;?></B></TD>
<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_TRANSACTIONID;?></B></TD>
<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_EVENTTYPE;?></B></TD>
<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_DATETIME;?></B></TD>			
<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_ATTEMPT_AMOUNT;?></B></TD>
<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_AVAL_BALANCE;?></B></TD>
<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_CHARGE_AMOUNT;?></B></TD>
<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_MODE;?></B></TD>

  </TR>
  </thead>
	<?php
	while(list($billing_ID,$trans_id, $event_type, $date_time, $amount,$aval_amount, $chrg_amount,$MODE) = mysql_fetch_array($query)) {
	?>
	<TR height="30">
	<TD bgcolor="#FFFFFF" align="center"><?php echo $msisdn; ?></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php if(!empty($billing_ID)){echo $billing_ID;} else {echo '-';} ?></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php if(!empty($trans_id)){echo $trans_id;} else {echo '-';} ?></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php if(!empty($event_type)){echo $event_type;} else {echo '-';} ?></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php if(!empty($date_time)){echo date('j-M \'y g:i a',strtotime($date_time));} else {echo '-';}?></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php if(!empty($amount)){echo 'Rs. '.$amount;} else {echo '-';}?></TD>
	
	<?php
		if($aval_amount==-1)
			$aval_amount='PostPaid';
		else
			$aval_amount=number_format(($aval_amount/100),2);
		if($aval_amount=='0.00')
		{
		$aval_amount='NA';
		}else
		{
			$aval_amount='Rs. '.$aval_amount;		
		}
		?>
		<TD bgcolor="#FFFFFF" align="right"><?php echo $aval_amount; ?>&nbsp;</TD>
		<TD bgcolor="#FFFFFF" align="center"><?php if(!empty($chrg_amount)){echo 'Rs. '.$chrg_amount;} else {echo '-';} ?></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php if(!empty($MODE)){echo $MODE;} else {echo '-';} ?></TD>
	</TR>	
		
	  </TABLE>
	  
<?php
	}
	}
	else {
			echo "<div class='alert alert-block'><h4>Ooops!</h4>No records found for this number.</div> ";
	   }
	mysql_close($dbConn);
?>