<!--Logic will start here -->
<?php
  session_start();
ini_set('display_errors','0');
require_once("incs/db.php");
$msisdn = $_REQUEST['msisdn'];
$service_info = $_REQUEST['service_info'];
$_SESSION['usrId'] = $_REQUEST['usrId'];
//echo $msisdn."-".$service_info."-".$_SESSION['usrId'];
//exit;
 //if ($_POST['Submit'] == "Submit" && $_POST['msisdn'] != "")
    if ($_POST['msisdn'] != "")
	{
		if($_POST['service_info'] == '14021') $service_info='1402';
		else $service_info=$_POST['service_info'];

		if($_SESSION['usrId'] == 227) {
			$service_info=1809;
		}
                
		fwrite($filePointer,"CC interface"."|".$_REQUEST['usrId']."|".$service_info."|".$remoteAdd."|".$_POST['msisdn']."|".date('his')."\r\n");
		fclose($filePointer);

	    //$select_query2 ="select msisdn, date_time, chrg_amount,circle from master_db.tbl_billing_success where msisdn='$_POST[msisdn]' and";
        //$select_query2 .= " service_id=".$service_info." order by date_time desc limit 1";
		
		if($_SESSION['usrId']=='269') {
			$planData[] = '92';
		} else {
			$planDataResult = mysql_query("SELECT Plan_id from master_db.tbl_plan_bank WHERE sname='".$_POST['service_info']."'");
			while($row = mysql_fetch_array($planDataResult)) {
				$planData[] = $row['Plan_id'];
			}
		}
		
 				
		$select_query2_main = "( select msisdn, date_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success where msisdn='$_POST[msisdn]' and event_type !='Recharged' and ";
		$select_query2_main .=" plan_id IN (".implode(",",$planData).") and ";
		$select_query2_main .= " service_id=".$service_info." )";
		
		$select_query2_bak = "(select msisdn, date_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success_230312 where msisdn='$_POST[msisdn]' and event_type !='Recharged' and";
		$select_query2_bak .=" plan_id IN (".implode(",",$planData).") and ";
	    $select_query2_bak .= " service_id=".$service_info." )";

		$select_query3_bak = "(select msisdn, date_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success_backup where msisdn='$_POST[msisdn]' and event_type !='Recharged' and";
		$select_query3_bak .=" plan_id IN (".implode(",",$planData).") and ";
	    $select_query3_bak .= " service_id=".$service_info." )";
		
		$select_query2 = $select_query2_main." UNION ".$select_query2_bak." UNION ".$select_query3_bak." order by date_time desc limit 1 "; 

		//echo $select_query2; exit;
		$query = mysql_query($select_query2, $dbConn) or die(mysql_error());
		$query1 = mysql_query($select_query2, $dbConn) or die(mysql_error());
		$numRows = mysql_num_rows($query);
		if ($numRows > 0)
        {
         //   mysql_select_db($userDbName, $userDbConn);
				
			$select_query1= "select SUB_DATE, RENEW_DATE, status , circle, MODE_OF_SUB, DNIS, STATUS from ";
		 switch($service_info)
			{
				case '1001': if($_SESSION['usrId']=='269') { 
									$select_query1.= "docomo_radio.tbl_radio_smspack_sub";
								} else {
									$select_query1.= "docomo_radio.tbl_radio_subscription";
								}
				break;
				case '2121':list($msisdn1, $date_time1, $chrg_amount1,$circle1,$plan_id1) = mysql_fetch_array($query1);
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
						$endQuery =" where ANI='$_POST[msisdn]' and plan_id IN (".implode(",",$planData).") order by SUB_DATE desc limit 1";		
						$eQuery = array();
						//$eQuery[] =$mainQuery." etislat_hsep.tbl_astro_subscription ".$endQuery;
						$eQuery[] =$mainQuery." etislat_hsep.tbl_sfp_subscription ".$endQuery;
						$eQuery[] =$mainQuery." etislat_hsep.tbl_jokes_subscription ".$endQuery;
						$eQuery[] =$mainQuery." etislat_hsep.tbl_hollywood_subscription ".$endQuery;
						$eQuery[] =$mainQuery." etislat_hsep.tbl_funnews_subscription ".$endQuery;
						$eQuery[] =$mainQuery." etislat_hsep.tbl_epl_subscription ".$endQuery;
				break;
			}
			
			$select_query1.=" where ANI='$_POST[msisdn]' ";
			$select_query1.=" and plan_id IN (".implode(",",$planData).")";

			$select_query1.="  order by SUB_DATE desc limit 1";		
			//echo $select_query1; die;
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
					$querySubscription = mysql_query($eQuery[$i],$userDbConn) or die(mysql_error());
					$num = mysql_num_rows($querySubscription);
					if($num) { $qArray[$i]=$etisalatService; }
				}
			}
?>
		<center><div width="85%" align="left" class="txt"> 
		<div class="alert alert-block"><B><FONT COLOR="#FF0000">Subscription Status</FONT></B></div></div><center><br/>
		<TABLE width="85%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="table table-condensed table-bordered">
		<thead>
		<TR height="30">
		<TD bgcolor="#FFFFFF" align="center"><B>Mobile No</B></TD>
		<TD bgcolor="#FFFFFF" align="center"><B>Registration.ID</B></TD>
		<TD bgcolor="#FFFFFF" align="center"><B>Activation</B></TD>
		<TD bgcolor="#FFFFFF" align="center"><B>Next Charging</B></TD>
		<TD bgcolor="#FFFFFF" align="center"><B>Last Charging</B></TD>
		<TD bgcolor="#FFFFFF" align="center"><B>Charged Amt.</B></TD>
		<TD bgcolor="#FFFFFF" align="center"><B>Circle</B></TD>
		<TD bgcolor="#FFFFFF" align="center"><B>SubscriptionMode</B></TD>
		<?php if($service_info=='1208') { ?>
		<TD bgcolor="#FFFFFF" align="center"><B>Current Status</B></TD>		
		<TD bgcolor="#FFFFFF" align="center"><B>Option</B></TD>
		<?php } ?>
		</TR>
		</thead>
<?php
if($service_info == '2121') {		
	//list($msisdn, $date_time, $chrg_amount,$circle,$plan_id) = mysql_fetch_array($query);
	if(count($qArray)) { 
	foreach($qArray as $key=>$value) {
		$tempQuery = $eQuery[$key];
		$resultE = mysql_query($tempQuery);
		list($SUB_DATE,$RENEW_DATE,$status1,$circle1,$MODE_OF_SUB,$DNIS,$subStatus,$NewPlanId) = mysql_fetch_array($resultE); 
		$query2_main = "( select msisdn, date_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success where msisdn='$_POST[msisdn]' and event_type !='Recharged' and ";
		$query2_main .=" plan_id =".$NewPlanId." and ";
		$query2_main .= " service_id=".$service_info." )";

		$query2_main1 = "(select msisdn, date_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success_backup where msisdn='$_POST[msisdn]' and event_type !='Recharged' and";
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
			<TD bgcolor="#FFFFFF" align="center" class="blue">&nbsp;
				<a href="javascript:void(0);" onclick="openWindow(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $subsrv?>')"><?php echo $date_time; ?></a>
			</TD>
			<TD bgcolor="#FFFFFF" align="right"><?php echo $chrg_amount; ?>&nbsp;</TD>
			<TD bgcolor="#FFFFFF" align="right"><?php echo $circle; ?>&nbsp;</TD>
			<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php if($etisalatService && $MODE_OF_SUB)  {
				echo $MODE_OF_SUB; ?>(<a href='#' onclick="showDetail('<?php echo $value?>')"><?php echo $value?></a>)
			<?php } else { echo $MODE_OF_SUB; }?>&nbsp;
			</TD>					
			<TD bgcolor="#FFFFFF" align="center" class="blue" width='200px;'>&nbsp;
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
	 list($msisdn, $date_time, $chrg_amount,$circle,$plan_id) = mysql_fetch_array($query);
	 list($SUB_DATE,$RENEW_DATE,$status1,$circle1,$MODE_OF_SUB,$DNIS,$subStatus) = mysql_fetch_array($querySubscription); ?>
		 <TR height="30">
			<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $msisdn; ?></TD>
			<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $DNIS; ?></TD>
			<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $SUB_DATE; ?></TD>
			<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $RENEW_DATE; ?></TD>
			<TD bgcolor="#FFFFFF" align="center" class="blue">&nbsp;
				<a href="javascript:void(0);" onclick="openWindow(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $subsrv?>')"><?php echo $date_time; ?></a>
			</TD>
			<TD bgcolor="#FFFFFF" align="right"><?php echo $chrg_amount; ?>&nbsp;</TD>
			<TD bgcolor="#FFFFFF" align="right"><?php echo $circle; ?>&nbsp;</TD>
			<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php if($etisalatService && $MODE_OF_SUB)  {
				echo $MODE_OF_SUB; ?>(<a href='#' onclick="showDetail('<?php echo $value?>')"><?php echo $value?></a>)
			<?php } else { echo $MODE_OF_SUB; }?>&nbsp;
			</TD>					
			<TD bgcolor="#FFFFFF" align="center" class="blue" width='200px;'>&nbsp;
				<?php $blacklistID=array(48,68);
					if (($subStatus == 1 || $subStatus == 11 || $subStatus == 2) && !in_array($_REQUEST['usrId'],$blacklistID)) {
						if($_SESSION['usrId']!=265) { ?>
							<!--a href="main.php?msisdn=<?php echo $msisdn;?>&act=da&service_info=<?php echo $service_info;?>&subsrv=<?php echo $value;?>"><b>Deactivate</b></a-->
								<a href="javascript:void(0);" onclick="do_Act_Deactivate(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $subsrv;?>','da','customer_care_tataindicom')" style="text-decoration:none">
		<FONT COLOR="#0033FF" size='2px'>
		<B><span class="label label-important" id="">Deactivate<span></B></FONT></a>
					<?php } 
						if($subStatus == 11) echo "(Pending)";
					}
					elseif($subStatus==0) echo "Not Active";
					elseif($subStatus == 11) echo "Pending"; ?>
			</TD>
		</TR>
	<?php }
} 
?>
</TABLE><br/><br/><br/>
<?php
        } else
        {
			if($_SESSION['usrId'] == 24) {  //echo "hello:".$_POST['msisdn'];?>
				<div align='right' width="60%" class="txt">
				<a href='checkSubRetry.php?msisdn=<?php echo $_POST['msisdn'];?>&service_id=<?php echo $service_info?>'>
				<span class="label label-info"><FONT COLOR="#0033FF" size='2px'>Check Sub-Retry</FONT></span></a></div>
			<?php  }
			$flag=1;
            //echo "<div align='center'><B>No records found for this number</B></div>";
			echo "<div class='alert alert-block'><h4>Ooops!</h4>No records found for this number</div> ";
        }

?>

	<?php 
	if(($service_info==2121 && !$_GET['act']) || $_SESSION['usrId']==289) { ?>
	<div id="showinfo"><?php include('showServiceInfo.php');?></div><br/><br/>
<?php }?>

<center><div width="85%" align="left" class="txt"> 
<?php
/* if(!$flag) { ?>
	<?php if($_SESSION['usrId'] != 215) { ?>
		<!--a href="javascript:void(0);" onclick="openWindow(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $subsrv;?>')" style="text-decoration:none"><FONT COLOR="#0033FF" size='2px'>
		<B><span class="label label-info" id="">Click here to view subscription history<span></B></FONT></a>|-->

		<a href="javascript:void(0);" onclick="viewbillinghistory(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $subsrv;?>')" style="text-decoration:none">
		<FONT COLOR="#0033FF" size='2px'>
		<B><span class="label label-info" id="">Click here to view subscription history<span></B></FONT></a>

		<?php if($service_info!=2121){ ?>		
		<!--a href="javascript:void(0);" onclick="openWindow1('viewchargingDetails',<?php echo $msisdn;?>,<?php echo $service_info;?>)" style="text-decoration:none">
		<FONT COLOR="#0033FF" size='2px'><B><span class="label label-info">Click here to view Recharge/MCoupen history</span></B></FONT></a-->
		<a href="javascript:void(0);" onclick="viewchargingDetails(<?php echo $msisdn;?>,<?php echo $service_info;?>)" style="text-decoration:none">
		<FONT COLOR="#0033FF" size='2px'><B><span class="label label-info">Click here to view Recharge/MCoupen history</span></B></FONT></a>
		<? }	else {	?>
			<a href="javascript:void(0);" onclick="openWindow1('viewMessageDetails',<?php echo $msisdn;?>,<?php echo $service_info;?>)" style="text-decoration:none">
		<FONT COLOR="#0033FF" size='2px'>
		<B><span class="label label-info">Click here to view Message history</span></B></FONT></a>
		<?}?>

			<?php if($_SESSION['usrId']==1 || $_SESSION['usrId']==265) {  ?>
		<a href="javascript:void(0);" onclick="openWindow3('viewsMousDetail',<?php echo $msisdn;?>,<?php echo $service_info;?>)"><FONT COLOR="#0033FF" size='2px'><B>
		<span class="label label-important">Click here to view MOUS history</span></B></FONT></a><?php } ?>
	<?php }?>
<?php } */?>
<?php include("cc_links_include.php"); ?>
</div><center><br/>


<?php
	$deactivationQuery1="select SUB_DATE, RENEW_DATE, circle, MODE_OF_SUB, DNIS, STATUS, SUB_TYPE, UNSUB_DATE, UNSUB_REASON from ";
		//. $$unSubsTableName." where ANI='$_POST[msisdn]' order by UNSUB_DATE desc";

		switch($service_info)
		{
			case '1001': if($_SESSION['usrId']=='269') { 
					$deactivationQuery1.= "docomo_radio.tbl_radio_smspack_unsub";
				 } else {					
					$deactivationQuery1 .= "docomo_radio.tbl_radio_unsub";
				 }
			break;
			case '2121':
				switch($plan_id) {
					case '115':
					case '120':		
						$deactivationQuery1.= "etislat_hsep.tbl_astro_subscription_log ";	
					break;
					case '119':
					case '124':	
						$deactivationQuery1.= "etislat_hsep.tbl_sfp_subscription_log ";	
					break;
					case '116': 
					case '121':
						$deactivationQuery1.= "etislat_hsep.tbl_jokes_subscription_log ";	
					break;
					case '117':
					case '122':	
						$deactivationQuery1.= "etislat_hsep.tbl_hollywood_subscription_log ";	
					break;
					case '118':
					case '123':	
						$deactivationQuery1.= "etislat_hsep.tbl_funnews_subscription_log ";	
					break;
					case '125':
					case '126':	
						$deactivationQuery1.= "etislat_hsep.tbl_epl_subscription_log ";	
					break;
				}
			break;
		}
		$deactivationQuery1 .= " where ANI='$_POST[msisdn]' ";
		if($service_info==1801)
			$deactivationQuery1 .= " and plan_id=40 ";
		elseif($service_info==1809)
			$deactivationQuery1 .= " and plan_id=73 ";
		elseif($service_info==1807)
			$deactivationQuery1 .= " and plan_id=84 ";
		elseif($service_info==1810)
			$deactivationQuery1 .= " and plan_id=72 ";
		elseif($service_info==1811) 
			$deactivationQuery1 .=" and plan_id IN (77,78,79) ";
		elseif($service_info==1011)
			$deactivationQuery1.=" and plan_id IN (66,75,76) ";

		$deactivationQuery1 .= " order by UNSUB_DATE desc";

		$queryunSubscription = mysql_query($deactivationQuery1,$dbConnDocomo) or die(mysql_error());
        echo $numRows1 = mysql_num_rows($queryunSubscription);
        if ($numRows1 > 0)
        {

?>
<TABLE width="85%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="table table-condensed table-bordered">
 <thead>
<TR height="30">
<TD bgcolor="#FFFFFF" align="center"><B>Mobile No</B></TD>
<TD bgcolor="#FFFFFF" align="center"><B>Registration.ID</B></TD>
<TD bgcolor="#FFFFFF" align="center"><B>Subscription Date</B></TD>
<TD bgcolor="#FFFFFF" align="center"><B>Renew Date</B></TD>
<TD bgcolor="#FFFFFF" align="center"><B>Circle</B></TD>
<TD bgcolor="#FFFFFF" align="center"><B>SubscriptionMode</B></TD>			
<TD bgcolor="#FFFFFF" align="center"><B>Status</B></TD>
<TD bgcolor="#FFFFFF" align="center"><B>Subscrition Type</B></TD>
<TD bgcolor="#FFFFFF" align="center"><B>Unsubscription Date</B></TD>
<TD bgcolor="#FFFFFF" align="center"><B>Reason</B></TD>
</TR>
 </thead>
<?php

  list($SUB_DATE,$RENEW_DATE,$circle,$MODE_OF_SUB,$DNIS,$subStatus,$SUB_TYPE,
                $UNSUB_DATE, $UNSUB_REASON) = mysql_fetch_array($queryunSubscription);

?>
<TR height="30">
<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php

            echo $msisdn;

?></TD>
<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php

            echo $DNIS;

?></TD>
<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php

            echo $SUB_DATE;

?></TD>
<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php

            echo $RENEW_DATE;

?></TD>
<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php

            echo $circle;

?></TD>
<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php

            echo $MODE_OF_SUB;

?></TD>
<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php

            echo $subStatus;

?></TD>
<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php

            echo $SUB_TYPE;

?></TD>
<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php

            echo $UNSUB_DATE;

?></TD>
<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php

            echo $UNSUB_REASON;

?></TD>
</TR>				

</TABLE>
<?php
} else
        {
            //   echo "<div align='center'><B>No history found</B></div>";
		 ?>
		 <div class="alert alert-block">
 
  <h4>Ooops!</h4>
  No history found....
</div> 
        <?php
        }
    }
//if section end here	
//In case of Deactivation code start here
	elseif ($_GET['msisdn'] != "" && $_GET['act'] == "da")
        {
			if($_GET['service_info']==2121) { 
				switch($_GET['subsrv']) {
					case 'Astro':		
						$Query1= "CALL etislat_hsep.ASTRO_UNSUB('$_GET[msisdn]', 'CC')";	
					break;
					case 'SFP':	
						$Query1= "CALL etislat_hsep.SFP_UNSUB('$_GET[msisdn]', 'CC')";	
					break;
					case 'JOKES':
						$Query1= "CALL etislat_hsep.JOKES_UNSUB('$_GET[msisdn]', 'CC')";	
					break;
					case 'HollyWood':
						$Query1= "CALL etislat_hsep.HOLLYWOOD_UNSUB('$_GET[msisdn]', 'CC')";	
					break;
					case 'FunNews':
						$Query1= "CALL etislat_hsep.FUNNEWS_UNSUB('$_GET[msisdn]', 'CC')";	
					break;
					case 'EPL':
						$Query1= "CALL etislat_hsep.epl_UNSUB('$_GET[msisdn]', 'CC')";	
					break;
				} //echo $Query1;
			}

            $result = mysql_query($Query1) or die(mysql_error());
            echo "<div align='center' class='alert alert-block'><B>Request for deactivation sent</B></div>";
        }
		//In case of Deactivation code end here
		//In case of Activation code start here
		elseif ($_GET['msisdn'] != "" && $_GET['act'] == "a")
		{
			if($_GET['service_info']==1208)
			{
				$amtquery="select iAmount from master_db.tbl_plan_bank where Plan_id='21' and S_id='$_GET[service_info]'";
				$amt = mysql_query($amtquery);
				List($row1) = mysql_fetch_row($amt);
				$amount = $row1;
				$qry="call reliance_cricket.CRICKET_SUB('$_GET[msisdn]', '01' , 'CC' , '54433','".$amount."',$_GET[service_info],21 )";
				$result=mysql_query($qry) or die(mysql_error());
				echo "<div align='center' class='alert alert-block'><B>Request for activation sent</B></div>";
			}
		}
		//In case of Activation code end here
		?>
		<?php
function Colorize($IN) {
switch($IN) {
	case 'Processed':
	return 'success';
	break;	
	case 'Processing':
	return 'warning';
	break;	
	case 'Queued':
	return 'info';
	break;	
	case 'Error':
	return 'error';
	break;	
	
	default: 
	return '';
	
}
}
?>
		<!--Logic will end here -->