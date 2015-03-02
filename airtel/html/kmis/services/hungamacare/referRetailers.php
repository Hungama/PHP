<?php
	include("web_admin.js");
	include("header.php");
	include("config/dbConnect.php");

	$logPath = "/var/www/html/kmis/services/hungamacare/log/directAct/direct_act".date("Y-m-d").".txt";

	$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAY'=>'Haryana');
	
?>
<script language="javascript">
	function validateData() {
		if(document.getElementById('number').value=="") {
			alert("Please enter retailer number");
			return false;
		}
		if(document.getElementById('timestamp').value=="") {
			alert("Please select date");
			return false;
		}
	}
</script>

<form name="tstest" action='referRetailers.php' method='POST'  onSubmit="return validateData()">
<table width="30%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
<tr>
	<td bgcolor="#FFFFFF" height="30px" width='50%'><B>Enter Retailer Number</B></td>
	<td bgcolor="#FFFFFF" height="30px" width='50%'>&nbsp;&nbsp;<INPUT TYPE="text" NAME="number" id="number" />&nbsp;&nbsp;</td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height="30px" width='50%'><B>Select Date</B></td>
	<td bgcolor="#FFFFFF" height="30px" width='50%'>&nbsp;&nbsp;<input type="Text" name="timestamp" id="timestamp" value="">&nbsp;&nbsp;<a href="javascript:show_calendar('document.tstest.timestamp', document.tstest.timestamp.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>&nbsp;&nbsp;</td>
</tr>
<tr><td colspan='2' align='center' bgcolor="#FFFFFF"><input name="Submit" type="submit" class="txtbtn" value="Submit"/>			</tr>
</table>
</form> </BR></BR></BR>
<div align='left' width="70%"><a href='referDetailsUPW.php?timestamp=<?php echo $viewDate;?>'><font color="#FF0000">Home</font></a> | <a href='referRetailers.php'><font color="#FF0000">Search</font></a></div>
<?php 
	if($_REQUEST['number'] && $_REQUEST['timestamp']) {
		$retailerMDN=trim($_REQUEST['number']);	
		$viewDate=date("Y-m-d",strtotime($_REQUEST['timestamp']));;
?>
<table border="0" cellpadding="5" align="center">
<tr>
	<td><b>Selected Retailer MDN:</b><?php echo $retailerMDN; ?></td>
</tr>
</table> 
<table width="80%" align='center' bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
<tr align='center'>			
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
	$query="select distinct(friendANI),date(referDate) from master_db.tbl_refer_ussdData where ANI='".$retailerMDN."' and service_id='1517' and referfrom='Retailer' and date(referDate)='".$viewDate."'";
	$result1 = mysql_query($query);
	$result = mysql_query($query);
	$num = mysql_num_rows($result);
	$billingArray = array();
	$billingArray1 = array();

	while($row=mysql_fetch_array($result1)) {
		$billingArray[]=$row['friendANI'];
	}	

	$query1= mysql_query("select sum(aa) 'chrg',m from ( select sum(chrg_amount) 'aa' ,msisdn 'm' from master_db.tbl_billing_success where msisdn in (".implode(',',$billingArray).") and service_id='1517' and mode='RET' and date(response_time)>='".$viewDate."' and circle='UPW' group by msisdn union select sum(chrg_amount) 'aa',msisdn 'm' from master_db.tbl_billing_success_backup where msisdn in (".implode(',',$billingArray).") and service_id='1517' and mode='RET' and date(response_time)>='".$viewDate."' and circle='UPW' group by msisdn)  a group by m");

	while($row1=mysql_fetch_array($query1)) {
		$ani=$row1['m'];
		$billingArray1[$ani]['chrg']=$row1['chrg'];
		$billingArray1[$ani]['status']=0;
	}
	//print_r($billingArray1);

if($num) { 
	while(list($referANI,$datetime) = mysql_fetch_array($result)) { 
		$getCircle = "select master_db.getCircle(".trim($referANI).") as circle";
		$circle1=mysql_query($getCircle) or die( mysql_error() );
		while($row = mysql_fetch_array($circle1)) {
			$circle = $row['circle'];
		}
		if(!$circle) { $circle='UND'; }
		
		if($circle == 'UPW') { 
		$subQuery = mysql_query("SELECT SUB_DATE,STATUS,MODE_OF_SUB,chrg_amount,circle,datediff(RENEW_DATE,SUB_DATE) as diff FROM airtel_SPKENG.tbl_spkeng_subscription WHERE date(SUB_DATE)>='".$viewDate."' and MODE_OF_SUB='RET' AND ANI='".$referANI."' and circle='UPW'");
		list($subDate,$status,$modeOfSub,$chrg_amount,$circle1,$diff)=mysql_fetch_array($subQuery);

		$chkStatus=1;
		if($status==1 || $status==11) { 
			$statusValue="Subscribed";			
			$chkStatus=1;
		} else { 
			$statusValue="Not Subscribed";
			$chkStatus=0;
			$chrgAmount="NA";
		}

		$billingChargQuery = "select chrg_amount from master_db.tbl_billing_success_backup where msisdn='".$referANI."' and mode='RET' and service_id='1517' union select chrg_amount from master_db.tbl_billing_success where msisdn='".$referANI."' and mode='RET' and service_id='1517'";
		$chrgAmountResult = mysql_query($billingChargQuery);
		list($chrgAmount) = mysql_fetch_array($chrgAmountResult);

		if(!$subDate) $statusUser=0;
		else $statusUser=1;		
?>
	<tr align='center'>	
		<td bgcolor="#FFFFFF" height="30px"><?php echo $datetime;?></td>	
		<td bgcolor="#FFFFFF" height="30px"><?php echo $referANI;?></td>	
		<td bgcolor="#FFFFFF" height="30px">RET</td>	
		<td bgcolor="#FFFFFF" height="30px"><?php if($chrgAmount) echo $chrgAmount; else "NA";?></td>	
		<td bgcolor="#FFFFFF" height="30px"><?php echo $circle;?></td>
		<td bgcolor="#FFFFFF" height="30px"><?php echo $statusValue;?></td>
		<?php if($chkStatus==1) { ?>
		<td bgcolor="#FFFFFF" height="30px"><?php echo $subDate;?></td>
		<td bgcolor="#FFFFFF" height="30px">
			<?php 
				if($billingArray1[$referANI]['status']==0 && $billingArray1[$referANI]['chrg']) {
					echo $billingArray1[$referANI]['chrg']; 
					$diff1 = ceil($billingArray1[$referANI]['chrg']/5);
					$billingArray1[$referANI]['status']=1; 
				  } else {
					echo "NA";
				  }			 	
			?>
		</td>
		<td bgcolor="#FFFFFF" height="30px"><?php echo $diff1;?></td>
	<?php } else { ?> 
		<td bgcolor="#FFFFFF" height="30px" colspan=3>NA</td>	
	<?php } ?>
	</tr>
<?php }  } // end of while loop
} else { ?>
<tr><td colspan='10' bgcolor="#FFFFFF" height="30px" align='center'>No Record found</td></tr>
<?php } // end of if loop ?>
</table>
<?php } // end of MDN loop ?>