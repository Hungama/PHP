<?php
 if ($_POST['Submit'] == "Submit" && $_POST['msisdn'] != "")
    {
		if($_SESSION['usrId'] == 227) {
			$service_info=1809;
		}
                
		fwrite($filePointer,"CC interface"."|".$_REQUEST['usrId']."|".$service_info."|".$remoteAdd."|".$_POST['msisdn']."|".date('his')."\r\n");
		fclose($filePointer);

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
		
if($service_info=='1208')
{
$select_query1.= "reliance_cricket.tbl_cricket_subscription";
}
else if($service_info=='1202')
{
$select_query1.= "reliance_hungama.tbl_jbox_subscription";
}
else if($service_info=='1203')
{
$select_query1.= "reliance_hungama.tbl_jbox_subscription";
}
else if($service_info=='1206')
{
$select_query1.= "reliance_hungama.tbl_jbox_subscription";
}
else if($service_info=='1202')
{
$select_query1.= "reliance_hungama.tbl_jbox_subscription";
}
				
				
				
						$endQuery =" where ANI='$_POST[msisdn]' and plan_id IN (".implode(",",$planData).") order by SUB_DATE desc limit 1";		
						$eQuery = array();
						//$eQuery[] =$mainQuery." etislat_hsep.tbl_astro_subscription ".$endQuery;
						$eQuery[] =$mainQuery." etislat_hsep.tbl_sfp_subscription ".$endQuery;
						$eQuery[] =$mainQuery." etislat_hsep.tbl_jokes_subscription ".$endQuery;
						$eQuery[] =$mainQuery." etislat_hsep.tbl_hollywood_subscription ".$endQuery;
						$eQuery[] =$mainQuery." etislat_hsep.tbl_funnews_subscription ".$endQuery;
						$eQuery[] =$mainQuery." etislat_hsep.tbl_epl_subscription ".$endQuery;
					
			$select_query1.=" where ANI='$_POST[msisdn]' ";
			$select_query1.=" and plan_id IN (".implode(",",$planData).")";

			$select_query1.="  order by SUB_DATE desc limit 1";		
			$querySubscription = mysql_query($select_query1,$dbConn) or mysql_error($dbConn);
?>
		<center><div width="85%" align="left" class="txt"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B><FONT COLOR="#FF0000">Subscription Status</FONT></B></div><center><br/>
		<TABLE width="85%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
		<TBODY>
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
<?php
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
	<TD bgcolor="#FFFFFF" align="center">&nbsp;
	<?php	
		if($etisalatService && $MODE_OF_SUB)
			echo $MODE_OF_SUB."(<a href='showServiceInfo.php?etiSname=".$etisalatService."'>".$etisalatService."</a>)";
		else
			echo $MODE_OF_SUB;
	?>
	&nbsp;</TD>
	<?php if($service_info=='1208') { ?>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php if ($status1 == '1' || $status1 == '5') echo "Active"; else echo "Inactive"; ?></TD>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;
		<?php
		if (($subStatus == 1 || $subStatus == 5 || $subStatus == 2) && !in_array($_REQUEST['usrId'],$blacklistID)) { 
			if($_SESSION['usrId']!=265) { ?>
				<a href="customer_care.php?msisdn=<?php echo $msisdn;?>&act=da&service_info=<?php echo $service_info;?>&subsrv=<?php echo $subsrv;?>"><b><u>Deactivate</u></b></a>
		<?php }
		} else {
		?><!--<a href="main.php?msisdn=<?php echo $msisdn;?>&act=a&service_info=<?php echo $service_info;?>">Activate</a>-->
		<?php } 
	}?>
	</TD>
	<?php if($service_info!='1208') { ?>
	<?php if($_SESSION['usrId'] != 219 && $_SESSION['usrId'] != 221) { ?>
	<TD bgcolor="#FFFFFF" align="center" class="blue" width='200px;'>&nbsp;<?php

	$blacklistID=array(48,68);
	if (($subStatus == 1 || $subStatus == 11 || $subStatus == 2) && !in_array($_REQUEST['usrId'],$blacklistID)) {
		if($_SESSION['usrId']!=265) {
		?>
	<a href="customer_care.php?msisdn=<?php echo $msisdn;?>&act=da&service_info=<?php echo $service_info;?>&subsrv=<?php echo $subsrv;?>"><b>Deactivate</b></a>
	<?php }
	if($subStatus == 11)
		echo "(Pending)";
	}
	elseif($subStatus==0)
	{
		echo "Not Active";
	}
	elseif($subStatus == 11)
	{
		echo "Pending";
	}

	?></TD>
	<?php }?>
	<?php }?>
	</TR>
</TBODY>
</TABLE><br/><br/><br/>
<?php
        } else
        {
			if($_SESSION['usrId'] == 24) {  //echo "hello:".$_POST['msisdn'];?>
				<div align='right' width="60%" class="txt"><a href='checkSubRetry.php?msisdn=<?php echo $_POST['msisdn'];?>&service_id=<?php echo $service_info?>'><FONT COLOR="#0033FF" size='2px'>Check Sub-Retry</FONT></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
			<?php  }
			$flag=1;
            echo "<div align='center'><B>No records found for this number</B></div>";
        }

?>


<center><div width="85%" align="left" class="txt"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php if(!$flag) { ?>
	<?php if($_SESSION['usrId'] != 215) { ?>
		<a href="javascript:void(0);" onclick="openWindow(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $subsrv;?>')"><FONT COLOR="#0033FF" size='2px'>
		<B>Click here to view subscription history</B></FONT></a> |

		<?php if($service_info!=2121){ ?>		
		<a href="javascript:void(0);" onclick="openWindow1('viewchargingDetails',<?php echo $msisdn;?>,<?php echo $service_info;?>)">
		<FONT COLOR="#0033FF" size='2px'>
		<B>Click here to view Recharge/MCoupen history</B></FONT></a>
		<? }	else {	?>
			<a href="javascript:void(0);" onclick="openWindow1('viewMessageDetails',<?php echo $msisdn;?>,<?php echo $service_info;?>)">
		<FONT COLOR="#0033FF" size='2px'>
		<B>Click here to view Message history</B></FONT></a>
		<?}?>

			<?php if($_SESSION['usrId']==1 || $_SESSION['usrId']==265) {  ?> |
		<a href="javascript:void(0);" onclick="openWindow3('viewsMousDetail',<?php echo $msisdn;?>,<?php echo $service_info;?>)"><FONT COLOR="#0033FF" size='2px'><B>Click here to view MOUS history</B></FONT></a><?php } ?>
	<?php }?>
<?php }?>
</div><center><br/>
<?php
	//	mysql_select_db($userDbName, $userDbConn);
		$deactivationQuery1="select SUB_DATE, RENEW_DATE, circle, MODE_OF_SUB, DNIS, STATUS, SUB_TYPE, UNSUB_DATE, UNSUB_REASON from ";
		//. $$unSubsTableName." where ANI='$_POST[msisdn]' order by UNSUB_DATE desc";

		switch($service_info)
		{
			case '1208':
				$deactivationQuery1 .= "reliance_cricket.tbl_cricket_unsub";
			break;
			case '1202':
				$deactivationQuery1 .= "reliance_hungama.tbl_jbox_unsub";
			break;
			case '1203':
				$deactivationQuery1 .= "reliance_hungama.tbl_mtv_unsub";
			break;
			case '1206':
				$deactivationQuery1 .= "reliance_starclub.tbl_jbox_unsub ";
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
<TABLE width="85%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
<TBODY>
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
</TBODY>
</TABLE>
<?php
} else
        {
            echo "<div align='center'><B>No history found</B></div>";
        }
    }
//if section end here	
//Deactivation of MDN
	elseif ($_GET['msisdn'] != "" && $_GET['act'] == "da")
        {
		if($_GET['service_info']==1202)
				$Query1 = "call reliance_hungama.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
				elseif($_GET['service_info']==1203) {
				$aftId='DCC546461';
				$deactMode="CC"."#".$aftId;
				$Query1 = "call reliance_hungama.MTV_UNSUB('$_GET[msisdn]', '".$deactMode."')";
			} 
			elseif($_GET['service_info']==1208)
				$Query1 = "call reliance_cricket.CRICKET_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1206)
                $Query1 = "call reliance_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			$result = mysql_query($Query1) or die(mysql_error());
            echo "<div align='center'><B>Request for deactivation sent</B></div>";
        }
		//Activation of MDN
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
				echo "<div align='center'><B>Request for activation sent</B></div>";
			}
		}

		
		?>
		<!--Logic will end here -->