<?php
session_start();
include ("config/dbConnect.php");

$msisdn=$_REQUEST['msisdn'];
$serviceId=$_REQUEST['service_info'];
?>

<script language="javascript">

function ShowHideReason() {  
	if(document.getElementById('rDiv').style.display=='none')
		document.getElementById('rDiv').style.display='block';
	else
		document.getElementById('rDiv').style.display='none';
}


function checkfield1() {
	var reason = document.getElementById('unsubReason').value;
	if(reason=="") {
		document.getElementById('unsubReason').focus();
		alert("Please enter Deactivation Reason");
		return false;
	}
	if(reason) { 
		len = reason.length; //return false;
		if(len<10) {
			document.getElementById('unsubReason').focus();
			alert("Please enter proper Deactivation Reason");
			return false;
		}
	}
}

function redirectTnbva(mdn,chk,sId) { //alert('hi'+mdn+","+chk+","+sId);
	var url="unsubCC.php?msisdn="+mdn+"&act="+chk+"&service_info="+sId+"&submit=yes"; 
	window.location.href=url;
}

</script>

<br/>
<?php 
if($_REQUEST['actType'] != "da" && $_GET['act'] != "tnbva" && $_REQUEST['submit']!='yes')
{
?>
<B><font color="#FF0000"><center>Offer of the Week.<!--TNVA: Free Voice alert try n churn for 7 Days--></center></font></B></br>
<table width="100%">
	<?php if($serviceId == 1101) { ?>
	<tr>
		<td width="40%">
			<INPUT TYPE="button" value='Mu Discounted offer' onclick="redirectTnbva(<?php echo $msisdn;?>,'mu',<?php echo $_REQUEST['service_info'];?>)" />
		</td>
		<td>&nbsp;&nbsp;</td>
		<td width="40%">
			<INPUT TYPE="button" value='Voice alert Try & Buy' onclick="redirectTnbva(<?php echo $msisdn;?>,'tnbva',<?php echo $_REQUEST['service_info'];?>)" />
		</td>
	</tr>
	<tr>
		<td>Music Unlimited Discounted Offer @Rs.1 for 7 days&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;</td>
		<td>Free voice Alert Activation Of 7 days&nbsp;&nbsp;</td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan=3 align='center'><br/><br/><INPUT TYPE="button" value="Confirm Deactivation" onclick="ShowHideReason()" /><br/><br/></td>
	</tr>
</table>
<div style="display:none" id="rDiv">
	<form name="frm1" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield1();">
	<B>Feedback : (minimum 10 character requried) </B><br/>
	<TEXTAREA NAME="unsubReason" ID="unsubReason" ROWS="3" COLS="37" maxlength="60"></TEXTAREA>
	<br/>
	<INPUT TYPE="hidden" name='actType' id='actType' value="da">
	<INPUT TYPE="hidden" name='msisdn' id='msisdn' value="<?php echo $msisdn;?>">
	<INPUT TYPE="hidden" name='service_info' id='service_info' value="<?php echo $serviceId;?>">
	<input name="Submit" type="submit" class="txtbtn" value="Submit"/>		
	</form>
</div>
<?php  
} 
elseif($_REQUEST['msisdn'] != "" && $_REQUEST['actType'] == "da")
{	
	$reason = $_REQUEST['unsubReason'];
	if($_REQUEST['service_info']==1102)
		$Query1 = "call mts_hungama.JBOX_UNSUB_CC('$_REQUEST[msisdn]', 'CC','".$reason."')";
	elseif($_REQUEST['service_info']==1101 || $_REQUEST['service_info']==11011)
		$Query1 = "call mts_radio.RADIO_UNSUB_CC('$_REQUEST[msisdn]', 'CC','".$reason."')";
	elseif($_REQUEST['service_info']==1103)
		$Query1 = "call mts_mtv.MTV_UNSUB_CC('$_REQUEST[msisdn]', 'CC','".$reason."')";
	elseif($_REQUEST['service_info']==1111)
		$Query1 = "call dm_radio.DIGI_UNSUB_DETAIL('$_REQUEST[msisdn]', 'CC','".$reason."')";
	elseif($_REQUEST['service_info']==1105)
		 $Query1 = "call mts_starclub.JBOX_UNSUB_CC('$_REQUEST[msisdn]', 'CC','".$reason."')";
	elseif($_REQUEST['service_info']==1110)
		 $Query1 = "call mts_redfm.REDFM_UNSUB_CC('$_REQUEST[msisdn]', 'CC','".$reason."')"; 
	elseif($_REQUEST['service_info']==1116) {
		if(is_numeric($_REQUEST['catid'])) $Query1 = "call mts_voicealert.VOICE_FETCHUNSUB('$_REQUEST[msisdn]', '".$_REQUEST['catid']."' ,'CC')";
		elseif($_REQUEST['catid'] == 'all') $Query1 = "call mts_voicealert.VOICE_UNSUB_ALL('$_REQUEST[msisdn]','CC','".$reason."')";
		else $Query1 = "call mts_voicealert.JBOX_UNSUB_DETAIL('$_REQUEST[msisdn]', 'CC','".$reason."')";
}
elseif($_REQUEST['service_info']==1106)
	$Query1 = "call mts_starclub.JBOX_UNSUB_CC('$_REQUEST[msisdn]', 'CC','".$reason."')";
elseif($_REQUEST['service_info']==1113)
	$Query1 = "call mts_mnd.MND_UNSUB_CC('$_REQUEST[msisdn]', 'CC','".$reason."')";
$result = mysql_query($Query1,$dbConn) or die(mysql_error());
	echo "<div align='center'><B>Request for deactivation sent</B></div>";
}
elseif ($_GET['msisdn'] != "" && $_GET['act'] == "tnbva") 
{
	$query = "SELECT mode FROM mts_voicealert.tbl_voice_subscription WHERE ani='".$msisdn."'";
	$result = mysql_query($query,$dbConn);
	list($count) = mysql_fetch_array($result);
	if(!$count)
	{
		$Query1 = "call mts_voicealert.VOICE_OBD('$_GET[msisdn]','01','TNBVA','54444','7','1116','26', '3','7')";
		$result = mysql_query($Query1,$dbConn) or die(mysql_error());
		echo "<div align='center'><B>Voice alert free Try & buy have been activated</B></div>";
	}
	else 
	{
		echo "<div align='center'><B>You are already activate on Voice alert try & buy offer.</B></div>";
	}
}
elseif ($_GET['msisdn'] != "" && $_GET['act'] == "mu") 
{
	$getPlanQuery = "select plan_id from mts_radio.tbl_radio_subscription WHERE ani='".$msisdn."'";
	$getPlanResult = mysql_query($getPlanQuery,$dbConn);
	$getPlanRecord=mysql_fetch_row($getPlanResult);
	if($getPlanRecord[0]==38)
	{
		$message1= "you are already activated on mu discounted offer.";
	}
	else
	{
		$query = "UPDATE mts_radio.tbl_radio_subscription SET plan_id='38' WHERE ani='".$msisdn."'";
		$result = mysql_query($query,$dbConn);
		$message1="MU discounted offer of Rs 1 per week have been activated";	
	}
	echo $message1;?>
        <br/>
    <center><input type="button" name="close_btn" id="close_btn" value="Close" OnClick="javascript:window.close();"></center>
<?php }
?>