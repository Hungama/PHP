<?php
include("db.php");
$amount=$_REQUEST['obd_form_amount'];
$planData=$_REQUEST['obd_form_pricepoint'];
$dbfound=1;
	
if ($_REQUEST['msisdn']!= "")
    {
		if($_REQUEST['service_info'] == '14021') $service_info='1402';
		else $service_info=$_REQUEST['service_info'];
		//$select_query1= "select SUB_DATE, RENEW_DATE, status , circle, MODE_OF_SUB, DNIS, STATUS from ";
			$select_query1="select ANI,MODE_OF_SUB,chrg_amount,USER_BAL,plan_id,STATUS,date(SUB_DATE),date(RENEW_DATE) from ";
			switch($service_info)
			{
				case '1001': if($_SESSION['usrId']=='269') { 
									$select_query1.= "docomo_radio.tbl_radio_smspack_sub";
								} else {
									$select_query1.= "docomo_radio.tbl_radio_subscription";
								}
				break;
				case '1801':
					$select_query1.= "docomo_radio.tbl_radio_subscription";
				break;
				case '1601':
					$select_query1.= "indicom_radio.tbl_radio_subscription";
				break;
				case '1602':
					$select_query1.= "indicom_hungama.tbl_jbox_subscription";
				break;
				case '1002':
					$select_query1.= "docomo_hungama.tbl_jbox_subscription";
				break;
				case '1003':
					$select_query1.= "docomo_hungama.tbl_mtv_subscription";
				break;
				case '1005':
					$select_query1.= "docomo_starclub.tbl_jbox_subscription";
				break;
				case '1208':
					$select_query1.= "reliance_cricket.tbl_cricket_subscription";
				break;
				case '1202':
					$select_query1.= "reliance_hungama.tbl_jbox_subscription";
				break;
				case '1402':
				case '14021':
					$select_query1.= "uninor_hungama.tbl_jbox_subscription";
				break;
				case '1203':
					$select_query1.= "reliance_hungama.tbl_mtv_subscription";
				break;
				case '1403':
					$select_query1.= "uninor_hungama.tbl_mtv_subscription";
				break;
				case '1603':
					$select_query1.= "indicom_hungama.tbl_mtv_subscription";
				break;
				case '1410':
					$select_query1.= "uninor_redfm.tbl_jbox_subscription";
				break;
				case '1009':
					$select_query1.= "docomo_manchala.tbl_riya_subscription ";
				break;
				case '1609':
					$select_query1.= "indicom_manchala.tbl_riya_subscription ";
				break;
				case '1006':
					$select_query1.= "uninor_starclub.tbl_jbox_subscription ";
				break;
				case '1606':
					$select_query1.= "indicom_starclub.tbl_jbox_subscription ";
				break;
				case '1206':
					$select_query1.= "reliance_starclub.tbl_jbox_subscription ";
				break;
				case '1406':
					$select_query1.= "uninor_starclub.tbl_jbox_subscription ";
				break;
				case '1409':
					$select_query1.= "uninor_hungama.tbl_jbox_subscription ";	
				break;
				case '1010':
					$select_query1.= "docomo_redfm.tbl_jbox_subscription ";	
				break;
				case '1412':
					$select_query1.= " uninor_myringtone.tbl_radio_ringtonesubscription ";	
				break;
				case '1605':
					$select_query1.= "indicom_starclub.tbl_jbox_subscription ";	
				break;
				case '1809':
					$select_query1.= "docomo_manchala.tbl_riya_subscription ";	
				break;
				case '1007':
					$select_query1.= "docomo_vh1.tbl_jbox_subscription ";	
				break;
				case '1607':
					$select_query1.= "indicom_vh1.tbl_jbox_subscription ";	
				break;
				case '1807':
					$select_query1.= "docomo_vh1.tbl_jbox_subscription ";	
				break;
				case '1810':
					$select_query1.= "docomo_redfm.tbl_jbox_subscription ";	
				break;
				case '1610':
					$select_query1.= "indicom_redfm.tbl_jbox_subscription ";	
				break;
				case '1611':
					$select_query1.= "indicom_rasoi.tbl_rasoi_subscription ";	
				break;
				case '1811':
					$select_query1.= "docomo_rasoi.tbl_rasoi_subscription ";	
				break;
				case '1011':
					$select_query1.= "docomo_rasoi.tbl_rasoi_subscription ";	
				break;
				case '1416':
					$select_query1.= "uninor_jyotish.tbl_jyotish_subscription ";	
				break;
				case '1408':
					$select_query1.= "uninor_cricket.tbl_cricket_subscription ";	
				break;
				//case '2121':
				//etisalate
				default:
				$dbfound=0;
				break;
			}
			

		$select_query1.=" where ANI='$_REQUEST[msisdn]' ";
			if(!empty($planData))
			{
			$select_query1.=" and plan_id ='$planData'";
             }
			$select_query1.="  order by SUB_DATE desc limit 1";		
		//echo $select_query1;//die;
			
			if($dbfound)
			{
			$querySubscription = mysql_query($select_query1,$con) or die(mysql_error());
			$num = mysql_num_rows($querySubscription);
			}
			else
			{
			$num=0;
			}
if($num>=1){		
?><br/>
		<div width="100%" align="left">
		<h1 style="font:20px/21px verdana,sans-serif;color:#43729F;margin:0 0 4px 0;">Subscription Status</h1>
		
		<TABLE class="listing form" cellpadding="0" cellspacing="0">
		<TBODY>
		<TR height="30">
		<th bgcolor="#FFFFFF" align="center"><B>Mobile No</B></th>
		<th bgcolor="#FFFFFF" align="center"><B>SubscriptionMode</B></th>
		<th bgcolor="#FFFFFF" align="center"><B>User Balance</B></th>
		<th bgcolor="#FFFFFF" align="center"><B>Plan Id</B></th>
		<th bgcolor="#FFFFFF" align="center"><B>Charging Amt.</B></th>
		<th bgcolor="#FFFFFF" align="center"><B>Status</B></th>
		<th bgcolor="#FFFFFF" align="center"><B>Subscription Date</B></th>
		<th bgcolor="#FFFFFF" align="center"><B>Renew Date</B></th>
		<?php if($service_info=='1208') { ?>
		<th bgcolor="#FFFFFF" align="center"><B>Current Status</B></th>		
		<th bgcolor="#FFFFFF" align="center"><B>Option</B></th>
		<?php } ?>
		</TR>
<?php
	 $subStatus=-1;
// ANI,MODE_OF_SUB,chrg_amount,USER_BAL,plan_id,STATUS,SUB_DATE,RENEW_DATE 
	 list($msisdn,$MODE_OF_SUB,$charngamnt,$userblance,$planid,$status,$subdate,$renewdate) = mysql_fetch_array($querySubscription); 
?>
	<TR height="30">
	<TD bgcolor="#FFFFFF" align="center"><b><?php echo $msisdn; ?></b></TD>
	<TD bgcolor="#FFFFFF" align="center"><input type="text" name="usersubmode" id="usersubmode" value='<?php echo $MODE_OF_SUB; ?>' readonly size="10"/></TD>
	<TD bgcolor="#FFFFFF" align="center"><input type="text" name="userblance" id="userblance" value='<?php echo $userblance; ?>' readonly size="2"/></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php echo $planid; ?>
	<input type="hidden" name="userplanid" id="userplanid" value='<?php echo $planid; ?>' readonly size="2"/>
	</TD>
	<TD bgcolor="#FFFFFF" align="center"><?php echo $charngamnt;?></TD>
	<TD bgcolor="#FFFFFF" align="center"><input type="text" name="userstatus" id="userstatus" value='<?php echo $status; ?>' readonly size="2"/></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php echo $subdate; ?></TD>
	<TD bgcolor="#FFFFFF" align="center">
	<input type="hidden" id="subdate" maxlength="25" size="10" name="subdate" value="<?php echo $subdate;?>">
	<input type="text" id="renewdate" maxlength="25" size="10" name="renewdate" value="<?php echo $renewdate;?>">
						<a href="javascript:NewCal('renewdate','ddmmmyyyy',false,24)"><img src="img/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	</TD>
	</TR>
<!--/TBODY>
</TABLE-->
<TR height="30">
<TD bgcolor="#FFFFFF" colspan="8" align="right">
<input type="button" name="editbtn" value="Edit" id="editbtn" onclick="javascript:makeEditable()" style="color: #FFF;background-color: #900;font-weight:bold;">
<input type="button" name="updatebtn" value="Update" id="updatebtn" onclick="javascript:doUpdate()" style="visibility:hidden;color: #FFF;background-color: #900;font-weight:bold;">
</TD>
</TR>
<tr><td bgcolor="#FFFFFF" colspan="8" id="showupdateinfo" style="font:20px verdana,sans-serif;color:#43729F;margin:0 0 4px 0;"></td></tr>
<?php
}
else
{
//echo "<h1 style=\"font:20px/21px verdana,sans-serif;color:#43729F;margin-top:10px;\">No Record Found</h1>";
echo "<br>";
?>
 <b>Mode:</b>&nbsp;&nbsp;<select name="sub_mode" id="sub_mode">
				<option value="IVR">IVR</option>
				<option value="CCI">CCI</option>
				<!--option value="IBD">IBD</option>
				<option value="OBD">OBD</option>
				<option value="TC">TELECALLING</option>
				<option value="USSD">USSD</option-->
				</select>
	
<?php
echo '<input type="button" name="subscribe_btn" value="To Subscribe This MSISDN Click Here" id="subscribe_btn" onclick="javascript:doSubScribeMDN()" style="color:#FFF;background-color: #900;font-weight:bold;">';
echo "<br></br>";
echo '<span id="showsubscribeinfo" style="font:20px verdana,sans-serif;color:#43729F;margin:0 0 4px 0;"></span>';
}?>

</TBODY>
</TABLE>
</div>
<?php
 }
?>