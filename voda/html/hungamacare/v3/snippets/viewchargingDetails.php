<?php
session_start();
require_once("../../2.0/incs/db.php");
require_once("../../2.0/language.php");
$service_info_duration=$_REQUEST['subsrv'];
?>
<center>
<?php
$serviceQuery=mysql_query("SELECT S_id FROM master_db.tbl_plan_bank WHERE sname='".$_REQUEST[service_info]."'",$dbConn);
		list($serviceId)=mysql_fetch_array($serviceQuery);
		

$select_query2_main = "select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success where msisdn='".$_GET[msisdn]."' and service_id='".$serviceId."' and event_type in('Recharged','Recharge Failed')";
		
$select_query2_bak = "select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success_backup where msisdn='".$_GET[msisdn]."' and service_id='".$serviceId."' and event_type in('Recharged','Recharge Failed')";

$select_query3_bak = "select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success_04_06_2013 where msisdn='".$_GET[msisdn]."' and service_id='".$serviceId."' and event_type in('Recharged','Recharge Failed')";

if($service_info_duration==1)
		{
		$query1 = "select * from (".$select_query2_main." UNION ".$select_query2_bak." UNION ".$select_query3_bak; 	
		}
		else if($service_info_duration==2)
		{
		$query1 =  "select * from (".$select_query2_main." UNION ".$select_query2_bak; 
		}
		else if($service_info_duration==3)
		{
	$query1 =  "select * from (".$select_query2_main; 
		}

$query1 .=") as record order by date_time desc limit 30";

$query=mysql_query($query1,$dbConn) or die(mysql_error());
$numofrows=mysql_num_rows($query);
if($numofrows==0)
{?>
<div width="85%" align="left" class="txt">
<div class="alert alert-block">
<h4>Ooops!</h4>Hey, we couldn't seem to find any record of <?php echo $_GET['msisdn']; ?>
</div>
</div>
<?php
}
else
{
?>
<center><div width="85%" align="left" class="txt">
<div class="alert"><a href="javascript:viewchargingDetails('<?= $_GET['msisdn']; ?>','<?= $_REQUEST['service_info']?>','<?php echo $service_info_duration;?>')" id="Refresh"><i class="icon-refresh"></i></a>Charging details for <?php echo $_GET['msisdn']; ?>&nbsp;displaying last 30 transactions </i>
</div></div><center>

<TABLE width="95%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="table table-condensed table-bordered">
  <thead>
  <TR height="30">
	<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_ANI;?> </B></TD>
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
		<TD bgcolor="#FFFFFF" align="center"><?php echo $_GET['msisdn']; ?></TD>
		<TD bgcolor="#FFFFFF" align="center"><?php echo $billing_ID; ?></TD>
		<TD bgcolor="#FFFFFF" align="center"><?php echo $trans_id; ?></TD>
		<TD bgcolor="#FFFFFF" align="center"><?php echo $event_type; ?></TD>
		<TD bgcolor="#FFFFFF" align="center">
		<?php if(!empty($date_time)){echo date('j-M \'y g:i a',strtotime($date_time));} else {echo '-';}?>
		</TD>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo 'Rs. '.$amount; ?></TD>
		<?php
	/*	if($aval_amount==-1)
			$aval_amount='PostPaid';
		else
			$aval_amount=number_format(($aval_amount/100),2);
		if($aval_amount=='0.00')
			$aval_amount='NA';
		*/	
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
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo 'Rs. '.$chrg_amount; ?></TD>
		<?php
			if($MODE=='null')
				$MODE='-';

		?>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $MODE; ?></TD>
	  </TR>
	  <?php }?>
</TABLE>
<?php
	
	mysql_close($dbConn);}
?>