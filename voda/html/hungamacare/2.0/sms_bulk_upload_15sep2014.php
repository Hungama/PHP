<?php
ob_start();
session_start();
$user_id=$_SESSION['usrId'];
$PAGE_TAG='bulk_sms';
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
$services = explode(",", $listservices);

//********************************SMS ***************************
$serviceSMSarray=array();
foreach ($serviceArray as $k => $v) {
	if(in_array($k,$services)) {
		if($v!='') {
			$checkforactivation = "SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='sms' and (service_id like '%,".$v."' or service_id like '".$v.",%' or service_id like '%,".$v.",%' or service_id='".$v."')";
			$total_act = mysql_query($checkforactivation,$dbConn);
			$row1_act = mysql_fetch_array($total_act);
			if($row1_act['value'] == "sms") {
				$serviceSMSarray[$v] = $Service_DESC[$k]['Name'];
			}
		} 
	} 
}
asort($serviceSMSarray);
$timeFrom = mktime(9,30,0);
$timeTo = mktime(21,30,0);
$currTime = mktime(date('H'),date('i'),date('s'));
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
	var upfile=document.forms[type]["upfile"].value;
	var message=document.forms[type]["message"].value;
	var service_info=document.forms[type]["service_info"].value;
	if (service_info==0) {
		 bootstrap_alert.warning('<?php echo JS_NOSERVICESELECTED;?>');
		 return false;
	} else if (message==null || message=="") {
		bootstrap_alert.warning('<?php echo JS_NOMESSAGE;?>');
		return false;
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
	
function resestForm(type)
{
	var formname='form-'+type;
	document.getElementById('message').innerHTML="";
	document.getElementById(formname).reset();
}


$(".alert").alert();
$(".alert").alert('close');

bootstrap_alert = function() {}
bootstrap_alert.warning = function(message) {
            $('#alert_placeholder').html('<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a><span>'+message+'</span></div>')
        }
    


</script>
	<!-- Bootstrap CSS Toolkit styles -->
<link rel="stylesheet" href="css/jquery.fileupload-ui.css">
</head>

<body onload="javascript:viewSMSUploadhistory('sms')">
<div class="navbar navbar-inner">
	<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
</div>

<div class="container">
	<div class="row">
		<div class="page-header">
			<h1>SMS-Bulk Upload<small>&nbsp;&nbsp;</small></h1>
		</div>
		<div class="tab-pane active" id="pills-basic">
		<div class="tabbable">
			<ul class="nav nav-pills">
				<li class="active"><a href="#active" onclick="viewSMSUploadhistory('sms')" data-toggle="tab" data-act="activation">SMS</a></li>
			</ul>
		<div class="tab-content">
		<!-- SMS section start here-->
			<div id="active" class="tab-pane active">
				<form id="form-active" name="form-active" method="post" enctype="multipart/form-data">
					<table class="table table-bordered table-condensed">
					<tr>
						<td align="left" width="16%" height="32"><span>Service&nbsp;</span></td>
						<td><select name="service_info" id="service_info">
								<option value="0">Select Service</option>
								<?php foreach($serviceSMSarray as $s_id=>$s_val) { ?>
									<option value="<?php echo $s_id;?>"><?php echo $s_val;?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td width="16%" height="32" align="left">Message</td>
						<td>
						<textarea cols="40" rows="4" maxlength="400" name="message" id="message"></textarea>
						</td>
					</tr>
					<tr>
						<td align="left" width="16%" height="32"><span>Browse File To Upload </span></td>
						<td><INPUT name="upfile" id='upfile' type="file" class="in">
							<INPUT type="hidden" name="action" id='sms' value="sms" class="in">
							<input id="upfor" type="hidden" value="sms" name="upfor">
						<?php
						if($currTime >= $timeFrom && $currTime <= $timeTo ) {?>
						  <button class="btn btn-primary" style="float:right" >Submit</button>
						  <?php } else {?>
							<button class="btn btn-primary" style="float:right" disabled>Submit</button>						  
						  <?php } ?>
							<input type='hidden' name='usrId' value=<?php echo $user_id;?>>
						</td>
					</tr>
				</table>
			</form>	
			<div id="grid-active"></div>
		</div>

	</div><!-- /.tab-content -->
	</div><!-- /.tabbable -->
	</div>

	<div class="well well-small"><?php echo FILE_UPLOAD_SMS;?></div>
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
	function viewSMSUploadhistory(a) {
		document.getElementById('alert_placeholder').style.display='none';
		$('#grid-view_upload_history').hide();
		$('#grid-view_upload_history').html('');
		$('#loading').show();
		$.fn.GetUploadHistory(a);
		};
	
$.fn.GetUploadHistory = function(type) {
$('#loading').show();
		$.ajax({
	     
					    url: 'smsviewhistory.php',
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


$("form#form-active").submit(function(){
var isok = checkfield('form-active');
if(isok)
{
document.getElementById('alert_placeholder').style.display='none';
 $('#loading').show();
	var formData = new FormData($("form#form-active")[0]);
    $.ajax({
        url: 'bulkupload_process_sms.php',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
   	document.getElementById('grid-active').style.display='inline';
	document.getElementById('grid-active').innerHTML=data;
	resestForm('active');
	viewSMSUploadhistory('sms');
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