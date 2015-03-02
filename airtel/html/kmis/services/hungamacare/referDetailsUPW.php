<?php
	include("web_admin.js");
	include("header.php");
	include("config/dbConnect.php");

	$logPath = "/var/www/html/kmis/services/hungamacare/log/directAct/direct_act".date("Y-m-d").".txt";

	$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAY'=>'Haryana');

	if($_REQUEST['timestamp']) {
		$viewDate=date("Y-m-d",strtotime($_REQUEST['timestamp']));
	} /*else {
		$viewDate=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
	}*/
	//echo $viewDate;
?>
<script language="javascript">

</script>

<form name="tstest" action='referDetailsUPW.php' method='POST' >
<table width="30%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
<tr>
	<td bgcolor="#FFFFFF" height="30px" width='50%'><B>Select Date</B></td>
	<td bgcolor="#FFFFFF" height="30px" width='50%'>&nbsp;&nbsp;<input type="Text" name="timestamp" id="timestamp" value="">&nbsp;&nbsp;<a href="javascript:show_calendar('document.tstest.timestamp', document.tstest.timestamp.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>&nbsp;&nbsp;</td>
</tr>
<tr><td colspan='2' align='center' bgcolor="#FFFFFF"><input type='Submit' name='submit' value='submit' onSubmit="return validateData();"/></tr>
</table>
</form> </BR></BR></BR>
<?php 
	define('MAX_REC_PER_PAGE', 50);  
	if($viewDate) { 
		if($viewDate>="2013-04-08") $extraCondition=" AND b.userCircle='UPW'";	
		else $extraCondition=" AND 1 ";	
		$query1="select count(distinct(friendANI),ANI) from master_db.tbl_refer_ussdData where date(referDate)='".$viewDate."' and service_id='1517' and referfrom='Retailer' ".$extraCondition; //limit $start, $max";

		$rs = mysql_query($query1);
		list($total) = mysql_fetch_row($rs);
		$total_pages = ceil($total / MAX_REC_PER_PAGE);
		$page = intval(@$_GET["page"]); 
		if (0 == $page) {  $page = 1;   }  
		$start = MAX_REC_PER_PAGE * ($page - 1);
		$max = MAX_REC_PER_PAGE; 
	}
?>

<div align='left' width="70%"><a href='downloadRetCsv.php?date=<?php echo $viewDate."&max=".$max."&start=".$start; ?>'>Download data</a> | <a href='referDetailsUPW.php?timestamp=<?php echo $viewDate;?>'><font color="#FF0000">Home</font></a> | <a href='referRetailers.php'><font color="#FF0000">Search</font></a></div>
<table border="0" cellpadding="5" align="center">
<tr>
	<td><b>Goto Page:</b></td>
	<?php 
	for ($i = 1; $i <= $total_pages; $i++) {
	$txt = $i;
	if ($page != $i)
	$txt = "<a href=\"" . $_SERVER["PHP_SELF"] . "?page=$i&timestamp=$viewDate\">$txt</a>";
	?>
	<td align="center"><?php echo $txt; ?></td>
	<?php  } ?>
</tr>
</table> 
<?php if($viewDate) { ?>
<table width="80%" align='center' bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
<tr align='center'>						
	<th bgcolor="#FFFFFF" height="30px">Retailer MDN</th>
	<th bgcolor="#FFFFFF" height="30px">Date of Referral</th>
	<th bgcolor="#FFFFFF" height="30px">Refered MDN</th>
	<th bgcolor="#FFFFFF" height="30px">Mode</th>
	<th bgcolor="#FFFFFF" height="30px">Price</th>
	<th bgcolor="#FFFFFF" height="30px">Circle</th>
	<th bgcolor="#FFFFFF" height="30px">Status</th>
	<th bgcolor="#FFFFFF" height="30px">Timestamp</th>	
	<th bgcolor="#FFFFFF" height="30px">Amount</br>(till date)</th>
	<th bgcolor="#FFFFFF" height="30px">Days</br>(from activation)</th>
</tr>
<?php 
	//$query="select distinct(friendANI),ANI,referDate from master_db.tbl_refer_ussdData where date(referDate)='".$viewDate."' and service_id='1517' and referfrom='Retailer' limit $start, $max";	
	if($viewDate>="2013-04-08") $extraCondition=" AND b.userCircle='UPW'";
	else $extraCondition=" AND 1 ";
	$query="SELECT distinct(a.ANI) as 'SubANI',b.ANI as 'RetANI',b.friendANI,a.sub_date,a.chrg_amount,a.circle,a.Mode_Of_sub,a.status, datediff(a.RENEW_DATE,a.SUB_DATE) as diff ,master_db.totalChargeAmount(a.ANI,a.sub_date) as totalAmount,u.sub_date,u.chrg_amount,u.circle,u.Mode_Of_sub,u.status,datediff(u.RENEW_DATE,u.SUB_DATE) as diff1 ,master_db.totalChargeAmount(u.ANI,u.sub_date) as totalAmount1 from master_db.tbl_refer_ussdData b LEFT JOIN airtel_SPKENG.tbl_spkeng_unsub u ON b.friendANI=u.ANI and u.MODE_OF_SUB='RET' and u.circle='UPW' and u.status=1  LEFT JOIN airtel_SPKENG.tbl_spkeng_subscription a ON b.friendANI=a.ANI and a.MODE_OF_SUB='RET' and a.circle='UPW' and a.status=1 WHERE date(b.referDate)='".$viewDate."' and b.service_id='1517' ".$extraCondition." limit $start, $max";
	//$result1 = mysql_query($query);
	$result = mysql_query($query);
	$num = mysql_num_rows($result);
if($num) { 
	while(list($subANI,$retailerANI,$referANI,$datetime,$chrg_amount,$circle,$mode,$status,$diff,$totalAmount,$udatetime,$uchrg_amount,$ucircle,$umode,$ustatus,$udiff,$utotalAmount) = mysql_fetch_array($result)) { 
		/*$getCircle = "select master_db.getCircle(".trim($referANI).") as circle";
		$circle1=mysql_query($getCircle) or die( mysql_error() );
		while($row = mysql_fetch_array($circle1)) {
			$circle = $row['circle'];
		}
		if(!$circle) { $circle='UND'; }*/
		
		//if($circle == 'UPW') { 
		
		if(!$subDate) $statusUser=0;
		else $statusUser=1;		
		$chkStatus=0;
		if($status==1) {  
			$statusValue="Subscribed"; 
			$chkStatus=1; 
		} else {
			$statusValue="Not Subscribed"; 
			if($udatetime) {
				$chrg_amount = $uchrg_amount;
				$circle = $ucircle;
				$mode = $umode;
				$diff = $udiff;
				$totalAmount = $utotalAmount;
			} else {
				$chkStatus=0; 
			}
		}
?>
	<tr align='center'>	
		<td bgcolor="#FFFFFF" height="30px"><?php echo $retailerANI;
		//echo $referANI.",".$retailerANI.",".$referANI.",".$datetime.",".$chrg_amount.",".$circle.",".$mode.",".$status.",".$diff.",".$totalAmount?></td>	
		<td bgcolor="#FFFFFF" height="30px"><?php echo $viewDate;?></td>	
		<td bgcolor="#FFFFFF" height="30px"><?php echo $referANI;?></td>	
		<td bgcolor="#FFFFFF" height="30px">RET</td>	
		<td bgcolor="#FFFFFF" height="30px"><?php if($chrg_amount) echo $chrg_amount; else "NA";?></td>	
		<td bgcolor="#FFFFFF" height="30px"><?php echo $circle;?></td>
		<td bgcolor="#FFFFFF" height="30px"><?php echo $statusValue;?></td>
		<?php if($chkStatus==1) { ?>
		<td bgcolor="#FFFFFF" height="30px"><?php echo $datetime;?></td>
		<td bgcolor="#FFFFFF" height="30px"><?php echo $totalAmount;?></td>
		<td bgcolor="#FFFFFF" height="30px"><?php echo $diff;?></td>
	<?php } else { ?> 
		<td bgcolor="#FFFFFF" height="30px" colspan=3>NA</td>	
	<?php } ?>
	</tr>
<?php  } // end of while loop
} else { ?>
<tr><td colspan='10' bgcolor="#FFFFFF" height="30px" align='center'>No Record found</td></tr>
<?php } // end of if loop ?>
</table>
<?php } // viewDate if check?>