<?php
ob_start();
session_start();
ini_set('display_errors', '0');
$PAGE_TAG = 'sms-kci';
include "includes/constants.php";
include "includes/language.php";
$user_id=$_SESSION['usrId'];
$SKIP=1;
require_once("../2.0/incs/common.php");
require_once("../2.0/incs/db.php");
require_once("../2.0/language.php");
require_once("../2.0/base.php");
//get all service that need to configure start here
$listservices=$_SESSION["access_service"];
$services = explode(",", $listservices);
$serviceKCIarray=array();
$checkforSMSKCI="select service_id from master_db.tbl_interface_type_master where value='SMS_KCI'";
$total_service = mysql_query($checkforSMSKCI,$dbConn);
$sms_kci_services= mysql_fetch_array($total_service);
$AllServices = explode(",", $sms_kci_services['service_id']);
$f_array = array_flip($serviceArray);	

foreach ($AllServices as $k) {
	$S_Name=$f_array[$k];
	if(in_array($S_Name,$services)) {
				$serviceKCIarray[$k] = $Service_DESC[$S_Name]['Name'];
			}
		}
asort($serviceKCIarray);
//get all service that need to configure end here

$circle_info = array( 'pan' => 'ALL','CHN' => 'Chennai', 'GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi');
$Priority = array('1','2','3','4','5');
$kcitype = array( 'hangup'=>'CallHangUp','SUB'=>'Subscription','UNSUB'=>'UnSubscription','RESUB'=>'RESUB','TOPUP'=>'TOPUP');
asort($circle_info);
/*
if (isset($_REQUEST['sid']) and $_REQUEST['sid']!='') {
$sid=$_REQUEST['sid'];
} else {
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=SMSKCI.Services.php">';
  exit;
}
*/
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.png">
<title><?php echo DICT_SMS_KCI_TITLE;?></title>
<?php
echo CONST_CSS;
echo EDITINPLACE_CSS;
?>

</head>

<body>
<div class="container">
<?php
include "includes/menu.php";
?>
<div class="row">
	<div class="col-md-12"><h4><?php echo DICT_SMS_KCI_TITLE;?></h4></div>
</div>    
<div class="row">
	<div class="col-md-8">
	<h6>Add New SMS Keyword<small>&nbsp;&nbsp;</small></h6>
	</div>
    <div class="col-md-4">
    	<!--div class="btn-group btn-group-xs pull-right">
  <button type="button" class="btn btn-info">Upload TSV</button>
  <button type="button" class="btn btn-success">Download TSV</button>
</div--><br/>
    </div>
    </div>

<div class="row">
	<div class="col-md-12">
	<form id="form-SMS" name="form-SMS" method="post" enctype="multipart/form-data">
	  <table class="table table-bordered table-condensed">
	  <tr>
                                <td align="left" width="16%" height="32"><span>Service</span></td>
                                <td align="left" colspan="2"><select name="service_info" data-width="auto">
                                        <option value="0">Select Service</option>
                                        <?php foreach ($serviceKCIarray as $s_id => $s_val) {
                                            ?>
                                            <option value="<?php echo $s_id; ?>"><?php echo $s_val; ?></option>
                                        <?php } ?>
                                    </select></td>

         </tr>
		
	       <tr>
                                <td align="left" width="16%" height="32"><span>KCI Type</span></td>
                                <td align="left" colspan="2"><select name="kcitype" data-width="auto">
                                        <option value="0">Select Type</option>
                                        <?php foreach ($kcitype as $k_id => $k_val) {
                                            ?>
                                            <option value="<?php echo $k_id; ?>"><?php echo $k_val; ?></option>
                                        <?php } ?>
                                    </select></td>

                            </tr>
          <tr>
	      <td align="left"><span>Msg Type</span></td>
	      <td align="left" colspan="2">
		  <div class="row">
		<div class="col-md-3">
        	<div class="form-group">
	        	<input type="text" value="" name="msg_type" placeholder="Msg Type" class="form-control">
        	</div>          
        </div>
		</div>
		</tr>
	    <tr>
	      <td>Message Description
            <br/><span id="counter">ss</span></td>
	      <td>
	        <textarea name="msg_desc" rows="4" class="form-control input-sm" id="msg_desc"></textarea>
      		</td>
            <td valign="middle">
			<button class="btn btn-primary" style="float:right">Submit</button>
			
        </tr>
	    <!-- date range section end here -->
      </table>
	  </form>
	</div>
<br/>
<div id="grid-SMS"></div>
 <div id = "alert_placeholder"></div>
</div> 
<br/>
    <div class="row">
         <div class="col-md-12">
             <div id="loading" style='display:none'><img src="<?php echo IMG_LOADING ;?>" border="0" /></div> 
         </div>
             
    </div>   
        <div class="row">
             <div class="col-md-12" id="grid">
             		
             </div>
        </div>
    </div>  

</div>  
   
<?php
echo CONST_JS;
echo EDITINPLACE_JS;
?>
<script>
(function($) {
    $.fn.extend( {
        limiter: function(limit, elem) {
            $(this).on("keyup focus", function() {
                setCount(this, elem);
            });
            function setCount(src, elem) {
                var chars = src.value.length;
                if (chars > limit) {
                    src.value = src.value.substr(0, limit);
                    chars = limit;
                }
                elem.html( (limit - chars)+' characters left' );
            }
            setCount($(this)[0], elem);
        }
    });
})(jQuery);


$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  		var parts = decodeURI(e.target).split('#');
		$.fn.AjaxAct(parts[1],'');
});
function viewMSGhistory(a) {
	document.getElementById('loading_sms').style.display='none';
	//$('#grid-SMS').hide();
	//$('#grid-SMS').html('');
	};
$.fn.AjaxAct = function(act,xhr) {
		if(!xhr) {
						$('#loading').show();
						$('#grid').html('');	

					}
		
		$.ajax({
						url: 'snippets/viewhistory.php',
						data: '&type='+act+'&S_id='+'<?=$sid?>',
						type: 'post',
						cache: false,
						dataType: 'html',
						success: function (abc) {
							$('#grid').html(abc);
						}
						
					});
					
					
					$('#loading').hide();
					$('#grid').show();
	
};

$(document).ready(function() {
    if (location.hash !== '') $('a[href="' + location.hash + '"]').tab('show');
    return $('a[data-toggle="tab"]').on('shown', function(e) {
      return location.hash = $(e.target).attr('href').substr(1);
	  								});
});
//post message data start here
function resestForm(type)
{
	var formname='form-'+type;
	document.getElementById(formname).reset();
}

$("form#form-SMS").submit(function(){
//var isok = checkfield('form-SMS');
if(1)
{
 $('#loading_sms').show();
	var formData = new FormData($("form#form-SMS")[0]);
    $.ajax({
        url: 'snippets/sms_keyword_process.php',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
	document.getElementById('grid-SMS').style.display='inline';
	document.getElementById('grid-SMS').innerHTML=data;
//	document.getElementById('loading_sms').style.display='none';
	resestForm('SMS');   //
	//$('#loading_sms').hide();
	$('#loading').hide();
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




        function checkfield(type) { 
            $('#loading').hide();
            document.getElementById('alert_placeholder').style.display='inline';
            var msg_type=document.forms[type]["msg_type"].value;
            var circle=document.forms[type]["circle"].value;
			var msg=document.forms[type]["msg"].value;
             if (msg_type== '') {
                bootstrap_alert.warning('<?php echo 'Please select message type.' ?>');
                return false;
            } 
			else if(circle=='' || circle == '0')
            {   
                bootstrap_alert.warning('<?php echo 'Please select circle'; ?>');
                return false;
            }
			else if (msg=="") {
                bootstrap_alert.warning('<?php echo 'Please eneter message.'; ?>');
                return false;
            }            
          //  $('#loading').show();
            hideMessageBox();
            //return false;
            return true;
        }
        bootstrap_alert = function() {}
        bootstrap_alert.warning = function(message) {
            $('#alert_placeholder').html('<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a><span>'+message+'</span></div>')
        }
        function hideMessageBox() {
          //  document.getElementById('error_box').style.display='none';
            document.getElementById('alert_placeholder').style.display='none';
        }

        function showMessageBox() {
            //document.getElementById('error_box').style.display='inline';
            document.getElementById('alert_placeholder').style.display='inline';
        }
		
		
		 function deleteMsg(msg_id) { 
            var xmlhttp;
            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				if(xmlhttp.responseText=='OK')
				{
                  //document.forms["form-active"]["scenarios"].innerHTML=xmlhttp.responseText;
				  bootstrap_alert.warning('<?php echo 'Message has been deleted successfully.' ?>');
				  }
				  else
				  {
				  bootstrap_alert.warning('<?php echo 'Server Error. Please try again.' ?>');
				  }
                }
            }	
            var url="snippets/deleteMesaage.php?msg_id="+msg_id;
            xmlhttp.open("GET",url,true);
            xmlhttp.send();	
        }
//post message data end here
var elem = $("#counter");
$("#msg").limiter(160, elem);
</script>
</body>
</html>
<?php
mysql_close($dbConn);
?>