<?php
ob_start();
session_start();
$SKIP=1;
ini_set('display_errors','0');
include("db.php");
$operatorlist=array('docomo','reliance','uninor','Indidcom','Indicom','Etislat');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- include all required CSS & JS File start here -->
<?php 
require_once("main-header.php");
?>
<link href="../2.0/assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<!-- include all required CSS & JS File end here -->
<script type="text/javascript" language="javascript">
	
function checkfield(type){
$('#loading').hide();
document.getElementById('alert_placeholder').style.display='inline';
  var menuid=document.forms[type]["obd_form_menuid"].value;
   var service_info=document.forms[type]["obd_form_service"].value;
   var test_mode_value=document.forms[type]["test_mode_value"].value;
   
if (menuid==null || menuid=="")
  {
  bootstrap_alert.warning('Please select menu id.');
  return false;
  }  
  else if (service_info==0)
  {
  bootstrap_alert.warning('Please select service.');
  return false;
  }
  else if(test_mode_value==0)
 {
 var testingno=document.forms[type]["testingno"].value;
 if(testingno==0)
 {
 bootstrap_alert.warning('Please select testing number.');
 return false;
  }
 }
  else if(test_mode_value==1)
 {
 var upfile=document.forms[type]["upfile"].value;
 if(upfile==null || upfile=="")
 {
  bootstrap_alert.warning('Please select a file to upload.');
  return false;
 }
     var ext = upfile.substring(upfile.lastIndexOf('.') + 1);

    if(ext=="txt")
    {
	var count=(upfile.split(".").length - 1);
	if(count==1)
		{
		$('#loading').show();
showhideMessageBox();
        return true;
		}
		else
		{
		bootstrap_alert.warning('Please upload valid (.txt) file.');
		return false;
		}
    }
    else
    {
	 bootstrap_alert.warning('Please upload valid (.txt) file.');
      return false;
    }
}
$('#loading').show();
showhideMessageBox();	
//	return false;
return true;
}

$(".alert").alert();
$(".alert").alert('close');

bootstrap_alert = function() {}
bootstrap_alert.warning = function(message) {
            $('#alert_placeholder').html('<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a><span>'+message+'</span></div>')
        }
    
	function showhideMessageBox()
	{
	document.getElementById('error_box').style.display='none';
	document.getElementById('alert_placeholder').style.display='none';
	document.getElementById('grid-view_menu_message').style.display='none';
	}
	
	function showhide(type)
	{
	if(type=='live')
	{
document.getElementById('live_mode').style.display = 'table-row';
document.getElementById('test_mode').style.display = 'none';
document.getElementById('test_mode_value').value = 1;
	}
	else
	{
document.getElementById('live_mode').style.display = 'none';
document.getElementById('test_mode').style.display = 'table-row';
document.getElementById('test_mode_value').value = 0;
	}
	}
	
function startStopUssd(type,batchid) {
if(type=='start')
{
document.getElementById("btn_action_push_"+batchid).disabled=true;
document.getElementById("btn_action_push_"+batchid).style.display = 'none';
document.getElementById("btn_action_stop_"+batchid).style.display = 'inline';
}
else if(type=='kill')
{
document.getElementById("btn_action_kill_"+batchid).disabled=true;
}
else
{
document.getElementById("btn_action_stop_"+batchid).disabled=true;
document.getElementById("btn_action_stop_"+batchid).style.display = 'none';
document.getElementById("btn_action_push_"+batchid).style.display = 'inline';
}
 var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		//alert(xmlhttp.responseText);
if(type=='start')
{
document.getElementById("btn_action_push_"+batchid).disabled=false;
}
else if(type=='kill')
{
document.getElementById("btn_action_kill_"+batchid).disabled=true;
}
else
{
document.getElementById("btn_action_stop_"+batchid).disabled=false;
}
if(xmlhttp.responseText=='100')
{
alert('Operation completed.');
viewUploadhistory('ussd');
}
else
{
alert('Operation failed.');
}
//document.getElementById("channelS").innerHTML=xmlhttp.responseText;			
		}
	}	
	var url="start_stopUssdFile.php?type="+type+"&batchid="+batchid;
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}
function confirmStop(batchid)
{
var x;
var r=confirm("This will terminate the campaign and the RUN cannot be executed on the same base.");
if (r==true)
  {
  startStopUssd('kill',batchid);
  }
}
	</script>
	   <!-- range picker-->
	   	<!--link rel="stylesheet" type="text/css" media="all" href="bootstrap-daterangepicker-master/daterangepicker.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
		<script type="text/javascript" src="bootstrap-daterangepicker-master/date.js"></script>
		<script type="text/javascript" src="bootstrap-daterangepicker-master/daterangepicker.js"></script-->
		
				
		
			
		
	<!-- end here -->
	<!-- Bootstrap CSS Toolkit styles -->
</head>

<body onload="javascript:viewUploadhistory('ussd')">

<div class="navbar navbar-inner">
<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
</div>

<div class="container">
<div class="row">

<div class="page-header">
  <h1>USSD Base Upload<small>&nbsp;&nbsp;</small></h1>
 </div>
<div class="tab-pane active" id="pills-basic">
							<div class="tabbable">
							  <ul class="nav nav-pills">
							  <li class="active"><a href="#active" data-toggle="tab" data-act="activation">USSD</a></li>
						   </ul>
							  <div class="tab-content">
							    <div id="active" class="tab-pane active">
                                 	<form id="form-active" name="form-active" method="post" enctype="multipart/form-data">
									<table class="table table-bordered table-condensed">
									 <tr>
                <td align="left" width="16%" height="32"><span>Menu ID&nbsp;</span></td>
				<td>
<?php
$menudata='';
$getlivemenu='select serialid,menu_id,menu from USSD.tbl_ussd_config where level=0';
$result_livemenu = mysql_query($getlivemenu) or die(mysql_error());
?>
			  <select name="obd_form_menuid" id="obd_form_menuid" onchange="setmenumessage(this.value)">
				<option value="">Select Menu-ID</option>
				
<?php
while($data_livemenu = mysql_fetch_array($result_livemenu))
{
//$menudata[$data_livemenu[0]] = $data_livemenu[1];
?>
<option value="<?php echo $data_livemenu[0];?>"><?php echo $data_livemenu[1];?></option>
<?php }?>
	
			</select>
	
		</td>
			</tr><tr>
                   <td width="16%" height="32" align="left">USSD String</td>
				   <td>
				    <input type="text" class="text" name="obd_form_ussdstr" id="obd_form_ussdstr" readonly="true" value='*829#'/>
				</td>
                </tr>
				 <tr>
            
			 <td align="left" width="16%" height="32">
				Please select service
				</td>
				<td>
			   <select name="obd_form_service" id="obd_form_service" onchange="">
						<option value="0">Select any one--</option>
						<option value="1401">Uninor-MusicUnlimited</option>
						<option value="1410">RedFM</option>
						<option value="1450">My Music</option>
				  		</select>
			                        </td>
									</tr>
									<tr>
                   <td width="16%" height="32" align="left">Mode</td>
				   <td>
<input type="radio" name="mode" value="live" checked onchange="showhide(this.value)">Live
<input type="radio" name="mode" value="test" onchange="showhide(this.value)">Testing
				</td>
                </tr>
				<tr id="test_mode" style="display:none">
				<td align="left" width="16%" height="32" >Select Testing Number</td>
				<td>
				<select name='testingno'>
					<option value="0">Select Number</option>
					<option value="8587800665">8587800665</option>
					</select>
				</td>
				</tr>
				<tr id="live_mode">
                <td align="left" width="16%" height="32">
				<span>Browse File To Upload </span>
				</td>
				<td>
				<INPUT name="upfile" id='upfile' type="file" class="in">
				</td>
                </tr>
	<tr id="live_mode">
                <td align="left" width="16%" height="32">
				<span>Schedule For </span>
				</td>
				<td>
 <select name="schedule_date"  id="schedule_date">
                <option value="<?php echo date("Y-m-d");?>"  <?php echo (strcmp($Date,(date("Y-m-d")))==0?'selected':'');?>><?php echo date("d-M");?></option>
				<option value="<?php echo date("Y-m-d", time()+24*60*60);?>"><?php echo date("d-M", time()+24*60*60);?></option>
				<option value="<?php echo date("Y-m-d", time()+24*60*60);?>"><?php echo date("d-M", time()+(24*60*60)*2);?></option>
                </select>
				</td>
                </tr>

<tr>
                <td align="left" width="16%" height="32">
				<span>Start Date</span>
				</td>
				<td>
  <div class='input-append date' id='datetimepicker1'>
    <input data-format='dd/MM/yyyy hh:mm:ss' type='text' />
    <span class='add-on'>
      <i data-date-icon='icon-calendar' data-time-icon='icon-time'>
      </i>
    </span>
  </div>
 
				</td>
                </tr>
<tr>
                <td align="left" width="16%" height="32">
				<span>End Date</span>
				</td>
				<td>
 <div class='input-append date' id='datetimepicker2'>
     <input data-format='dd/MM/yyyy hh:mm:ss' type='text' />
    <span class='add-on'>
      <i data-date-icon='icon-calendar' data-time-icon='icon-time'>
      </i>
    </span>
  </div>
 </td>
                </tr>				
				
				<tr>
                <td align="left" width="16%" height="32">
				</td>
				<td>
				<input type="hidden" name="test_mode_value" id="test_mode_value" value="1"/>
				<button class="btn btn-primary" style="float:right">Submit</button>
				</td>
                </tr>
				
				</table>
									</form>	
	
 <div id="grid-active">

 </div>				
							    </div>
							  </div><!-- /.tab-content -->
							</div><!-- /.tabbable -->
						</div>
						
<div class="alert alert-danger" style='display:none' id="error_box"></div>
<div id = "alert_placeholder"></div>
<div id="grid-view_menu_message"></div> 

<div id="loading"><img src="../2.0/assets/img/loading-circle-48x48.gif" border="0" /></div> 
					
					<div id="grid-view_upload_history"></div> 

</div>
</div>
<!-- Footer section start here-->
  <?php
 require_once("footer.php");
  ?>
<!-- Footer section end here-->
<script type='text/javascript'>
  $(function() {
    $('#datetimepicker1').datetimepicker({
      language: 'pt-BR'
    });
  });
  
   $(function() {
    $('#datetimepicker2').datetimepicker({
      language: 'pt-BR'
    });
  });
</script>
  <script src="assets/js/jquery.pageslide.js"></script>

  <script>

$('#loading').hide();
	$('#grid-active').hide();
	$('#grid-active').html('');
	function viewUploadhistory(a) {
	document.getElementById('alert_placeholder').style.display='none';
		$('#loading').show();
		$('#grid-view_upload_history').hide();
		$('#grid-view_upload_history').html('');
		$.fn.GetUploadHistory(a);
	};
	
		function setmenumessage(a) {
		$('#loading').show();
		$('#grid-view_menu_message').hide();
		$('#grid-view_menu_message').html('');
		$.fn.GetMenuMessage(a);
	};
	
$.fn.GetUploadHistory = function(type) {
//$('#loading').show();
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

$.fn.GetMenuMessage = function(id) {
//$('#loading').show();
		$.ajax({
	     
					    url: 'viewmenumessage.php',
					    data: 'menuid='+id,
						//data: $('#form-'+act).serialize() + '&action=del&username=<?php echo $username;?>',
						type: 'get',
						cache: false,
						dataType: 'html',
						success: function (abc) {
							$('#grid-view_menu_message').html(abc);
     						$('#loading').hide();
						}
						
					});
						
					$('#grid-view_menu_message').show();
	
};

$("form#form-active").submit(function(){
var isok = checkfield('form-active');
if(isok)
{
document.getElementById('alert_placeholder').style.display='none';
 //$('#loading').show();
	var formData = new FormData($("form#form-active")[0]);
    $.ajax({
        url: 'bulkupload_process.php',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
   	document.getElementById('grid-active').style.display='inline';
	document.getElementById('grid-active').innerHTML=data;
	viewUploadhistory('ussd');
	        },
        cache: false,
        contentType: false,
        processData: false
    });
//document.getElementById("form-active").reset();
    return false;
	}
	else
	{
	return false;
	}
});
$(".second").pageslide({ direction: "right", modal: true });
</script>
<script src="../2.0/assets/js/bootstrap-datetimepicker.min.js"></script>
<!-- added for file uplaod using bootstarp api-->
</body>
</html>