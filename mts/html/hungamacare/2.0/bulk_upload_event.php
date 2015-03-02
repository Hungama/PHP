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
//array of allowed service to login user

$listservices=$_SESSION["access_service"];
//print_r($listservices);
$services = explode(",", $listservices);

$mainservicearray=array();
foreach ($serviceArray as $k => $v) {
	if(in_array($k,$services)) {
		//if($v!='1412' && $v!='')
		if($v!='') {
			if($Service_DESC[$k]['Operator']=='Uninor') {
				$mainservicearray[$v] = $Service_DESC[$k]['Name'];
			}
		} 
	} 
}
asort($mainservicearray);
				
//********************************Activation ***************************
$serviceActivationarray=array();
foreach ($serviceArray as $k => $v) {
	if(in_array($k,$services)) {
		if($v!='') {
			$checkforactivation = "SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='active' and service_id like '%$v%'";
			$total_act = mysql_query($checkforactivation,$dbConn);
			//$isforactivation=mysql_num_rows($total_act);
			$row1_act = mysql_fetch_array($total_act);
			if($row1_act['value'] == "active") {
			
		if($v==1002)
							{
							$serviceActivationarray[$v] = $Service_DESC[$k]['Name'];
							$serviceActivationarray['10021'] = $Service_DESC['BPLTataDoCoMo']['Name'];
							}
							else
							{
							$serviceActivationarray[$v] = $Service_DESC[$k]['Name'];
							}			
			}
		} 
	} 
}
						 
//***********************************Top-Up********************************
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
						  
//***********************************Deactivation********************************
$serviceDeactivationarray=array();
foreach ($serviceArray as $k => $v) { 
	if(in_array($k,$services)) {
		if($v!='') {
			$checkforDeactivation="SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='deactive' and service_id like '%$v%'";
			$total_deactivation = mysql_query($checkforDeactivation,$dbConn);
			//$isfordeact=mysql_num_rows($total_deactivation);
			$row1_deactive= mysql_fetch_array($total_deactivation);
			if($row1_deactive['value'] == "deactive") {
				//$serviceDeactivationarray[$v] = $Service_DESC[$k]['Name'];
					if($v==1002)
							{
							$serviceDeactivationarray[$v] = $Service_DESC[$k]['Name'];
							$serviceDeactivationarray['10021'] = $Service_DESC['BPLTataDoCoMo']['Name'];
							}
							else
							{
							$serviceDeactivationarray[$v] = $Service_DESC[$k]['Name'];
							}
			}
		}
	}
}
						  
//***********************************Event********************************
$serviceEventarray=array();
foreach ($serviceAllEventArray as $k => $v) { 
	if(in_array($k,$services)) {
		if($v!='') {
			$checkforEvent="SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='event' and service_id like '%$v%'";
			$total_event = mysql_query($checkforEvent,$dbConn);
			//$isforevent=mysql_num_rows($total_event);
			$row1_event= mysql_fetch_array($total_event);
			if($row1_event['value'] == 'event') {
				$serviceEventarray[$v] = $Service_DESC[$k]['Name'];
			}
		}
	}
}
/********************************Event Activation********************************************/
$eventActivation=array();
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


/*******************************End here ***************************************************/
		  
asort($serviceActivationarray);
asort($serviceTopUparray);
asort($serviceDeactivationarray);
asort($serviceEventarray);
asort($eventActivation);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- include all required CSS & JS File start here -->
<?php 
require_once("main-header.php");
?>
<!-- include all required CSS & JS File end here -->
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
		if(pricepoint=="" && (uploadfor=='active' || uploadfor=='event' || uploadfor=='topup')) {
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
	
//validation for ringtone page
function checkfieldRT(type,sid){
$('#loading').hide();
document.getElementById('alert_placeholder').style.display='inline';
var pricepoint=document.forms[type]["pricepoint"].value;
var channel=document.forms[type]["channel"].value;
var upfile=document.forms[type]["upfile"].value;
if(sid==0)
{
bootstrap_alert.warning('<?php echo 'Please select service.';?>');
  return false;
}
else if(sid==1412)
{
var ringtype=document.forms[type]["ringtype"].value;
var content_id=document.forms[type]["content_id"].value;
//return true is not a valid integer no

 if (ringtype==null || ringtype=="")
  {
  bootstrap_alert.warning('<?php echo JS_NOCONTENTTYPESELECTED;?>');
  return false;
  }
  else if(pricepoint==null || pricepoint=="")
  {
  bootstrap_alert.warning('<?php echo JS_NOPPSELECTED;?>');
  return false;
  }
    else if(channel==null || channel=="")
  {
  bootstrap_alert.warning('<?php echo JS_NOMODESELECTED;?>');
  return false;
  }
    else if(content_id==null || content_id=="" || content_id==0)
  {
  bootstrap_alert.warning('<?php echo JS_NOCONTENTIDSELECTED;?>');
  return false;
  }
  else if(isNaN(content_id))
  {
bootstrap_alert.warning('<?php echo JS_NOVALIDCONTENTIDSELECTED;?>');
return false;
  }
//alert('my ringtone');
}

else if(sid==1408)
{
//alert('sport event');
if(pricepoint==null || pricepoint=="")
  {
  bootstrap_alert.warning('<?php echo JS_NOPPSELECTED;?>');
  return false;
  }
    else if(channel==null || channel=="")
  {
  bootstrap_alert.warning('<?php echo JS_NOMODESELECTED;?>');
  return false;
  }
}
else if(sid==1410) // || sid==1409 || sid==1009
{
//var content_id=document.forms[type]["content_id"].value;
//alert('missriya/redfm');
if(pricepoint==null || pricepoint=="")
  {
  bootstrap_alert.warning('<?php echo JS_NOPPSELECTED;?>');
  return false;
  }
    else if(channel==null || channel=="")
  {
  bootstrap_alert.warning('<?php echo JS_NOMODESELECTED;?>');
  return false;
  }
 /*   else if(content_id==null || content_id=="" || content_id==0)
  {
  bootstrap_alert.warning('<?php echo JS_NOCONTENTIDSELECTED;?>');
  return false;
  }
  else if(isNaN(content_id))
  {
bootstrap_alert.warning('<?php echo JS_NOVALIDCONTENTIDSELECTED;?>');
return false;
  }
  */

}
else
{
//alert('other event');
 if(channel==null || channel=="")
  {
  bootstrap_alert.warning('<?php echo JS_NOMODESELECTED;?>');
  return false;
  }
else if(pricepoint==null || pricepoint=="")
  {
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
	return true;
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
	//tonePlanData toneMode uninorRT  event
	var formname='form-'+type;
	//alert(type);
	
	document.getElementById('grid-'+type).style.display='none';
	
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	if(type!='deactive') {
		document.forms[formname]["price"].value = "<option value=''>-- Select Price Point --</option>";
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {// alert(xmlhttp.responseText);
			//document.getElementById("channelS").innerHTML=xmlhttp.responseText;			
			if(type!='event') {
				var channelid='channel-'+type;
			} else {
				var channelid='toneMode-uninorRT';
			}
			document.getElementById(channelid).innerHTML=xmlhttp.responseText;
		}
	}	
	var url="getBulkModePrice.php?case=mode&type="+type+"&sid="+sid;
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}

function SetPricePoint(type,sid){alert('hi'+type);
if(type=='event' && sid==1402)
{
var ch=document.forms['form-uninorRT']["channel"].value;
if(ch=='WAP-JOKES')
{
document.getElementById('uninorJokes_contentType').style.display = 'table-row';
document.getElementById('uninorRT_contentId').style.display = 'table-row';

}
else
{
document.getElementById('uninorJokes_contentType').style.display = 'none';
document.getElementById('uninorRT_contentId').style.display = 'none';
}
}
else
{
document.getElementById('uninorJokes_contentType').style.display = 'none';
}
//tonePlanData toneMode uninorRT  event
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}	
	if(type == 'deactive') {
		//document.getElementById('price12').style.display = 'none';
	} else {
		//document.getElementById('price12').style.display = 'table-row';				
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) { //	alert(xmlhttp.responseText);
				if(type!='event')
		{
		var pricepoint='pricepoint-'+type;
		}
		else
		{
		var pricepoint='tonePlanData-uninorRT';
		}
		
		if(ch=='WAP-JOKES')
			{
			document.getElementById('tonePlanData-uninorRT').innerHTML = "<select id='pricepoint' name='pricepoint'><option value=''>Select Price Point</option><option value='86-10'>Rs. 10</option></select>";
			}else
			{
		document.getElementById(pricepoint).innerHTML=xmlhttp.responseText;	
			}		

			}
		}	

	if(type!='event')
		{
		var url = "getBulkModePrice.php?case=price&type="+type+"&sid="+sid;
		}
	else if(type=='event_active')
		{alert('hi');
		var url = "getBulkModePrice_event_active.php?case=price&type="+type+"&sid="+sid;
		}
		else
		{
		var url = "getBulkModePrice-RT.php?case=price&type="+type+"&sid="+sid;
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
    
/*
$('#clickme').on('click', function() {
            bootstrap_alert.warning('Your text goes here');
});
*/

function setTonePriceData(toneType,S_id) {
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		document.getElementById("tonePlanData-uninorRT").innerHTML=xmlhttp.responseText;
	    }
	}
	xmlhttp.open("GET","tonePriceData.php?tonetype="+toneType+"&sid="+S_id,true);
	xmlhttp.send();	
}


function showContentType(type,sid) 
{
	document.getElementById('uninorJokes_contentType').style.display = 'none';
	if(sid=='1412') {
		document.getElementById('uninorRT_contentType').style.display = 'table-row';
		document.getElementById('uninorRT_contentId').style.display = 'table-row';
		document.getElementById("tonePlanData-uninorRT").innerHTML="";
		document.getElementById('tonePlanData-uninorRT').innerHTML = "<select id='pricepoint' name='pricepoint'><option value=''>Select Price Point</option></select>";
		document.getElementById("toneMode-uninorRT").innerHTML="";
		document.getElementById('toneMode-uninorRT').innerHTML = "<select name='channel' id='channel'><option value='IVR'>IVR</option><option value='OBD'>OBD</option><option value='TC'>TELECALLING</option><option value='USSD'>USSD</option><option value='CCI'>CCI</option><option value='IBD'>IBD</option></select>";
	} else if(sid=='1408') {
		document.getElementById('uninorRT_contentType').style.display = 'none';
		document.getElementById('uninorRT_contentId').style.display = 'none';
		document.getElementById("tonePlanData-uninorRT").innerHTML="";
		document.getElementById('tonePlanData-uninorRT').innerHTML = "<select id='pricepoint' name='pricepoint'><option value=''>Select Price Point</option><option value='15'>Rs. 15</option><option value='10'>Rs. 10</option><option value='7'>Rs. 7</option><option value='5'>Rs. 5</option><option value='4'>Rs. 4</option><option value='3'>Rs. 3</option><option value='2'>Rs. 2</option><option value='1'>Rs. 1</option></select>";
		document.getElementById("toneMode-uninorRT").innerHTML="";
		document.getElementById('toneMode-uninorRT').innerHTML = "<select name='channel' id='channel'><option value='IVR'>IVR</option><option value='OBD'>OBD</option><option value='TC'>TELECALLING</option><option value='USSD'>USSD</option><option value='CCI'>CCI</option><option value='IBD'>IBD</option><option value='WAP'>WAP</option></select>";
	} 
	else {
		//alert('for othere services');
		document.getElementById('uninorRT_contentType').style.display = 'none';
		document.getElementById('uninorRT_contentId').style.display = 'none';
		document.getElementById("tonePlanData-uninorRT").innerHTML="";
		document.getElementById('tonePlanData-uninorRT').innerHTML = "<select id='pricepoint' name='pricepoint'></select>";
		//tonePlanData toneMode uninorRT
		document.getElementById('uninorJokes_contentType').style.display = 'none';
		showRowsTable('event',sid);
	}
}
function setJokesData(mode)
{
alert(mode);
}

</script>
	<!-- Bootstrap CSS Toolkit styles -->
<link rel="stylesheet" href="css/jquery.fileupload-ui.css">
</head>

<!--body onload="javascript:viewUploadhistory('event_active')"-->
<body>

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
				<!--li class="active"><a href="#active" onclick="viewUploadhistory('active')" data-toggle="tab" data-act="activation">Activation</a></li>
				<li class=""><a href="#topup" onclick="viewUploadhistory('topup')" data-toggle="tab" data-act="topup">Top-Up</a></li>
				<li class=""><a href="#deactive" onclick="viewUploadhistory('deactive')" data-toggle="tab" data-act="deactivation">Deactivation</a></li>
				<li class=""><a href="#uninorRT" onclick="viewUploadhistory('uninorRT')" data-toggle="tab" data-act="Ringtone">Event</a></li-->
				<li class="active"><a href="#event_active" onclick="viewUploadhistory('event_active')" data-toggle="tab" data-act="Event-ACtivation">Event-Activation</a></li>
			</ul>
		<div class="tab-content">
			<div id="active" class="tab-pane">
				<form id="form-active" name="form-active" method="post" enctype="multipart/form-data">
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
					<tr>
						<td align="left" width="16%" height="32"><span>Browse File To Upload </span></td>
						<td><INPUT name="upfile" id='upfile' type="file" class="in">
							<INPUT type="hidden" name="action" id='action' value="active" class="in">
							<input id="upfor" type="hidden" value="active" name="upfor">
		                    <!--button class="btn btn-primary" id="submit-active" type="button" style="float:right">Submit</button-->
							<button class="btn btn-primary" style="float:right">Submit</button>
							<input type='hidden' name='usrId' value=<?php echo $user_id;?>>
						</td>
					</tr>
				</table>
			</form>	
			<div id="grid-active"></div>
		</div>
		<div id="topup" class="tab-pane">
		<form id="form-topup" name="form-topup" method="post">
			<table class="table table-bordered table-condensed">
			<tr>
				<td align="left" width="16%" height="32"><span>Service&nbsp;</span></td>
				<td><select name="service_info" id="service_info" onchange="showRowsTable('topup',this.value);">
						<option value="0">Select Service</option>
						<?php foreach($serviceTopUparray as $s_id=>$s_val) { ?>
							<option value="<?php echo $s_id;?>"><?php echo $s_val;?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="16%" height="32" align="left">Mode</td>
				<td><div id="channel-topup">
						<select name="channel" id="channel" class="in">
					</SELECT></div>
				</td>
			</tr>
			<tr>
				<td align="left" width="16%" height="32">Price Point</td>
				<td><div id="pricepoint-topup"><select name="price" id='price' class="in"></select></div></td>
			</tr>
			<tr>
                <td align="left" width="16%" height="32"><span>Browse File To Upload </span></td>
				<td><INPUT name="upfile" id='upfile' type="file" class="in">
					<INPUT type="hidden" name="action" id='action' value="topup" class="in">
					<input id="upfor" type="hidden" value="topup" name="upfor">
					<!--button class="btn btn-primary" id="submit-topup" type="button" style="float:right">Submit</button-->
					<button class="btn btn-primary" style="float:right">Submit</button>
					<input type='hidden' name='usrId' value=<?php echo $user_id;?>>
				</td>
			</tr>
			</table>
		</form>
		<div id="grid-topup"></div>
	</div>
	<!---Start event old section here-->
	<div id="event" class="tab-pane">
	<form id="form-event" name="form-event" method="post">
		<table class="table table-bordered table-condensed">
		<tr>
			<td align="left" width="16%" height="32"><span>Service&nbsp;</span></td>
			<td><select name="service_info" id="service_info" onchange="showRowsTable('event',this.value);">
					<option value="0">Select Service</option>
                    <?php foreach($mainservicearray as $s_id=>$s_val) {  //if($s_id!='1412')
						if($s_id!='1412' && $s_id!='1410' && $s_id!='1408') { ?>
						<option value="<?php echo $s_id;?>"><?php echo $s_val;?></option>
						<?php }
					} ?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="16%" height="32" align="left">Mode</td>
			<td><div id="channel-event"><select name="channel" id="channel" class="in"></SELECT></div></td>
		</tr>
		<tr>
			<td align="left" width="16%" height="32">Price Point</td>
			<td><div id="pricepoint-event">
					<select name="price" id='price' class="in"></select>
				</div>
			</td>
		</tr>
		<tr>
			<td align="left" width="16%" height="32"><span>Browse File To Upload </span></td>
			<td><INPUT name="upfile" id='upfile' type="file" class="in">
				<INPUT type="hidden" name="action" id='action' value="event" class="in">
				<input id="upfor" type="hidden" value="event" name="upfor">
				<button class="btn btn-primary" style="float:right">Submit</button>
				<input type='hidden' name='usrId' value=<?php echo $user_id;?>>
			</td>
		</tr>
		</table>
	</form>
	<div id="grid-event"></div>
    </div>
	<!---close event old section here-->							
	
	<div id="deactive" class="tab-pane">
	<form id="form-deactive" name="form-deactive" method="post">
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
			<tr>
				<td align="left" width="16%" height="32"><span>Browse File To Upload </span></td>
				<td>
					<INPUT name="upfile" id='upfile' type="file" class="in">
					<INPUT type="hidden" name="action" id='action' value="deactive" class="in"/>
					<input id="upfor" type="hidden" value="deactive" name="upfor">
					<!--button class="btn btn-primary" id="submit-deactive" type="button" style="float:right">Submit</button-->
					<button class="btn btn-primary" style="float:right">Submit</button>
					<input type='hidden' name='usrId' value=<?php echo $user_id;?>>
				</td>
			</tr>
		</table>
	</form>
	<div id="grid-deactive"></div>									
    </div>

	<!--my ringtone section start here-->	
	<div id="uninorRT" class="tab-pane">
	<form id="form-uninorRT" name="form-uninorRT" method="post">
	<table class="table table-bordered table-condensed">
		<tr>
			<td align="left" width="16%" height="32"><span>Service&nbsp;</span></td>
			<td><select name="service_id" id="service_id" onchange="showContentType('uninorRT',this.value)">
					<option value="0">Select Service</option>
					<?php foreach($serviceEventarray as $s_id=>$s_val) { // mainservicearray ?>
						<option value="<?php echo $s_id;?>"><?php echo $s_val;?></option>
					<?php } ?>
				</select>   
			</td>
		</tr>
		<tr style="display:none" id="uninorRT_contentType">
			<td width="16%" height="32" align="left">Content Type</td>
			<td><select name='ringtype' class='in' onchange="setTonePriceData(this.value,1412)">
					<option value="">Select Type</option>
					<option value="polytone">PolyTone</option>
					<option value="monotone">MonoTone</option>
					<option value="truetone">TrueTone</option>
				</select>
			</td>
		</tr>
		
		<tr>
			<td width="16%" height="32" align="left">Mode</td>
			<td><div id="toneMode-uninorRT"><select name="channel" class="in" onchange="setJokesData(this.value)"></select></div></td>
		</tr>
		<tr style="display:none" id="uninorJokes_contentType">
			<td width="16%" height="32" align="left">Content Type</td>
			<td><select name='ringtype2' class='in'>
					<option value="">Select Type</option>
					<option value="Fullsong">FullSong</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="left" width="16%" height="32">Price Point</td>
			<td><div id="tonePlanData-uninorRT"><select name="pricepoint" class="in"></select></div></td>
		</tr>
		<tr id="uninorRT_contentId">
			<td width="16%" height="32" align="left">Content Id</td>
			<td><INPUT TYPE="text" NAME="content_id" id="content_id" placeholder="Enter Content Id" maxlength="7"/></td>
		</tr>
	<tr>
			<td align="left" width="16%" height="32"><span>Browse File To Upload </span></td>
			<td><INPUT name="upfile" id='upfile' type="file" class="in">
				<INPUT type="hidden" name="action" id='action' value="uninorRT" class="in">
				<input id="upfor" type="hidden" value="event" name="upfor">
                <button class="btn btn-primary" style="float:right">Submit</button>
				<input type='hidden' name='usrId' value=<?php echo $user_id;?>>
			</td>
		</tr>
	</table>
	</form>
	<div id="grid-uninorRT"></div>									
    </div>

	<div id="event_active" class="tab-pane active">
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
	</div><!-- /.tab-content -->
	</div><!-- /.tabbable -->
	</div>

	<div class="well well-small"><?php echo FILE_UPLOAD_MESSAGE;?></div>
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
  <script>
  
$('#loading').hide();
	$('#grid-active').hide();
	$('#grid-active').html('');
	function viewUploadhistory(a) {
		document.getElementById('alert_placeholder').style.display='none';
		$('#grid-view_upload_history').hide();
		$('#grid-view_upload_history').html('');
		if(a!='uninorRT')
		{
		$('#loading').show();
		$.fn.GetUploadHistory(a);
		}
		else
		{
		//$.fn.GetRTUploadHistory(a);
		$('#loading').hide();
		}
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

$.fn.GetRTUploadHistory = function(type) {
$('#loading').show();
		$.ajax({
	     
					    url: 'viewRTBulkhistory.php',
					    data: 'type='+type,
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
/*	document.getElementById('pricepoint-active').innerHTML="<select><option value=''></option></select>";
	document.getElementById('channel-active').innerHTML="<select><option value=''></option></select>";
	document.getElementById("form-active").reset();
	*/
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

$("form#form-topup").submit(function(){
var isok = checkfield('form-topup');
 if(isok)
{
document.getElementById('alert_placeholder').style.display='none';
 $('#loading').show();
	var formData = new FormData($("form#form-topup")[0]);

    $.ajax({
        url: 'bulkupload_process.php',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
       document.getElementById('loading').style.display='none';
	document.getElementById('grid-topup').style.display='inline';
		 document.getElementById('grid-topup').innerHTML=data;
		 resestForm('topup');
		viewUploadhistory('topup');
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

$("form#form-event").submit(function(){
var isok = checkfield('form-event');
 if(isok)
{
document.getElementById('alert_placeholder').style.display='none';
 $('#loading').show();
    var formData = new FormData($("form#form-event")[0]);

    $.ajax({
        url: 'bulkupload_process.php',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
        document.getElementById('loading').style.display='none';
	document.getElementById('grid-event').style.display='inline';
		 document.getElementById('grid-event').innerHTML=data;
		  resestForm('event');
			viewUploadhistory('event');
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
			//				$('#loading').hide();
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
//ringtone
$("form#form-uninorRT").submit(function(){
var sid=document.forms['form-uninorRT']["service_id"].value;
var isok = checkfieldRT('form-uninorRT',sid);
//var isok =true;
 if(isok)
{
document.getElementById('alert_placeholder').style.display='none';
 $('#loading').show();
    var formData = new FormData($("form#form-uninorRT")[0]);

    $.ajax({
        url: 'bulkupload_process_ringtone.php',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
       document.getElementById('loading').style.display='none';
		document.getElementById('grid-uninorRT').style.display='inline';
		 document.getElementById('grid-uninorRT').innerHTML=data;
	//	resestForm('uninorRT');
	document.getElementById('form-uninorRT').reset();
			viewUploadhistory('uninorRT');
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
//event activation
$("form#form-event_active").submit(function(){
var isok = checkfield('form-event_active');
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
$(".second").pageslide({ direction: "right", modal: true });
</script>

<!-- added for file uplaod using bootstarp api-->
</body>
</html>