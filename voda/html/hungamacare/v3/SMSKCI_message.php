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
$Priority = array('1','2','3','4','5');
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
	<h6>Add New SMS<small>&nbsp;&nbsp;<?php echo $f_array[$sid];?></small></h6>
	</div>
    <div class="col-md-4">
    	<div class="btn-group btn-group-xs pull-right">
  <button type="button" class="btn btn-info">Upload TSV</button>
  <button type="button" class="btn btn-success"><a href="download_tsv.php?S_id=<?=$sid?>">Download TSV</a></button>
</div><br/>
    </div>
    </div>

<div class="row">
	<div class="col-md-12">
	<form id="form-SMS" name="form-SMS" method="post" enctype="multipart/form-data">
	  <table class="table table-bordered table-condensed">
	   

	 
          <tr>
	      <td>Browse File To Upload</td>
	      <td>
	       <INPUT name="upfile" id='upfile' type="file" class="in">
      		</td>
            <td valign="middle">
			<input type='hidden' name='S_id' value=<?php echo $sid;?>>
			<button class="btn btn-primary" id="submit-SMS" type="button" style="float:right">Submit</button>
			</td>
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
$('#loading_sms').hide();
$('#loading').hide();
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
				url: 'snippets/smsfile_process.php',
				data: $('#form-'+act).serialize() + '&action=upload',
				type: 'post',
				cache: false,
				dataType: 'html',
				success: function (xhr) {
				document.getElementById('grid-SMS').style.display='inline';
				document.getElementById('grid-SMS').innerHTML='<div width="85%" align="left" class="txt"><div class="alert alert-success"><a class="close" data-dismiss="alert">&times;</a>Message has been saved successfully</div></div>';
				$('#loading').hide();
				resestForm('SMS'); 
				
				}
			
				
			});

	};



        function checkfield(type) { 
            $('#loading').hide();
            document.getElementById('alert_placeholder').style.display='inline';
           var upfile=document.forms[type]["upfile"].value;
             if(upfile==null || upfile=="")
 {
	bootstrap_alert.warning('Please upload message file.');
  return false;
 }else 
{
var ext = upfile.substring(upfile.lastIndexOf('.') + 1);

    if(ext=="txt" || ext=="xls" || ext=="tsv" || ext=="csv")
    {
	var count=(upfile.split(".").length - 1);
	if(count==1)
		{
		}
		else
		{
		bootstrap_alert.warning('Please upload valid image.');
		return false;
		}
    }
    else
    {
	 bootstrap_alert.warning('Please upload message file.');
        return false;
    }
}
			//  $('#loading').show();
            hideMessageBox();
            return true;
        }
        bootstrap_alert = function() {}
        bootstrap_alert.warning = function(message) {
            $('#alert_placeholder').html('<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a><span>'+message+'</span></div>')
        }
        function hideMessageBox() {
           document.getElementById('alert_placeholder').style.display='none';
        }

//post message data end here
</script>
</body>
</html>
<?php
mysql_close($dbConn);
?>