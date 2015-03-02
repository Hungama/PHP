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
window.parent.location.href ='index.php?logerr=logout';
}
</script>

<script language="javascript">
function checkfield()
{
	if(document.frm1.service_info.value==0)
	{
		alert("Please select service name.");
		document.frm1.service_info.focus();
		return false;
	}
	return true;
}

function checkfield1()
{
	
	if(document.tstest.timestamp.value==0)
	{
		alert("Please select Date.");
		document.tstest.timestamp.value();
		return false;
	}
	return true;
}

function openWindow(str)
{
    window.open("view_billing_details.php?msisdn="+str,"mywindow","menubar=0,resizable=1,width=650,height=500,scrollbars=yes");
}
</script>

<script language="JavaScript" src="ts_picker.js">

//Script by Denis Gritcyuk: tspicker@yahoo.com
//Submitted to JavaScript Kit (http://javascriptkit.com)
//Visit http://javascriptkit.com for this script

</script>
</head>