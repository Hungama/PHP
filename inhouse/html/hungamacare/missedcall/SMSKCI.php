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
$circle_info = array( 'pan' => 'ALL','CHN' => 'Chennai', 'GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi');
$Priority = array('1'=>'1 (Lowest)','2'=>'2 (Lower)','3'=>'3 (Medium)','4'=>'4 (Higher)','5'=>'5 (Highest)');
//$Priority = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
$listservices=$_SESSION["access_service"];
$services = explode(",", $listservices);
$serviceKCIarray=array();
$f_array = array_flip($serviceArray);

if (isset($_REQUEST['sid']) and $_REQUEST['sid']!='') {
$sid=$_REQUEST['sid'];
} else {
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=SMSKCI.Services.php">';
  exit;
}


$checkforSMSKCI_MSGType="select S_id,msg_type,msg_desc,kci_type from Inhouse_IVR.tbl_smskci_serviceinfo where S_id='".$sid."' and status=1";
$sms_kci_MsgType = mysql_query($checkforSMSKCI_MSGType,$dbConn);

asort($circle_info);

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

<body onload="javascript:getMessage('hangup')">
<div class="container">
<?php
include "includes/menu.php";
?>
<div class="row">
	<div class="col-md-12"><h4><?php echo DICT_SMS_KCI_TITLE;?></h4></div>
</div>    
<div class="row">
	<div class="col-md-8">
	<h6>Add New SMS<small>&nbsp;&nbsp;<?php echo $f_array[$sid];?></small></h6>
	</div>
    <!--div class="col-md-4">
    	<div class="btn-group btn-group-xs pull-right">
  <button type="button" class="btn btn-info">Upload TSV</button>
  <button type="button" class="btn btn-success"><a href="download_tsv.php?S_id=<?=$sid?>">Download TSV</a></button>
</div><br/>
    </div-->
    </div>

<div class="row">
	<div class="col-md-12">
	<form id="form-SMS" name="form-SMS" method="post" enctype="multipart/form-data">
	  <table class="table table-bordered table-condensed">
	   

	   <tr>
	      <td align="left"><span>Type of KCI</span></td>
	      <td align="left" colspan="2">
		  <select name="msg_type" data-width="50%">
		   <option value="0" >Select KCI Type</option>
				<?php
				while($row=mysql_fetch_array($sms_kci_MsgType))
				{ 
				echo $dpvalue=trim($row['msg_type']).'|'.trim($row['kci_type']);
				echo "<option value=".$dpvalue.">".ucfirst($row['msg_type'])." ( ".$row['msg_desc']." ) "."</option>";
				}
				?>
	        	</select></td>
        </tr>
	       <tr>
                                <td align="left" width="16%" height="32"><span>Circle</span></td>
                                <td align="left" colspan="2"><select name="circle" data-width="auto">
                                        <option value="0">Select Circle</option>
                                        <?php foreach ($circle_info as $c_id => $c_val) {
                                            ?>
                                            <option value="<?php echo $c_id; ?>"><?php echo $c_val; ?></option>
                                        <?php } ?>
                                    </select></td>

                            </tr>
         <tr>
                                <td align="left" width="16%" height="32"><span>Priority</span></td>
                                <td align="left" colspan="2"><select name="priority" data-width="auto" >
                                        <option value="0">Select Priority</option>
                                        <?php foreach ($Priority as $prid=>$pvalue) {
										if($prid=='5') {$selected='selected';}
                                            ?>
                                            <option value="<?php echo $prid; ?>" <?php echo $selected;?>><?php echo $pvalue; ?></option>
                                        <?php } ?>
                                    </select></td>

                            </tr>
	    <tr>
	      <td>Message Text
            <br/><span id="counter">ss</span></td>
	      <td>
	        <textarea name="msg" rows="4" class="form-control input-sm" id="msg"></textarea>
      		</td>
            <td valign="middle">
			<input type='hidden' name='S_id' value=<?php echo $sid;?>>
			<button class="btn btn-primary" id="submit-SMS" type="button" class="" >Save</button>
			<!--button class="btn btn-primary" style="float:right">Submit</button-->
			<!--a href="javascript:;" class="btn btn-primary">Save!</a--></td>
        </tr>
	    <!-- date range section end here -->
      </table>
	  </form>
	</div>
<br/>
<div id="grid-SMS"></div>
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
            var msg_type=document.forms[type]["msg_type"].value;
            var circle=document.forms[type]["circle"].value;
			var msg=document.forms[type]["msg"].value;
             if (msg_type== '0') {
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
		 
		 var r = confirm("Do you want to delete this message?");
	if (r == true)
	{
  //processed request
   }
else
  {
  return false;
  }
			showMessageBox();		 
            var xmlhttp;
            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function() {
                 if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				var response=xmlhttp.responseText;
				if(response!='NOK')
				{
				  bootstrap_alert.warning('<?php echo 'Message has been deleted successfully.' ?>');
				  getMessage(response);
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