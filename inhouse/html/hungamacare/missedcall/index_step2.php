<?php
ob_start();
session_start();
ini_set('display_errors', '0');

include "includes/constants.php";
include "includes/language.php";
//print_r ($_SESSION);
//echo $_SESSION['suid']."#".$_SESSION['cpgid'];

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.png">

    <title><?php echo DICT_MissedCall_Campgion;?></title>
<?php
echo CONST_CSS;
?>
 <script language="javascript" type="text/javascript" src="http://stuff.w3shaman.com/jquery-plugins/js/jquery.js"></script>
  <script language="javascript" type="text/javascript" src="http://stuff.w3shaman.com/jquery-plugins/auto-suggest/js/jquery.suggestion.js"></script>
  <link rel="stylesheet" type="text/css" href="http://stuff.w3shaman.com/jquery-plugins/auto-suggest/css/styles.css" />
     </head>

<body class="bg-primary">

    <div class="container">

      <div class="row login-form">
        <div class="col-xs-12">
          <div class="col-md-6">
            <img src="images/icon-login.png" alt="<?php echo DICT_INDEX_PAGE;?>">
             </div>

          <div class="col-md-6">
		  <h6>Step 2-</h6>
             <form id="form-step2" name="form-step2" method="post" enctype="multipart/form-data">
           <div class="control-group">
		   
              <input type="text" name="realdnis" class="form-control login-field" placeholder="Select a number (66xxxxxxx)" value="" id="realdnis">
          </div>
			<div class="col-md-3" style="float:right">
          	<input type='hidden' name='uid' value=<?php echo $_SESSION['suid'];?>>
			<button class="btn btn-primary" id="submit-step2" type="button" class="" style="float:right">Next</button>
        </div>
             </form>
			   <div id="grid-step2"></div>
			<div id="alert_placeholder"></div>

          </div>
        </div>
      </div>
	    <div class="row">
         <div class="col-md-12">
             <div id="loading"><img src="<?php echo IMG_LOADING ;?>" border="0" /></div> 
         </div>
             
    </div>
	 <div class="row">
             <div class="col-md-12" id="grid">
             		
             </div>
        </div>
    </div> <!-- /container -->

  <script language="javascript" type="text/javascript">
	$("#realdnis").suggestion({
	  url:"data.php?chars=",
	   minChars:1,
	   width:250
	});
      </script>
<?php
echo CONST_JS;
?>
<script>
//post message data start here
function resestForm(type)
{
	var formname='form-'+type;
	document.getElementById(formname).reset();
}
$.fn.AjaxAct = function(act,xhr) {
if(!xhr) {
						$('#loading').show();
						//$('#grid').html('');	
						//$('#grid').show();
window.location.href='index_step3.php';
					}
}

$('#loading').hide();
	$('#submit-step2').on('click', function() {

	//	var isok = checkfield('form-step2');
	var isok=1;
		if(isok)
			{
			$.fn.SubmitForm('step2');
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
				url: 'snippets/step_process.php',
				data: $('#form-'+act).serialize() + '&action=step2',
				type: 'post',
				cache: false,
				dataType: 'html',
				success: function (xhr) {
				$('#loading').hide();
				//resestForm('step2'); 
				$.fn.AjaxAct(xhr, '');
				}
			
				
			});
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
             document.getElementById('alert_placeholder').style.display='none';
        }

        function showMessageBox() {
                 document.getElementById('alert_placeholder').style.display='inline';
        }
		</script>
</body>
</html>