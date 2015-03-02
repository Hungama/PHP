<?php
session_start();
require_once("../../2.0/incs/db.php");
require_once("../../2.0/language.php");
$service_info_duration=$_REQUEST['subsrv'];
?>
<center><div width="85%" align="left" class="txt">
<div class="alert"><a href="javascript:viewbillinghistory('<?= $_GET['msisdn']; ?>','<?= $_REQUEST['service_info']?>','<?php echo $service_info_duration;?>')" id="Refresh"><i class="icon-refresh"></i></a>&nbsp;Billing details for <?php echo $_GET['msisdn']; ?>&nbsp;displaying last 30 transactions </i>
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
		$serviceQuery=mysql_query("SELECT S_id FROM master_db.tbl_plan_bank WHERE sname='".$_REQUEST[service_info]."'",$dbConn);
		list($serviceId)=mysql_fetch_array($serviceQuery);
		
		$select_query2_main = "select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success where msisdn='".$_GET[msisdn]."' and service_id='".$serviceId."' and event_type not in('Recharged','Recharge Failed')";
		
		$select_query3_bak = "select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success_04_06_2013 where msisdn='".$_GET[msisdn]."' and service_id='".$serviceId."' and event_type not in('Recharged','Recharge Failed')";

		$select_query2_bak = "select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success_backup where msisdn='".$_GET[msisdn]."' and service_id='".$serviceId."' and event_type not in('Recharged','Recharge Failed')";
		
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


  if($_REQUEST['service_info']!=1412)
	{
		$query1 .= " union select '' as billing_id,'' as trans_id,'UNSUB' as event_type,unsub_date as date_time,'0' as amount,'0' as aval_amount,'0' as chrg_amount,unsub_reason as 'mode' from ";
	}
 	 
	//$query1 = "";
	switch($_REQUEST['service_info'])
	{
		case '1001':
			$query1 .="docomo_radio.tbl_radio_unsub ";
		break;
		case '1002':
			$query1 .="docomo_hungama.tbl_jbox_unsub ";
		break;
		case '10021':
			$query1 .="docomo_bpl.tbl_bpl_unsub ";
		break;
		case '1003':
			$query1 .="docomo_hungama.tbl_mtv_unsub ";
		break;
		case '1005':
			$query1 .="docomo_starclub.tbl_jbox_unsub ";
		break;
		case '1013':
		case '1813':
			$query1.= "docomo_mnd.tbl_character_unsub1 ";	
		break;
		case '1613':
			$query1.= "indicom_mnd.tbl_character_unsub1 ";	
		break;
		case '1402':
			$query1 .="uninor_hungama.tbl_jbox_unsub ";
		break;
		case '1403':
			$query1 .="uninor_hungama.tbl_mtv_unsub ";
		break;
		case '1423':
			$query1.= "uninor_summer_contest.tbl_contest_subscription";
		break;
		case '1202':
			$query1 .=" reliance_hungama.tbl_jbox_unsub ";
		break;
		case '1203':
			$query1 .=" reliance_hungama.tbl_mtv_unsub ";
		break;
		case '1208':
			$query1 .="reliance_cricket.tbl_cricket_unsub ";
		break;
		case '1601':
			$query1 .=" indicom_radio.tbl_radio_unsub ";
		break;
		case '1602':
			$query1 .=" indicom_hungama.tbl_jbox_unsub ";
		break;
		case '1603':
			$query1 .=" indicom_hungama.tbl_mtv_unsub ";
		break;
		case '1605':
			$query1 .=" indicom_starclub.tbl_jbox_unsub ";
		break;
		case '1609':
			$query1 .=" indicom_manchala.tbl_riya_unsub ";
		break;
		case '1009':
			$query1 .=" docomo_manchala.tbl_riya_unsub ";
		break;
		case '1801':
			$query1 .=" docomo_vh.tbl_vh_unsub ";
		break;
		case '1406':
			$query1 .= "uninor_starclub.tbl_jbox_unsub ";
		break;
		case '1410':
              $query1 .= "uninor_redfm.tbl_jbox_unsub ";
        break;
		case '1409':
			$query1 .= "uninor_hungama.tbl_jbox_unsub ";
		break;
		case '1010':
			$query1 .= "docomo_redfm.tbl_jbox_unsub ";
		break;
		case '1809':
			$query1 .= "docomo_manchala.tbl_riya_unsub ";
		break;
		case '1007':
			$query1 .= "docomo_vh1.tbl_jbox_unsub ";
		break;
		case '1607':
			$query1 .= "indicom_vh1.tbl_jbox_unsub ";
		break;
		case '1807':
			$query1 .= "docomo_vh1.tbl_jbox_unsub ";
		break;
		case '1810':
			$query1 .= "virgin_redfm.tbl_jbox_unsub ";
		break;
		case '1610':
			$query1 .= "indicom_redfm.tbl_jbox_unsub ";
		break;
		case '1611':
			$query1 .= "indicom_rasoi.tbl_rasoi_unsub ";
		break;
		case '1011':
		case '1811':
			$query1 .= "docomo_rasoi.tbl_rasoi_unsub ";
		break;
		case '1416':
			$query1 .= "uninor_jyotish.tbl_Jyotish_unsub ";
		break;
	/*	case '2121':
			switch($_GET['subsrv']) {
				case 'ast':	
					$query1.= "etislat_hsep.tbl_astro_subscription_log ";	
				break;
				case 'sfp':
					$query1.= "etislat_hsep.tbl_sfp_subscription_log ";	
				break;
				case 'jks':
					$query1.= "etislat_hsep.tbl_jokes_subscription_log ";	
				break;
				case 'hwd':
					$query1.= "etislat_hsep.tbl_hollywood_subscription_log ";	
				break;
				case 'fns':
					$query1.= "etislat_hsep.tbl_funnews_subscription_log ";	
				break;
			}
			*/
		break;
	}
	if($_REQUEST['service_info']!=1412)
		$query1 .="where ani='$_GET[msisdn]'";

	$query1 .=") as record order by date_time desc limit 30";
	
$query=mysql_query($query1,$dbConn) or die(mysql_error());
	
	while(list($billing_ID,$trans_id, $event_type, $date_time, $amount,$aval_amount, $chrg_amount,$MODE) = mysql_fetch_array($query)) {
	?>
	  <TR height="30">
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $_GET['msisdn']; ?></TD>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $billing_ID; ?></TD>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $trans_id; ?></TD>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $event_type; ?></TD>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;
		<?php if(!empty($date_time)){echo date('j-M \'y g:i a',strtotime($date_time));} else {echo '-';}?>
		<?php //if(!empty($date_time)){echo date('j-M-Y g:i a',strtotime($date_time));} else {echo '-';}?></TD>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo 'Rs. '.$amount; ?></TD>
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
	
	mysql_close($dbConn);
?>