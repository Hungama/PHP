<?php
ob_start();
session_start();
ini_set('display_errors', '0');

include "includes/constants.php";
include "includes/language.php";

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.png">

    <title><?php echo DICT_MissedCall_Dashborad;?></title>
<?php
echo CONST_CSS;
?>
 <link rel="stylesheet" type="text/css" media="all" href="daterangepicker.css" />
     </head>

<body class="bg-primary">

    <div class="container">

      <div class="row login-form">
        <div class="col-xs-12">
		<a href="dashboard.php" class="btn btn-primary">Dashboard</a>&nbsp;<a href="userprofile.php" class="btn btn-primary">Profile Manager</a>&nbsp;<a href="campaignmanager.php" class="btn btn-primary">Campaign Manager</a> &nbsp;<a href="logout.php" class="btn btn-primary" style="float:right">Logout</a>
	<form id="form-SMS" name="form-SMS" method="post" enctype="multipart/form-data">
  <table class="table table-bordered table-condensed">
	 <tr>
	      <!--td align="left"><input type="text" name="date1" class="form-control login-field" value="" placeholder="Date1" id="date1"></td>
	      <td align="left"><input type="text" name="date2" class="form-control login-field" value="" placeholder="Date2" id="date2"></td-->
		  
		  <td>
		  
		  <fieldset>
                  <div class="control-group">
                     <div class="controls">
                     <div class="input-prepend">
				
					<span class="add-on"><i class="icon-calendar"></i>
					</span>
					<input type="text" class="form-control login-field" name="missed_date" id="missed_date" value="<?php echo date("m/d/Y");?> - <?php echo date("m/d/Y");?>" />
					
                     </div>
                    </div>
                  </div>
                 </fieldset>
		  </td>
		  <td align="left"><button class="btn btn-primary" id="submit-SMS" type="button" class="" >Submit</button></td>
        </tr>          
         </table>   
  </form>
  	   <div class="row">
         <div class="col-md-12">
             <div id="loading"><img src="<?php echo IMG_LOADING ;?>" border="0" /></div> 
         </div>
             
    </div>
		<div id="grid-SMS"></div>
			<div id="alert_placeholder"></div>
          </div>

	 <div class="row">
             <div class="col-md-12" id="grid">
             		
             </div>
        </div>	 
 
        
      </div>
	
    </div> <!-- /container -->


<?php
echo CONST_JS;
?>

</body>
<!-- data range picker start here -->
		
         <script type="text/javascript" src="date.js"></script>
		 <script type="text/javascript" src="daterangepicker.js"></script>
<!-- data range picker -->
     <script type="text/javascript">
               $(document).ready(function() {
          $('#missed_date').daterangepicker();	
               });
     </script>
<script>
$('#loading').hide();
$('#submit-SMS').on('click', function() {

	//	var isok = checkfield('form-SMS');
	var isok=1;
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
			$('#grid-SMS').hide();
			$('#grid-SMS').html('');
			$.ajax({
				url: 'snippets/viewhistory.php',
				data: $('#form-'+act).serialize() + '&action=data',
				type: 'post',
				cache: false,
				dataType: 'html',
				success: function (xhr) {//alert(xhr);
				document.getElementById('grid-SMS').style.display='inline';
				document.getElementById('grid-SMS').innerHTML=xhr;
			//	$('#grid').html(xhr);
				$('#loading').hide();
				//resestForm('SMS'); 
				//$.fn.AjaxAct(xhr, '');
				}
			
				
			});
			
		  
	};

	
</script>
</html>