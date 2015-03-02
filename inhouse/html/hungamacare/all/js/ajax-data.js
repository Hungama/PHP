function getServicesinfo(op,type)
{
if(op=='')
{
alert('Please select valid option from drop down list');
return false;
}
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
	if(type=='op')
	{
	document.getElementById("obd_form_service").innerHTML=xmlhttp.responseText;
	}
	else
	{
	document.getElementById("obd_form_pricepoint").innerHTML=xmlhttp.responseText;
	//document.getElementById("planid_dd").innerHTML=xmlhttp.responseText;	
	}
   }
   
  }
xmlhttp.open("GET","getservicelist.php?str="+op+"&type="+type,true);
xmlhttp.send();
}

function getPlannfo(pid)
{
if(pid=='')
{
alert('Please select valid option from drop down list');
return false;
}
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
		document.getElementById("pricepoint_dd").innerHTML=xmlhttp.responseText;	
	}
   
  }
xmlhttp.open("GET","getplaninfo.php?str="+pid,true);
xmlhttp.send();
}

function setAmount(amt)
{
if(amt=='')
{
alert('Please select valid option from drop down list');
return false;
}
else
{
document.getElementById("obd_form_amount").value=amt;
}
}

function getMdnStatus()
{
var msisdn=document.getElementById("msisdn").value;
var service_info=document.getElementById("obd_form_service").value;
var obd_form_pricepoint=document.getElementById("obd_form_pricepoint").value;
var obd_form_amount=document.getElementById("obd_form_amount").value;
//alert("MDN-"+msisdn+" "+"SID-"+service_info+"AMUT-"+obd_form_amount+"PID-"+obd_form_pricepoint);
//obd_form_service  obd_form_pricepoint  obd_form_amount  msisdn
//service_info,obd_form_pricepoint,obd_form_amount,msisdn
if(service_info=='')
{
alert('Please select operator and service');
return false;
}
else if(obd_form_pricepoint=='')
{
alert('Please select price point');
return false;
}
else if(obd_form_amount=='')
{
alert('Please select amount');
return false;
}
else if(msisdn=='')
{
alert('Please select MSISDN');
return false;
}
document.getElementById("getstatus_btn").disabled = true;
document.getElementById("showinfo").innerHTML='<img src="loading.gif" border="0"/>';

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
	//alert(xmlhttp.responseText);
	document.getElementById("show_status").innerHTML=xmlhttp.responseText;	
	document.getElementById("getstatus_btn").disabled = false;
document.getElementById("showinfo").innerHTML='';
    }
   
  }
xmlhttp.open("GET","getstatus.php?service_info="+service_info+"&obd_form_pricepoint="+obd_form_pricepoint+"&obd_form_amount="+obd_form_amount+"&msisdn="+msisdn,true);
xmlhttp.send();

}

function makeEditable()
{
document.getElementById('editbtn').style.visibility='hidden'; // hide  
document.getElementById('updatebtn').style.visibility='visible'; // show
document.getElementById("usersubmode").readOnly = false;
document.getElementById("userblance").readOnly = false;
document.getElementById("userstatus").readOnly = false
}

function doUpdate()
{
var msisdn=document.getElementById("msisdn").value;
var service_info=document.getElementById("obd_form_service").value;
var obd_form_pricepoint=document.getElementById("obd_form_pricepoint").value;
var obd_form_amount=document.getElementById("obd_form_amount").value;
var usersubmode=document.getElementById("usersubmode").value;
var userblance=document.getElementById("userblance").value;
var userstatus=document.getElementById("userstatus").value;
var renewdate=document.getElementById("renewdate").value;
var subdate=document.getElementById("subdate").value;
var isbalance;
if(isNaN(userblance))
{
isbalance=0;
}
else
{
isbalance=1;
}
var isstatus;
if(isNaN(userstatus))
{
isstatus=0;
}
else
{
isstatus=1;
}
if(usersubmode=='')
{
alert('User Sub Mode field can not be blank.');
return false;
}
else if(userblance=='' || isbalance==0)
{
alert('User balance field can not be blank. It should be numeric.');
document.getElementById("userblance").value='';
document.getElementById("userblance").focus();
return false;
}
else if(userstatus=='' || isstatus==0)
{
alert('User status field can not be blank. It should be numeric.');
document.getElementById("userstatus").value='';
document.getElementById("userstatus").focus();
return false;
}
//alert("MDN-"+msisdn+" "+"SID-"+service_info+" AMUT- "+obd_form_amount+" PID-"+obd_form_pricepoint+" usersubmode-"+usersubmode+" userblance-"+userblance+" userstatus-"+userstatus+" renewdate"+renewdate);

document.getElementById("updatebtn").disabled = true;
//document.getElementById("showinfo").innerHTML='<img src="loading.gif" border="0"/>';

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
	alert(xmlhttp.responseText);
	
	document.getElementById("updatebtn").disabled = false;
	/*
	document.getElementById("show_status").innerHTML=xmlhttp.responseText;	
	document.getElementById("showinfo").innerHTML='';
	*/
    }
   
  }
xmlhttp.open("GET","doUpdate.php?msisdn="+msisdn+"&obd_form_service="+service_info+"&obd_form_pricepoint="+obd_form_pricepoint+"&obd_form_amount="+obd_form_amount+"&usersubmode="+usersubmode+"&userblance="+userblance+"&userstatus="+userstatus+"&renewdate="+renewdate+"&subdate="+subdate,true);
xmlhttp.send();

}