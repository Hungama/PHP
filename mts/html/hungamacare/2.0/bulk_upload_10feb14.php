<?php
ob_start();
session_start();
$user_id=$_SESSION['usrId'];
$PAGE_TAG='bulk';
require_once("incs/common.php");

//$SKIP=1;
ini_set('display_errors','0');
//require_once("incs/database.php");
require_once("incs/db.php");
require_once("language.php");
require_once("base.php");
$flag=0;
$_SESSION['authid']='true';
$service_info=$_REQUEST['service_info'];

$listservices=$_SESSION["access_service"];
//print_r($serviceArray);

if($_SESSION['bulklmt']==0)
	{
	$bulklimit_msg='20,000';
	$bulklimit='20000';
	}
	else
	{
	$bulklimit_msg=number_format($_SESSION['bulklmt']);
	$bulklimit=$_SESSION['bulklmt'];
	}
	//$bulklimit_msg='20,000';
	//$bulklimit='20000';
	
$services = explode(",", $listservices);

//********************************Activation ***************************
$serviceActivationarray=array();
foreach ($serviceArray as $k => $v) {
	if(in_array($k,$services)) {
		if($v!='') {
		//	$checkforactivation = "SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='active' and service_id like '%$v%'";
			$checkforactivation = "SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='active' and (service_id like '%,".$v."' or service_id like '".$v.",%' or service_id like '%,".$v.",%' or service_id='".$v."')";
			$total_act = mysql_query($checkforactivation,$dbConn);
			//$isforactivation=mysql_num_rows($total_act);
			$row1_act = mysql_fetch_array($total_act);
			if($row1_act['value'] == "active") {
				$serviceActivationarray[$v] = $Service_DESC[$k]['Name'];
			}
		} 
	} 
}
						 
					  
//***********************************Deactivation********************************
$serviceDeactivationarray=array();
foreach ($serviceArray as $k => $v) { 
	if(in_array($k,$services)) {
		if($v!='') {
			//$checkforDeactivation="SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='deactive' and service_id like '%$v%'";
			$checkforDeactivation = "SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='deactive' and (service_id like '%,".$v."' or service_id like '".$v.",%' or service_id like '%,".$v.",%' or service_id='".$v."')";

			$total_deactivation = mysql_query($checkforDeactivation,$dbConn);
			//$isfordeact=mysql_num_rows($total_deactivation);
			$row1_deactive= mysql_fetch_array($total_deactivation);
			if($row1_deactive['value'] == "deactive") {
				$serviceDeactivationarray[$v] = $Service_DESC[$k]['Name'];
			}
		}
	}
}
						  
//***********************************Renewal********************************

$serviceRenewalarray=array();
foreach ($serviceArray as $k => $v) { 
	if(in_array($k,$services)) {
		if($v!='') {
		//	$checkforEvent="SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='renewal' and service_id like '%$v%'";
		$checkforEvent = "SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='renewal' and (service_id like '%,".$v."' or service_id like '".$v.",%' or service_id like '%,".$v.",%' or service_id='".$v."')";

			$total_event = mysql_query($checkforEvent,$dbConn);
			//$isforevent=mysql_num_rows($total_event);
			$row1_event= mysql_fetch_array($total_event);
			if($row1_event['value'] == 'renewal') {
				$serviceRenewalarray[$v] = $Service_DESC[$k]['Name'];
			}
		}
	}
}

						 
//***********************************Top-Up********************************
/*
$serviceTopUparray=array();
foreach ($serviceArray as $k => $v) { 
	if(in_array($k,$services)) {
		if($v!='') {
			$checkfortopup="SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='topup' and service_id like '%$v%'";
			$total_topup = mysql_query($checkfortopup,$dbConn);
			//$isfortopup=mysql_num_rows($total_topup);
			$row1_topup= mysql_fetch_array($total_topup);
			if($row1_topup['value'] == "topup") {
				$serviceTopUparray[$v] = $Service_DESC[$k]['Name'];
			}
		}
	}
}
asort($serviceTopUparray);
*/				  
/********************************Toup Charging Activation********************************************/
$topupchargingActivation=array();
//print_r($serviceEventActivation);
foreach ($serviceTopUpChargingActivation as $k => $v) { 
	if(in_array($k,$services)) {
		if($v!='') {
			$checkfortoupcharging="SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='topup_charging' and service_id like '%$v%'";
			$total_event = mysql_query($checkfortoupcharging,$dbConn);
			$row1_event= mysql_fetch_array($total_event);
			if($row1_event['value'] == 'topup_charging') {
				$topupchargingActivation[$v] = $Service_DESC[$k]['Name'];
			}
		}
	}
}
//eventActivation
/********************************Event Activation********************************************/
$eventActivation=array();
//print_r($serviceEventActivation);
foreach ($serviceEventActivation as $k => $v) { 
	if(in_array($k,$services)) {
		if($v!='') {
			$checkforEvent="SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='event_active' and service_id like '%$v%'";
			$total_event = mysql_query($checkforEvent,$dbConn);
			$row1_event= mysql_fetch_array($total_event);
			if($row1_event['value'] == 'event_active') {
				$eventActivation[$v] = $Service_DESC[$k]['Name'];
			}
		}
	}
}
/********************************Event -Unsub********************************************/
$eventunsub=array();
foreach ($serviceEventUnsub as $k => $v) { 
	if(in_array($k,$services)) {
		if($v!='') {
			$checkforEvent="SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='event_unsub' and service_id like '%$v%'";
			$total_event = mysql_query($checkforEvent,$dbConn);
			$row1_event= mysql_fetch_array($total_event);
			if($row1_event['value'] == 'event_unsub') {
				$eventunsub[$v] = $Service_DESC[$k]['Name'];
			}
		}
	}
}

/********************************0 Rs price Point********************************************/
$autochurnrenewal=array();
foreach ($serviceAutoChurnRenew as $k => $v) { 
	if(in_array($k,$services)) {
		if($v!='') {
			$checkforEvent="SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='autochurn_renewal' and service_id like '%$v%'";
			$total_event = mysql_query($checkforEvent,$dbConn);
			$row1_event= mysql_fetch_array($total_event);
			if($row1_event['value'] == 'autochurn_renewal') {
				$autochurnrenewal[$v] = $Service_DESC[$k]['Name'];
			}
		}
	}
}

asort($serviceActivationarray);
asort($serviceDeactivationarray);
asort($serviceRenewalarray);
asort($topupchargingActivation);
asort($eventActivation);
asort($eventunsub);
asort($autochurnrenewal);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- include all required CSS & JS File start here -->
<?php 
require_once("main-header.php");
?>
<!-- include all required CSS & JS File end here -->
<link rel="stylesheet" type="text/css" media="all" href="daterangepicker.css" />
<script type="text/javascript" src="date.js"></script>
<script type="text/javascript" src="daterangepicker.js"></script>
<script type="text/javascript" language="javascript">
	
function checkfield(type) {
	$('#loading').hide();
	document.getElementById('alert_placeholder').style.display='inline';
	var channel=document.forms[type]["channel"].value;
	var upfile=document.forms[type]["upfile"].value;
	var uploadfor=document.forms[type]["upfor"].value;
	var service_info=document.forms[type]["service_info"].value;
	if (service_info==0) {
		 bootstrap_alert.warning('<?php echo JS_NOSERVICESELECTED;?>');
		 return false;
	} else if (channel==null || channel=="") {
		bootstrap_alert.warning('<?php echo JS_NOMODESELECTED;?>');
		return false;
	} else if(type!="form-deactive") {
		var pricepoint=document.forms[type]["price"].value;
if(pricepoint=="" && (uploadfor=='active' || uploadfor=='renewal' || uploadfor=='topup' || uploadfor=='topup_charging' || uploadfor=='event_active' || uploadfor=='event_unsub')) {
			bootstrap_alert.warning('<?php echo JS_NOPPSELECTED;?>');
			return false; 
		}
	}
 if(upfile==null || upfile=="")
 {
	bootstrap_alert.warning('<?php echo JS_NOFILESELECTED;?>');
  return false;
 }
else 
{
var ext = upfile.substring(upfile.lastIndexOf('.') + 1);

    if(ext=="txt")
    {
	var count=(upfile.split(".").length - 1);
	if(count==1)
		{
		$('#loading').show();
		hideMessageBox();
		//return false;
        return true;
		}
		else
		{
		bootstrap_alert.warning('<?php echo JS_FILETYPEERROR;?>');
		return false;
		}
    }
    else
    {
	 bootstrap_alert.warning('<?php echo JS_FILETYPEERROR;?>');
        return false;
    }
}
	$('#loading').show();
	hideMessageBox();
	//return false;
 return true;
}

function hideMessageBox() {
	document.getElementById('error_box').style.display='none';
	document.getElementById('alert_placeholder').style.display='none';
}

function showMessageBox() {
	document.getElementById('error_box').style.display='inline';
	document.getElementById('alert_placeholder').style.display='inline';
}
	
function showTable(radioname)
{
	if(radioname=='a')
	{
		document.getElementById('price12').style.display = 'table-row';
		document.getElementById('chanel12').style.display = 'table-row';
		document.getElementById('chanel13').style.display = 'none';
	}
	if(radioname=='d')
	{
		document.getElementById('channel').value='';
		document.getElementById('chanel12').style.display = 'none';
		document.getElementById('price12').style.display = 'none';
		document.getElementById('chanel13').style.display = 'table-row';
	}
}

function getRadioValue()
{
	for (index=0; index < document.frm.upfor.length; index++)
	{
		if (document.frm.upfor[index].checked) 
		{
			var radioValue = document.frm.upfor[index].value;
			return radioValue;
			break;
		}
	}
}

function resestForm(type)
{
	var formname='form-'+type;
	document.getElementById('channel-'+type).innerHTML="<select><option value=''></option></select>";
	if(type!='deactive') {
		document.getElementById('pricepoint-'+type).innerHTML="<select><option value=''></option></select>";
	}
	document.getElementById(formname).reset();
}

function showRowsTable(type,sid) {
	var formname='form-'+type;
	//alert(type);
	//handle language display here 
	if(type=='active' ||type=='renewal')
	{
	if(sid=='1116')
	{
	document.getElementById(type+'-cat11').style.display = 'table-row';
	document.getElementById(type+'-cat22').style.display = 'table-row';
	document.getElementById(type+'-lang1').style.display = 'table-row';
	document.getElementById(type+'-lang_1').style.display = 'none';
	}
	else
	{
	document.getElementById(type+'-cat11').style.display = 'none';
	document.getElementById(type+'-cat22').style.display = 'none';
	document.getElementById(type+'-lang1').style.display = 'none';
	document.getElementById(type+'-lang_1').style.display = 'table-row';
	}
	}
	//end here
	var auto_types=0;
	if(type=='autochurn_renewal')
	{
	if (document.getElementById('auto_type1').checked) {
		auto_types = document.getElementById('auto_type1').value;
		}
		if (document.getElementById('auto_type2').checked) {
		auto_types = document.getElementById('auto_type2').value;
		}
	}
	//alert(auto_types);
	document.getElementById('grid-'+type).style.display='none';
	
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
/*
	if(type!='deactive') {
		document.forms[formname]["price"].value = "<option value=''>-- Select Price Point --</option>";
	}
	*/
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var channelid='channel-'+type;
			document.getElementById(channelid).innerHTML=xmlhttp.responseText;
		}
	}	
	var url="getBulkModePrice.php?case=mode&type="+type+"&sid="+sid+"&auto_types="+auto_types;
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}
function resetPricePoint(type)
{
var formname='form-'+type;
//
document.getElementById('pricepoint-'+type).innerHTML="<select><option value=''></option></select>";
}
function SetPricePoint(type,sid){ // alert(type+','+sid);
//tonePlanData toneMode renewal  event
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}	
	
	var auto_types=0;
	if(type=='auto_churn' || type=='auto_renewal')
	{
	if (document.getElementById('auto_type1').checked) {
		auto_types = document.getElementById('auto_type1').value;
		}
		if (document.getElementById('auto_type2').checked) {
		auto_types = document.getElementById('auto_type2').value;
		}
	type=auto_types;
	}
	
	if(type == 'deactive') {
		//document.getElementById('price12').style.display = 'none';
	} else {
		//document.getElementById('price12').style.display = 'table-row';				
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) { //	alert(xmlhttp.responseText);
				if(type=='auto_churn' || type=='auto_renewal')
			    {
				var pricepoint='pricepoint-autochurn_renewal';
				}
				else
				{
				var pricepoint='pricepoint-'+type;
				}
		
		document.getElementById(pricepoint).innerHTML=xmlhttp.responseText;	
			}
		}	

		//var url = "getBulkModePrice.php?case=price&type="+type+"&sid="+sid;
		if(type=='topup_charging' || type=='event_active' || type=='event_unsub' || type=='auto_churn' || type=='auto_renewal')
		{
		var url = "getBulkModePrice_event_active.php?case=price&type="+type+"&sid="+sid;
		}
		else
		{
		var url = "getBulkModePrice.php?case=price&type="+type+"&sid="+sid;
		}	
	
	xmlhttp.open("GET",url,true);
		xmlhttp.send();	
	}
}
$(".alert").alert();
$(".alert").alert('close');

bootstrap_alert = function() {}
bootstrap_alert.warning = function(message) {
            $('#alert_placeholder').html('<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a><span>'+message+'</span></div>')
        }
function stopBulkFile(batchid,type)
{
var xmlhttp;    
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	alert(xmlhttp.responseText);
	location.reload();
     }
  }
xmlhttp.open("GET","stopbulkfile.php?batchid="+batchid+"&bulktype="+type,true);
xmlhttp.send();
}


</script>
	<!-- Bootstrap CSS Toolkit styles -->
<link rel="stylesheet" href="css/jquery.fileupload-ui.css">
</head>

<body onload="javascript:viewUploadhistory('active')">

<div class="navbar navbar-inner">
	<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
</div>

<div class="container">
	<div class="row">
		<div class="page-header">
			<h1>Bulk Upload<small>&nbsp;&nbsp;</small></h1>
		</div>
		<div class="tab-pane active" id="pills-basic">
		<div class="tabbable">
			<ul class="nav nav-pills">
				<?php /* if(in_array('billing',$AR_PList)) {?>   <li class="active"><a href="#BillDump" data-toggle="tab" data-act="BillDump">Billing Data</a></li><?php } */?>
				<li class="active"><a href="#active" onclick="viewUploadhistory('active')" data-toggle="tab" data-act="activation">Activation</a></li>
				<li class=""><a href="#deactive" onclick="viewUploadhistory('deactive')" data-toggle="tab" data-act="deactivation">Deactivation</a></li>
				<li class=""><a href="#renewal" onclick="viewUploadhistory('renewal')" data-toggle="tab" data-act="renewal">Renewal</a></li>
				<li class=""><a  href="#topup_charging" onclick="viewUploadhistory('topup_charging')" data-toggle="tab" data-act="TopUp-Charging">TopUp-Charging</a></li>
				<li class=""><a href="#event_active" onclick="viewUploadhistory('event_active')" data-toggle="tab" data-act="event_active">Event-Charging</a></li>
				<li class=""><a href="#event_unsub" onclick="viewUploadhistory('event_unsub')" data-toggle="tab" data-act="event_unsub">Event-Unsub</a></li>
				<li class=""><a href="#autochurn_renewal" onclick="viewUploadhistory('autochurn_renewal')" data-toggle="tab" data-act="autochurn_renewal">Auto Churn-Renewal</a></li>
			</ul>
		<div class="tab-content">
		<!-- Activation section start here-->
			<div id="active" class="tab-pane active">
				<form id="form-active" name="form-active" method="post" enctype="multipart/form-data">
				<input type="hidden" value="<?php echo $bulklimit;?>" name="bulklimit"/>
					<table class="table table-bordered table-condensed">
					<tr>
						<td align="left" width="16%" height="32"><span>Service&nbsp;</span></td>
						<td><select name="service_info" id="service_info" onchange="showRowsTable('active',this.value);">
								<option value="0">Select Service</option>
								<?php foreach($serviceActivationarray as $s_id=>$s_val) { ?>
									<option value="<?php echo $s_id;?>"><?php echo $s_val;?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td width="16%" height="32" align="left">Mode</td>
						<td><div id="channel-active"><select name="channel" id="channel" class="in"></SELECT></div></td>
					</tr>
					<tr>
						<td align="left" width="16%" height="32">Price Point</td>
						<td><div id="pricepoint-active">
								<select name="price" id='price' class="in"></select>
							</div>
						</td>
					</tr>

		<!-- added for voice alert only start here--->		
		<TR height="30" id="active-cat11" style="display:none">
        <TD width="16%" height="32" align="left">Category 1</TD>
        <TD>
		<select name='cat1' id='cat1' class="in">
				<option value=''>Please select Category1</option>
				<option value='1'>BEAUTY</option>
				<option value='2'>BOLLYWOOD</option>
				<option value='3'>COMEDY</option>
				<option value='4'>DEVOTIONAL</option>
				<option value='5'>FEMINA</option>
				<option value='6'>FITNESS</option>
				<option value='7'>NEWS</option>
				<option value='8'>PERSONALITY</option>
				<option value='9'>MOVIE</option>
				<option value='10'>KNOWLEDGE</option>
				<option value='11'>WORD OF THE DAY</option>
			</select>
			</TD>
	  </TR>
	  <TR height="30" id="active-cat22" style="display:none">
        <TD width="16%" height="32" align="left">Category 2</TD>
        <TD><select name='cat2' id='cat2' class="in">
				<option value=''>Please select Category2</option>
				<option value='1'>BEAUTY</option>
				<option value='2'>BOLLYWOOD</option>
				<option value='3'>COMEDY</option>
				<option value='4'>DEVOTIONAL</option>
				<option value='5'>FEMINA</option>
				<option value='6'>FITNESS</option>
				<option value='7'>NEWS</option>
				<option value='8'>PERSONALITY</option>
				<option value='9'>MOVIE</option>
				<option value='10'>KNOWLEDGE</option>
				<option value='11'>WORD OF THE DAY</option>
			</select>
		</TD>
	  </TR>
	  <TR height="30" id="active-lang1" style="display:none">
        <TD width="16%" height="32" align="left">Language</TD>
        <TD>
			<select name='lang' id='lang' class="in">
				<option value=''>Please select Language</option>
				<option value='01'>Hindi</option>
				<option value='02'>English</option>
				<option value='07'>Tamil</option>
				<option value='08'>Telugu</option>
				<option value='09'>Malayalam</option>
				<option value='10'>Kannada</option>
			</select>
		</TD>
	  </TR>
					<!-- end here for voice alert-->
		<tr id="active-lang_1">
					<?php
		$langQuery = "select lang_name,langID from master_db.tbl_language_master order by lang_name";
		$langResult = mysql_query($langQuery,$dbConn);
					?>
						<td align="left" width="16%" height="32"><span>Language</span></td>
						<td>
						<select name='lang_active' id='lang_active' class="in">
				<option value=''>Please select Language</option>
				<?php while($langDetails = mysql_fetch_array($langResult)) { ?>
					<option value='<?php echo $langDetails['langID']?>' <?php if($langDetails['langID']=='01') echo "SELECTED"?>><?php echo $langDetails['lang_name']?></option>
				<?php } ?>
			</select>
						</td>
					</tr>
					<tr>
						<td align="left" width="16%" height="32"><span>Browse File To Upload </span></td>
						<td><INPUT name="upfile" id='upfile' type="file" class="in">
							<INPUT type="hidden" name="action" id='action' value="active" class="in">
							<input id="upfor" type="hidden" value="active" name="upfor">
		                  	<button class="btn btn-primary" style="float:right" disabled>Submit</button>
							<input type='hidden' name='usrId' value=<?php echo $user_id;?>>
						</td>
					</tr>
				</table>
			</form>	
			<div id="grid-active"></div>
		</div>

	<!-- Deactivation section start here-->
	
	
	<div id="deactive" class="tab-pane">
	<form id="form-deactive" name="form-deactive" method="post">
	<input type="hidden" value="<?php echo $bulklimit;?>" name="bulklimit"/>
		<table class="table table-bordered table-condensed">
			<tr>
                <td align="left" width="16%" height="32"><span>Service&nbsp;</span></td>
				<td><select name="service_info" id="service_info" onchange="showRowsTable('deactive',this.value);">
						<option value="0">Select Service</option>
						<?php foreach($serviceDeactivationarray as $s_id=>$s_val) { ?>
							<option value="<?php echo $s_id;?>"><?php echo $s_val;?></option>
						<?php }?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="16%" height="32" align="left">Mode</td>
				<td><div id="channel-deactive"><select name="channel" id="channel" class="in"></SELECT></div></td>
			</tr>
			<tr id="deactive-lang_1">
					<?php
		$langQuery = "select lang_name,langID from master_db.tbl_language_master order by lang_name";
		$langResult = mysql_query($langQuery,$dbConn);
					?>
						<td align="left" width="16%" height="32"><span>Language&nbsp;</span></td>
						<td>
						<select name='lang_deactive' id='lang_deactive' class="in">
				<option value=''>Please select Language</option>
				<?php while($langDetails = mysql_fetch_array($langResult)) { ?>
					<option value='<?php echo $langDetails['langID']?>' <?php if($langDetails['langID']=='01') echo "SELECTED"?>><?php echo $langDetails['lang_name']?></option>
				<?php } ?>
			</select>
						</td>
					</tr>
			<tr>
				<td align="left" width="16%" height="32"><span>Browse File To Upload </span></td>
				<td>
					<INPUT name="upfile" id='upfile' type="file" class="in">
					<INPUT type="hidden" name="action" id='action' value="deactive" class="in"/>
					<input id="upfor" type="hidden" value="deactive" name="upfor">
					<button class="btn btn-primary" style="float:right">Submit</button>
					<input type='hidden' name='usrId' value=<?php echo $user_id;?>>
				</td>
			</tr>
		</table>
	</form>
	<div id="grid-deactive"></div>									
    </div>

	<!--Renewal section start here-->	
	<div id="renewal" class="tab-pane">
	<form id="form-renewal" name="form-renewal" method="post">
	<input type="hidden" value="<?php echo $bulklimit;?>" name="bulklimit"/>
	<table class="table table-bordered table-condensed">
		<tr>
			<td align="left" width="16%" height="32"><span>Service&nbsp;</span></td>
			<td><select name="service_info" id="service_info" onchange="showRowsTable('renewal',this.value);">
					<option value="0">Select Service</option>
					<?php foreach($serviceRenewalarray as $s_id=>$s_val) { // mainservicearray ?>
						<option value="<?php echo $s_id;?>"><?php echo $s_val;?></option>
					<?php } ?>
				</select>   
			</td>
		</tr>
		<tr>
			<td width="16%" height="32" align="left">Mode</td>
			<td><div id="channel-renewal"><select name="channel" id="channel" class="in"></SELECT></div></td>
		</tr>
		
		<tr>
			<td align="left" width="16%" height="32">Price Point</td>
			<td><div id="pricepoint-renewal">
								<select name="price" id='price' class="in"></select>
							</div>
						</td>
		</tr>
			<!-- added for voice alert only start here--->		
		<TR height="30" id="renewal-cat11" style="display:none">
        <TD width="16%" height="32" align="left">Category 1</TD>
        <TD>
		<select name='cat1' id='cat1' class="in">
				<option value=''>Please select Category1</option>
				<option value='1'>BEAUTY</option>
				<option value='2'>BOLLYWOOD</option>
				<option value='3'>COMEDY</option>
				<option value='4'>DEVOTIONAL</option>
				<option value='5'>FEMINA</option>
				<option value='6'>FITNESS</option>
				<option value='7'>NEWS</option>
				<option value='8'>PERSONALITY</option>
				<option value='9'>MOVIE</option>
				<option value='10'>KNOWLEDGE</option>
				<option value='11'>WORD OF THE DAY</option>
			</select>
			</TD>
	  </TR>
	  <TR height="30" id="renewal-cat22" style="display:none">
        <TD width="16%" height="32" align="left">Category 2</TD>
        <TD><select name='cat2' id='cat2' class="in">
				<option value=''>Please select Category2</option>
				<option value='1'>BEAUTY</option>
				<option value='2'>BOLLYWOOD</option>
				<option value='3'>COMEDY</option>
				<option value='4'>DEVOTIONAL</option>
				<option value='5'>FEMINA</option>
				<option value='6'>FITNESS</option>
				<option value='7'>NEWS</option>
				<option value='8'>PERSONALITY</option>
				<option value='9'>MOVIE</option>
				<option value='10'>KNOWLEDGE</option>
				<option value='11'>WORD OF THE DAY</option>
			</select>
		</TD>
	  </TR>
	  <TR height="30" id="renewal-lang1" style="display:none">
        <TD width="16%" height="32" align="left">Language</TD>
        <TD>
			<select name='lang' id='lang' class="in">
				<option value=''>Please select Language</option>
				<option value='01'>Hindi</option>
				<option value='02'>English</option>
				<option value='07'>Tamil</option>
				<option value='08'>Telugu</option>
				<option value='09'>Malayalam</option>
				<option value='10'>Kannada</option>
			</select>
		</TD>
	  </TR>
	  <tr>
                <td align="left" width="16%" height="32">
				<span>Activation/Renewal Date</span>
				</td>
				<td>
				<fieldset>
                  <div class="control-group">
                     <div class="controls">
                     <div class="input-prepend">
				<span class="add-on"><i class="icon-calendar"></i></span><input type="text" name="schedule_date" id="schedule_date" value="<?php echo date("m/d/Y");?> - <?php echo date("m/d/Y");?>" />
                     </div>
                    </div>
                  </div>
                 </fieldset>
        		</td>
                </tr>
					<!-- end here for voice alert-->
			<tr id="renewal-lang_1">
		<?php
		$langQuery = "select lang_name,langID from master_db.tbl_language_master order by lang_name";
		$langResult = mysql_query($langQuery,$dbConn);
					?>
						<td align="left" width="16%" height="32"><span>Language&nbsp;</span></td>
						<td>
						<select name='lang_renewal' id='lang_renewal' class="in">
				<option value=''>Please select Language</option>
				<?php while($langDetails = mysql_fetch_array($langResult)) { ?>
					<option value='<?php echo $langDetails['langID']?>' <?php if($langDetails['langID']=='01') echo "SELECTED"?>><?php echo $langDetails['lang_name']?></option>
				<?php } ?>
			</select>
						</td>
					</tr>		
		<tr>
			<td align="left" width="16%" height="32"><span>Browse File To Upload </span></td>
			<td><INPUT name="upfile" id='upfile' type="file" class="in">
				<INPUT type="hidden" name="action" id='action' value="renewal" class="in">
				<input id="upfor" type="hidden" value="renewal" name="upfor">
                <button class="btn btn-primary" style="float:right">Submit</button>
				<input type='hidden' name='usrId' value=<?php echo $user_id;?>>
			</td>
		</tr>
	</table>
	</form>
	<div id="grid-renewal"></div>									
    </div>

	<div id="topup_charging" class="tab-pane">
				<form id="form-topup_charging" name="form-topup_charging" method="post" enctype="multipart/form-data">
					<table class="table table-bordered table-condensed">
					<tr>
						<td align="left" width="16%" height="32"><span>Service&nbsp;</span></td>
						<td><select name="service_info" id="service_info" onchange="showRowsTable('topup_charging',this.value);">
								<option value="0">Select Service</option>
								<?php foreach($topupchargingActivation as $s_id=>$s_val) { ?>
									<option value="<?php echo $s_id;?>"><?php echo $s_val;?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td width="16%" height="32" align="left">Mode</td>
						<td><div id="channel-topup_charging"><select name="channel" id="channel" class="in"></SELECT></div></td>
					</tr>
					<tr>
						<td align="left" width="16%" height="32">Price Point</td>
						<td><div id="pricepoint-topup_charging">
								<select name="price" id='price' class="in"></select>
							</div>
						</td>
					</tr>
					<tr>
						<td align="left" width="16%" height="32"><span>Browse File To Upload </span></td>
						<td><INPUT name="upfile" id='upfile' type="file" class="in">
							<INPUT type="hidden" name="action" id='action' value="topup_charging" class="in">
							<input id="upfor" type="hidden" value="topup_charging" name="upfor">
		                  	<button class="btn btn-primary" style="float:right">Submit</button>
							<input type='hidden' name='usrId' value=<?php echo $user_id;?>>
						</td>
					</tr>
				</table>
			</form>	
			<div id="grid-topup_charging"></div>
		</div>	
		
		<div id="event_active" class="tab-pane">
				<form id="form-event_active" name="form-event_active" method="post" enctype="multipart/form-data">
				
					<table class="table table-bordered table-condensed">
					<tr>
						<td align="left" width="16%" height="32"><span>Service&nbsp;</span></td>
						<td><select name="service_info" id="service_info" onchange="showRowsTable('event_active',this.value);">
								<option value="0">Select Service</option>
								<?php foreach($eventActivation as $s_id=>$s_val) { ?>
									<option value="<?php echo $s_id;?>"><?php echo $s_val;?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td width="16%" height="32" align="left">Mode</td>
						<td><div id="channel-event_active"><select name="channel" id="channel" class="in"></SELECT></div></td>
					</tr>
					<tr>
						<td align="left" width="16%" height="32">Price Point</td>
						<td><div id="pricepoint-event_active">
								<select name="price" id='price' class="in"></select>
							</div>
						</td>
					</tr>
					<tr>
						<td align="left" width="16%" height="32"><span>Browse File To Upload </span></td>
						<td><INPUT name="upfile" id='upfile' type="file" class="in">
							<INPUT type="hidden" name="action" id='action' value="event_active" class="in">
							<input id="upfor" type="hidden" value="event_active" name="upfor">
		                  	<button class="btn btn-primary" style="float:right">Submit</button>
							<input type='hidden' name='usrId' value=<?php echo $user_id;?>>
						</td>
					</tr>
				</table>
			</form>	
			<div id="grid-event_active"></div>
		</div>	
		<!---for event unsub-->
				<div id="event_unsub" class="tab-pane">
				<form id="form-event_unsub" name="form-event_unsub" method="post" enctype="multipart/form-data">
				
					<table class="table table-bordered table-condensed">
					<tr>
						<td align="left" width="16%" height="32"><span>Service&nbsp;</span></td>
						<td><select name="service_info" id="service_info" onchange="showRowsTable('event_unsub',this.value);">
								<option value="0">Select Service</option>
								<?php foreach($eventunsub as $s_id=>$s_val) { ?>
									<option value="<?php echo $s_id;?>"><?php echo $s_val;?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td width="16%" height="32" align="left">Mode</td>
						<td><div id="channel-event_unsub"><select name="channel" id="channel" class="in"></SELECT></div></td>
					</tr>
					<tr>
						<td align="left" width="16%" height="32">Price Point</td>
						<td><div id="pricepoint-event_unsub">
								<select name="price" id='price' class="in"></select>
							</div>
						</td>
					</tr>
					<tr>
						<td align="left" width="16%" height="32"><span>Browse File To Upload </span></td>
						<td><INPUT name="upfile" id='upfile' type="file" class="in">
							<INPUT type="hidden" name="action" id='action' value="event_unsub" class="in">
							<input id="upfor" type="hidden" value="event_unsub" name="upfor">
		                  	<button class="btn btn-primary" style="float:right">Submit</button>
							<input type='hidden' name='usrId' value=<?php echo $user_id;?>>
						</td>
					</tr>
				</table>
			</form>	
			<div id="grid-event_unsub"></div>
		</div>
		
				<!---for autochurn_renewal-->
				<div id="autochurn_renewal" class="tab-pane">
				<form id="form-autochurn_renewal" name="form-autochurn_renewal" method="post" enctype="multipart/form-data">
				
					<table class="table table-bordered table-condensed">
					<tr>
						<td align="left" width="16%" height="32"><span>Service&nbsp;</span></td>
						<td><select name="service_info" id="service_info" onchange="showRowsTable('autochurn_renewal',this.value);">
								<option value="0">Select Service</option>
								<?php foreach($autochurnrenewal as $s_id=>$s_val) { ?>
									<option value="<?php echo $s_id;?>"><?php echo $s_val;?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td width="16%" height="32" align="left">Type</td><!--onchange="showRowsTable('auto_deact',this.value)"/-->
						<td><div id="auto_types">
					 <input type="radio" id="auto_type1" name="auto_type" value="auto_churn" checked="true" onchange="resetPricePoint('autochurn_renewal')"/>&nbsp; Auto deactivation&nbsp;&nbsp;&nbsp;
                     <input type="radio" id="auto_type2" name="auto_type" value="auto_renewal" onchange="resetPricePoint('autochurn_renewal')">&nbsp; Auto renewal &nbsp;&nbsp;&nbsp;
					</div> </td>
				</tr>
					<tr>
						<td width="16%" height="32" align="left">Mode</td>
						<td><div id="channel-autochurn_renewal"><select name="channel" id="channel" class="in"></SELECT></div></td>
					</tr>
					<tr>
						<td align="left" width="16%" height="32">Price Point</td>
						<td><div id="pricepoint-autochurn_renewal">
								<select name="price" id='price' class="in"></select>
							</div>
						</td>
					</tr>
					<tr>
						<td align="left" width="16%" height="32"><span>Browse File To Upload </span></td>
						<td><INPUT name="upfile" id='upfile' type="file" class="in">
							<INPUT type="hidden" name="action" id='action' value="autochurn_renewal" class="in">
							<input id="upfor" type="hidden" value="autochurn_renewal" name="upfor">
		                  	<button class="btn btn-primary" style="float:right">Submit</button>
							<input type='hidden' name='usrId' value=<?php echo $user_id;?>>
						</td>
					</tr>
				</table>
			</form>	
			<div id="grid-autochurn_renewal"></div>
		</div>
	</div><!-- /.tab-content -->
	</div><!-- /.tabbable -->
	</div>

	<div class="well well-small">
	<?php //echo FILE_UPLOAD_MESSAGE;
	echo 'Please note: Only .txt file shall be accepted. Also, only '.$bulklimit_msg.' numbers shall be accepted in the file. Each row in your file should contain just 1 number (10 digits)';
	?></div>
	<div class="alert alert-danger" style='display:none' id="error_box"></div>
	<div id = "alert_placeholder"></div>
	<div id="loading"><img src="assets/img/loading-circle-48x48.gif" border="0" /></div> 
	<div id="grid-view_upload_history"></div> 

</div>
</div>
<!-- Footer section start here-->
  <?php
 require_once("footer.php");
  ?>
<!-- Footer section end here-->
  <script src="assets/js/jquery.pageslide.js"></script>
     <script type="text/javascript">
               $(document).ready(function() {
                  $('#schedule_date').daterangepicker();
               });
     </script>
  <script>
  
$('#loading').hide();
	$('#grid-active').hide();
	$('#grid-active').html('');
	function viewUploadhistory(a) {
		document.getElementById('alert_placeholder').style.display='none';
		$('#grid-view_upload_history').hide();
		$('#grid-view_upload_history').html('');
		$('#loading').show();
		$.fn.GetUploadHistory(a);
		};
	
$.fn.GetUploadHistory = function(type) {
$('#loading').show();
		$.ajax({
	     
					    url: 'viewuploadhistory.php',
					    data: 'type='+type,
						//data: $('#form-'+act).serialize() + '&action=del&username=<?php echo $username;?>',
						type: 'get',
						cache: false,
						dataType: 'html',
						success: function (abc) {
							$('#grid-view_upload_history').html(abc);
     						$('#loading').hide();
						}
						
					});
						
					$('#grid-view_upload_history').show();
	
};
$("form#form-autochurn_renewal").submit(function(){
var isok = checkfield('form-autochurn_renewal');
//var isok=true;
if(isok)
{
document.getElementById('alert_placeholder').style.display='none';
 $('#loading').show();
	var formData = new FormData($("form#form-autochurn_renewal")[0]);
    $.ajax({
        url: 'bulkupload_process.php',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
   	document.getElementById('grid-autochurn_renewal').style.display='inline';
	document.getElementById('grid-autochurn_renewal').innerHTML=data;
	resestForm('autochurn_renewal');
	viewUploadhistory('autochurn_renewal');
	        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
	}
	else
	{
	return false;
	}
});

$("form#form-event_unsub").submit(function(){
var isok = checkfield('form-event_unsub');
//var isok=true;
if(isok)
{
document.getElementById('alert_placeholder').style.display='none';
 $('#loading').show();
	var formData = new FormData($("form#form-event_unsub")[0]);
    $.ajax({
        url: 'bulkupload_process.php',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
   	document.getElementById('grid-event_unsub').style.display='inline';
	document.getElementById('grid-event_unsub').innerHTML=data;
	resestForm('event_unsub');
	viewUploadhistory('event_unsub');
	        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
	}
	else
	{
	return false;
	}
});

$("form#form-event_active").submit(function(){
var isok = checkfield('form-event_active');
//var isok=true;
if(isok)
{
document.getElementById('alert_placeholder').style.display='none';
 $('#loading').show();
	var formData = new FormData($("form#form-event_active")[0]);
    $.ajax({
        url: 'bulkupload_process.php',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
   	document.getElementById('grid-event_active').style.display='inline';
	document.getElementById('grid-event_active').innerHTML=data;
	resestForm('event_active');
	viewUploadhistory('event_active');
	        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
	}
	else
	{
	return false;
	}
});

$("form#form-topup_charging").submit(function(){
var isok = checkfield('form-topup_charging');
//var isok=true;
if(isok)
{
document.getElementById('alert_placeholder').style.display='none';
 $('#loading').show();
	var formData = new FormData($("form#form-topup_charging")[0]);
    $.ajax({
        url: 'bulkupload_process.php',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
   	document.getElementById('grid-topup_charging').style.display='inline';
	document.getElementById('grid-topup_charging').innerHTML=data;
	resestForm('topup_charging');
	viewUploadhistory('topup_charging');
	        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
	}
	else
	{
	return false;
	}
});


$("form#form-active").submit(function(){
var isok = checkfield('form-active');
if(isok)
{
document.getElementById('alert_placeholder').style.display='none';
 $('#loading').show();
	var formData = new FormData($("form#form-active")[0]);
    $.ajax({
        url: 'bulkupload_process.php',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
   	document.getElementById('grid-active').style.display='inline';
	document.getElementById('grid-active').innerHTML=data;
	resestForm('active');
	viewUploadhistory('active');
	        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
	}
	else
	{
	return false;
	}
});

$("form#form-renewal").submit(function(){
var isok = checkfield('form-renewal');
 if(isok)
{
document.getElementById('alert_placeholder').style.display='none';
 $('#loading').show();
    var formData = new FormData($("form#form-renewal")[0]);

    $.ajax({
        url: 'bulkupload_process.php',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
        document.getElementById('loading').style.display='none';
	document.getElementById('grid-renewal').style.display='inline';
		 document.getElementById('grid-renewal').innerHTML=data;
		  resestForm('renewal');
			viewUploadhistory('renewal');
			//$('#loading').hide();
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
	}
	else
	{
	return false;
	}
});

$("form#form-deactive").submit(function(){
var isok = checkfield('form-deactive');
 if(isok)
{
document.getElementById('alert_placeholder').style.display='none';
 $('#loading').show();
    var formData = new FormData($("form#form-deactive")[0]);

    $.ajax({
        url: 'bulkupload_process.php',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
document.getElementById('loading').style.display='none';
	document.getElementById('grid-deactive').style.display='inline';
		 document.getElementById('grid-deactive').innerHTML=data;
		  resestForm('deactive');
			viewUploadhistory('deactive');
			//$('#loading').hide();
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
	}
	else
	{
	return false;
	}
});
$(".second").pageslide({ direction: "right", modal: true });
</script>

<!-- added for file uplaod using bootstarp api-->
</body>
</html>