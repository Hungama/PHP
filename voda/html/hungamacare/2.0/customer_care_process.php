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
$Submit = $_REQUEST['Submit'];
//echo $msisdn."****".$no_of_servicename."****".$service_info_duration."****".$service_info_array."*****".$_POST['Submit']."<br>";
//print_r($service_info_array);
//exit;
$logPath = "/var/www/html/kmis/services/hungamacare/ccInterface/log_".date("Ymd").".txt";
$flag=0;
//$_SESSION['usrId'] = $_REQUEST['usrId'];
    if ($Submit == "Submit")
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
		<div id="alert-success" class="alert alert"><?php echo CC_SEARCH_INFO.$msisdn; ?></div>
<TABLE width="85%" class="table table-condensed table-bordered" >

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
	</TR>
	
<?php

	for($i=0;$i<$no_of_servicename;$i++)
	{
	
	$service_info=$service_info_array[$i];
	
	
		$select_query2_main = "( select msisdn, date_time, chrg_amount,circle  from master_db.tbl_billing_success nolock where msisdn='$msisdn' and event_type !='Recharged' and ";
		$select_query2_main .= " service_id=".$service_info." )";
		
		$select_query2_bak = "(select msisdn, date_time, chrg_amount,circle  from master_db.tbl_billing_success_backup nolock where msisdn='$msisdn' and event_type !='Recharged' and";
	    $select_query2_bak .= " service_id=".$service_info." )";
		
		if($service_info_duration==1)
		{
	$select_query2 = $select_query2_main." UNION ".$select_query2_bak." order by date_time desc limit 1 "; 		
		}
		else if($service_info_duration==2)
		{
	$select_query2 = $select_query2_main." order by date_time desc limit 1 "; 
		}
		
	/*	if($service_info_duration==1 || $service_info_duration==2)
		{
	$select_query2="select msisdn, date_time, chrg_amount,circle from master_db.tbl_billing_success nolock where msisdn='".$msisdn."' and service_id=".$service_info." order by date_time desc limit 1";
		}
	*/
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
			$select_query1= "select SUB_DATE, RENEW_DATE, circle, MODE_OF_SUB, DNIS, STATUS from ";
		  	switch($service_info)
			{
				case '1302':
					$select_query1.= "vodafone_hungama.tbl_jbox_subscription";
				break;
				case '1301':
					$select_query1.= "vodafone_radio.tbl_radio_subscription";
				break;
				case '1303':
					$select_query1.= "vodafone_hungama.tbl_mtv_subscription";
				break;
				case '1307':
					$select_query1.= "vodafone_vh1.tbl_jbox_subscription";
				break;
				case '1310':
					$select_query1.= "vodafone_redfm.tbl_jbox_subscription";
				break;
		    }
			
			$select_query1.=" where ANI='".$msisdn."' order by SUB_DATE desc limit 1";	
			//echo $select_query1;
			$querySubscription = mysql_query($select_query1,$dbConn) or die(mysql_error($dbConn));
			$num = mysql_num_rows($querySubscription);	
	
?>
		
<?php
	//actual service name code start here 
//	$servicename=$serviceNameArray[$service_info];
	
	$sname_ks = array_flip($serviceArray);
 $servicename = $Service_DESC[$sname_ks[$service_info]]['Name'];
	
	 // $subStatus=-1;
	 $RENEW_DATE = "";
	 //list($msisdn, $date_time, $chrg_amount,$circle,$plan_id) = mysql_fetch_array($query);
	 list($msisdn, $date_time, $chrg_amount,$circle) = mysql_fetch_array($query);
	 list($SUB_DATE,$RENEW_DATE,$circle1,$MODE_OF_SUB,$DNIS,$subStatus) = mysql_fetch_array($querySubscription);
	 
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
	}
	else if($subStatus=='')
	{
	?>
	<span class="label label-info">
	<?php
	echo "Not Active";
	} ?>
	</span>
	</TD>
	<TD><?php if(!empty($DNIS)){echo $DNIS;} else {echo '-';} ?></TD>
	<TD><?php 
	echo $servicename;	
	?>
	</TD>
	<TD><?php if(!empty($SUB_DATE)){echo date('j-M \'y g:i a',strtotime($SUB_DATE));} else {echo '-';}?></TD>
	<TD><?php if(!empty($RENEW_DATE)){echo date('j-M \'y g:i a',strtotime($RENEW_DATE));} else {echo '-';}?></TD>
	<TD><?php if(!empty($date_time)){echo date('j-M \'y g:i a',strtotime($date_time));} else {echo '-';}?></TD>
	<TD><?php echo 'Rs. '.$chrg_amount; ?>&nbsp;</TD>
	<TD><?php echo $circle_info[strtoupper($circle)]; ?>&nbsp;</TD>
	
<TD><?php if(!empty($MODE_OF_SUB)){echo $MODE_OF_SUB;} else {echo '-';}?></TD>	
<TD border="0" width="24%">
	<table border="0"><tr><td style="border: 0">
	
	<?php
	if (($subStatus == '1' || $subStatus == '11')) { ?>	
	 <button class="btn btn-mini btn-danger" type="button" onclick="do_Act_Deactivate(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $subsrv;?>','da','customer_care_process','')" >Deactivate</button>
	<?php
	if($subStatus == '11')
	echo "(Pending)";
	}
	elseif($subStatus=='0')
	{
	echo "Not Active";
	}
	elseif($subStatus=='')
	{
	}
	?>
	</td>
	<td style="border: 0">
 <button class="btn btn-mini btn-info" type="button" onclick="viewbillinghistory(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $service_info_duration;?>')">
		 <?php echo BTN_LABEL_SUB_HISTORY;?>
		 </button>
</td>
	<!--td style="border: 0">
		<button class="btn btn-mini btn-info" type="button"  onclick="viewchargingDetails(<?php echo $msisdn;?>,<?php echo $service_info;?>)">
		 <?php echo BTN_LABEL_RECHARGE_COUPAN_HISTORY;?>
		 </button>
		 
		</td-->
		
		</tr></table>
		
	</TD>
	
	
</TR>
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
			if($_GET['service_info']==1302)
				$Query1 = "call vodafone_hungama.JBOX_UNSUB('$_GET[msisdn]', 'CC')";			
			elseif($_GET['service_info']==1301)
				$Query1 = "call vodafone_radio.radio_unsub('$_GET[msisdn]', 'CC')";
			elseif($_GET['service_info']==1307)
				$Query1 = "call vodafone_vh1.jbox_unsub('$_GET[msisdn]', 'CC')";			
			elseif($_GET['service_info']==1310)
				$Query1 = "call vodafone_redfm.JBOX_UNSUB('$_GET[msisdn]', 'CC')";			
	//echo $Query1."<br>";
       $result = mysql_query($Query1,$dbConn) or die(mysql_error());
        echo "<div class='alert alert-block'>Request for deactivation sent</div> ";
        }
?>
<!--Logic will end here -->