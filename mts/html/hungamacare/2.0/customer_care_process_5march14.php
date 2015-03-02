<!--Logic will start here -->
<?php
session_start();
ini_set('display_errors','1');
//set_time_limit(10);
require_once("incs/db.php");
require_once("language.php");
require_once("base.php");
$msisdn = $_REQUEST['msisdn'];
$service_info_array = $_REQUEST['service_info'];
$no_of_servicename=count($service_info_array);
$service_info_duration = $_REQUEST['service_info_duration'];
/*for($i=0;$i<$no_of_servicename;$i++)
{
echo $msisdn."****".$service_info_array[$i]."****".$service_info_duration."****".$service_info_array."<br>";
}
*/
//print_r($service_info_array);
//exit;
$remoteAdd=$_SERVER['REMOTE_ADDR'];
$logDir="/var/www/html/hungamacare/2.0/logs/CC/";
$logFile="accessLog_".date('Ymd');
$logPath=$logDir.$logFile;
$filePointer=fopen($logPath,'a+');

$flag=0;
$_SESSION['usrId'] = $_REQUEST['usrId'];
   //if ($_POST['Submit'] == "Submit" && $_POST['msisdn'] != "")
   if ($_POST['Submit'] == "Submit")
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
		<TD><B><?php echo TH_ANI;?></B></TD>
		<TD><B><?php echo TH_STATUS;?></B></TD>
		<TD><B><?php echo TH_REGISTRATION_ID;?></B></TD>
		<TD><B><?php echo TH_SERVICENAME;?></B></TD>
		<TD><B>Activation</B></TD>
		<TD><B><?php echo TH_NEXT_CHARGING;?></B></TD>
		<TD><B><?php echo TH_LAST_CHARGING;?></B></TD>
		<TD><B><?php echo TH_CHARGED_AMT;?></B></TD>
		<TD><B><?php echo TH_CIRCLE;?></B></TD>
		<TD><B><?php echo TH_MODE;?></B></TD>
		<!--TD><B><?php echo 'Days left For Renewal';?></B></TD-->
		<TD><B>
		<?php
		echo 'Cat/Rel/Ticket Status';
		?></B>
		</TD>
		
<TD></TD>	
	</TR>
	
<?php

	for($i=0;$i<$no_of_servicename;$i++)
	{
	$service_info=$service_info_array[$i];

		fwrite($filePointer,"CC interface"."|".$_REQUEST['usrId']."|".$service_info."|".$remoteAdd."|".$msisdn."|".date('his')."\r\n");
		fclose($filePointer);
	
			$planDataResult = mysql_query("SELECT Plan_id from master_db.tbl_plan_bank WHERE sname='".$service_info."'",$dbConn);
			while($row = mysql_fetch_array($planDataResult)) {
				$planData[] = $row['Plan_id'];
			}
					
	if($service_info=="1116")
	{
	$q_1116='AND subservice_id NOT IN (1,2,3,4,5,6,7,8,9,10)';
	}
	else
	{
	$q_1116='';
	}
		
		$select_query2_main = "( select msisdn, response_time, chrg_amount,circle,plan_id,SC from master_db.tbl_billing_success nolock where service_id=".$service_info." and msisdn='$msisdn' and plan_id IN (".implode(",",$planData).") $q_1116)";
		
		$select_query3_bak = "(select msisdn, response_time, chrg_amount,circle,plan_id,SC from master_db.tbl_billing_success_backup1 nolock where service_id=".$service_info." and msisdn='$msisdn' and plan_id IN (".implode(",",$planData).") $q_1116)";

		$select_query2_bak = "(select msisdn, response_time, chrg_amount,circle,plan_id,SC from master_db.tbl_billing_success_backup nolock where service_id=".$service_info." and msisdn='$msisdn' and plan_id IN (".implode(",",$planData).") $q_1116)";
		
		
		if($service_info_duration==1)
		{
	$select_query2 = $select_query2_main." UNION ".$select_query2_bak." UNION ".$select_query3_bak." order by response_time desc limit 1 "; 		
		}
		else if($service_info_duration==2)
		{
	$select_query2 = $select_query2_main." UNION ".$select_query2_bak." order by response_time desc limit 1 "; 
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
		//list($msisdn, $date_time, $chrg_amount,$circle,$plan_id,$SC) = mysql_fetch_array($query);
		if ($numRows > 0)
        {
	//	$select_query1= "select SUB_DATE, circle, MODE_OF_SUB, DNIS, STATUS from ";
		$select_query1= "select SUB_DATE, RENEW_DATE, circle, MODE_OF_SUB, DNIS, STATUS, DATEDIFF(RENEW_DATE,NOW()) as diff from ";
        	switch($service_info)
			{
			case '1102':
					//if($SC=='546460' || $SC=='54644646')
					//$select_query1.= "Hungama_RaginiMMS.tbl_celebchat_subscription";
					//else
					$select_query1.= "mts_hungama.tbl_jbox_subscription";
				break;
				case '1101':
				case '11011':
					$select_query1.= "mts_radio.tbl_radio_subscription";
				break;
				case '1103':
					$select_query1.= "mts_mtv.tbl_mtv_subscription";
				break;
				case '1111':
					$select_query1.= "dm_radio.tbl_digi_subscription";
					//get last saved religion
					 $getreligion_query = "select lastreligion_cat,lang from dm_radio.tbl_religion_profile WHERE ANI='".$msisdn."'";
					 $result_religion= mysql_query($getreligion_query,$dbConn);
					 $religion = mysql_fetch_array($result_religion); 
				break;
				case '1105':
                     $select_query1.= "mts_starclub.tbl_jbox_subscription";
                break;
				case '1106':
                     $select_query1.= "mts_starclub.tbl_jbox_subscription"; //"CelebChat.tbl_chat_subscription";
                break;
				case '1110':
                     $select_query1.= "mts_redfm.tbl_jbox_subscription";
                break;
				case '1113':
                     $select_query1.= "mts_mnd.tbl_character_subscription1";
                break;
				case '1123':
                     $select_query1.= "Mts_summer_contest.tbl_contest_subscription";
                break;
				case '1124':
                     $select_query1.= "mts_radio.tbl_AudioCinema_subscription";
                break;
				case '1126':
                     $select_query1.= "mts_Regional.tbl_regional_subscription";
                break;
				case '1125':
                     $select_query1.= "mts_JOKEPORTAL.tbl_jokeportal_subscription";
               	break;

				case '1116':
                 /*    $select_query1.= "mts_voicealert.tbl_voice_subscription";
					 $pquery = "SELECT plan_id FROM mts_voicealert.tbl_voice_subscription WHERE ANI='".$msisdn."'";
					 $result1= mysql_query($pquery,$dbConn);
					 $pData = mysql_fetch_array($result1); 
					 $mPlanId=$pData['plan_id'] ;
					 $query12 = "SELECT cat_id,plan_id from mts_voicealert.tbl_voice_category where ANI='".$msisdn."' and status=1";	
					 $resultCatData = mysql_query($query12,$dbConn);
					 $k=0;
					 $catList="";
					 while($catData = mysql_fetch_array($resultCatData)) {
						 if($catData['plan_id'] != $mPlanId) { 
							 $catArray[]=$catData['cat_id'];
						 }
						 if($catData['plan_id'] == $mPlanId) { 
							 if($k==0) $catList .= $catData['cat_id']; 
							 else $catList .= ", ".$catData['cat_id'];
							 $k++;
						 }						 
					 }
					 */
					 $category_info=array('1'=>'BEAUTY','2'=>'BOLLYWOOD','3'=>'COMEDY','4'=>'DEVOTIONAL','5'=>'FEMINA','7'=>'NEWS','8'=>'PERSONALITY','9'=>'MOVIE','10'=>'KNOWLEDGE','11'=>'WORD OF THE DAY');
					 $select_query1.= "mts_voicealert.tbl_voice_subscription";
					 $pquery = "select a.plan_id ,b.cat_id from mts_voicealert.tbl_voice_subscription as a,mts_voicealert.tbl_voice_category as b where a.ANI='$msisdn' and a.ANI=b.ANI and a.plan_id=b.plan_id and b.status=1";
					 $result1= mysql_query($pquery,$dbConn);
					 $k=0;
					 $catList="";
					 while($catData = mysql_fetch_array($result1)) {
						 if($k==0) $catList .= $category_info[$catData['cat_id']]; 
							 else $catList .= ", ".$category_info[$catData['cat_id']];
							 $k++;
						 
					 }
					 if(!$catList) $catList="-";
					break;
				
		    }
			
			$select_query1.=" where ANI='$msisdn' ";
			$select_query1.=" and plan_id IN (".implode(",",$planData).")";

			$select_query1.="  order by SUB_DATE desc limit 1";	
		//	echo $select_query1;
			$querySubscription = mysql_query($select_query1,$dbConn) or mysql_error($dbConn);
			$num = mysql_num_rows($querySubscription);	
	
?>
		
<?php

	$servicename=$serviceNameArray[$service_info];
	//msisdn, response_time, chrg_amount,circle
    $subStatus=-1;
	 $RENEW_DATE = "";
	 list($msisdn, $date_time, $chrg_amount,$circle,$plan_id,$SC) = mysql_fetch_array($query);
	 //list($SUB_DATE,$RENEW_DATE,$status1,$circle1,$MODE_OF_SUB,$DNIS,$subStatus) = mysql_fetch_array($querySubscription);

	if($SC=='546460' || $SC=='54644646' || $service_info=='1102')
	{
	$ticket_query= mysql_query("select SUB_TYPE as TicketStatus from Hungama_RaginiMMS.tbl_celebchat_subscription nolock where ANI='".$msisdn."'",$dbConn);
	list($TicketStatus) = mysql_fetch_array($ticket_query);
	}				

 //list($msisdn, $response_time, $chrg_amount,$circle) = mysql_fetch_array($query);
 list($SUB_DATE,$RENEW_DATE,$circle1,$MODE_OF_SUB,$DNIS,$subStatus,$daysLeft) = mysql_fetch_array($querySubscription);

	 ?>
	<TR height="30">
	<TD bgcolor="#FFFFFF" align="center"><?php echo $msisdn; ?></TD>
	<TD bgcolor="#FFFFFF" align="center">
	
	<?php if($subStatus == '0')
	{?>
	<span class="label label-warning">
	<?php
	echo STATUS_0;
	}
	else if($subStatus == '1')
	{?>
	<span class="label label-success">
	<?php
	echo STATUS_1;
	} 
	else if($subStatus == '11')
	{?>
	<span class="label label-info">
	<?php
	echo STATUS_11;
	}
	else if($subStatus == '5')
	{?>
	<span class="label label-info">
	<?php
	echo STATUS_5;
	} ?></span>
	</TD>
	<TD><?php if(!empty($DNIS)){echo $DNIS;} else {echo '-';} ?></TD>
	<TD><?php 
	echo $servicename;
	?>
	</TD>
	<TD><?php if(!empty($SUB_DATE)){echo date('j-M \'y g:i a',strtotime($SUB_DATE));} else {echo '-';}?></TD>
	<TD><?php 
	
	$autochurnrenwplanid=array('76','77','78','79','80','81','82','83','84','85','86','87','88','89');
	if(in_array($plan_id,$autochurnrenwplanid))
	{
	echo '-';
	}
	/*else if($MODE_OF_SUB=='Event')
	{
	echo '-';
	}*/
	else
	{
	if(!empty($RENEW_DATE)){echo date('j-M \'y g:i a',strtotime($RENEW_DATE));} else {echo '-';}
	}
	?></TD>
	<TD><?php if(!empty($date_time)){echo date('j-M \'y g:i a',strtotime($date_time));} else {echo '-';}?></TD>
	<TD><?php echo 'Rs. '.$chrg_amount; ?>&nbsp;</TD>
	<TD><?php echo $circle_info[strtoupper($circle)]; ?>&nbsp;</TD>
	
	<?php //if($MODE_OF_SUB=='push') $MODE_OF_SUB='OBD1'; elseif($MODE_OF_SUB=='push2') $MODE_OF_SUB='OBD2'; echo $MODE_OF_SUB; ?>
	<TD><?php if(!empty($MODE_OF_SUB)){echo $MODE_OF_SUB;} else {echo '-';}?></TD>	
	<!--TD><?php if(!empty($daysLeft)){echo $daysLeft;} else {echo '-';}
	if($service_info=='1101') { $showActiveFlag=1; } else { $showActiveFlag=0; }
	?></TD-->
	<TD><?php
	if($service_info==1111)
	{
		if(!empty($religion['lastreligion_cat'])){echo ucwords($religion['lastreligion_cat']);} else {echo '-';}
	}
	else if($service_info==1116)
	{
		if(!empty($catList)){echo $catList;} else {echo '-';}
	}
	else if($SC=='546460' || $SC=='54644646' || $service_info==1102)
	{
	echo $TicketStatus;
	}
	else
	{
	echo '-';
	}
	?></TD>
	<TD border="0" width="24%">
	<table border="0"><tr><td style="border: 0">
	
	<?php
	if (($subStatus == 1 || $subStatus == 11 || $subStatus == 2 ||$subStatus == 5)) {
		if($service_info == '1116') { ?>
<button class="btn btn-mini btn-danger" type="button" onclick="do_Act_Deactivate(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $subsrv;?>','da','customer_care_process','all')" >Deactivate (All)</button>		
	<?php }
	else
	{?>		
	 <button class="btn btn-mini btn-danger" type="button" onclick="do_Act_Deactivate(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $subsrv;?>','da','customer_care_process','')" >Deactivate</button>
	<?php 
	}
	}
	elseif($subStatus=='')
	{
		echo "<button class=\"btn btn-mini btn-danger\" type=\"button\" disabled>Not Active</button>";
	}
	?>
	</td>
	<td style="border: 0">
 <button class="btn btn-mini btn-info" type="button" onclick="viewbillinghistory(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $service_info_duration;?>')">
		 <?php echo BTN_LABEL_SUB_HISTORY;?>
		 </button>
</td>
	<td style="border: 0">
		<button class="btn btn-mini btn-info" type="button"  onclick="viewchargingDetails(<?php echo $msisdn;?>,<?php echo $service_info;?>)">
		 <?php echo BTN_LABEL_RECHARGE_COUPAN_HISTORY;?>
		 </button>
		 
		</td>
		
		</tr></table>
		
	</TD>
	
	
</TR>
<!-- added for Voice Alert category section start here -->
<?php if(count($catArray) && $service_info == '1116') { ?>
<tr><td colspan="13">Additional Category Status</td></tr>
<?php
	for($j=0;$j<count($catArray);$j++) {
	if(!$mPlanId) $mPlanId='25';
	$select_queryVA="select msisdn, response_time, chrg_amount,circle from master_db.tbl_billing_success nolock where service_id=".$service_info." and msisdn='$msisdn' and plan_id!=".$mPlanId." and subservice_id='".$catArray[$j]."' order by response_time desc limit 1";		
	$queryVA = mysql_query($select_queryVA, $dbConn) or die(mysql_error());
	$numRows = mysql_num_rows($queryVA);

	if($numRows == 0) {
		$select_queryVA =" select msisdn, response_time, chrg_amount,circle from master_db.tbl_billing_success_backup nolock where service_id=".$service_info." and msisdn='$msisdn' and plan_id!=".$mPlanId." and subservice_id='".$catArray[$j]."' order by response_time desc limit 1";
		$queryVA = mysql_query($select_queryVA, $dbConn) or die(mysql_error());
		$numRows = mysql_num_rows($queryVA);	
		//echo $numRows." old";
	}
	$selectSUB = "select SUB_DATE,RENEW_DATE,circle,MODE_OF_SUB,dnis,status,datediff(RENEW_DATE,NOW()) as diff from mts_voicealert.tbl_voice_category where ani='$msisdn' and plan_id!=".$mPlanId." and cat_id='".$catArray[$j]."'";
	$resultSUB = mysql_query($selectSUB);

	list($msisdn1, $response_time1, $chrg_amount1,$circle1) = mysql_fetch_array($queryVA);
	list($SUB_DATE2,$RENEW_DATE2,$circle2,$MODE_OF_SUB2,$DNIS2,$subStatus2,$daysLeft2) = mysql_fetch_array($resultSUB);
	?>
	<TR height="30">
		<TD><?php echo $msisdn1; ?></TD>
		<TD><?php if(!empty($DNIS2)){echo $DNIS2;} else {echo '-';} ?></TD>
		<TD><?php if(!empty($SUB_DATE2)){echo date('j-M \'y g:i a',strtotime($SUB_DATE2));} else {echo '-';}?></TD>
		<TD><?php if(!empty($RENEW_DATE2)){echo date('j-M \'y g:i a',strtotime($RENEW_DATE2));} else {echo '-';}?></TD>
		<TD><a href="javascript:void(0);" onclick="openWindow(<?=$msisdn1;?>,<?=$service_info;?>)"> <?php echo $response_time1; ?></a></TD>
		<TD><?php echo $chrg_amount1; ?></TD>
		<TD><?php echo $circle_info[strtoupper($circle1)]; ?></TD>
		<TD><?php if($MODE_OF_SUB2=='push') $MODE_OF_SUB2='OBD1'; elseif($MODE_OF_SUB2=='push2') $MODE_OF_SUB2='OBD2'; echo $MODE_OF_SUB2; ?></TD>	
		<TD><?php if(!empty($daysLeft2)){echo $daysLeft2;} else {echo '-';} ?></TD>	
		<?php if($service_info=='1116') { ?>
			<TD><?php echo $catArray[$i];?></TD>
		<?php } ?>
		<TD><a href="#" onclick="DeactivateCat('<?php echo $msisdn;?>','da','<?php echo $service_info;?>','<?php echo $catArray[$j];?>');">Deactivate</a></TD>
	</TR>
	<?php }  // end for loop 
	}
	?>
<!-- end here -->


<?php
$flag++;
        } else
        {
	     }

?>

	<?php 
	}
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
		
		 if($_GET['service_info']==1102)
			$Query1 = "call mts_hungama.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
		elseif($_GET['service_info']==1101 || $_GET['service_info']==11011)
			$Query1 = "call mts_radio.RADIO_UNSUB('$_GET[msisdn]', 'CC')";
		elseif($_GET['service_info']==1103)
			$Query1 = "call mts_mtv.MTV_UNSUB('$_GET[msisdn]', 'CC')";
		elseif($_GET['service_info']==1111)
			$Query1 = "call dm_radio.DIGI_UNSUB('$_GET[msisdn]', 'CC')";
		elseif($_GET['service_info']==1105)
			 $Query1 = "call mts_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
		elseif($_GET['service_info']==1110)
			 $Query1 = "call mts_redfm.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
		elseif($_GET['service_info']==1116) {
			if(is_numeric($_GET['catid'])) $Query1 = "call mts_voicealert.VOICE_FETCHUNSUB('$_GET[msisdn]', '".$_GET['catid']."' ,'CC')";
			elseif($_GET['catid'] == 'all') $Query1 = "call mts_voicealert.VOICE_UNSUB_ALL('$_GET[msisdn]','CC')";
			else $Query1 = "call mts_voicealert.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
		}
		elseif($_GET['service_info']==1106)
			 $Query1 = "call mts_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
		elseif($_GET['service_info']==1113)
			 $Query1 = "call mts_mnd.MND_UNSUB('$_GET[msisdn]', 'CC')";
		elseif($_GET['service_info']==1124)
			$Query1 = "call mts_radio.CINEMA_UNSUB('$_GET[msisdn]', 'CC')";
		elseif($_GET['service_info']==1126)
			$Query1 = "call mts_Regional.REGIONAL_UNSUB('$_GET[msisdn]', 'CC')";
		elseif($_GET['service_info']==1123)
			$Query1 = "call Mts_summer_contest.CONTEST_UNSUB('$_GET[msisdn]', 'CC')";
		elseif($_GET['service_info']==1125)
			$Query1 = "call mts_JOKEPORTAL.JOKEPORTAL_UNSUB('$_GET[msisdn]', 'CC')";

		//echo $Query1."<br>";
      $result = mysql_query($Query1,$dbConn) or die(mysql_error());
        echo "<div class='alert alert-block'>Request for deactivation sent</div> ";
        }
		 elseif ($_GET['msisdn'] != "" && $_GET['act'] == "tnbva") {
		$Query1 = "call mts_voicealert.VOICE_OBD('$_GET[msisdn]','01','TNBVA','54444','7','1116','26', '3','7')";
		$result = mysql_query($Query1,$dbConn) or die(mysql_error());
		echo "<div class='alert alert-block'>Request for activate TNB Voice Alert service sent successfully.</div>";
	}
?>
<!--Logic will end here -->