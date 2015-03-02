<?php
session_start();
$flag=0;
$logDir="/var/www/html/hungamacare/log/adminAccessLog/";
$logFile="adminAccessLog_".date('Ymd');
$logPath=$logDir.$logFile;
$filePointer=fopen($logPath,'a+');
$_SESSION['authid']='true';
if (isset($_SESSION['authid']))
{
	include ("config/dbConnect.php");
	//include("db.php");
	$service_info=$_REQUEST['service_info'];
	$serviceType=$_REQUEST['serviceType'];
		
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
<script language="javascript">
function logout()
{
window.parent.location.href = 'index.php?logerr=logout';
}
</script>
<script language="javascript">
function checkfield()
	{
var re5digit=/^\d{10}$/ //regular expression defining a 10 digit number
var re14digit=/^\d{13}$/ //regular expression defining a 10 digit number
if(document.frm.msisdn.value.search(re5digit)==-1 && document.frm.msisdn.value.search(re14digit)==-1)
	{
		alert("Please enter Valid Mobile Number.");
		document.frm.msisdn.focus();
		return false;
	}
return true;
}
function openWindow(str,service_info,subsrv)
{
   window.open("view_billing_details.php?msisdn="+str+"&service_info="+service_info+"&subsrv="+subsrv,"mywindow","menubar=0,resizable=1,width=650, height=500,scrollbars=yes");
}
function openWindow1(pageName,str,service_info)
{
   window.open(pageName+".php?msisdn="+str+"&service_info="+service_info,"mywindow","menubar=0,resizable=1,width=650,height=500,scrollbars=yes");
}
function openWindow3(pageName,str,service_info)
{
   window.open(pageName+".php?msisdn="+str+"&service_id="+service_info,"mywindow","menubar=0,resizable=1,width=650,height=500,scrollbars=yes");
}

function showDetail(service) { //alert(service);
	if(service=='FunNews') {
		document.getElementById('showinfo').style.display='block';
		document.getElementById('showinfo').innerHTML="<table width='85%' align='center' bgcolor='#0369b3' border='0' cellpadding='1' cellspacing='1' class='txt'><tr><th bgcolor='#FFFFFF' align='center'>SMS Pack</th><th bgcolor='#FFFFFF' align='center'>Service Description</th><th bgcolor='#FFFFFF' align='center'>charging model</th><th bgcolor='#FFFFFF' align='center'>Subscription Mode</th><th bgcolor='#FFFFFF' align='center'>Service</th></tr><tr><td bgcolor='#FFFFFF' align='center'>Fun News Pack</td><td bgcolor='#FFFFFF' align='center'>You will now get funny and cool news from around the world on your mobile</td><td bgcolor='#FFFFFF' align='center'>SMS</td><td bgcolor='#FFFFFF' align='center'>Send FNP to 38567 for Fun News Pack</td><td bgcolor='#FFFFFF' align='center'>One alert per day</td></tr></table>";
	} else if(service=='SFP') {
		document.getElementById('showinfo').style.display='block';
		document.getElementById('showinfo').innerHTML="<table width='85%' align='center' bgcolor='#0369b3' border='0' cellpadding='1' cellspacing='1' class='txt'><tr><th bgcolor='#FFFFFF' align='center'>SMS Pack</th><th bgcolor='#FFFFFF' align='center'>Service Description</th><th bgcolor='#FFFFFF' align='center'>charging model</th><th bgcolor='#FFFFFF' align='center'>Subscription Mode</th><th bgcolor='#FFFFFF' align='center'>Service</th></tr><tr><td bgcolor='#FFFFFF' align='center'>Spanish Football Pack</td><td bgcolor='#FFFFFF' align='center'>You will now get latest news and scores of matches on your mobile@ N75/wk</td><td bgcolor='#FFFFFF' align='center'>SMS</td><td bgcolor='#FFFFFF' align=center>Send SPL to 38567 for Spanish Football Pack</td><td bgcolor='#FFFFFF' align='center'>One alert per day</td></tr></table>";
	} else if(service=='JOKES') {
		document.getElementById('showinfo').style.display='block';
		document.getElementById('showinfo').innerHTML="<table width='85%' align='center' bgcolor='#0369b3' border='0' cellpadding='1' cellspacing='1' class='txt'><tr><th bgcolor='#FFFFFF' align='center'>SMS Pack</th><th bgcolor='#FFFFFF' align='center'>Service Description</th><th bgcolor='#FFFFFF' align='center'>charging model</th><th bgcolor='#FFFFFF' align='center'>Subscription Mode</th><th bgcolor='#FFFFFF' align='center'>Service</th></tr><tr><td bgcolor='#FFFFFF' align='center'>Jokes SMS Pack</td><td bgcolor='#FFFFFF' align='center'>You will now get funniest of jokes and share it with your friends @ N75/wk</td><td bgcolor='#FFFFFF' align='center'>SMS</td><td bgcolor='#FFFFFF' align='center'>Send SPL to 38567 for Jokes Pack</td><td bgcolor='#FFFFFF' align='center'>One alert per day</td></tr></table>";
	} else if(service=='HollyWood') {
		document.getElementById('showinfo').style.display='block';
		document.getElementById('showinfo').innerHTML="<table width='85%' align='center' bgcolor='#0369b3' border='0' cellpadding='1' cellspacing='1' class='txt'><tr><th bgcolor='#FFFFFF' align='center'>SMS Pack</th><th bgcolor='#FFFFFF' align='center'>Service Description</th><th bgcolor='#FFFFFF' align='center'>charging model</th><th bgcolor='#FFFFFF' align='center'>Subscription Mode</th><th bgcolor='#FFFFFF' align='center'>Service</th></tr><tr><td bgcolor='#FFFFFF' align='center'>Hollywood News Pack</td><td bgcolor='#FFFFFF' align='center'>You will now get hottest Hollywood gossip on your mobile@ N75/wk</td><td bgcolor='#FFFFFF' align='center'>SMS</td><td bgcolor='#FFFFFF' align='center'>Send HNP to 38567 for Hollywood News Pack</td>	<td bgcolor='#FFFFFF' align='center'>One alert per day</td></tr></table>";
	} else if(service=='EPL') {
		document.getElementById('showinfo').style.display='block';
		document.getElementById('showinfo').innerHTML="<table width='85%' align='center' bgcolor='#0369b3' border='0' cellpadding='1' cellspacing='1' class='txt'><tr><th bgcolor='#FFFFFF' align='center'>SMS Pack</th><th bgcolor='#FFFFFF' align='center'>Service Description</th><th bgcolor='#FFFFFF' align='center'>charging model</th><th bgcolor='#FFFFFF' align='center'>Subscription Mode</th><th bgcolor='#FFFFFF' align='center'>Service</th></tr><tr><td bgcolor='#FFFFFF' align='center'>English Premier League Pack</td><td bgcolor='#FFFFFF' align='center'>You will now get latest news and scores of matches on your mobile@ N75/wk</td><td bgcolor='#FFFFFF' align='center'>SMS</td><td bgcolor='#FFFFFF' align='center'>Send EPL to 38567 for English Premier League Pack</td><td bgcolor='#FFFFFF' align='center'>One alert per day</td></tr></table>";
	} else {
		document.getElementById('showinfo').display='none';
	}
}
</script>
</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<form name="frm" method="POST" action="" onSubmit="return checkfield()">
<TABLE width="30%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
<TBODY>
    
	<TR>
        <TD bgcolor="#FFFFFF" align="center"><B>Enter Mobile No.</B></TD>
    </TR>

    <TR>
        <TD bgcolor="#FFFFFF" align="center">&nbsp;&nbsp;<INPUT name="msisdn" type="text" class="in" value="<?php echo $_REQUEST['msisdn']; ?>">
		<input type='hidden' name='service_info' value=<?php echo $service_info;?>>
		<input type='hidden' name='serviceType' value=<?php echo $serviceType;?>>
		<input type='hidden' name='usrId' value=<?php echo $_REQUEST['usrId'];?>>
		</TD>
	</TR>
	<TR>
        <td align="center" bgcolor="#FFFFFF">
            <input name="Submit" type="submit" class="txtbtn" value="Submit"/>			
        </td>
    </TR>

</TBODY>
</TABLE>
</form><br/><br/>
<?php
    if ($_POST['Submit'] == "Submit" && $_POST['msisdn'] != "")
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
            mysql_select_db($userDbName, $userDbConn);
				
			$select_query1= "select SUB_DATE, RENEW_DATE, status , circle, MODE_OF_SUB, DNIS, STATUS from ";
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
				case '2121':list($msisdn1, $date_time1, $chrg_amount1,$circle1,$plan_id1) = mysql_fetch_array($query1);
						$mainQuery = "select SUB_DATE, RENEW_DATE, status , circle, MODE_OF_SUB, DNIS, STATUS, plan_id from ";
						switch($plan_id1) {
							/*case '115':
							case '120':	$subsrv='ast';	
								$select_query1.= "etislat_hsep.tbl_astro_subscription";	
								$etisalatService="Astro";
							break;*/
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
			} else {
				$querySubscription = mysql_query($select_query1,$userDbConn) or die(mysql_error());
				$num = mysql_num_rows($querySubscription);
			}
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
	} else { $subStatus=-1;
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
				<a href="main.php?msisdn=<?php echo $msisdn;?>&act=da&service_info=<?php echo $service_info;?>&subsrv=<?php echo $subsrv;?>"><b><u>Deactivate</u></b></a>
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
	<a href="main.php?msisdn=<?php echo $msisdn;?>&act=da&service_info=<?php echo $service_info;?>&subsrv=<?php echo $subsrv;?>"><b>Deactivate</b></a>
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
<?php }?>
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

	<?php 
	if(($service_info==2121 && !$_GET['act']) || $_SESSION['usrId']==289) { ?>
	<div id="showinfo"><?php include('showServiceInfo.php');?></div><br/><br/>
<?php }?>

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
		mysql_select_db($$userDbName, $userDbConn);
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
			case '1801':
				$deactivationQuery1 .= "docomo_radio.tbl_radio_unsub";
			break;
			case '1601':
				$deactivationQuery1 .= "indicom_radio.tbl_radio_unsub";
			break;
			case '1002':
				$deactivationQuery1 .= "docomo_hungama.tbl_jbox_unsub";
			break;
			case '1602':
				$deactivationQuery1 .= "indicom_hungama.tbl_jbox_unsub";
			break;
			case '1003':
				$deactivationQuery1 .= "docomo_hungama.tbl_mtv_unsub";
			break;
			case '1005':
				$deactivationQuery1 .= "docomo_starclub.tbl_jbox_unsub";
			break;
			case '1208':
				$deactivationQuery1 .= "reliance_cricket.tbl_cricket_unsub";
			break;
			case '1202':
				$deactivationQuery1 .= "reliance_hungama.tbl_jbox_unsub";
			break;
			case '1402':
				$deactivationQuery1 .= "uninor_hungama.tbl_jbox_unsub";
			break;
			case '1403':
				$deactivationQuery1 .= "uninor_hungama.tbl_mtv_unsub";
			break;
			case '1603':
				$deactivationQuery1 .= "indicom_hungama.tbl_mtv_unsub";
			break;
			case '1203':
				$deactivationQuery1 .= "reliance_hungama.tbl_mtv_unsub";
			break;
			case '1603':
				$deactivationQuery1 .= "indicom_hungama.tbl_mtv_unsub";
			break;
			case '1605':
				$deactivationQuery1 .= "indicom_starclub.tbl_jbox_unsub";
			break;
			case '1410':
				$deactivationQuery1 .= "uninor_redfm.tbl_jbox_unsub";
			break;
			case '1009':
				$deactivationQuery1 .= "docomo_manchala.tbl_riya_unsub ";
			break;
			case '1609':
				$deactivationQuery1 .= "indicom_manchala.tbl_riya_unsub ";
			break;
			case '1006':
				$deactivationQuery1 .= "indicom_starclub.tbl_jbox_unsub ";
			break;
			case '1606':
				$deactivationQuery1 .= "indicom_starclub.tbl_jbox_unsub ";
			break;
			case '1206':
				$deactivationQuery1 .= "reliance_starclub.tbl_jbox_unsub ";
			break;
			case '1406':
				$deactivationQuery1 .= "uninor_starclub.tbl_jbox_unsub ";
			break;
			case '1409':
				$deactivationQuery1 .= "uninor_hungama.tbl_jbox_unsub ";
			break;
			case '1010':
				$deactivationQuery1 .= "docomo_redfm.tbl_jbox_unsub ";
			break;
			case '1809':
				$deactivationQuery1 .= "docomo_manchala.tbl_riya_unsub ";
			break;
			case '1007':
				$deactivationQuery1 .= "docomo_vh1.tbl_jbox_unsub ";
			break;
			case '1607':
				$deactivationQuery1 .= "indicom_vh1.tbl_jbox_unsub ";
			break;
			case '1807':
				$deactivationQuery1 .= "docomo_vh1.tbl_jbox_unsub ";
			break;
			case '1810':
				$deactivationQuery1 .= "docomo_redfm.tbl_jbox_unsub ";
			break;
			case '1610':
				$deactivationQuery1 .= "indicom_redfm.tbl_jbox_unsub ";
			break;
			case '1611':
				$deactivationQuery1 .= "indicom_rasoi.tbl_rasoi_unsub ";
			break;
			case '1011':
				$deactivationQuery1 .= "docomo_rasoi.tbl_rasoi_unsub ";
			break;
			case '1811':
				$deactivationQuery1 .= "docomo_rasoi.tbl_rasoi_unsub ";
			break;
			case '1416':
				$deactivationQuery1 .= "uninor_jyotish.tbl_Jyotish_unsub ";
			break;
			case '1408':
				$deactivationQuery1 .= "uninor_cricket.tbl_cricket_unsub ";
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
        $numRows1 = mysql_num_rows($queryunSubscription);
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
    } elseif ($_GET['msisdn'] != "" && $_GET['act'] == "da")
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
			elseif($_GET['service_info']==1602)
				$Query1 = "call indicom_radio.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1202)
				$Query1 = "call reliance_hungama.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1003)
				$Query1 = "call docomo_hungama.MTV_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1203) {
				$aftId='DCC546461';
				$deactMode="CC"."#".$aftId;
				$Query1 = "call reliance_hungama.MTV_UNSUB('$_GET[msisdn]', '".$deactMode."')";
			} elseif($_GET['service_info']==1005)
				$Query1 = "call docomo_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1208)
				$Query1 = "call reliance_cricket.CRICKET_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1402)
				$Query1 = "call uninor_hungama.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1403)
				$Query1 = "call uninor_hungama.MTV_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1603)
				$Query1 = "call indicom_hungama.MTV_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1605)
				$Query1 = "call indicom_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1410)
				$Query1 = "call uninor_redfm.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1009)
				$Query1 = "call docomo_manchala.RIYA_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1609)
				$Query1 = "call indicom_manchala.RIYA_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1006)
				$Query1 = "call indicom_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1606)
                $Query1 = "call indicom_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1206)
                $Query1 = "call reliance_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1406)
                $Query1 = "call uninor_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
	 		elseif($_GET['service_info']==1409)
                $Query1 = "call uninor_hungama.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
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
			elseif($_GET['service_info']==1416)
                $Query1 = "call uninor_jyotish.Jyotish_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1408)
                $Query1 = "call uninor_cricket.CRICKET_UNSUB('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==2121) { 
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
            echo "<div align='center'><B>Request for deactivation sent</B></div>";
        }
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
<br/><br/><br/><br/><br/><br/><br/>
<?php 
	if($service_info==2121 || $_SESSION['usrId']==289) { ?>
	<div id="showinfo"><?php include('showServiceInfo.php');?></div><br/><br/>
<?php }?>


<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td bgcolor="#0369b3" height="1"></td>
</tr>
<tr> 
<td class="footer" align="right" bgcolor="#ffffff"><b>Powered by Hungama</b></td>
</tr><tr>
<td bgcolor="#0369b3" height="1"></td>
</tr>
</tbody></table>
</body>
</html>
<?php

    mysql_close($dbConn);
} else
{
    header("Location:index.php");
}

?>