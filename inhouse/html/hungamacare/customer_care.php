<?php
include("session.php");
error_reporting(E_ALL);
$flag=0;
$logDir="/var/www/html/hungamacare/log/adminAccessLog/";
$logFile="adminAccessLog_".date('Ymd');
$logPath=$logDir.$logFile;
$filePointer=fopen($logPath,'a+');
$_SESSION['authid']='true';
include ("config/dbConnect.php");
$service_info=$_REQUEST['service_info'];
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Hungama Customer Care</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<style media="all" type="text/css">@import "css/all.css";</style>
<script type="text/javascript" language="javascript">
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
function checkfield()
	{
var re5digit=/^\d{10}$/ //regular expression defining a 10 digit number
var re14digit=/^\d{13}$/ //regular expression defining a 10 digit number
if(document.frm.msisdn.value.search(re5digit)==-1 && document.frm.msisdn.value.search(re14digit)==-1)
	{
		alert("Please enter Valid Mobile Number.");
		document.frm.msisdn.focus();
		return false;
	}
return true;
}
function openWindow(str,service_info,subsrv)
{
   window.open("view_billing_details.php?msisdn="+str+"&service_info="+service_info+"&subsrv="+subsrv,"mywindow","menubar=0,resizable=1,width=650, height=500,scrollbars=yes");
}
function openWindow1(pageName,str,service_info)
{
   window.open(pageName+".php?msisdn="+str+"&service_info="+service_info,"mywindow","menubar=0,resizable=1,width=650,height=500,scrollbars=yes");
}
function openWindow3(pageName,str,service_info)
{
   window.open(pageName+".php?msisdn="+str+"&service_id="+service_info,"mywindow","menubar=0,resizable=1,width=650,height=500,scrollbars=yes");
}

function showDetail(service) { //alert(service);
	if(service=='FunNews') {
		document.getElementById('showinfo').style.display='block';
		document.getElementById('showinfo').innerHTML="<table width='85%' align='center' bgcolor='#0369b3' border='0' cellpadding='1' cellspacing='1' class='txt'><tr><th bgcolor='#FFFFFF' align='center'>SMS Pack</th><th bgcolor='#FFFFFF' align='center'>Service Description</th><th bgcolor='#FFFFFF' align='center'>charging model</th><th bgcolor='#FFFFFF' align='center'>Subscription Mode</th><th bgcolor='#FFFFFF' align='center'>Service</th></tr><tr><td bgcolor='#FFFFFF' align='center'>Fun News Pack</td><td bgcolor='#FFFFFF' align='center'>You will now get funny and cool news from around the world on your mobile</td><td bgcolor='#FFFFFF' align='center'>SMS</td><td bgcolor='#FFFFFF' align='center'>Send FNP to 38567 for Fun News Pack</td><td bgcolor='#FFFFFF' align='center'>One alert per day</td></tr></table>";
	} else if(service=='SFP') {
		document.getElementById('showinfo').style.display='block';
		document.getElementById('showinfo').innerHTML="<table width='85%' align='center' bgcolor='#0369b3' border='0' cellpadding='1' cellspacing='1' class='txt'><tr><th bgcolor='#FFFFFF' align='center'>SMS Pack</th><th bgcolor='#FFFFFF' align='center'>Service Description</th><th bgcolor='#FFFFFF' align='center'>charging model</th><th bgcolor='#FFFFFF' align='center'>Subscription Mode</th><th bgcolor='#FFFFFF' align='center'>Service</th></tr><tr><td bgcolor='#FFFFFF' align='center'>Spanish Football Pack</td><td bgcolor='#FFFFFF' align='center'>You will now get latest news and scores of matches on your mobile@ N75/wk</td><td bgcolor='#FFFFFF' align='center'>SMS</td><td bgcolor='#FFFFFF' align=center>Send SPL to 38567 for Spanish Football Pack</td><td bgcolor='#FFFFFF' align='center'>One alert per day</td></tr></table>";
	} else if(service=='JOKES') {
		document.getElementById('showinfo').style.display='block';
		document.getElementById('showinfo').innerHTML="<table width='85%' align='center' bgcolor='#0369b3' border='0' cellpadding='1' cellspacing='1' class='txt'><tr><th bgcolor='#FFFFFF' align='center'>SMS Pack</th><th bgcolor='#FFFFFF' align='center'>Service Description</th><th bgcolor='#FFFFFF' align='center'>charging model</th><th bgcolor='#FFFFFF' align='center'>Subscription Mode</th><th bgcolor='#FFFFFF' align='center'>Service</th></tr><tr><td bgcolor='#FFFFFF' align='center'>Jokes SMS Pack</td><td bgcolor='#FFFFFF' align='center'>You will now get funniest of jokes and share it with your friends @ N75/wk</td><td bgcolor='#FFFFFF' align='center'>SMS</td><td bgcolor='#FFFFFF' align='center'>Send SPL to 38567 for Jokes Pack</td><td bgcolor='#FFFFFF' align='center'>One alert per day</td></tr></table>";
	} else if(service=='HollyWood') {
		document.getElementById('showinfo').style.display='block';
		document.getElementById('showinfo').innerHTML="<table width='85%' align='center' bgcolor='#0369b3' border='0' cellpadding='1' cellspacing='1' class='txt'><tr><th bgcolor='#FFFFFF' align='center'>SMS Pack</th><th bgcolor='#FFFFFF' align='center'>Service Description</th><th bgcolor='#FFFFFF' align='center'>charging model</th><th bgcolor='#FFFFFF' align='center'>Subscription Mode</th><th bgcolor='#FFFFFF' align='center'>Service</th></tr><tr><td bgcolor='#FFFFFF' align='center'>Hollywood News Pack</td><td bgcolor='#FFFFFF' align='center'>You will now get hottest Hollywood gossip on your mobile@ N75/wk</td><td bgcolor='#FFFFFF' align='center'>SMS</td><td bgcolor='#FFFFFF' align='center'>Send HNP to 38567 for Hollywood News Pack</td>	<td bgcolor='#FFFFFF' align='center'>One alert per day</td></tr></table>";
	} else if(service=='EPL') {
		document.getElementById('showinfo').style.display='block';
		document.getElementById('showinfo').innerHTML="<table width='85%' align='center' bgcolor='#0369b3' border='0' cellpadding='1' cellspacing='1' class='txt'><tr><th bgcolor='#FFFFFF' align='center'>SMS Pack</th><th bgcolor='#FFFFFF' align='center'>Service Description</th><th bgcolor='#FFFFFF' align='center'>charging model</th><th bgcolor='#FFFFFF' align='center'>Subscription Mode</th><th bgcolor='#FFFFFF' align='center'>Service</th></tr><tr><td bgcolor='#FFFFFF' align='center'>English Premier League Pack</td><td bgcolor='#FFFFFF' align='center'>You will now get latest news and scores of matches on your mobile@ N75/wk</td><td bgcolor='#FFFFFF' align='center'>SMS</td><td bgcolor='#FFFFFF' align='center'>Send EPL to 38567 for English Premier League Pack</td><td bgcolor='#FFFFFF' align='center'>One alert per day</td></tr></table>";
	} else {
		document.getElementById('showinfo').display='none';
	}
}
	</script>
	
	</head>
<body onload="javascript:getModuleList(<?= $service_info?>)">
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
			<?php
			$getservice_query="select service_name from master_db.tbl_service_master where service_id = '".$service_info."'";
$get_serviceinfo = mysql_query($getservice_query,$dbConn) or die(mysql_error());

$row_service_info = mysql_fetch_array($get_serviceinfo);
			?>
				<h1>Customer Care- &nbsp;&nbsp;<?php echo $row_service_info['service_name'];?></h1>
				</div>
		  <div class="select-bar">
		   
			</div>
			<!--- Middle section start here -->
			 
			 		

			 <div class="table">
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
		<form name="frm" method="POST" action="" onSubmit="return checkfield()">
       <table class="listing" cellpadding="0" cellspacing="0">		
		<tr class="bg">
						<td class="first"><strong>Enter Mobile No:&nbsp;&nbsp;&nbsp;</strong>
						<INPUT name="msisdn" type="text" class="in" value="<?php echo $_REQUEST['msisdn']; ?>">
		<input type='hidden' name='service_info' value=<?php echo $service_info;?>>
		<input type='hidden' name='usrId' value=<?php echo $_REQUEST['usrId'];?>>
						
						</td>
					</tr>
					<tr class="bg">
						<td class="first">
						  <input name="Submit" type="submit" class="txtbtn" value="Submit"/>			
						</td>
					</tr>
		</table>
		</form>
		<!--Logic will start here -->
		
<?php
	$include_cc_page=substr($service_info, 0, 2);
			if($include_cc_page=='10')
			{
		//	echo "Tata Docomo";
			include('customer_care_tatadocomo.php');
			}
			else if($include_cc_page=='12')
			{
	//echo "Reliance";
			include('customer_care_reliance.php');
			}
			else if($include_cc_page=='14')
			{
			//echo "Uninor";
			include('customer_care_uninor.php');
			}
            else if($include_cc_page=='16')
			{
			//echo "Tata Indicom";
			include('customer_care_tataindicom.php');
			}
			else if($include_cc_page=='18')
			{
			//echo "VMI";
			include('customer_care_vmi.php');
			}
			else if($include_cc_page=='21')
			{
			echo "Etisalat";
 include('customer_care_etisalat.php');
			}
			else
			{
			echo "Invalid request";
			}
			
 ?>
		<!--Logic will end here -->
				        <p>&nbsp;</p>
		  </div>
		  
		  <!--- Middle section end here -->
		  
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