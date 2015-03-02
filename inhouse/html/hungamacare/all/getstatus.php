<?php
//Operator- obd_form_operator
//Service Id- service_info
//Plan Id- obd_form_pricepoint>> $planData
//Amount- obd_form_amount
//Mobile no- msisdn
include("db.php");
$amount=$_REQUEST['obd_form_amount'];
$planData=$_REQUEST['obd_form_pricepoint'];
//echo $_REQUEST['msisdn']." ".$planData." ".$_REQUEST['service_info']." ".$amount;
//exit;
    if ($_REQUEST['msisdn'] != "")
    {
		if($_REQUEST['service_info'] == '14021') $service_info='1402';
		else $service_info=$_REQUEST['service_info'];

		               
	/*	
		$select_query2_main = "(select msisdn, date_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success where msisdn='$_REQUEST[msisdn]' and event_type !='Recharged' and ";
		$select_query2_main .=" plan_id IN (".implode(",",$planData).") and ";
		$select_query2_main .= " service_id=".$service_info." )";
		
		$select_query2_bak = "(select msisdn, date_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success_230312 where msisdn='$_REQUEST[msisdn]' and event_type !='Recharged' and";
		$select_query2_bak .=" plan_id IN (".implode(",",$planData).") and ";
	    $select_query2_bak .= " service_id=".$service_info." )";

		$select_query3_bak = "(select msisdn, date_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success_backup where msisdn='$_REQUEST[msisdn]' and event_type !='Recharged' and";
		$select_query3_bak .=" plan_id IN (".implode(",",$planData).") and ";
	    $select_query3_bak .= " service_id=".$service_info." )";
		
		$select_query2 = $select_query2_main." UNION ".$select_query2_bak." UNION ".$select_query3_bak." order by date_time desc limit 1 "; 

		//echo $select_query2; exit;
		$query = mysql_query($select_query2, $con) or die(mysql_error());
		$query1 = mysql_query($select_query2, $con) or die(mysql_error());
		$numRows = mysql_num_rows($query);
    */
         //   mysql_select_db($userDbName, $userDbConn);
				
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
				case '2121':
				/*list($msisdn1, $date_time1, $chrg_amount1,$circle1,$plan_id1) = mysql_fetch_array($query1);
						$mainQuery = "select SUB_DATE, RENEW_DATE, status , circle, MODE_OF_SUB, DNIS, STATUS, plan_id from ";
						switch($plan_id1) {
							case '119':
							case '124':	$subsrv='sfp';
								$select_query1.= "etislat_hsep.tbl_sfp_subscription ";	
								$etisalatService="SFP";
							break;
							case '116': 
							case '121': $subsrv='jks';
								$select_query1.= "etislat_hsep.tbl_jokes_subscription ";	
								$etisalatService="JOKES";
							break;
							case '117':
							case '122':	$subsrv='hwd';
								$select_query1.= "etislat_hsep.tbl_hollywood_subscription ";	
								$etisalatService="HollyWood";
							break;
							case '118':
							case '123':	$subsrv='fns';
								$select_query1.= "etislat_hsep.tbl_funnews_subscription ";	
								$etisalatService="FunNews";
							break;
							case '125':
							case '126':	$subsrv='epl';
								$select_query1.= "etislat_hsep.tbl_epl_subscription ";	
								$etisalatService="EPL";
							break;
						}					
						$endQuery =" where ANI='$_REQUEST[msisdn]' and plan_id IN (".implode(",",$planData).") order by SUB_DATE desc limit 1";		
						$eQuery = array();
						//$eQuery[] =$mainQuery." etislat_hsep.tbl_astro_subscription ".$endQuery;
						$eQuery[] =$mainQuery." etislat_hsep.tbl_sfp_subscription ".$endQuery;
						$eQuery[] =$mainQuery." etislat_hsep.tbl_jokes_subscription ".$endQuery;
						$eQuery[] =$mainQuery." etislat_hsep.tbl_hollywood_subscription ".$endQuery;
						$eQuery[] =$mainQuery." etislat_hsep.tbl_funnews_subscription ".$endQuery;
						$eQuery[] =$mainQuery." etislat_hsep.tbl_epl_subscription ".$endQuery;
						*/
				break;
			}
			
			$select_query1.=" where ANI='$_REQUEST[msisdn]' ";
			$select_query1.=" and plan_id ='$planData'";

			$select_query1.="  order by SUB_DATE desc limit 1";		
			//echo $select_query1;//die;
			
			if($service_info == '2121') {
				$qArray = array();
				for($i=0;$i<5;$i++) {
					//if($i==0) $etisalatService="Astro";
					if($i==0) $etisalatService="SFP";
					elseif($i==1) $etisalatService="JOKES";
					elseif($i==2) $etisalatService="HollyWood";
					elseif($i==3) $etisalatService="FunNews"; 
					elseif($i==4) $etisalatService="EPL"; 
					//echo "<br/>".$i.": ".$eQuery[$i];
					$querySubscription = mysql_query($eQuery[$i],$con) or die(mysql_error());
					$num = mysql_num_rows($querySubscription);
					if($num) { $qArray[$i]=$etisalatService; }
				}
			} else {
				$querySubscription = mysql_query($select_query1,$con) or die(mysql_error());
				$num = mysql_num_rows($querySubscription);
			}
	if($num>=1){		
?><br/>
		<center><div width="100%" align="left">
		<h1 style="font:20px/21px verdana,sans-serif;color:#43729F;margin:0 0 4px 0;">Subscription Status</h1>
		</div></center>
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
if($service_info == '2121') {		
	//list($msisdn, $date_time, $chrg_amount,$circle,$plan_id) = mysql_fetch_array($query);
	if(count($qArray)) { 
	foreach($qArray as $key=>$value) {
		$tempQuery = $eQuery[$key];
		$resultE = mysql_query($tempQuery);
		list($SUB_DATE,$RENEW_DATE,$status1,$circle1,$MODE_OF_SUB,$DNIS,$subStatus,$NewPlanId) = mysql_fetch_array($resultE); 
		$query2_main = "( select msisdn, date_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success where msisdn='$_REQUEST[msisdn]' and event_type !='Recharged' and ";
		$query2_main .=" plan_id =".$NewPlanId." and ";
		$query2_main .= " service_id=".$service_info." )";

		$query2_main1 = "(select msisdn, date_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success_backup where msisdn='$_REQUEST[msisdn]' and event_type !='Recharged' and";
		$query2_main1 .=" plan_id=".$NewPlanId." and ";
	    $query2_main1 .= " service_id=".$service_info." )";
		
		$mainQuery2 = $query2_main." UNION ".$query2_main1." order by date_time desc limit 1";
		$mainResult = mysql_query($mainQuery2);
		list($msisdn, $date_time, $chrg_amount,$circle,$plan_id) = mysql_fetch_array($mainResult);
		?>
		<TR height="30">
			<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $msisdn; ?></TD>
			<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $DNIS; ?></TD>
			<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $SUB_DATE; ?></TD>
			<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $RENEW_DATE; ?></TD>
			<TD bgcolor="#FFFFFF" align="center" class="">&nbsp;
				<a href="javascript:void(0);" onclick="openWindow(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $subsrv?>')"><?php echo $date_time; ?></a>
			</TD>
			<TD bgcolor="#FFFFFF" align="right"><?php echo $chrg_amount; ?>&nbsp;</TD>
			<TD bgcolor="#FFFFFF" align="right"><?php echo $circle; ?>&nbsp;</TD>
			<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php if($etisalatService && $MODE_OF_SUB)  {
				echo $MODE_OF_SUB; ?>(<a href='#' onclick="showDetail('<?php echo $value?>')"><?php echo $value?></a>)
			<?php } else { echo $MODE_OF_SUB; }?>&nbsp;
			</TD>					
			<TD bgcolor="#FFFFFF" align="center" class="" width='200px;'>&nbsp;
				<?php $blacklistID=array(48,68);
					if (($subStatus == 1 || $subStatus == 11 || $subStatus == 2) && !in_array($_REQUEST['usrId'],$blacklistID)) {
						if($_SESSION['usrId']!=265) { ?>
							<a href="main.php?msisdn=<?php echo $msisdn;?>&act=da&service_info=<?php echo $service_info;?>&subsrv=<?php echo $value;?>"><b>Deactivate</b></a>
					<?php } 
						if($subStatus == 11) echo "(Pending)";
					}
					elseif($subStatus==0) echo "Not Active";
					elseif($subStatus == 11) echo "Pending"; ?>
			</TD>
			</TR>
	<?php }
	} else { $subStatus=-1;
	 list($msisdn, $date_time, $chrg_amount,$circle,$plan_id) = mysql_fetch_array($query);
	 list($SUB_DATE,$RENEW_DATE,$status1,$circle1,$MODE_OF_SUB,$DNIS,$subStatus) = mysql_fetch_array($querySubscription); ?>
		 <TR height="30">
			<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $msisdn; ?></TD>
			<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $DNIS; ?></TD>
			<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $SUB_DATE; ?></TD>
			<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $RENEW_DATE; ?></TD>
			<TD bgcolor="#FFFFFF" align="center" class="">&nbsp;
				<a href="javascript:void(0);" onclick="openWindow(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $subsrv?>')"><?php echo $date_time; ?></a>
			</TD>
			<TD bgcolor="#FFFFFF" align="right"><?php echo $chrg_amount; ?>&nbsp;</TD>
			<TD bgcolor="#FFFFFF" align="right"><?php echo $circle; ?>&nbsp;</TD>
			<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php if($etisalatService && $MODE_OF_SUB)  {
				echo $MODE_OF_SUB; ?>(<a href='#' onclick="showDetail('<?php echo $value?>')"><?php echo $value?></a>)
			<?php } else { echo $MODE_OF_SUB; }?>&nbsp;
			</TD>					
			<TD bgcolor="#FFFFFF" align="center" class="" width='200px;'>&nbsp;
				<?php $blacklistID=array(48,68);
					if (($subStatus == 1 || $subStatus == 11 || $subStatus == 2) && !in_array($_REQUEST['usrId'],$blacklistID)) {
						if($_SESSION['usrId']!=265) { ?>
							<a href="main.php?msisdn=<?php echo $msisdn;?>&act=da&service_info=<?php echo $service_info;?>&subsrv=<?php echo $value;?>"><b>Deactivate</b></a>
					<?php } 
						if($subStatus == 11) echo "(Pending)";
					}
					elseif($subStatus==0) echo "Not Active";
					elseif($subStatus == 11) echo "Pending"; ?>
			</TD>
		</TR>
	<?php }
} else {
	 $subStatus=-1;
// ANI,MODE_OF_SUB,chrg_amount,USER_BAL,plan_id,STATUS,SUB_DATE,RENEW_DATE 
	 list($msisdn,$MODE_OF_SUB,$charngamnt,$userblance,$planid,$status,$subdate,$renewdate) = mysql_fetch_array($querySubscription); ?>
	<TR height="30">
	<TD bgcolor="#FFFFFF" align="center"><b><?php echo $msisdn; ?></b></TD>
	<TD bgcolor="#FFFFFF" align="center"><input type="text" name="usersubmode" id="usersubmode" value='<?php echo $MODE_OF_SUB; ?>' readonly size="10"/></TD>
	<TD bgcolor="#FFFFFF" align="center"><input type="text" name="userblance" id="userblance" value='<?php echo $userblance; ?>' readonly size="2"/></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php echo $planid; ?></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php echo $charngamnt;?></TD>
	<TD bgcolor="#FFFFFF" align="center"><input type="text" name="userstatus" id="userstatus" value='<?php echo $status; ?>' readonly size="2"/></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php echo $subdate; ?></TD>
	<TD bgcolor="#FFFFFF" align="center">
	<input type="hidden" id="subdate" maxlength="25" size="10" name="subdate" value="<?php echo $subdate;?>">
	<input type="text" id="renewdate" maxlength="25" size="10" name="renewdate" value="<?php echo $renewdate;?>">
						<a href="javascript:NewCal('renewdate','ddmmmyyyy',false,24)"><img src="img/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	</TD>
	</TR>
<?php }?>
<!--/TBODY>
</TABLE-->
<TR height="30">
<TD bgcolor="#FFFFFF" colspan="8" align="right">
<input type="button" name="editbtn" value="Edit" id="editbtn" onclick="javascript:makeEditable()" style="color: #FFF;background-color: #900;font-weight:bold;">
<input type="button" name="updatebtn" value="Update" id="updatebtn" onclick="javascript:doUpdate()" style="visibility:hidden;color: #FFF;background-color: #900;font-weight:bold;">
</TD>
</TR>
<?php
}
else
{
echo "<h1 style=\"font:20px/21px verdana,sans-serif;color:#43729F;margin-top:10px;\">No Record Found</h1>";
}?>

</TBODY>
</TABLE>
<br/><br/><br/>
<?php
   
}
?>