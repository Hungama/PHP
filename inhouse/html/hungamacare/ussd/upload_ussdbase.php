<?php 
include("session.php");
error_reporting(0);
//include database connection file
include("db.php");
$operatorlist=array('docomo','reliance','uninor','Indidcom','Indicom','Etislat');
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<style media="all" type="text/css">@import "css/all.css";</style>
	<script type="text/javascript" src="js/ajax-data.js"></script>
	<script language="javascript" type="text/javascript" src="datetimepicker/datetimepicker.js"></script>
<script type="text/javascript">
    function Checkfiles()
    {
        var fup = document.getElementById('obd_form_mob_file');
        var fileName = fup.value;
        var ext = fileName.substring(fileName.lastIndexOf('.') + 1);

    if(ext=="txt")
    {
        return true;
    }
    else
    {
        alert("Upload .txt file only");
        return false;
    }
	  //return false;
    }
</script>
<script language="javascript" type="text/javascript">
	function validate_form( )
{
if(document.getElementById("obd_form_service").value=='')
{
   alert ( "Please select service." );
   document.getElementById("obd_form_service").focus();
   return false;
}
else if(document.getElementById("obd_form_mob_file").value=='')
{
   alert ( "Please upload file." );
   document.getElementById("obd_form_mob_file").focus();
   return false;
}


   var fup = document.getElementById('obd_form_mob_file');
        var fileName = fup.value;
        var ext = fileName.substring(fileName.lastIndexOf('.') + 1);

    if(ext=="txt")
    {
        return true;
    }
    else
    {
        alert("Upload .txt file only");
        return false;
    }
return true;
}
	</script>
</head>
<body>
<div id="main">
	<div id="header">
		<a href="index.html" class="logo"><img src="img/Hlogo.png" width="282" height="80" alt=""/></a>
		<!--ul id="top-navigation">
			<li class="active"><span><span>Home</span></span></li>
		</ul-->
	</div>
	<div id="middle">
		<div id="left-column">
			<?php include('left-sidebar.php');?>
			</div>
		<div id="center-column">
			<div class="top-bar">
				<!--h1>Upload OBT Data---Please don't use this file right now..it's under process..</h1-->
				<h1>Admin-Home</h1>
				
				</div><br />
		  <div class="select-bar">
		    <?php echo "<h2 style=\"color:red\">".$_REQUEST[msg]."<h2>";?>
			</div>
				<h2 style="color:#FF0000;font-size:13px">(* Please upload file of less than 25,000 numbers otherwise it will not process.)</h2>
			 <div class="table">
				
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />

				<form name="obd_up_form" method="post" action="saveussdfileinfo.php" onsubmit="return validate_form()" enctype="multipart/form-data">
				<table class="listing form" cellpadding="0" cellspacing="0">
					<tr>
						<th class="full" colspan="2">&nbsp;</th>
					</tr>
			<tr class="bg">
<?php


$getlivemenu='select menu_id from USSD.tbl_ussd_config where level=0';
$result_livemenu = mysql_query($getlivemenu) or die(mysql_error());
?>
	
		<td class="first"><strong>Menu ID<span style="color:red">&nbsp;*</span></strong></td>
						<td class="last">
                      <!--input type="text" class="text" name="obd_form_menuid" id="obd_form_menuid" readonly="true" value='3'/-->
					  <select name="obd_form_menuid" id="obd_form_menuid">
				<option value="">Select MenuID</option>
				
<?php
while($data_livemenu = mysql_fetch_array($result_livemenu))
{ 
?>
<option value="<?php echo $data_livemenu[0];?>"><?php echo $data_livemenu[0];?></option>
<?php }?>
	
			</select>
						</td>
					</tr>
					<tr class="bg">

				<td class="first"><strong>USSD String<span style="color:red">&nbsp;*</span></strong></td>
						<td class="last">
                      <input type="text" class="text" name="obd_form_ussdstr" id="obd_form_ussdstr" readonly="true" value='*829#'/>
						</td>
					</tr>
				<tr class="bg">
						<td class="first"><strong>Please select service </strong></td>
						<td class="last">
                       <select name="obd_form_service" id="obd_form_service" onchange="">
						<option value="">Select any one--</option>
						<option value="1401">Uninor-MusicUnlimited</option>
						<option value="1410">RedFM</option>
						<option value="1450">My Music</option>
				  		</select>
						</td>
					</tr>
<!--tr class="bg">
						<td class="first"><strong>Please select circle </strong></td>
						<td class="last">
                       <select name="obd_form_circle" id="obd_form_circle" onchange="">
						<option value="">Select any one--</option>
						<option value="MAH">MAH</option>
						<option value="UPW">UPW</option>
						<option value="BIH">BIH</option>
						<option value="GUJ">GUJ</option>
				  		</select>
						</td>
					</tr-->

	<tr>
						<td class="first" width="172"><strong>						
						<B>Browse File To Upload <FONT COLOR="#FF0000">[.txt file]</B><span style="color:red">&nbsp;*</span><br/>&nbsp;&nbsp;&nbsp;(text file must contain one 10 digit msisdn per line)</FONT>
						</strong></td>
						<td class="last"><input type="file"  name="obd_form_mob_file" id="obd_form_mob_file"/>
						
						</td>
					</tr>
					
					<tr class="bg">
						<td class="first"><strong></strong></td>
						<td class="last"><input type="submit" name="submit" value="submit"/></td>
					</tr>
					</table>
					</form>
	        <span id="show_status"></span>
		  </div>
		</div>
		<div id="right-column">
			<strong class="h">INFO</strong>
			<div class="box">Information for USSD</div>
	  </div>
	</div>
	<div id="footer"></div>
</div>


</body>
</html>