<?php
ob_start();
session_start();
$user_id=$_SESSION['usrId'];
$PAGE_TAG='cc';
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

$catArray=array('Music','AudioCinema','BollywoodGossip','LoveGuru');
asort($catArray);
$circle_info=array('Delhi'=>'DEL','Gujarat'=>'GUJ','WestBengal'=>'WBL','Bihar'=>'BIH','Rajasthan'=>'RAJ','UP WEST'=>'UPW','Maharashtra'=>'MAH','Andhra Pradesh'=>'APD','UP EAST'=>'UPE','Assam'=>'ASM','Tamil Nadu'=>'TNU','Kolkata'=>'KOL','NE'=>'NES','Chennai'=>'CHN','Orissa'=>'ORI','Karnataka'=>'KAR','Haryana'=>'HAR','Punjab'=>'PUN','Mumbai'=>'MUM','Madhya Pradesh'=>'MPD','Jammu-Kashmir'=>'JNK',"Punjab"=>'PUB','Kerala'=>'KER','Himachal Pradesh'=>'HPD','Other'=>'UND','Haryana'=>'HAY');
asort($circle_info);
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
	var cat_info=document.forms[type]["cat_info"].value;
	var circle_info=document.forms[type]["circle_info"].value;
	var dpd1=document.forms[type]["dpd1"].value;
	if (cat_info==0) {
		 bootstrap_alert.warning('<?php echo 'Please select category.';?>');
		 return false;
	} 
	else if (circle_info==0) {
		 bootstrap_alert.warning('<?php echo 'Please select circle.';?>');
		 return false;
	}
	else if (dpd1=="") {
		bootstrap_alert.warning('<?php echo 'Please select date.';?>');
		return false;
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
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

    <link id="bsdp-css" href="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
	<!-- Bootstrap CSS Toolkit styles -->
<link rel="stylesheet" href="css/jquery.fileupload-ui.css">
 <link href="css/datepicker.css" rel="stylesheet">
</head>
<!-- -->
<body onload="javascript:viewSMSUploadhistory('config')">
<div class="navbar navbar-inner">
	<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
</div>

<div class="container">
	<div class="row">
		<div class="page-header">
			<h1>Configure 54646 Category<small>&nbsp;&nbsp;</small></h1>
		</div>
		<div class="tab-pane active" id="pills-basic">
		<div class="tabbable">
			<ul class="nav nav-pills">
				<li class="active"><a href="#active" onclick="viewSMSUploadhistory('sms')" data-toggle="tab" data-act="activation">Configure</a></li>
			</ul>
		<div class="tab-content">
		<!-- Config section start here-->
			<div id="active" class="tab-pane active">
				<form id="form-active" name="form-active" method="post" enctype="multipart/form-data">
					<table class="table table-bordered table-condensed">
					<tr>
						<td align="left" width="16%" height="32"><span>Category&nbsp;</span></td>
						<td><select name="cat_info" id="cat_info">
								<option value="0">Select Category</option>
								<?php foreach($catArray as $val) { ?>
									<option value="<?php echo $val;?>"><?php echo $val;?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="left" width="16%" height="32"><span>Circle&nbsp;</span></td>
						<td><select name="circle_info" id="circle_info">
								<option value="0">Select Circle</option>
								<?php foreach($circle_info as $cId=>$cval) { ?>
									<option value="<?php echo $cval;?>"><?php echo $cId;?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="left" width="16%" height="32"><span>Schedule Date&nbsp;</span></td>
						<td>
					 <input type="text" value="" name="dpd1" id="dpd1" placeholder="Click to set date">(mm/dd/yyyy)
						</td>
					</tr>
					
				
					<tr>
						<td align="left" width="16%" height="32"></td>
						<td>
						<button class="btn btn-primary" style="float:right">Submit</button>						  
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

	
	<div class="alert alert-danger" style='display:none' id="error_box"></div>
	<div id = "alert_placeholder"></div>
	<div id="loading"><img src="assets/img/loading-circle-48x48.gif" border="0" /></div> 
	<div id="grid-view_upload_history"></div> 

</div>
</div>
<!-- Footer section start here-->
  <?php
// require_once("footer.php");
  ?>

<!-- Footer section end here-->
  <script src="assets/js/jquery.pageslide.js"></script>
  <script src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script>
 
   $(function(){
			window.prettyPrint && prettyPrint();
  $('#dpd1').datepicker({
    multidate: true,
	
});
 	});
/*
 $(function(){
			window.prettyPrint && prettyPrint();
		 // disabling dates
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

       $('#dpd1').datepicker({
				//format: 'mm-dd-yyyy',
			multidate: true,				
            onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
          }
        })
 	});
	*/
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
	     
					    url: 'configviewhistory.php',
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
        url: 'config54646_process.php',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
   	document.getElementById('grid-active').style.display='inline';
	document.getElementById('grid-active').innerHTML=data;
	resestForm('active');
	viewSMSUploadhistory('config54646');
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
<?php
//all footer information will go here
include "Menu-Vertical.php";
?>
  <!--script src="js/bootstrap-datepicker.js"></script-->
<!-- added for file uplaod using bootstarp api-->
</body>
</html>