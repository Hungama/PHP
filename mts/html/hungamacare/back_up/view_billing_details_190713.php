<?php
session_start();
if(isset($_SESSION['authid']))
{
	include("config/dbConnect.php");
		//mysql_select_db($DB_DATABASE_M, $dbConn) or die(mysql_error());
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>Hungama Customer Care</title>
<link rel="stylesheet" href="style.css" type="text/css">
<style type="text/css">
<!--
.style3 {font-family: "Times New Roman", Times, serif}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<br/>
<center><div width="85%" align="left" class="txt">&nbsp;&nbsp;<FONT COLOR="#FF0000"> <B>Billing details for <?php echo $_GET['msisdn']; ?></B></FONT><br/>&nbsp;&nbsp;&nbsp;<i>Displaying last 30 transactions </i></div><center><br/>
<TABLE width="95%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
  <TBODY>
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
	<?php
	$planDataResult = mysql_query("SELECT Plan_id from master_db.tbl_plan_bank WHERE sname='".$_REQUEST['service_info']."'",$dbConn);
	while($row = mysql_fetch_array($planDataResult)) {
		$planData[] = $row['Plan_id'];
	}
	if($_REQUEST['service_info'] == '11011') $serviceId='1101';
	else $serviceId=$_REQUEST['service_info'];
	
	$query1 = "select * from ( select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success where msisdn='".$_GET[msisdn]."' and service_id='".$serviceId."' and plan_id IN (".implode(",",$planData).") ";
	
	$query1 .=" UNION select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success_backup where msisdn='".$_GET[msisdn]."' and service_id='".$serviceId."' and plan_id IN (".implode(",",$planData).")";

	$query1 .=" UNION select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success_backup1 where msisdn='".$_GET[msisdn]."' and service_id='".$serviceId."' and plan_id IN (".implode(",",$planData).") UNION ";

    $query1 .= "select '' as billing_id,'' as trans_id,'UNSUB' as event_type,unsub_date as date_time,'0' as amount,'0' as aval_amount,'0' as chrg_amount,unsub_reason as 'mode' from ";
 	 
	//$query1 = "";
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
	


	$query1 .=" where ani='$_GET[msisdn]' and plan_id IN (".implode(",",$planData).") ) as record order by date_time desc ";

	if($_SESSION['usrId'] == '1') {
		$query1 .=" limit 2";
	} else {
		$query1 .="  limit 30";
	}
	//echo $query1; die;
		
	$query=mysql_query($query1,$dbConn) or die(mysql_error());
	
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
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php if($MODE=='push') { $MODE='OBD1'; } elseif($MODE=='push2') { $MODE='OBD2';} echo $MODE; ?></TD>
	  </TR>
	  <?php }?>
</TBODY>
</TABLE>
<?php
	
	mysql_close($dbConn);
}
?>
