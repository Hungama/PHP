<?php
ob_start();
session_start();
require_once("../../2.0/incs/db.php");
$user_id=$_SESSION['loginId'];
require_once("../../2.0/language.php");
require_once("../../2.0/base.php");
$logDir="/var/www/html/kmis/services/hungamacare/v3/snippets/logs/adminAccessLog/";
$logFile="adminAccessLog_".date('Ymd');
$logPath=$logDir.$logFile;
$filePointer=fopen($logPath,'a+');
$remoteAdd=$_SERVER['REMOTE_ADDR'];
$msisdn = $_REQUEST['msisdn'];
$service_info_array = $_REQUEST['service_info'];
$no_of_servicename=count($service_info_array);
$service_info_duration = $_REQUEST['service_info_duration'];
$submt=$_REQUEST['Submit'];
//print_r($service_info_array);
//exit;	
//echo $msisdn."****".$no_of_servicename."****".$service_info_duration."****".$service_info_array."***".$submt;
$flag=0;
$_SESSION['usrId'] = $_REQUEST['usrId'];
   //if ($_POST['Submit'] == "Submit" && $_POST['msisdn'] != "")
   if ($_REQUEST['Submit'] == "Submit")
    {
	if($service_info_array[0]=='' || $service_info_duration==0 || $msisdn=='')
	{
	echo "<div class='alert alert-block'><h4>Ooops!</h4>Either mobile number or service left blank.</div> ";
	exit;
	}
	
	?>
	<div width="85%" align="left" class="txt"> 
		</div>
		<div id="result-table">
		<div id="alert-success" class="alert alert"><?php echo CC_SEARCH_INFO.$msisdn;?></div>
		<TABLE width="85%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="table table-condensed table-bordered" >

	<TR height="30">
		<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_ANI;?></B></TD>
		<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_STATUS;?></B></TD>
		<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_REGISTRATION_ID;?></B></TD>
		<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_SERVICENAME;?></B></TD>
		<TD bgcolor="#FFFFFF" align="center"><B>Activation</B></TD>
		<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_NEXT_CHARGING;?></B></TD>
		<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_LAST_CHARGING;?></B></TD>
		<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_CHARGED_AMT;?></B></TD>
		<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_CIRCLE;?></B></TD>
		<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_MODE;?></B></TD>
<TD bgcolor="#FFFFFF" align="center"></TD>	
	</TR>
		
		<?php
	
	for($i=0;$i<$no_of_servicename;$i++)
	{
	$service_info=$service_info_array[$i];
	$planData='';
		fwrite($filePointer,"CC interface"."|".$_REQUEST['usrId']."|".$service_info."|".$remoteAdd."|".$msisdn."|".date('his')."\r\n");
		fclose($filePointer);
			$planDataResult = mysql_query("SELECT Plan_id,S_id from master_db.tbl_plan_bank WHERE sname='".$service_info."'",$dbConn);
			while($row = mysql_fetch_array($planDataResult)) {
				$planData[] = $row['Plan_id'];
				$serviceId=$row['S_id'];
			}
					
		$select_query2_main = "( select msisdn, date_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success nolock where msisdn='$msisdn' and event_type !='Recharged' and ";
		$select_query2_main .=" plan_id IN (".implode(",",$planData).") and ";
		$select_query2_main .= " service_id=".$serviceId." )";
		
		$select_query3_bak = "(select msisdn, date_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success_04_06_2013 nolock where msisdn='$msisdn' and event_type !='Recharged' and";
		$select_query3_bak .=" plan_id IN (".implode(",",$planData).") and ";
	    $select_query3_bak .= " service_id=".$serviceId." )";

		$select_query2_bak = "(select msisdn, date_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success_backup nolock where msisdn='$msisdn' and event_type !='Recharged' and";
		$select_query2_bak .=" plan_id IN (".implode(",",$planData).") and ";
	    $select_query2_bak .= " service_id=".$serviceId." )";
		
		if($service_info_duration==1)
		{
	$select_query2 = $select_query2_main." UNION ".$select_query2_bak." UNION ".$select_query3_bak." order by date_time desc limit 1 "; 	
		}
		else if($service_info_duration==2)
		{
	$select_query2 = $select_query2_main." UNION ".$select_query2_bak." order by date_time desc limit 1 "; 
		}
		else if($service_info_duration==3)
		{
	$select_query2 = $select_query2_main." order by date_time desc limit 1 "; 
		}
		else
		{
		echo "<div class='alert alert-block'><h4>Ooops!</h4>Please select data period.</div> ";
		exit;
		}		
//echo $select_query2."<br>";
//exit;
		
		$query = mysql_query($select_query2, $dbConn) or die(mysql_error());
		$numRows = mysql_num_rows($query);
		if ($numRows > 0)
        {
        	$select_query1= "select SUB_DATE, RENEW_DATE, status , circle, MODE_OF_SUB, DNIS, STATUS from ";
			switch($service_info)
			{
			
				case '14021':
					$select_query1.= "uninor_hungama.tbl_Artist_Aloud_subscription";
						break;
				case '1402':
					$select_query1.= "uninor_hungama.tbl_jbox_subscription";
				break;
				case '1403':
					$select_query1.= "uninor_hungama.tbl_mtv_subscription";
				break;
				case '1410':
					$select_query1.= "uninor_redfm.tbl_jbox_subscription";
				break;
				case '1406':
					$select_query1.= "uninor_starclub.tbl_jbox_subscription ";
				break;
				case '1409':
				//	$select_query1.= "uninor_hungama.tbl_jbox_subscription ";	
					$select_query1.= "uninor_manchala.tbl_riya_subscription ";	
				break;
				case '1412':
					//$select_query1.= " uninor_myringtone.tbl_radio_ringtonesubscription ";	
					$select_query1.= " uninor_myringtone.tbl_radio_subscription ";	
					
				break;
				case '1416':
					$select_query1.= "uninor_jyotish.tbl_jyotish_subscription ";	
				break;
				case '1408':
					$select_query1.= "uninor_cricket.tbl_cricket_subscription ";	
				break;
				case '1418':
					$select_query1.= "uninor_hungama.tbl_comedy_subscription ";	
				break;
				case '1423':
					$select_query1.= "uninor_summer_contest.tbl_contest_subscription";
				break;
				case '1001':
					$select_query1.= "docomo_radio.tbl_radio_subscription";
				break;
				case '1002':
					$select_query1.= "docomo_hungama.tbl_jbox_subscription";
				break;
				case '10021':
					$select_query1.= "docomo_bpl.tbl_bpl_subscription";
				break;
				case '1027':
					$select_query1.= "docomo_hungama.tbl_dev_subscription";
				break;
				case '1003':
					$select_query1.= "docomo_hungama.tbl_mtv_subscription";
				break;
				case '1005':
					$select_query1.= "docomo_starclub.tbl_jbox_subscription";
				break;
				case '1009':
					$select_query1.= "docomo_manchala.tbl_riya_subscription ";
				break;
				case '1006':
					$select_query1.= "uninor_starclub.tbl_jbox_subscription ";
				break;
				case '1010':
					$select_query1.= "docomo_redfm.tbl_jbox_subscription ";	
				break;
				case '1007':
					$select_query1.= "docomo_vh1.tbl_jbox_subscription ";	
				break;
				case '1011':
					$select_query1.= "docomo_rasoi.tbl_rasoi_subscription ";	
				break;
				case '1013':
				case '1813':
					$select_query1.= "docomo_mnd.tbl_character_subscription1 ";	
				break;
				case '1613':
					$select_query1.= "indicom_mnd.tbl_character_subscription1 ";	
				break;
				case '1601':
					$select_query1.= "indicom_radio.tbl_radio_subscription";
				break;
				case '1602':
					$select_query1.= "indicom_hungama.tbl_jbox_subscription";
				break;
				case '1603':
					$select_query1.= "indicom_hungama.tbl_mtv_subscription";
				break;
				case '1609':
					$select_query1.= "indicom_manchala.tbl_riya_subscription ";
				break;	
				case '1606':
					$select_query1.= "indicom_starclub.tbl_jbox_subscription ";
				break;
				case '1605':
					$select_query1.= "indicom_starclub.tbl_jbox_subscription ";	
				break;
				case '1607':
					$select_query1.= "indicom_vh1.tbl_jbox_subscription ";	
				break;
				case '1610':
					$select_query1.= "indicom_redfm.tbl_jbox_subscription ";	
				break;
				case '1611':
					$select_query1.= "indicom_rasoi.tbl_rasoi_subscription ";	
				break;
				case '1801':
					$select_query1.= "docomo_radio.tbl_radio_subscription";
				break;
				case '1809':
					$select_query1.= "docomo_manchala.tbl_riya_subscription ";	
				break;
				case '1810':
					$select_query1.= "docomo_redfm.tbl_jbox_subscription ";	
				break;
				case '1208':
					$select_query1.= "reliance_cricket.tbl_cricket_subscription";
				break;
				case '1202':
					$select_query1.= "reliance_hungama.tbl_jbox_subscription";
				break;
				case '1203':
					$select_query1.= "reliance_hungama.tbl_mtv_subscription";
				break;
				
		}
			
			$select_query1.=" where ANI='$msisdn' ";
			$select_query1.=" and plan_id IN (".implode(",",$planData).")";

			$select_query1.="  order by SUB_DATE desc limit 1";	
			//exit;
			//echo $select_query1."<br>";
			$querySubscription = mysql_query($select_query1,$dbConn) or mysql_error($dbConn);
	
?>
		
<?php
	$sname_ks = array_flip($serviceArray);
//	$servicename=$serviceNameArray[$service_info];
	//end here
    $subStatus=-1;
	 list($msisdn, $date_time, $chrg_amount,$circle,$plan_id) = mysql_fetch_array($query);
	 list($SUB_DATE,$RENEW_DATE,$status1,$circle1,$MODE_OF_SUB,$DNIS,$subStatus) = mysql_fetch_array($querySubscription); 
         if($subStatus == ''){
             $subStatus=-1;
         }?>
	<TR height="30">
	<TD bgcolor="#FFFFFF" align="center"><?php echo $msisdn; ?></TD>
	<TD bgcolor="#FFFFFF" align="center">
	
	<!--
	define("STATUS_LABEL_0","label-warning",true);
define("STATUS_LABEL_1","label-success",true);
define("STATUS_LABEL_5","label-info",true);
define("STATUS_LABEL_11","label-info",true);
	-->
	<!--span class="label <?php //echo STATUS_LABEL_.$subStatus;?>"-->
	
	<?php if($subStatus == 0)
	{?>
	<span class="label label-warning">
	<?php
	echo STATUS_0;
	}
	else if($subStatus == 1)
	{?>
	<span class="label label-success">
	<?php
	echo STATUS_1;
	} 
	else if($subStatus == 11)
	{?>
	<span class="label label-info">
	<?php
	echo STATUS_11;
	}
	else if($subStatus == 5)
	{?>
	<span class="label label-info">
	<?php
	echo STATUS_5;
	} ?></span>
	</TD>
	<TD><?php if(!empty($DNIS)){echo $DNIS;} else {echo '-';} ?></TD>
	<TD><?php 
	//echo $Service_DESC[$servicename]['Name']; 
		if(!empty($Service_DESC[$sname_ks[$service_info]]['Name']))
		{
		echo $Service_DESC[$sname_ks[$service_info]]['Name'];
		}
		else
		{
		echo $sname_ks[$service_info];
		}
	?>
	</TD>
	<TD><?php if(!empty($SUB_DATE)){echo date('j-M \'y g:i a',strtotime($SUB_DATE));} else {echo '-';}?></TD>
	<TD><?php if(!empty($RENEW_DATE)){echo date('j-M \'y g:i a',strtotime($RENEW_DATE));} else {echo '-';}?></TD>
	<TD><?php if(!empty($date_time)){echo date('j-M \'y g:i a',strtotime($date_time));} else {echo '-';}?></TD>
	<TD><?php echo 'Rs. '.$chrg_amount; ?>&nbsp;</TD>
	<TD><?php echo $circle_info[strtoupper($circle)]; ?>&nbsp;</TD>
	<TD><?php	if(!empty($MODE_OF_SUB)){echo $MODE_OF_SUB;} else {echo '-';}?></TD>	
	<TD border="0" width="22%">
	<table border="0"><tr><td style="border: 0">
	
	<?php
	$blacklistID=array(48,68);
	if (($subStatus == 1 || $subStatus == 11 || $subStatus == 2 ||$subStatus == 5)) {
		if($service_info!='1412'){?>
	 <button class="btn btn-sm btn-danger" type="button" onclick="do_Act_Deactivate(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $subsrv;?>','da','customer_care_process')" >Deactivate</button>
	  <?php }
	//if($subStatus == 11)echo "<button class=\"btn-mini\" type=\"button\">Pending</button>";
		
	}
	elseif($subStatus=='')
	{
		echo "<button class=\"btn btn-mini btn-danger\" type=\"button\" disabled>Not Active</button>";
	}
	?>
	</td>
	<td style="border: 0">
 <button class="btn btn-sm btn-info"  type="button" onclick="viewbillinghistory(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $service_info_duration;?>')" >
		 <?php echo BTN_LABEL_SUB_HISTORY;?>
		 </button>
</td>
	<td style="border: 0">	<?php if($service_info!=2121){ ?>		
		<button class="btn btn-sm btn-info" type="button" onclick="viewchargingDetails(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $service_info_duration;?>')" >
		 <?php echo BTN_LABEL_RECHARGE_COUPAN_HISTORY;?>
		 </button>
		 
		<? }	else {	?>
		 <button class="btn btn-sm btn-info"  type="button" onclick="viewMessageDetails('viewMessageDetails',<?php echo $msisdn;?>,<?php echo $service_info;?>)" >
		 <?php echo BTN_LABEL_MESSAGE;?>
		 </button>
<?}?>
</td>
		
		</tr></table>

	</TD>
	
	
</TR>
<?php
$flag++;
        } else
        {
	     }

?>

	<?php }
		echo '</TABLE></div>';
	if($flag==0)
	{
	echo "<div class='alert alert-block'><h4>Ooops!</h4>No records found for this number.</div> ";
	?>
	<script>
	document.getElementById('result-table').style.display='none';
	</script>
	<?php
	}
	?>

<?php
//end here 
}
//if section end here	

	elseif ($_GET['msisdn'] != "" && $_GET['act'] == "da")
        {
		if($_GET['service_info']==1001 ||  $_GET['service_info']==1801) {
			if($_SESSION['usrId'] == '269') {
				$Query1 = "call docomo_radio.RADIO_SMS_UNSUB('$_GET[msisdn]', 'CC')";	
			} else {
				$Query1 = "call docomo_radio.RADIO_UNSUB('$_GET[msisdn]', 'CC')";
			}
			} elseif($_GET['service_info']==1601)
				$Query1 = "call indicom_radio.RADIO_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1002)
				$Query1 = "call docomo_hungama.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==10021)
				$Query1 = "call docomo_bpl.BPL_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1027)
				$Query1 = "call docomo_hungama.DEV_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1602)
				$Query1 = "call indicom_hungama.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1603)
				$Query1 = "call indicom_hungama.MTV_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1605)
				$Query1 = "call indicom_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1009)
				$Query1 = "call docomo_manchala.RIYA_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1609)
				$Query1 = "call indicom_manchala.RIYA_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1006)
				$Query1 = "call indicom_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1606)
                $Query1 = "call indicom_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1010)
                $Query1 = "call docomo_redfm.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1809)
                $Query1 = "call docomo_manchala.RIYA_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1007)
                $Query1 = "call docomo_vh1.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1607)
                $Query1 = "call indicom_vh1.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1807)
                $Query1 = "call docomo_vh1.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1810)
                $Query1 = "call docomo_redfm.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1610)
                $Query1 = "call indicom_redfm.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1611)
                $Query1 = "call indicom_rasoi.RASOI_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1811)
                $Query1 = "call docomo_rasoi.RASOI_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1011)
                $Query1 = "call docomo_rasoi.RASOI_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1013 || $_GET['service_info']==1813)
                $Query1 = "call docomo_mnd.MND_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1613)
                $Query1 = "call indicom_mnd.MND_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1003)
				$Query1 = "call docomo_hungama.MTV_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1005)
				$Query1 = "call docomo_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			else if($_GET['service_info']==1402)
				$Query1 = "call uninor_hungama.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1403)
				$Query1 = "call uninor_hungama.MTV_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==14021)
				$Query1 = "call uninor_hungama.ARTIST_ALOUD_UNSUB('$_GET[msisdn]', 'CC')";				
			elseif($_GET['service_info']==1410)
				$Query1 = "call uninor_redfm.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1406)
                $Query1 = "call uninor_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
	 		elseif($_GET['service_info']==1409)
                $Query1 = "call uninor_manchala.RIYA_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1416)
                $Query1 = "call uninor_jyotish.Jyotish_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1408)
                $Query1 = "call uninor_cricket.CRICKET_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1418)
                $Query1 = "call uninor_hungama.COMEDY_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1423)
                $Query1 = "call uninor_summer_contest.Contest_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1202)
				$Query1 = "call reliance_hungama.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1203) {
				$aftId='DCC546461';
				$deactMode="CC"."#".$aftId;
				$Query1 = "call reliance_hungama.MTV_UNSUB('$_GET[msisdn]', '".$deactMode."')";
												}
			elseif($_GET['service_info']==1208)
				$Query1 = "call reliance_cricket.CRICKET_UNSUB('$_GET[msisdn]', 'CC')";
			//	echo $Query1."<br>";
        $result = mysql_query($Query1,$dbConn) or die(mysql_error());
        echo "<div class='alert alert-block'>Request for deactivation sent</div> ";
        }
		else
		{
		echo "NO INPUT";
		}
mysql_close($dbConn);
?>
<!--Logic will end here -->