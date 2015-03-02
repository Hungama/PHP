<?php
session_start();
if (isset($_SESSION['authid']))
{
	include ("config/dbConnect.php");	   
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>Hungama Customer Care</title>
<link rel="stylesheet" href="style.css" type="text/css">
<style type="text/css">
<!--
.style3 {font-family: "Times New Roman", Times, serif}
-->
</style>
<script language="javascript">
function logout()
{
window.parent.location.href = 'index.php?logerr=logout';
}
</script>
<script language="javascript">
function checkfield(){
var re5digit=/^\d{10}$/ //regular expression defining a 10 digit number
if(document.frm.msisdn.value.search(re5digit)==-1){
alert("Please enter 10 digit Mobile Number.");
document.frm.msisdn.focus();
return false;
}
return true;
}
function openWindow(str,service_info)
{
   window.open("view_billing_details.php?msisdn="+str+"&service_info="+service_info,"mywindow","menubar=0,resizable=1,width=650,height=500,scrollbars=yes");
}
</script>
</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<?php

	include ("header.php");
	if(!isset($_POST['Submit'])){
?>
<form name="frm" method="POST" action="allReport.php" onSubmit="return checkfield()">
<TABLE align="center" border="0" cellpadding="1" cellspacing="1" class="txt">
<TBODY>
   <TR>
       <td>Select Report :: <select name='reportName'>
			<option value='select report'>Select Report</option>
			<option value='showReport.php?serviceName=endless'>MTS MUSIC UNLIMITED</option>
			<option value='showReport.php?serviceName=mtv'>MTS Mtv</option>
			<option value='showReport.php?serviceName=54646'>MTS 54646</option> 
			<option value='showReport.php?serviceName=mtsdevotional'>MTS Devotional</option>
			<option value='showReport.php?serviceName=fmj'>MTS FMJ</option>
			<option value='showReport.php?serviceName=redfm'>MTS RedFM</option>
			<option value='showReport.php?serviceName=mtscmd'>MTS Comedy</option>
			<option value='showReport.php?serviceName=mtsva'>MTS Voice Alert</option>
		<Select></td>
        <td align="center" bgcolor="#FFFFFF">
            <input name="Submit" type="submit" class="txtbtn" value="Submit"/>			
        </td>
    </TR>

</TBODY>
</TABLE>
</form><br/><br/>
<?php 
	}
else
{
	$redirectionPage=$_POST['reportName'];
	header("location:$redirectionPage");
	mysql_close($dbConn);
	exit;
}
}
else
{
    header("Location:index.php");
}

?>
