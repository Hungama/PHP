<?php
session_start();
//if(isset($_SESSION['authid']))
//{
	require_once("incs/db.php");
	require_once("language.php");
	$service_info_duration=$_REQUEST['subsrv'];
	$msisdn=$_REQUEST['msisdn'];
    $serviceId = $_REQUEST['service_info'];
?>
<div width="85%" align="left" class="txt">
<div class="alert"><a href="javascript:viewbillinghistory('<?php echo $msisdn; ?>','<?php echo $_REQUEST['service_info']?>','<?php echo $service_info_duration;?>')" id="Refresh"><i class="icon-refresh"></i></a>&nbsp;Billing details for <?php echo $_REQUEST['msisdn']; ?>&nbsp;displaying last 30 transactions </i>
</div></div>
<TABLE width="95%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="table table-condensed table-bordered">
  <thead>
  <TR height="30">
	<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_ANI;?> </B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_BILLINGID;?></B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_TRANSACTIONID;?></B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_EVENTTYPE;?></B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_DATETIME;?></B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_ATTEMPT_AMOUNT;?></B></TD>
	<!--TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_AVAL_BALANCE;?></B></TD-->
	<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_CHARGE_AMOUNT;?></B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_MODE;?></B></TD>
  </TR>
  </thead>
<?php
	/*
$query1 ="select * from (select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success where msisdn='".$msisdn."' and service_id='".$serviceId."' union ";
	$query1 .="select '' as billing_id,'' as trans_id,'UNSUB' as event_type,unsub_date as date_time,'0' as amount,'0' as aval_amount,'0' as chrg_amount,unsub_reason as 'mode' from ";
	*/
	
	
		$select_query2_main = "select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success nolock where msisdn='".$msisdn."' and service_id='".$serviceId."' and event_type not in('Recharged','Recharge Failed')";
		
		$select_query2_bak = "select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success_backup nolock  where msisdn='".$msisdn."' and service_id='".$serviceId."' and event_type not in('Recharged','Recharge Failed')";
		if($service_info_duration==1)
		{
		$query1 = "select * from (".$select_query2_main." UNION ".$select_query2_bak; 		
		}
		else if($service_info_duration==2)
		{
		$query1 =  "select * from (".$select_query2_main; 
		}
		
		$query1 .= " union select '' as billing_id,'' as trans_id,'UNSUB' as event_type,unsub_date as date_time,'0' as amount,'0' as aval_amount,'0' as chrg_amount,unsub_reason as 'mode' from ";
		
	switch($_REQUEST['service_info'])
	{
		case '1302':
			$query1 .="vodafone_hungama.tbl_jbox_unsub ";
		break;
		case '1307':
			$query1 .="vodafone_vh1.tbl_jbox_unsub ";
		break;
		case '1310':
			$query1 .="vodafone_redfm.tbl_jbox_unsub ";
		break;
		case '1301':
			$query1.= "vodafone_radio.tbl_radio_unsub ";
		break;
	}
	$query1 .="where ani='".$msisdn."') as record order by date_time desc limit 30";

	$query=mysql_query($query1,$dbConn) or die(mysql_error());
	
	while(list($billing_ID,$trans_id, $event_type, $date_time, $amount,$aval_amount, $chrg_amount,$MODE) = mysql_fetch_array($query)) {
	?>
	  <TR height="30">
		<TD bgcolor="#FFFFFF" align="center"><?php echo $msisdn; ?></TD>
		<TD bgcolor="#FFFFFF" align="center"><?php echo $billing_ID; ?></TD>
		<TD bgcolor="#FFFFFF" align="center"><?php echo $trans_id; ?></TD>
		<TD bgcolor="#FFFFFF" align="center"><?php echo $event_type; ?></TD>
		<TD bgcolor="#FFFFFF" align="center">
		<?php if(!empty($date_time)){echo date('j-M \'y g:i a',strtotime($date_time));} else {echo '-';}?>
		</TD>
		<TD bgcolor="#FFFFFF" align="center"><?php echo 'Rs. '.$amount; ?></TD>
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
		<!--TD bgcolor="#FFFFFF" align="right"><?php echo $aval_amount; ?>&nbsp;</TD-->
		<TD bgcolor="#FFFFFF" align="center"><?php echo 'Rs. '.$chrg_amount; ?></TD>
		<?php
			if($MODE=='null')
				$MODE='';

		?>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php if($MODE=='push') { $MODE='OBD1'; } elseif($MODE=='push2') { $MODE='OBD2';} echo $MODE; ?></TD>
	  </TR>
	  <?php }?>
	  </TBODY>
</TABLE>
	  <?php
	  
	mysql_close($dbConn);
?>