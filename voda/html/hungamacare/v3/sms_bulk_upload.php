<?php
ob_start();
session_start();
ini_set('display_errors', '0');
$PAGE_TAG = 'sms-kci';
include "includes/constants.php";
include "includes/language.php";
$user_id=$_SESSION['usrId'];
$loginid = $_SESSION['loginId'];
if ($loginid == '') {
    Header("location:login.php?ERROR=500");
}

$SKIP=1;
require_once("../2.0/incs/common.php");
require_once("../2.0/incs/db.php");
require_once("../2.0/language.php");
require_once("../2.0/base.php");
$circle_info = array( 'pan' => 'ALL','APD'=>'Andhra Pradesh','CHN' => 'Chennai', 'GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi');
$Priority = array('1'=>'1 (Lowest)','2'=>'2 (Lower)','3'=>'3 (Medium)','4'=>'4 (Higher)','5'=>'5 (Highest)');
//$Priority = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
$listservices=$_SESSION["access_service"];
$services = explode(",", $listservices);
$serviceKCIarray=array();
$f_array = array_flip($serviceArray);
$flag=0;
$_SESSION['authid']='true';


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
$timeFrom = mktime(8,10,0);
$timeTo = mktime(19,40,0);
$currTime = mktime(date('H'),date('i'),date('s'));
 if(!isset($scheduleDate)) {
    $scheduleDate = date("Y-m-d",(time()-3600*24*22));
}
$preDate= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
asort($circle_info);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.png">
<title><?php echo 'SMS-Bulk Upload';?></title>
<?php
echo CONST_CSS;
echo EDITINPLACE_CSS;
?>
<link href="http://119.82.69.212/kmis/services/hungamacare/2.0/bootstrap-datetimepicker-0.0.11/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<script src="http://119.82.69.212/kmis/services/hungamacare/2.0/bootstrap-datetimepicker-0.0.11/js/bootstrap-datetimepicker.min.js"></script>
</head>

<body onload="javascript:getMessage('hangup')">
<div class="container">
<?php
include "includes/menu.php";
?>
<div class="row">
	<div class="col-md-12"><h4><?php echo 'SMS-Bulk Upload';?></h4></div>
</div>    
<div class="row">
	<div class="col-md-8">
	<!--h6>Add New SMS<small>&nbsp;&nbsp;</small></h6-->
	</div>

    </div>

<div class="row">
	<div class="col-md-12">
	<form id="form-active" name="form-active" method="post" enctype="multipart/form-data">
					<table class="table table-bordered table-condensed">
					<tr>
						<td align="left" width="16%" height="32"><span>Service&nbsp;</span></td>
						<td><select name="service_info" id="service_info" onchange="javascript:getSMSCli(this.value)" data-width="30%">
								<option value="0">Select Service</option>
								<?php foreach($serviceSMSarray as $s_id=>$s_val) { ?>
									<option value="<?php echo $s_id;?>"><?php echo $s_val;?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
				<tr>
						<td align="left" width="16%" height="32"><span>SMS CLI&nbsp;</span></td>
						<td>
					
					  <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
					<input type='text' name='smscli' id="smscli" value="" class="form-control" readonly >
					  </div>          
                                                        </div>
                                                    </div>
						</td>
					</tr>
					  <tr>
                                                <td align="left" width="16%" height="32">DND scrubbing</td>
                                                <td>
												  <!--input type="radio"  name="dnd_scrubbing" value="1" checked="checked"/>&nbsp; Yes &nbsp;&nbsp;&nbsp;
                                                    <input type="radio"  name="dnd_scrubbing" value="0"/>&nbsp; No &nbsp;&nbsp;&nbsp;-->
                                                
												  <label class="radio">
       <input type="radio"  name="dnd_scrubbing" value="1" data-toggle="radio" checked />&nbsp; Yes &nbsp;&nbsp;&nbsp;
                                                    </label><label class="radio">
       <input type="radio"  name="dnd_scrubbing" value="0" data-toggle="radio" checked />&nbsp; No &nbsp;&nbsp;&nbsp;
                                                    </label>
												</td>
												</tr>
						<tr>
						<td align="left" width="16%" height="32"><span>Schedule Date&nbsp;</span></td>
						<td>
					 <!--input type="text" value="" name="dpd1" id="dpd1" placeholder="Click to set date">(mm/dd/yyyy)-->
 <div id="dpd2" class="input-append date">
    <input data-format="yyyy-MM-dd hh:mm:00" type="text" name="dpd2" value="" placeholder="Click on icon to set date"></input>
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
</div>

						</td>
					</tr>
				<tr>
						<td width="16%" height="32" align="left">Message
						 <br/><span id="counter">ss</span>
						</td>
						<td>
						<textarea cols="40" rows="4" maxlength="400" name="message" class="form-control input-sm" id="message"></textarea>
						
						  
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
	</div>
<br/>
<div id="grid-active"></div>
 <div id = "alert_placeholder"></div>
</div>

<div id="loading_sms"><img src="<?php echo IMG_LOADING ;?>" border="0" /></div> 
	
<div  class="row"><div class="col-md-12">
	<ul id="myTab" class="nav nav-pills">
       <!--li class="active"><a href="#KCI" data-toggle="tab">KCI's</a></li-->
	   <li class="active"><a href="#hangup" data-toggle="tab">Call Hangup</a></li>
	   <li class=""><a href="#SUB" data-toggle="tab">Subscription</a></li>
	   <li class=""><a href="#UNSUB" data-toggle="tab">UnSubscription</a></li>
	   <li class=""><a href="#RESUB" data-toggle="tab">Renewal</a></li>
	   <li class=""><a href="#TOPUP" data-toggle="tab">TopUp</a></li>
	   
       <!-- Expand this to include Other types as well if there are -->
     </ul>
</div></div>

<div id="myTabContent" class="tab-content">
       
         <div id="KCI" class="tab-pane fade active in">
         </div>
         
         <div id="hangup" class="tab-pane fade">
		  </div>				 

         <div id="Footer" class="tab-pane fade">
		  </div>				 

</div>
<br/>
    <div class="row">
         <div class="col-md-12">
             <div id="loading"><img src="<?php echo IMG_LOADING ;?>" border="0" /></div> 
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

  $(function($) {
    $('#dpd2').datetimepicker({
      language: 'pt-BR'
    });
	
  });

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  		var parts = decodeURI(e.target).split('#');
		$.fn.AjaxAct(parts[1],'');
});
function getMessage(type)
{
$.fn.AjaxAct(type,'');
}
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
							$('#loading').hide();
						}
						
					});
					
					
					$('#grid').show();
	
};
$('#loading_sms').hide();
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

	$('#submit-SMS').on('click', function() {

		var isok = checkfield('form-SMS');
		if(isok)
			{
			$.fn.SubmitForm('SMS');
			}
		else
	{
	return false;
	}
		
	});
	
	$.fn.SubmitForm = function(act) {
			$('#loading').show();
			$('#alert-success').hide();
			$('#grid').hide();
			$('#grid').html('');
			$.ajax({
				url: 'snippets/sms_process.php',
				data: $('#form-'+act).serialize() + '&action=save',
				type: 'post',
				cache: false,
				dataType: 'html',
				success: function (xhr) {
				document.getElementById('grid-SMS').style.display='inline';
				document.getElementById('grid-SMS').innerHTML='<div width="85%" align="left" class="txt"><div class="alert alert-success"><a class="close" data-dismiss="alert">&times;</a>Message has been saved successfully</div></div>';
				$('#loading').hide();
				resestForm('SMS'); 
				$.fn.AjaxAct(xhr, '');
				}
			
				
			});
			
		  //alert($('#form-'+act).serialize());
		
		
		
	};



	
function checkfield(type) {
	$('#loading').hide();
	document.getElementById('alert_placeholder').style.display='inline';
	
	var upfile=document.forms[type]["upfile"].value;
	var message=document.forms[type]["message"].value;
	var service_info=document.forms[type]["service_info"].value;
	if (service_info==0) {
		 bootstrap_alert.warning('<?php echo JS_NOSERVICESELECTED;?>');
		 return false;
	} 
	
	else if (message==null || message=="") {
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
    function getSMSCli(sid)
	{
	if(sid=="1002")
	{
	document.forms['form-active']["smscli"].value='HUNVOC';
	}
	else if(sid=="1402")
	{
	document.forms['form-active']["smscli"].value='54646';
	}
	else if(sid=="1423")
	{
	document.forms['form-active']["smscli"].value='52000';
	}
	else
	{
	document.forms['form-active']["smscli"].value='NA';
	}

	}
	
//post message data end here
var elem = $("#counter");
$("#message").limiter(160, elem);
</script>
 
</body>
</html>
<?php
mysql_close($dbConn);
?>