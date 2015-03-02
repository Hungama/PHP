<?php
session_start();
//if(isset($_SESSION['authid']))
//{
	//include("config/dbConnect.php");
	require_once("incs/db.php");
	require_once("language.php");
	$service_info_duration=$_REQUEST['subsrv'];
	$msisdn=$_REQUEST['msisdn'];
if($_REQUEST['service_info'] == 1509 || $_REQUEST['service_info'] == 1504)
		$serviceId = 1511;
	elseif($_REQUEST['service_info'] == 15071)
		$serviceId = 1507;
	elseif($_REQUEST['service_info'] == 15221)
		$serviceId = 1522;
	elseif($_REQUEST['service_info'] == 15211 || $_REQUEST['service_info'] == 15212 || $_REQUEST['service_info'] == 15213)
		$serviceId = 1521;
	elseif ($_REQUEST['service_info'] == 15151)
            $service_id = 1515;
	else $serviceId = $_REQUEST['service_info'];
	//echo $service_id."******".$msisdn."*****".$_REQUEST['service_info'];
	//exit;
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
	
$planDataResult = mysql_query("SELECT Plan_id from master_db.tbl_plan_bank WHERE S_id='".$serviceId."' and sname='".$_REQUEST['service_info']."'", $dbConn);
	while($row = mysql_fetch_array($planDataResult)) {
		$planData[] = $row['Plan_id'];
													 }
	$query1 = "select * from ( select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success where msisdn='".$msisdn."' and service_id='".$serviceId."' and plan_id IN (".implode(",",$planData).") ";
	
	$query1 .=" UNION select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success_backup where msisdn='".$msisdn."' and service_id='".$serviceId."' and plan_id IN (".implode(",",$planData).")";
    $query1 .=" UNION ";
	
	$query1 .= "select '' as billing_id,'' as trans_id,'UNSUB' as event_type,unsub_date as date_time,'0' as amount,'0' as aval_amount,'0' as chrg_amount,unsub_reason as 'mode' from ";
	
	/*$select_query2_main = "select * from ( select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success where msisdn='".$msisdn."' and service_id='".$serviceId."' and plan_id IN (".implode(",",$planData).") ";
	
	$select_query2_bak ="select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success_backup where msisdn='".$msisdn."' and service_id='".$serviceId."' and plan_id IN (".implode(",",$planData).")";
    
	$select_query3 = "select '' as billing_id,'' as trans_id,'UNSUB' as event_type,unsub_date as date_time,'0' as amount,'0' as aval_amount,'0' as chrg_amount,unsub_reason as 'mode' from ";
	
		if($service_info_duration==1)
		{
	$query1 = $select_query2_main." UNION ".$select_query2_bak." UNION ".$select_query3; 		
		}
		else if($service_info_duration==2)
		{
	$query1 = $select_query2_main." UNION ".$select_query3; 
		}
	echo $query1;
	*/
switch($_REQUEST['service_info'])
	{
		case '1501':
			$query1 .="airtel_radio.tbl_radio_unsub ";
		break;
		case '1502':
			$query1 .="airtel_hungama.tbl_jbox_unsub ";
		break;
		case '1518':
			$query1 .="airtel_hungama.tbl_comedyportal_unsub ";
		break;
		case '1503':
			$query1 .="airtel_hungama.tbl_mtv_unsub ";
		break;
		case '1507':
			$query1 .="airtel_vh1.tbl_jbox_unsub ";
		break;
		case '1511':
			$query1 .="airtel_rasoi.tbl_rasoi_unsub ";
		break;
		case '1509':
			$query1 .="airtel_manchala.tbl_riya_unsub ";
		break;
		case '1514':
			$query1 .="airtel_EDU.tbl_jbox_unsub ";
		break;
		case '1513': 
			$query1 .="airtel_mnd.tbl_character_unsub1 ";
		break;
		case '1504':
			$query1 .="airtel_rasoi.tbl_storeatone_unsub ";
		break;
		case '15071':
			$query1 .="airtel_vh1.tbl_vh1nightpack_unsub ";
		break;
		case '1515':
		case '15151':
			$query1 .="airtel_devo.tbl_devo_unsub ";
		break;
		case '1517':
			$query1 .=" airtel_SPKENG.tbl_spkeng_unsub ";
		break;
		case '1520':
			$query1 .="airtel_hungama.tbl_pk_unsub ";
		break;
		case '1522':
		case '15221':
			$query1 .="airtel_hungama.tbl_arm_unsub ";
		break;
		case '15211':
			$query1 .= " airtel_smspack.TBL_ASTRO_SUBSCRIPTION_LOG ";
		break;
		case '15212':
			$query1 .= " airtel_smspack.TBL_SEXEDU_SUBSCRIPTION_LOG ";
		break;
		case '15213':
			$query1 .= " airtel_smspack.TBL_VASTU_SUBSCRIPTION_LOG ";
		break;
		case '1523':
			$query1 .= " airtel_TINTUMON.tbl_TINTUMON_unsub ";
		break;

	}
	$query1 .=" where ani='".$msisdn."' and plan_id IN (".implode(",",$planData).") ) as record order by date_time desc limit 30";
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