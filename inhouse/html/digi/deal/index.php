<?php //include("session.php");
error_reporting(0);
include("db.php");//include database connection file
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('header.php');?>
<body>
<div id="main">
	<div id="header">
		<?php include('header-menu.php');?>
	</div>
	<div id="middle">
		<div id="left-column">
		<?php include('left-sidebar.php');?>	
		</div>
		<div id="center-column">
			<div class="top-bar">
				<h1>Simulator Mode</h1>
				</div>
		  <div class="select-bar">
		    <?php echo $_REQUEST[msg];?>
			</div>
			 
		<div class="table">
			<!-- added for simulator mode start here
			<h4>To reply please select the radio button</h4><br/>-->
	      
     <div id="mobiimg">
				
<!--iframe src="http://www.aptnetwork.com/amd64/default_image.php" id="mobi66">
</iframe-->
      	<div id="mobi66_1">
			<?php include("mainMenu.php");?>
        </div>
	 </div>
 <!-- added for simulator mode end here-->
			<p>&nbsp;</p>
		  </div>
		</div>
		<div id="right-column">
<?php include('right-sidebar.php');?>
	  </div>
	</div>
	<div id="footer"></div>
</div>
</body>
</html>
