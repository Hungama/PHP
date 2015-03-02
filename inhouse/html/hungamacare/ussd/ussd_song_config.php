<?php
ob_start();
session_start();
$SKIP=1;
ini_set('display_errors','0');
include("db.php");
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
$('#loading').hide();
document.getElementById('alert_placeholder').style.display='inline';
  var song1=document.forms[type]["form_songname_1"].value;
  var song2=document.forms[type]["form_songname_2"].value;
  var song3=document.forms[type]["form_songname_3"].value;
   
   var song_ttid1=document.forms[type]["form_truetoneid_1"].value;
  var song_ttid2=document.forms[type]["form_truetoneid_2"].value;
  var song_ttid3=document.forms[type]["form_truetoneid_3"].value;
  var song_categoryname=document.forms[type]["form_song_categoryname"].value;
  var song_menuid=document.forms[type]["menu_id"].value;
  
if (song_categoryname==null || song_categoryname=="")
  {
  bootstrap_alert.warning('Please enter song category.');
  document.forms[type]["form_song_categoryname"].focus();
  return false;
  }
else if (song_menuid==null || song_menuid=="")
  {
  bootstrap_alert.warning('Please select menuid.');
  document.forms[type]["menu_id"].focus();
  return false;
  }  
else if (song1==null || song1=="")
  {
  bootstrap_alert.warning('Please enter first song name.');
  document.forms[type]["form_songname_1"].focus();
  return false;
  }
  else if (song_ttid1==null || song_ttid1=="")
  {
  bootstrap_alert.warning('Please enter first true tone id.');
  document.forms[type]["form_truetoneid_1"].focus();
  return false;
  } 
else if(song2==null || song2=="")
  {
  bootstrap_alert.warning('Please enter second song name.');
  document.forms[type]["form_songname_2"].focus();
  return false;
  }
 else if (song_ttid2==null || song_ttid2=="")
  {
  bootstrap_alert.warning('Please enter second true tone id.');
  document.forms[type]["form_truetoneid_2"].focus();
  return false;
  }
else if (song3==null || song3=="")
  {
  bootstrap_alert.warning('Please enter third song name.');
  document.forms[type]["form_songname_3"].focus();
  return false;
  }
    else if (song_ttid3==null || song_ttid3=="")
  {
  bootstrap_alert.warning('Please enter third true tone id.');
  document.forms[type]["form_truetoneid_3"].focus();
  return false;
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
</script>
	  	
			
		
	<!-- end here -->
	<!-- Bootstrap CSS Toolkit styles -->
</head>

<body onload="viewUploadhistory('ussd')">

<div class="navbar navbar-inner">
<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
</div>

<div class="container">
<div class="row">

<div class="page-header">
  <h1>Configure the Main Menu (Song list) on USSD<small>&nbsp;&nbsp;</small></h1>
 </div>
<div class="tab-pane active" id="pills-basic">
							<div class="tabbable">
							  <ul class="nav nav-pills">
							  <li class="active"><a href="#active" data-toggle="tab" data-act="activation" onclick="viewUploadhistory('ussd')">USSD</a></li>
						   </ul>
							  <div class="tab-content">
							    <div id="active" class="tab-pane active">
                                 	<form id="form-active" name="form-active" method="post" enctype="multipart/form-data">
									<table class="table table-bordered table-condensed">
		<tr><td>Song Category</td><td colspan="2"><input type="text" name="form_song_categoryname" id="form_song_categoryname" value=""/></td></tr>
		<tr><td>Menu ID</td><td colspan="2">
		<select id="menu_id" name="menu_id">
		<option value="">Select menu id</option>
		<option value="1">1</option>
		<option value="2">2</option>
		</select>
		</td></tr>
		<tr><td>1<input type="hidden" name="form_songname_1_id" id="form_songname_1_id" value="1"/></td>
      <td align="left">Song Name: <input type="text" class="text" name="form_songname_1" id="form_songname_1" value=""/></td>
		<td align="left">True Tone ID: <input type="text" class="text" name="form_truetoneid_1" id="form_truetoneid_1" value=""/></td>
                </tr>
				<tr><td>2<input type="hidden" name="form_songname_2_id" id="form_songname_2_id" value="2"/></td>
      <td  align="left">Song Name: <input type="text" class="text" name="form_songname_2" id="form_songname_2" value=""/></td>
		<td  align="left">True Tone ID: <input type="text" class="text" name="form_truetoneid_2" id="form_truetoneid_2" value=""/></td>
                </tr>
				<tr><td>3<input type="hidden" name="form_songname_3_id" id="form_songname_3_id" value="3"/></td>
      <td align="left">Song Name: <input type="text" class="text" name="form_songname_3" id="form_songname_3" value=""/></td>
		<td align="left">True Tone ID: <input type="text" class="text" name="form_truetoneid_3" id="form_truetoneid_3" value=""/></td>
                </tr>
		
		<tr>
 		<td colspan="3">
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
<script src="assets/js/jquery.pageslide.js"></script>

  <script>

$('#loading').hide();
	$('#grid-active').hide();
	$('#grid-active').html('');
	function viewUploadhistory(a) {
	document.getElementById('alert_placeholder').style.display='none';
		$('#loading').hide();
		$('#grid-view_upload_history').hide();
		$('#grid-view_upload_history').html('');
		$.fn.GetUploadHistory(a);
	};
	
	
$.fn.GetUploadHistory = function(type) {
//$('#loading').show();
		$.ajax({
	     
					    url: 'viewsongconfighistory.php',
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
 var formData = new FormData($("form#form-active")[0]);
    $.ajax({
        url: 'ussd_song_config_process.php',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
   	document.getElementById('grid-active').style.display='inline';
	document.getElementById('grid-active').innerHTML=data;
	document.getElementById('form-active').reset();
	viewUploadhistory('ussd');
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
</body>
</html>