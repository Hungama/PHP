<?php
session_start();
//if(isset($_SESSION['authid']))
//{
	//include("config/dbConnect.php");
	require_once("incs/db.php");
	require_once("language.php");
	$service_info_duration=$_REQUEST['subsrv'];
	$msisdn=$_REQUEST['msisdn'];
	//$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
	$planDataResult = mysql_query("SELECT Plan_id from master_db.tbl_plan_bank WHERE sname='".$_REQUEST['service_info']."'",$dbConn);
		while($row = mysql_fetch_array($planDataResult)) {
			$planData[] = $row['Plan_id'];
		}
?>
<div width="85%" align="left" class="txt">
<div class="alert"><a href="javascript:viewchargingDetails('<?= $msisdn; ?>','<?= $_REQUEST['service_info']?>')" id="Refresh"><i class="icon-refresh"></i></a>&nbsp;Subscription details for <?php echo $_REQUEST['msisdn']; ?>&nbsp;displaying last 30 transactions </i>
</div></div>
<?php

	$deactivationQuery1="select SUB_DATE, RENEW_DATE, circle, MODE_OF_SUB, DNIS, STATUS, SUB_TYPE, UNSUB_DATE, UNSUB_REASON from ";	
 	 
	//$query1 = "";
	switch($_REQUEST['service_info'])
	{
	case '1102':
				$deactivationQuery1 .= "mts_hungama.tbl_jbox_unsub";
			break;
			case '1101':
			case '11011':
				//$deactivationQuery1 .= "mts_radio.tbl_radio_unsub";
				$deactivationQuery1.= "mts_mu.tbl_HB_unsub";
			break;
			case '1103':
				$deactivationQuery1 .= "mts_mtv.tbl_mtv_unsub";
			break;
			case '1111':
				$deactivationQuery1 .= "dm_radio.tbl_digi_unsub";
			break;
			case '1105':
                 $deactivationQuery1 .= "mts_starclub.tbl_jbox_unsub";
            break;
			case '1106':
                 $deactivationQuery1 .= "CelebChat.tbl_chat_unsubscription";
            break;
			case '1110':
                 $deactivationQuery1 .= "mts_redfm.tbl_jbox_unsub";
            break;
			case '1113':
                 $deactivationQuery1 .= "mts_mnd.tbl_character_unsub1";
            break;
			case '1116':
                 $deactivationQuery1 .= "mts_voicealert.tbl_voice_unsub";
            break;
			case '1124':
             $deactivationQuery1.= "mts_radio.tbl_AudioCinema_unsub";
			break;
			case '1126':
              $deactivationQuery1.= "mts_Regional.tbl_regional_unsub";
			  break;
			case '1125':
              $deactivationQuery1.= "mts_JOKEPORTAL.tbl_jokeportal_unsub";
			  break;
			  case '1108':
              $deactivationQuery1.= "MTS_cricket.tbl_cricket_unsub";
			  break;
	}
	$deactivationQuery1 .= " where ANI='$_REQUEST[msisdn]' and plan_id IN (".implode(",",$planData).") order by UNSUB_DATE desc";
		
		$queryunSubscription = mysql_query($deactivationQuery1,$dbConn) or die(mysql_error());
        $numRows1 = mysql_num_rows($queryunSubscription);
     	  if ($numRows1 > 0)
        {
		
	$RENEW_DATE = "";	
  list($SUB_DATE,$RENEW_DATE,$circle,$MODE_OF_SUB,$DNIS,$subStatus,$SUB_TYPE,$UNSUB_DATE, $UNSUB_REASON) = mysql_fetch_array($queryunSubscription);
  
  ?>
<TABLE width="95%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="table table-condensed table-bordered">
  <thead>
  <TR height="30">
<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_ANI;?></B></TD>
<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_REGISTRATION_ID;?></B></TD>
<TD bgcolor="#FFFFFF" align="center"><B>Subscription Date</B></TD>
<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_NEXT_CHARGING;?></B></TD>
<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_CIRCLE;?></B></TD>
<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_MODE;?></B></TD>			
<TD bgcolor="#FFFFFF" align="center"><B><?php echo TH_STATUS;?></B></TD>
<TD bgcolor="#FFFFFF" align="center"><B>Subscrition Type</B></TD>
<TD bgcolor="#FFFFFF" align="center"><B>Unsubscription Date</B></TD>
<TD bgcolor="#FFFFFF" align="center"><B>Reason</B></TD>

  </TR>
  </thead>
	<TR height="30">
	<TD bgcolor="#FFFFFF" align="center"><?php echo $msisdn; ?></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php if(!empty($DNIS)){echo $DNIS;} else {echo '-';} ?></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php if(!empty($SUB_DATE)){echo date('j-M \'y g:i a',strtotime($SUB_DATE));} else {echo '-';}?></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php if(!empty($RENEW_DATE)){echo date('j-M \'y g:i a',strtotime($RENEW_DATE));} else {echo '-';}?></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php echo $circle_info[strtoupper($circle)]; ?></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php if($MODE_OF_SUB=='push') $MODE_OF_SUB='OBD1'; elseif($MODE_OF_SUB=='push2') $MODE_OF_SUB='OBD2'; echo $MODE_OF_SUB; ?></TD>
	 
	<TD bgcolor="#FFFFFF" align="center"><?php if(!empty($subStatus)){echo $subStatus;} else {echo '-';} ?></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php if(!empty($SUB_TYPE)){echo $SUB_TYPE;} else {echo '-';} ?></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php if(!empty($UNSUB_DATE)){echo date('j-M \'y g:i a',strtotime($UNSUB_DATE));} else {echo '-';}?></TD>
	<TD bgcolor="#FFFFFF" align="center"><?php if($UNSUB_REASON=='push' || $UNSUB_REASON=='push2') echo "CC"; else echo $UNSUB_REASON;?></TD>
</TR>	
		
	  </TABLE>
	  
<?php
	}
	else {
			echo "<div class='alert alert-block'><h4>Ooops!</h4>No records found for this number.</div> ";
	   }
	mysql_close($dbConn);
?>