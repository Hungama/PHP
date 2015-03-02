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
$get_query="select id,firstname,lastname,email,city,company,noofemp,website,mobileno,registed_on,uid 
from Inhouse_IVR.tbl_missedcall_signup where uid='".$_SESSION['suid']."'";
$query = mysql_query($get_query,$con);
list($id, $firstname, $lastname,$email,$city,$company,$noofemp,$website,$mobileno,$registed_on,$uid) = mysql_fetch_array($query);
?>
<br>
	<table class="table table-bordered table-striped">

<tr>
	<th width="8%">FirstName</th><td><?php echo $firstname;?></td>
	</tr><tr>
	<th width="25%">LastName</th><td><?php echo $lastname;?></td>
	</tr><tr>
	<th width="25%">Email</th><td><?php echo $email;?></td>
	</tr><tr>
	<th width="25%">City</th><td><?php echo $city;?></td>
	</tr><tr>
	<th width="25%">Company Name</th><td><?php echo $company;?></td>
	</tr><tr>
	<th width="25%">No Of Employees</th><td><?php echo $noofemp;?></td>
	</tr><tr>
	<th width="25%">Website</th><td><?php echo $website;?></td>
	</tr><tr>
	<th width="25%">Mobile No</th><td><?php echo $mobileno;?></td>
	</tr><tr>
	<th width="25%">Registerd On</th><td><?php echo $registed_on;?></td>
</tr>
<tr><td></td><td><div id="alert_placeholder"></div></td></tr>
<tr>
<td></td><td>
<a href="javascript:void(0)" onclick="userAction('<?php echo $uid;?>')" class="btn btn-primary" style="float:right"> <?php echo 'Delete account' ;?></a>
</td>
</tr>
</table>
<?php
mysql_close($con);
?>
  	   <div class="row">
         <div class="col-md-12">
             <div id="loading"><img src="<?php echo IMG_LOADING ;?>" border="0" /></div> 
         </div>
             
    </div>
		
          </div>

	 <div class="row">
             <div class="col-md-12" id="grid">
             		
             </div>
        </div>	 
 
        
      </div>
	
    </div> <!-- /container -->


<?php
echo CONST_JS;
 $Refresh = 600;
?>
</body>
<script>
$('#loading').hide();
   function userAction(id){ 
    var r = confirm("Do you want to delete your account ?");
	if (r == true)
	{
  //processed request
   }
else
  {
  return false;
  }
   
               $('#loading').show();
                $.ajax({
	     
                    url: 'snippets/userAction.php',
                    data: 'id='+id,
                    type: 'get',
                    cache: false,
                    dataType: 'html',
                    success: function (abc) {
                       $('#loading').hide();
					  
			   document.getElementById('alert_placeholder').style.display='inline';
				document.getElementById('alert_placeholder').innerHTML='<div width="50%" align="left" class="txt"><div class="alert alert-success"><a class="close" data-dismiss="alert">&times;</a>'+abc+'</div></div>';
				 $('#loading').show();
				//setTimeout("location.reload(true);",<?php echo $Refresh ?>);
				window.location.href="logout.php";
				//	 location.reload();
                    }
						
                });
						
          }

	
</script>
</html>