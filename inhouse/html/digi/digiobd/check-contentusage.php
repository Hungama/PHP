<?php include("session.php");
error_reporting(0);
//include database connection file
include("db.php");
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<title>Admin</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<style media="all" type="text/css">@import "css/all.css";</style>
	<script language="javascript" type="text/javascript" src="js/ajax-data.js"></script>
	</head>
<body>
<div id="main">
	<div id="header">
		<a href="index.html" class="logo"><img src="img/Hlogo.png" width="282" height="80" alt=""/></a>
	</div>
	<div id="middle">
		<div id="left-column">
		<?php include('left-sidebar.php');?>	
		</div>
		<div id="center-column">
			<div class="top-bar">
				<h1>Content Usages Information</h1>
				</div>
		  <div class="select-bar">
		    <?php echo $_REQUEST[msg];?>
			</div>
			 <div class="table">
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
<form name="hul_check_msisdn">
				<table class="listing form" cellpadding="0" cellspacing="0">
					<tr>
						<th class="full" colspan="2">Content Usages Information</th>
					</tr>
					
					<tr class="bg">
						<td class="first"><strong>Enter MSISDN </strong></td>
						<td class="last"><input type="text" class="text" name="hul_gp_msisdn" id="hul_gp_msisdn" onkeyup="getMsisdnInfo(2)" />
						<input type="button" name="getinfo" value="getinfo" onclick="getMsisdnInfo(2)"/>
						</td>
					</tr>
									
					
					
										</table>
					</form>
						<table class="listing form" cellpadding="0" cellspacing="0" id="showinfo">
					
					
					</table>
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
