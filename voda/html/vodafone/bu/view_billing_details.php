<?php
session_start();
//if(isset($_SESSION['authid']))
//{
	//include("config/dbConnect.php");
	require_once("incs/db.php");
	require_once("language.php");
	$service_info_duration=$_REQUEST['subsrv'];
	$msisdn=$_REQUEST['msisdn'];

?>
<div width="85%" align="left" class="txt">
<div class="alert"><a href="javascript:viewbillinghistory('<?= $msisdn; ?>','<?= $_REQUEST['service_info']?>','<?php echo $service_info_duration;?>')" id="Refresh"><i class="icon-refresh"></i></a>&nbsp;Billing details for <?php echo $_REQUEST['msisdn']; ?>&nbsp;displaying last 30 transactions </i>
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
	<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_AVAL_BALANCE;?></B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_CHARGE_AMOUNT;?></B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_MODE;?></B></TD>
  </TR>
  </thead>
<?php
$planDataResult = mysql_query("SELECT Plan_id from master_db.tbl_plan_bank WHERE sname='".$_REQUEST['service_info']."'", $dbConn);
	while($row = mysql_fetch_array($planDataResult)) {
		$planData[] = $row['Plan_id'];
	}
	if($_REQUEST['service_info'] == '11011') $serviceId='1101';
	else $serviceId=$_REQUEST['service_info'];
	
	$query1 = "select * from ( select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success where msisdn='".$msisdn."' and service_id='".$serviceId."' and plan_id IN (".implode(",",$planData).") ";
	
	$query1 .=" UNION select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success_backup where msisdn='".$msisdn."' and service_id='".$serviceId."' and plan_id IN (".implode(",",$planData).")";

	$query1 .=" UNION select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success_backup1 where msisdn='".$msisdn."' and service_id='".$serviceId."' and plan_id IN (".implode(",",$planData).") UNION ";

    $query1 .= "select '' as billing_id,'' as trans_id,'UNSUB' as event_type,unsub_date as date_time,'0' as amount,'0' as aval_amount,'0' as chrg_amount,unsub_reason as 'mode' from ";
switch($_REQUEST['service_info'])
	{
		case '1102':
			$query1.= "mts_hungama.tbl_jbox_unsub";
		break;
		case '1101':
		case '11011':
			$query1.= "mts_radio.tbl_radio_unsub";
		break;
		case '1103':
			$query1.= "mts_mtv.tbl_mtv_unsub";
		break;
		case '1111':
			$query1.= "dm_radio.tbl_digi_unsub";
		break;
		case '1105':
			 $query1.= "mts_starclub.tbl_jbox_unsub";
		break;
		case '1106':
			 $query1.= "mts_starclub.tbl_jbox_unsub"; //"CelebChat.tbl_chat_unsub";
		break;
		case '1110':
			 $query1.= "mts_redfm.tbl_jbox_unsub";
		break;
		case '1113':
			 $query1.= "mts_mnd.tbl_character_unsub1";
		break;
		case '1116':
			 $query1.= "mts_voicealert.tbl_voice_unsub";
		break;
	}
	$query1 .=" where ani='$msisdn' and plan_id IN (".implode(",",$planData).") ) as record order by date_time desc limit 30";
		
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
		/*if($aval_amount==-1)
			$aval_amount='PostPaid';
		else
			$aval_amount=number_format(($aval_amount/100),2);
		if($aval_amount=='0.00')
			$aval_amount='NA';
		*/if($aval_amount==-1)
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