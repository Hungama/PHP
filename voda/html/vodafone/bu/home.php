<?php
ob_start();
session_start();
$user_id=$_SESSION['usrId'];
$SKIP=1;
require_once("incs/common.php");

ini_set('display_errors','0');
//require_once("incs/database.php");
//require_once("incs/db.php");
$flag=0;
$_SESSION['authid']='true';
//require_once("../incs/GraphColors-D.php");
//require_once("../../ContentBI/base.php");
require_once("base.php");
asort($AR_SList);
$listservices=$_SESSION["access_service"];
//print_r ($listservices);
?>
<!--Page based on service Logic will start here -->
<?php
?>
<!--Logic will end here -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- include all required CSS & JS File start here -->
<?php 
require_once("main-header.php");
?>
<!-- include all required CSS & JS File end here -->

</head>

<!--body onload="javascript:getModuleList(<?= $service_info?>)"-->
<body>
<div class="navbar navbar-inner">
<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
</div>

<div class="container">

<div class="row" style="height:auto">

<div class="page-header">
  	<h1><?php echo 'Welcome, '.$_SESSION["fullname"];?> </h1>
</div>
<div class="tab-pane active" id="pills-basic">
		 <div class="tab-content" style="height:100%;overflow:visible;">
			<div id="<?php echo $cc_servicename;?>" >

			</div>
							
							
						
				 </div><!-- /.tab-content -->
						</div><!-- /.tabbable -->					
</div>
</div>
<!-- Footer section start here-->
  <?php
 //require_once("footer.php");
include "Menu-Vertical.php";
  ?>
<!-- Footer section end here-->    
<script src="assets/js/jquery.pageslide.js"></script>
<script>
    $(".second").pageslide({ direction: "right", modal: true });
</script>
</body>
</html>