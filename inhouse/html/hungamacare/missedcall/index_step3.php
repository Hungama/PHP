<?php
ob_start();
session_start();
ini_set('display_errors', '0');

include "includes/constants.php";
include "includes/language.php";
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

     </head>

<body class="bg-primary">

    <div class="container">

      <div class="row login-form">
        <div class="col-xs-12">
          <div class="col-md-6">
            <img src="images/icon-login.png" alt="<?php echo DICT_INDEX_PAGE;?>">
             </div>

          <div class="col-md-6">
		  <h6>Step 3-</h6>
            <form id="form-step3" name="form-step3" method="post" enctype="multipart/form-data">
		   Send an sms when somebody gives a missed call.
           <div class="control-group">
		   <br/><span id="counter">160</span>
		   SMS  <textarea name="missedcall_msg" rows="4" class="form-control input-sm"  id="missedcall_msg"></textarea>
          </div>
			 <!--button class="btn btn-primary btn-large btn-block" type="submit">
			 <a class="login-link" href="index_step4.php">Next</a></button-->
			 
			 <div class="col-md-3" style="float:right">
          <!--a href="index_step4.php" class="btn btn-block btn-lg btn-primary">Next</a-->
		  <input type='hidden' name='uid' value=<?php echo $_SESSION['suid'];?>>
			<button class="btn btn-primary" id="submit-step3" type="button" class="" >Next</button>
        </div>
             </form>
			  <div id="grid-step3"></div>
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


<?php
echo CONST_JS;
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
var elem = $("#counter");
$("#missedcall_msg").limiter(160, elem);
</script>
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
window.location.href='index_step4.php';
					}
}

$('#loading').hide();
	$('#submit-step3').on('click', function() {

	//	var isok = checkfield('form-step3');
	var isok=1;
		if(isok)
			{
			$.fn.SubmitForm('step3');
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
				data: $('#form-'+act).serialize() + '&action=step3',
				type: 'post',
				cache: false,
				dataType: 'html',
				success: function (xhr) {
				//document.getElementById('grid-step3').style.display='inline';
				//document.getElementById('grid-step3').innerHTML='<div width="85%" align="left" class="txt"><div class="alert alert-success"><a class="close" data-dismiss="alert">&times;</a>'+xhr+'</div></div>';
				$('#loading').hide();
				//resestForm('step3'); 
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
