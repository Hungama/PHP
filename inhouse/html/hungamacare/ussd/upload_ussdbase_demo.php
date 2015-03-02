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
<!-- include all required CSS & JS File end here -->
<script type="text/javascript" language="javascript">
	
function checkfield(type){
	
document.getElementById('alert_placeholder').style.display='inline';
  var menuid=document.forms[type]["obd_form_menuid"].value;
   var service_info=document.forms[type]["obd_form_service"].value;
  var upfile=document.forms[type]["upfile"].value;
  
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
 else if(upfile==null || upfile=="")
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
//$('#loading').show();
 return true;
}

$(".alert").alert();
$(".alert").alert('close');

bootstrap_alert = function() {}
bootstrap_alert.warning = function(message) {
            $('#alert_placeholder').html('<div class="alert"><a class="close" data-dismiss="alert">&times;</a><span>'+message+'</span></div>')
        }
    
	</script>
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
$getlivemenu='select menu_id,menu from USSD.tbl_ussd_config where level=0';
$result_livemenu = mysql_query($getlivemenu) or die(mysql_error());
?>
			  <select name="obd_form_menuid" id="obd_form_menuid">
				<option value="">Select Menu-ID</option>
				
<?php
while($data_livemenu = mysql_fetch_array($result_livemenu))
{ 
?>
<option value="<?php echo $data_livemenu[0];?>"><?php echo $data_livemenu[0];?></option>
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
                <td align="left" width="16%" height="32">
				<span>Browse File To Upload </span>
				</td>
				<td>
				<INPUT name="upfile" id='upfile' type="file" class="in">
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
<div class="alert alert-danger" style='display:none'></div>
<div id = "alert_placeholder"></div>
<div id="loading"><img src="../2.0/assets/img/loading-circle-48x48.gif" border="0" /></div> 
					
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
		$('#loading').show();
		$('#grid-view_upload_history').hide();
		$('#grid-view_upload_history').html('');
		$.fn.GetUploadHistory(a);
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
<!-- added for file uplaod using bootstarp api-->
</body>
</html>