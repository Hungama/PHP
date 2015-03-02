<?php
ob_start();
session_start();
ini_set('display_errors', '0');
require_once("../db.php");
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

     </head>

<body class="bg-primary">

    <div class="container">

      <div class="row login-form">
        <div class="col-xs-12">
		<a href="dashboard.php" class="btn btn-primary">Dashboard</a>&nbsp;<a href="userprofile.php" class="btn btn-primary">Profile Manager</a>&nbsp;<a href="campaignmanager.php" class="btn btn-primary">Campaign Manager</a> &nbsp;<a href="logout.php" class="btn btn-primary" style="float:right">Logout</a>
	
<?php
$get_query="select cpgid,cpgname,mobileno,missed_call_text,predefind_msg,created_on,modified_on,status 
from Inhouse_IVR.tbl_missedcall_cpginfo where uid='".$_SESSION['suid']."'";
$query = mysql_query($get_query,$con);
list($cpgid, $cpgname, $mobileno,$missed_call_text,$predefind_msg,$created_on,$modified_on,$status) = mysql_fetch_array($query);
?>
<br><br>
	<table class="table table-bordered table-striped">

<tr>
	<th width="8%">CampaignId</th><td><?php echo $cpgid;?></td>
	</tr><tr>
	<th width="25%">Campaign Name</th><td>
	<span class="label label-success"> <?php echo $cpgname;?></span>
	        
	</td>
	
	</tr><tr>
	<th width="25%">Mobile No</th><td><?php echo $mobileno;?></td>
	</tr><tr>
	<th width="25%">Missed Call SMS</th><td><?php echo $missed_call_text;?></td>
	</tr><tr>
	<th width="25%">Predefind Message</th><td><?php echo $predefind_msg;?></td>
	</tr><tr>
	<th width="25%">Created on</th><td><?php echo $created_on;?></td>
	</tr><!--tr>
	<th width="25%">Last modified on</th><td><?php echo $modified_on;?></td>
	</tr--><tr>
	<th width="25%">Action</th><td>
	<?php
	if($status==0) 
	{
	$btnmsg='Start campaign';
	$btnmsg='<i class="fui-play"></i>';
	$value=1;
	$fileStatus1='Inactive';
	}
	elseif($status==1)
	{
	$btnmsg='Stop campaign';
	$btnmsg='<i class="fui-pause"></i>';
	$value=0;
	$fileStatus1='Active';
	}
	?>
	<?php //echo $fileStatus1;?>&nbsp;&nbsp;
	<a href="javascript:void(0)" onclick="stopcampaign('<?php echo $cpgid;?>','<?php echo $value;?>')" class="btn btn-primary" style="float:left"> 
	<?php echo $btnmsg;?>
	</a>
	</td>
	</tr>
	<tr><td></td><td><div id="alert_placeholder"></div></td></tr>
</table>
<a href="javascript:void(0)" onclick="showViewConfirm('1')" id="edit_view_id" data-toggle="modal" data-target="#myModal" class="btn btn-primary" style="float:left">Create another campaign </a>
<?php
mysql_close($con);
?>
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
	
    </div> <!-- /container -->
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div style="width:900px" class="modal-dialog">
                                        <div class="modal-content" id="modal_content">
                                           
                                        </div>
                                    </div>
                                </div>

<?php
echo CONST_JS;
 $Refresh = 600;
?>
</body>
<script>
 $('#loading').hide();
   function stopcampaign(id,value){ 
               $('#loading').show();
                $.ajax({
	     
                    url: 'snippets/stopCampaign.php',
                    data: 'cpgid='+id+'&value='+value,
                    type: 'get',
                    cache: false,
                    dataType: 'html',
                    success: function (abc) {
                       $('#loading').hide();
					  // $('#alert_placeholder').html(abc);
			   document.getElementById('alert_placeholder').style.display='inline';
				document.getElementById('alert_placeholder').innerHTML='<div width="50%" align="left" class="txt"><div class="alert alert-success"><a class="close" data-dismiss="alert">&times;</a>'+abc+'</div></div>';
				 $('#loading').show();
				setTimeout("location.reload(true);",<?= $Refresh ?>);
				//	 location.reload();
                    }
						
                });
						
          }
			
  function showViewConfirm(id){ 
               // $('#loading').show();
                $.ajax({
	     
                    url: 'newcampgion.php',
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
</script>
</html>