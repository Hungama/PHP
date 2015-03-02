<?php
ob_start();
session_start();
ini_set('display_errors', '0');
$PAGE_TAG = 'sms-kci';
include "includes/constants.php";
include "includes/language.php";
$user_id=$_SESSION['usrId'];
$SKIP=1;
//ini_set('display_errors','0');
//$PAGE_TAG = 'sms-kci';
//include "includes/constants.php";
//include "includes/language.php";
require_once("../2.0/incs/common.php");
require_once("../2.0/incs/db.php");
require_once("../2.0/language.php");
require_once("../2.0/base.php");
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
//		print_r ($serviceKCIarray);
asort($serviceKCIarray);
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
	<div class="col-md-12"><h4>
	<?php echo DICT_SMS_KCI_TITLE;?></h4></div>
</div>    
<div class="row">
	<div class="col-md-8">
	<!--h6>Add New SMS</h6-->
	  <h6>My Services<small>&nbsp;&nbsp;manage your KCI's</small></h6>

	</div>
    <div class="col-md-4">
  <br/>
    </div>
    </div>

<div class="row">
	<div class="col-md-12">
	   <table class="table table-bordered">

								 <tr> <?php
							 $i=-1;
							foreach($serviceKCIarray as $RSelected=>$s_val) {
								//echo $s_val;
								if(1) {
									 $i++; 
								 

								 if($i%3==0 && $i !=0) {
									 echo "</tr><tr>";
								 }
									 ?> 
                                 <td><span class="label"><?php echo $i+1;?></span>
 <a href="SMSKCI.php?sid=<?= $RSelected;?>" data-toggle='modal' data-title="<?php echo $RSelected;?>" data-service="<?php echo $RSelected;?>"><?php echo $s_val;?></a>
                                 </td>
                                 
                                 
								   <?php }
									}
								   
								   for($k=1;$k<(3-$i%3);$k++) {
									   
									   echo "<td>&nbsp;</td>";
								   }
								    ?>
                                  </tr>
                                  </table>
	  <!--table class="table table-bordered table-condensed">
	    <tr>
	      <td align="left"><span>Type of KCI</span></td>
	      <td align="left" colspan="2"><select name="Tbl" id="Tbl" data-width="auto">
	        	<option>Type1</option>
	        	<option>Type2</option>
	        	<option>Type3</option>
	        	<option>Type4</option>
	        	<option>Type5</option>
	        </select></td>
        </tr>
	    
        
	    <tr>
	      <td>Message Text
            <br/><span id="counter">ss</span></td>
	      <td>
	        <textarea name="msg" rows="4" class="form-control input-sm" id="msg"></textarea>
      		</td>
            <td valign="middle"><a href="javascript:;" class="btn btn-primary">Save!</a></td>
        </tr>
	    
      </table-->
	</div>
<br/>
</div> 

   
<!--div  class="row"><div class="col-md-12">
	<ul id="myTab" class="nav nav-pills">
       <li class="active"><a href="#SMS" data-toggle="tab">KCI's</a></li>
	   <li class=""><a href="#CallHangups" data-toggle="tab">Call Hangups</a></li>
	   <li class=""><a href="#Footer" data-toggle="tab">Footer Messages</a></li>
       <Expand this to include Other types as well if there are >
     </ul>
</div></div-->

<!--div id="myTabContent" class="tab-content">
       
         <div id="SMS" class="tab-pane fade active in">
         </div>
         
         <div id="CallHangups" class="tab-pane fade">
		  </div>				 

         <div id="Footer" class="tab-pane fade">
		  </div>				 

</div-->
<br/>
    <!--div class="row">
         <div class="col-md-12">
             <div id="loading"><img src="<?php echo IMG_LOADING ;?>" border="0" /></div> 
         </div>
             
    </div-->   
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

$.fn.AjaxAct = function(act,xhr) {
		if(!xhr) {
						$('#loading').show();
						$('#grid').html('');	

					}
		
		$.ajax({
						url: 'snippets/test.php',
						data: '&type='+act,
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


var elem = $("#counter");
$("#msg").limiter(160, elem);
</script>
</body>
</html>