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
		//	$checkforactivation = "SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='active' and service_id like '%$v%'";
			$checkforactivation = "SELECT id,type,service_id,value FROM master_db.tbl_interface_type_master WHERE Isenable=1 and value='sms' and (service_id like '%,".$v."' or service_id like '".$v.",%' or service_id like '%,".$v.",%' or service_id='".$v."')";
			$total_act = mysql_query($checkforactivation,$dbConn);
			//$isforactivation=mysql_num_rows($total_act);
			$row1_act = mysql_fetch_array($total_act);
			if($row1_act['value'] == "sms") {
				$serviceSMSarray[$v] = $Service_DESC[$k]['Name'];
			}
		} 
	} 
}
asort($serviceSMSarray);
//print_r ($serviceSMSarray);
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
<script language="javascript" src="ts_picker.js"></script>
<script language="javascript">

 function checkfield() {
  var radioValue;
  radioValue=getRadioValue();

  if(document.getElementById('msgType').value==""){
		alert("Please select message type.");
		document.getElementById('msgType').focus();
		return false;
   } 
   if(document.getElementById('message').value==""){
		alert("Please enter message.");
		document.getElementById('message').focus();
		return false;
   }
   if(document.getElementById('message').value) {
		var iChars = "#";
		for (var i = 0; i < document.getElementById('message').value.length; i++) {
			if (iChars.indexOf(document.getElementById('message').value.charAt(i)) != -1) {
				alert ("The message has special characters. \nThese are not allowed.\n");
				return false;
			}
		}
   } 
   if(radioValue=="waplink" && document.getElementById('waplinkdata').value==""){
		alert("Please enter WAP link.");
		document.getElementById('waplinkdata').focus();
		return false;
   }
   /*if(document.getElementById('snderID').value==""){
		alert("Please enter sender ID.");
		document.getElementById('snderID').focus();
		return false;
   }*/
   if(document.getElementById('timestamp').value==""){
		alert("Please select a message start time.");
		document.getElementById('timestamp').focus();
		return false;
   }
   if(document.getElementById('timestamp1').value==""){
		alert("Please select a message end time.");
		document.getElementById('timestamp1').focus();
		return false;
   }
   /*if(document.frm.upfile.value==""){
		alert("Please select a file to upload.");
		document.frm.upfile.focus();
		return false;
   }*/
   return true;
}

function textCounter( field, countfield, maxlimit ) {
	 if ( field.value.length > maxlimit ) {
	  field.value = field.value.substring( 0, maxlimit );
	  field.blur();
	  field.focus();
	  return false;
	 } else {
	  countfield.value = maxlimit - field.value.length;
	 }
}

function showTable(radioname)
{
	if(radioname=='p')
	{
		document.getElementById('waplinkId').style.display = 'none';
	}
	if(radioname=='w')
	{
		document.getElementById('waplinkId').style.display = 'table-row';
	}
}
function getRadioValue()
{
	for (index=0; index < document.frm.msgType.length; index++)
	{
		if (document.frm.msgType[index].checked) 
		{
			var radioValue = document.frm.msgType[index].value;
			return radioValue;
			break;
		}
	}
}
function openWindow(sid)
{
	window.open("viewhistory.php?sid="+sid,"mywindow","menubar=0,resizable=1,width=650,height=500,scrollbars=yes");
}
</script>
	<!-- Bootstrap CSS Toolkit styles -->
<link rel="stylesheet" href="css/jquery.fileupload-ui.css">
</head>

<body onload="javascript:viewSMSUploadhistory('sms')">
<?php 
//insertion code start here--//
$ipAddress=$_SERVER['REMOTE_ADDR'];
$service_info=$_REQUEST['service_info'];
$processlog = "/var/www/html/hungamacare/2.0/MTSCricketEvent/activeBase/filestatus/log_".date('Ymd').".txt";
if($_SERVER['REQUEST_METHOD']=="POST") {
$selMaxId="select max(id)+1 from MTS_cricket.tbl_msg_history nolock";
$qryBatch = mysql_query($selMaxId,$dbConn);
list($Id) = mysql_fetch_array($qryBatch);
if(!$Id) $Id=1;
$msgType = $_REQUEST['msgType'];
$message = trim($_REQUEST['message']);	
$mainMessage = str_replace("#","",$message);
$wapLink = "";
if($msgType == "waplink") {
$wapLink = $_REQUEST['waplinkdata'];
$mainMessage = $message." ".$wapLink;
}
$senderId = $_REQUEST['snderID'];
$startTime = date("Y-m-d H:i:s",strtotime($_POST['timestamp']));
$endTime = date("Y-m-d H:i:s",strtotime($_POST['timestamp1']));
$Uploadquery="insert into MTS_cricket.tbl_msg_history(id, message,type,waplink,status,datetime,start_time,end_time,senderId,failure,pending,totalCount,ipAddr,success) values('".$Id."','".$message."','".$msgType."','".$wapLink."','0',NOW(),'".$startTime."', '".$endTime."','".$senderId."','0','0','".$file_size."','".trim($_SERVER['REMOTE_ADDR'])."','0')";
if(mysql_query($Uploadquery,$dbConn))
{
$msg = "Message has been uploaded successfully.";
$file_process_status = $Id.'#'.$senderId."#".$startTime."#".$endTime."#".$message.'#'.$ipAddress."#".date("Y-m-d H:i:s")."\r\n";
} 
else 
{
$error= mysql_error();
$msg = $error. " Please try again";
$file_process_status = $Id."Database Error-".$error."#".$ipAddress."#datetime#".date("Y-m-d H:i:s"). "\r\n";

}		
error_log($file_process_status, 3, $processlog);
} 
//insertion code end here--//
	?>




<div class="navbar navbar-inner">
	<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
</div>

<div class="container">
	<div class="row">
		<div class="page-header">
			<h1>Cricket SMS Upload<small>&nbsp;&nbsp;</small></h1>
		</div>
		<div class="tab-pane active" id="pills-basic">
		<div class="tabbable">
			<ul class="nav nav-pills">
				<?php /* if(in_array('billing',$AR_PList)) {?>   <li class="active"><a href="#BillDump" data-toggle="tab" data-act="BillDump">Billing Data</a></li><?php } */?>
				<li class="active"><a href="#active" onclick="viewSMSUploadhistory('sms')" data-toggle="tab" data-act="activation">SMS</a></li>
			</ul>
		<div class="tab-content">
		<!-- Activation section start here-->
		
			<div id="active" class="tab-pane active">
			 <form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()" enctype="multipart/form-data">
					<table class="table table-bordered table-condensed">
					<TR height="30">
        <td width="16%" height="32" align="left">&nbsp;&nbsp;<B>Message Type</B></TD>
        <TD >&nbsp;&nbsp;
		<!--plaintext-->
			<INPUT TYPE="radio" NAME="msgType" id="msgType" value="WC_CRIC_ALERT" class="in" onclick="showTable('p');" checked> Plain Text&nbsp;&nbsp;
			<!--INPUT TYPE="radio" NAME="msgType" id="msgType" value="waplink" class="in" onclick="showTable('w');"/> WAP Link<-->
		</TD>
      </TR>
				<TR height="30">
        <TD width="16%" height="32" align="left">&nbsp;&nbsp;<B>Message Text</B></TD>
        <TD >&nbsp;&nbsp;<TEXTAREA NAME="message" id="message" ROWS="5" COLS="60" maxlength="160" onkeyup="textCounter(this,this.form.counter,160);" ></TEXTAREA>
		</br>&nbsp;&nbsp;<br/>&nbsp;&nbsp;<B>Charaters Remaining:</B> <input onblur="textCounter(this.form.recipients,this,306);" disabled  onfocus="this.blur();" tabindex="999" maxlength="3" size="3" value="160" name="counter">	
		</TD>
      </TR>
	  <TR height="30" id='waplinkId' style="display:none;">
        <TD width="16%" height="32" align="left">&nbsp;&nbsp;<B>WAP Link</B></TD>
        <TD >&nbsp;&nbsp;<INPUT TYPE="text" NAME="waplinkdata" id="waplinkdata" size='80' />
		</TD>
      </TR>
	  <TR height="30">
	  <INPUT TYPE="hidden" NAME="snderID" id="snderID" size='80' value='52444'/>
        <TD width="16%" height="32" align="left">&nbsp;&nbsp;<B>Start Date</B></TD>
        <TD >&nbsp;&nbsp;<input type="Text" name="timestamp" id="timestamp" value="">
		<a href="javascript:show_calendar('document.frm.timestamp', document.frm.timestamp.value);">
		<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
		</TD>
      </TR>
	  <TR height="30">
        <TD width="16%" height="32" align="left">&nbsp;&nbsp;<B>End Date</B></TD>
        <TD >&nbsp;&nbsp;<input type="Text" name="timestamp1" id="timestamp1" value="">
		<a href="javascript:show_calendar('document.frm.timestamp1', document.frm.timestamp1.value);">
		<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
		</TD>
      </TR> 
	  <TR height="30">
        <td align="center" colspan="2" bgcolor="#FFFFFF">
			<input name="Submit" type="submit" class="txtbtn" value="Upload" onSubmit="return checkfield();"/>			
       </td>
     </TR>
				</table>
			</form>	
			<div id="grid-active"></div>
		</div>

	</div><!-- /.tab-content -->
	</div><!-- /.tabbable -->
	</div>

	<div class="well well-small"><?php //echo FILE_UPLOAD_SMS;?></div>
	<div class="alert alert-danger" style='display:none' id="error_box"></div>
	<div id = "alert_placeholder"><?php echo $msg; ?></div>
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
	     
					    url: 'smsviewcrickethistory.php',
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

function stopBulkFile(batchid,type)
            {
                var x;
                var r=confirm("Do you really want to stopped this batch id ?");
                if (r==true)
                {
                    stopBulkFile_confirm(batchid,type);
                }
            }

            function stopBulkFile_confirm(batchid,type)
            {
				var type='del';
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
				
				
                xmlhttp.open("GET","stopcrickethistory.php?batchid="+batchid+"type="+type,true);
                xmlhttp.send();
            }
$(".second").pageslide({ direction: "right", modal: true });
</script>
<!-- added for file uplaod using bootstarp api-->
</body>
</html>
