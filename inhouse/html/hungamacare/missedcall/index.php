<?php
ob_start();
session_start();
session_destroy();
ini_set('display_errors', '0');

include "includes/constants.php";
include "includes/language.php";

$uid=date('YmdHis');
$_SESSION['suid']=$uid;

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
			 <?php echo (strlen($_GET['ERROR']) > 0 ? "<div class=\"alert alert-danger\">" . ErrorLogin($_GET['ERROR']) . "</div>" : "");?>
             </div>
          <div class="col-md-6">
	   <a href="javascript:void(0)" onclick="showViewConfirm()" id="edit_view_id" data-toggle="modal" data-target="#myModal" class="btn btn-primary" style="float:right">SignIn</a>
		  <h6>Step 1-</h6>
         <form id="form-step" name="form-step" method="post" enctype="multipart/form-data">
		 <div id="alert_placeholder"></div>
           <div class="control-group">
              <input type="text" name="firstname" class="form-control login-field" value="" placeholder="Enter your firstname" id="firstname">
          </div>
			<div class="control-group">
              <input type="text" name="lastname" class="form-control login-field" value="" placeholder="Enter your lastname" id="lastname">
              
            </div>
			<div class="control-group">
              <input type="text" name="email" class="form-control login-field" value="" placeholder="Enter your email" id="email">
              <label class="login-field-icon fui-user" for="login-name"></label>
            </div>
			<div class="control-group">
              <input type="password" name="password" class="form-control login-field" value="" placeholder="Enter your password" id="password">
             <label class="login-field-icon fui-lock" for="login-pass"></label>
            </div>
			<div class="control-group">
              <input type="text" name="city" class="form-control login-field" value="" placeholder="Enter your city" id="city">
              
            </div>
			<div class="control-group">
              <input type="text" name="company" class="form-control login-field" value="" placeholder="Enter your company name" id="company">
              
            </div>
			<div class="control-group">
              <input type="text" name="noofemployee" class="form-control login-field" value="" placeholder="Enter no of employees" id="noofemployee">
              </div>
			<div class="control-group">
              <input type="text" name="website" class="form-control login-field" value="" placeholder="Enter your website" id="website">
              
            </div>
			<div class="control-group">
              <input type="text" name="coupan_code" class="form-control login-field" value="" placeholder="Enter your coupon code" id="coupan_code">
              </div>
			  <div class="control-group">
              <input type="text" name="campaign_name" class="form-control login-field" value="" placeholder="Enter your campaign name" id="campaign_name">
              </div>
			   <div class="control-group">
              <input type="text" name="mobile_no" class="form-control login-field" value="" placeholder="Enter your mobile no" id="mobile_no">
              </div>
            <!--button class="btn btn-primary btn-large btn-block" type="submit">
			<a class="login-link" href="index_step2.php">Next</a>
			</button-->
			
			<div class="col-md-3" style="float:right">
          <!--a href="index_step2.php" class="btn btn-block btn-lg btn-primary">Next</a-->
			<input type='hidden' name='uid' value=<?php echo $_SESSION['suid'];?>>
			<button class="btn btn-primary" id="submit-step" type="button" style="float:right">Next</button>
        </div>
             </form>
			  <div id="grid-step"></div>
			
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
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div style="width:900px" class="modal-dialog">
                                        <div class="modal-content" id="modal_content">
                                            
                                        </div>
                                    </div>
                                </div>

<?php
echo CONST_JS;
?>
</body>
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
window.location.href='index_step2.php';
					}
}

$('#loading').hide();
	$('#submit-step').on('click', function() {

	var isok = checkfield('form-step');
	//var isok=1;
		if(isok)
			{
			$.fn.SubmitForm('step');
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
				data: $('#form-'+act).serialize() + '&action=step1',
				type: 'post',
				cache: false,
				dataType: 'html',
				success: function (xhr) {
					$('#loading').hide();
				if(xhr=='NOK1')
				{
				document.getElementById('alert_placeholder').style.display='inline';
				document.getElementById('alert_placeholder').innerHTML='<div width="85%" align="left" class="txt"><div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a>Email already exist.</div></div>';
			//	resestForm('step'); 
				}
				else
				{
				$.fn.AjaxAct(xhr, '');
				}
				
				}
			
				
			});
};



        function checkfield(type) { 
            $('#loading').hide();
            document.getElementById('alert_placeholder').style.display='inline';
            var firstname=document.forms[type]["firstname"].value;
            var lastname=document.forms[type]["lastname"].value;
			var email=document.forms[type]["email"].value;
			var password=document.forms[type]["password"].value;
			var campaign_name=document.forms[type]["campaign_name"].value;
			var mobile_no=document.forms[type]["mobile_no"].value;

		     if (firstname== '') {
                bootstrap_alert.warning('<?php echo 'Please enter firstname.' ?>');
                return false;
            } 
		     else if (lastname== '') {
                bootstrap_alert.warning('<?php echo 'Please enter lastname.' ?>');
                return false;
            } 
			 else if (email== '') {
                bootstrap_alert.warning('<?php echo 'Please enter email.' ?>');
                return false;
            }
			 else if (password== '') {
                bootstrap_alert.warning('<?php echo 'Please enter password.' ?>');
                return false;
            }
			 else if (campaign_name== '') {
                bootstrap_alert.warning('<?php echo 'Please enter campaign name.' ?>');
                return false;
            }
			 else if (mobile_no== '') {
                bootstrap_alert.warning('<?php echo 'Please enter mobile no.' ?>');
                return false;
            }
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
		
		         function showViewConfirm(id){ 
                $('#loading').show();
                $.ajax({
	     
                    url: 'viewsignin.php',
                    data: 'rule_id='+id,
                    type: 'get',
                    cache: false,
                    dataType: 'html',
                    success: function (abc) {
                        $('#modal_content').html(abc);
                        $('#loading').hide();
                    }
						
                });
						
                $('#modal_content').show();
            }
			  function doLogin(id){ 
                var isok = checkEditfield('form-edit');
                if(isok)
                {
                    $('#loading').show();
                    var formData = new FormData($("form#form-edit")[0]);
                    $.ajax({
                        url: 'rule_edit_process.php',
                        type: 'POST',
                        data: formData,
                        async: false,
                        success: function (data) {
                            alert('Rule has been updated successfully');                            
                            reloadPage();
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
            }
		</script>
</html>
<?php
function ErrorLogin($Code)
{

    switch ($Code) {
        case "999":
            return "You seem to have tried an invalid email/password combination";
            break;

        case "0":
            return "Your account is locked, please contact administrator";
            break;
        case "500":
            return "You have been successfully signed out";
            break;
		case "998":
            return "Email/password combination can not be left blank.";
            break;
        default:
            return "Unknown Error. (Error Code: " . $Code . ")";

    }

}

?>