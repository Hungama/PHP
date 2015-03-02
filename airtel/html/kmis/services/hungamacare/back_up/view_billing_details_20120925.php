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

<!-- 
<table><tr><td>
<?php $url="http://10.2.73.156/kmis/services/hungamacare/main_swati.php"; ?>
 <a href=<?php echo $url ?>> <font color='red'>Back </font></a>
</td></tr> </table>
-->
<?php
	if($_REQUEST['service_info']==1502)
	{
		$displaymsg="Displaying latest transaction";
	}
	else
		$displaymsg="Displaying last 25 transactions";
?>


<center><div width="85%" align="left" class="txt">&nbsp;&nbsp;<FONT COLOR="#FF0000"> <B>Billing details for <?php echo $_GET['msisdn']; ?></B>

 
</FONT><br/>&nbsp;&nbsp;&nbsp;<i><?php echo $displaymsg ?></i></div><center><br/>
 <TABLE width="95%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
  <TBODY>

  <TR height="30">
	<TD bgcolor="#FFFFFF" align="center"><B>Mobile No</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Billing ID</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Trans id</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Event Type</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Date Time</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Attempt Amount</B></TD>
	<!--<TD bgcolor="#FFFFFF" align="center"><B>Aval Balance</B></TD>-->
	<TD bgcolor="#FFFFFF" align="center"><B>Chrg Amount</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Mode</B></TD>
  </TR>
<?php
	
	//$query = mysql_query("select billing_ID,trans_id, event_type, date_time, amount, aval_amount,chrg_amount,MODE from tbl_billing_success where msisdn='$_GET[msisdn]' order by date_time desc",$dbConn) or die(mysql_error());
	
	if($_REQUEST['service_info'] == 1509 || $_REQUEST['service_info'] == 1504)
		$service_id = 1511;
	elseif($_REQUEST['service_info'] == 15071)
		$service_id = 1507;
	else $service_id = $_REQUEST['service_info'];

	$query1 ="select * from (select billing_ID,trans_id, event_type, date_time, amount,aval_amount,chrg_amount,MODE as mode from master_db.tbl_billing_success where msisdn='$_GET[msisdn]' and service_id='".$service_id."' ";
	
	/*if($_REQUEST['service_info'] == 1509)
		$query1 .=" and plan_id IN (30,48) ";
	elseif($_REQUEST['service_info'] == 15022)
		$query1 .=" and SC='5464612' ";
	elseif($_REQUEST['service_info'] == 15071)
		$query1 .=" and plan_id=33 ";	
	elseif($_REQUEST['service_info'] == 1507)
		$query1 .=" and plan_id!=33 ";	
	elseif($_REQUEST['service_info'] == 1504)
		$query1 .=" and plan_id=34";	
	elseif($_REQUEST['service_info'] == 1511)
		$query1 .=" and plan_id IN (46,29)";	*/

	$q = "select plan_id from master_db.tbl_plan_bank where S_id='".$service_id."' and sname='".$_REQUEST['service_info']."'";
	$planDataArray = mysql_query($q);
	while($planData = mysql_fetch_array($planDataArray)) {
		$planArray[] = $planData['plan_id'];
	}

	$query1 .=" and plan_id IN (".implode(",",$planArray).") ";

	$query1 .=" union ";
	$query1 .="select '' as billing_id,'' as trans_id,'UNSUB' as event_type,unsub_date as date_time,'0' as amount,'0' as aval_amount,'0' as chrg_amount,unsub_reason as 'mode' from ";
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
	}
	
	$query1 .="where ani='$_GET[msisdn]') as record order by date_time desc ";
	if($_REQUEST['service_info']==1502)
	{
		$query1.=" limit 1";
	}
	else
		$query1.=" limit 25";


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
		?>
		<!--<TD bgcolor="#FFFFFF" align="right"><?php echo $aval_amount; ?>&nbsp;</TD>-->
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $chrg_amount; ?></TD>
		<?php
			if($MODE=='null')
				$MODE='';

		?>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $MODE; ?></TD>
	  </TR>
	  <?php }?>
</TBODY>
</TABLE>
<?php
	
	mysql_close($dbConn);
}
?>