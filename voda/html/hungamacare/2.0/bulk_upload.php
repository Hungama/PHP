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
$services = explode(",", $listservices);

//********************************Activation ***************************
$serviceActivationarray=array();
foreach ($serviceArray as $k => $v) {
	if(in_array($k,$services)) {
		if($v!='') {
			$checkforactivation = "SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='active' and (service_id like '%,".$v."' or service_id like '".$v.",%' or service_id like '%,".$v.",%' or service_id='".$v."')";
			$total_act = mysql_query($checkforactivation,$dbConn);
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
asort($serviceActivationarray);
asort($serviceDeactivationarray);
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
		if(pricepoint=="" && (uploadfor=='active')) {
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
	//handle language display here 
	
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
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var channelid='channel-'+type;
			document.getElementById(channelid).innerHTML=xmlhttp.responseText;
		}
	}	
	var url="getBulkModePrice.php?case=mode&type="+type+"&sid="+sid;
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}

function SetPricePoint(type,sid){ 
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}	
	if(type == 'deactive') {
		//document.getElementById('price12').style.display = 'none';
	} else {
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) { //	alert(xmlhttp.responseText);
			
		var pricepoint='pricepoint-'+type;
		document.getElementById(pricepoint).innerHTML=xmlhttp.responseText;	
			}
		}	

		var url = "getBulkModePrice.php?case=price&type="+type+"&sid="+sid;
	
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
				<li class="active"><a href="#active" onclick="viewUploadhistory('active')" data-toggle="tab" data-act="activation">Activation</a></li>
				<li class=""><a href="#deactive" onclick="viewUploadhistory('deactive')" data-toggle="tab" data-act="deactivation">Deactivation</a></li>
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

		<TR height="30" id='languageDiv'>
		<TD bgcolor="#FFFFFF">Language</TD>
        <TD bgcolor="#FFFFFF"><select name="lang" id="lang" class="in">
			<option value="">Select Language</option>
			<?php $querylang = mysql_query("select lang_name,langID from master_db.tbl_language_master order by lang_name",$dbConn);
				while($rowlang = mysql_fetch_array($querylang)) {
					echo '<option value="'.$rowlang['langID'].'">'.ucwords($rowlang['lang_name']).'</option>';
				} ?>	
		</select>
		</TD>
      </TR> 
		
					<tr>
						<td align="left" width="16%" height="32"><span>Browse File To Upload </span></td>
						<td><INPUT name="upfile" id='upfile' type="file" class="in">
							<INPUT type="hidden" name="action" id='action' value="active" class="in">
							<input id="upfor" type="hidden" value="active" name="upfor">
		                  	<button class="btn btn-primary" style="float:right">Submit</button>
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

</div><!-- /.tab-content -->
	</div><!-- /.tabbable -->
	</div>

	<div class="well well-small">
	<?php
//	echo FILE_UPLOAD_MESSAGE;
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