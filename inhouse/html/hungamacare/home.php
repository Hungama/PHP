<?php
include("session.php");
error_reporting(0);
//include database connection file
include("db.php");

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<style media="all" type="text/css">@import "css/all.css";</style>
	<!--script language="javascript" type="text/javascript" src="datetimepicker/datetimepicker.js"></script-->
	
	<script type="text/javascript" language="javascript">
	function setModule(service)
	{
	//alert(service);
	}
	function getModuleList(serviceid)
{
var xmlhttp;    
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
document.getElementById("modulelist").style.display='inline';
document.getElementById("listmodule").innerHTML=xmlhttp.responseText;
//alert(xmlhttp.responseText);
    }
  }
xmlhttp.open("GET","listmoduleinfo.php?serviceid="+serviceid,true);
xmlhttp.send();

}
	</script>
	
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
				<h1>Select Services </h1>
				</div>
		  <div class="select-bar">
		   
			</div>
			 <div class="table">
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
		<table class="listing" cellpadding="0" cellspacing="0">
				<form action="#" method="">
				<tr class="bg">
						<td class="first">
						<?php
$serviceArray=array('TataDoCoMoMX'=>'1001','RIAUninor'=>'1409','RIATataDoCoMo'=>'1009','RIATataDoCoMocdma'=>'1609','TataIndicom54646'=>'1602','TataDoCoMo54646'=>'1002','UninorAstro'=>'1416','UninorRT'=>'1412','TataDoCoMoMXcdma'=>'1601','RIATataDoCoMovmi'=>'1809','RedFMUninor'=>'1409','Uninor54646'=>'1402','Reliance54646'=>'1202','RedFMTataDoCoMo'=>'1010','TataDoCoMoFMJ'=>'1005','REDFMTataDoCoMocdma'=>'1610','REDFMTataDoCoMovmi'=>'1810','TataDoCoMoMXvmi'=>'1801','TataDoCoMoFMJcdma'=>'1605','MTVTataDoCoMocdma'=>'1603','MTVUninor'=>'1403','RelianceCM'=>'1208','MTVReliance'=>'1203','MTVTataDoCoMo'=>'1003');


						$listservices=$_SESSION["access_service"];
						$services = explode(",", $listservices);
					?>
                        <select name="service_info" id="service_info" onchange="javascript:getModuleList(this.value)">
                        <option value="">Select any one--</option>
                            <?php foreach ($serviceArray as $k => $v)
                                  {
                                    if(in_array($k,$services))
                                       {
                             ?>
                        <option value="<?php echo $v;?>"><?php echo $k;?></option>
                      <?php } } ?>
                       </select>

<?php 
/*
foreach ($services as $k)
{ ?>
<option value="<?php echo $k;?>" onchange="test()"><?php echo $k;?></option>
<?php }

*/
?>
	</td>
						<td class="last">
						</td>
				
	 
					</tr>
					</form>
					

			</table>
				        <p>&nbsp;</p>
		  </div>
		</div>
		<div id="right-column">
<?php include('right-sidebar.php');
//close database connection
mysql_close($con);
?>
	  </div>
	</div>
	<div id="footer"></div>
</div>


</body>
</html>