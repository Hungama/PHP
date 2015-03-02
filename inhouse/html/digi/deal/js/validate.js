function validate_login_form( )
{
if(document.getElementById("hul_form_uname").value=='')
{
   alert ( "Please enter username." );
   document.getElementById("hul_form_uname").focus();
   return false;
}
else if(document.getElementById("hul_form_pwd").value=='')
{
   alert ( "Please enter password." );
   document.getElementById("hul_form_pwd").focus();
   return false;
}
return true;
}


//for password check
function chk_password()
{ 
if(document.hul_group_pwdchange_form.hul_old_pwd.value=="" || document.hul_group_pwdchange_form.hul_old_pwd.value==null)
{
	alert("Please fill old password.");
	document.hul_group_pwdchange_form.hul_old_pwd.value="";
	document.hul_group_pwdchange_form.hul_old_pwd.focus();
	return false;
}
if(document.hul_group_pwdchange_form.hul_new_pwd.value=="" || document.hul_group_pwdchange_form.hul_new_pwd.value==null)
{	
	alert("Please fill new password.");
	document.hul_group_pwdchange_form.hul_new_pwd.value="";
	document.hul_group_pwdchange_form.hul_new_pwd.focus();
	return false;
}
var str=document.hul_group_pwdchange_form.hul_new_pwd.value;
var strln=str.length;
if(strln<4)
{
	alert("Please Fill atlest 4 digit password.");
	document.hul_group_pwdchange_form.hul_new_pwd.value="";
	document.hul_group_pwdchange_form.hul_new_pwd.focus();
	return false;
}

if(document.hul_group_pwdchange_form.hul_rnew_pwd.value=="" || document.hul_group_pwdchange_form.hul_rnew_pwd.value==null)
{
	alert("Please re enter new password.");
	document.hul_group_pwdchange_form.hul_rnew_pwd.value="";
	document.hul_group_pwdchange_form.hul_rnew_pwd.focus();
	return false;
}
if(document.hul_group_pwdchange_form.hul_new_pwd.value!=document.hul_group_pwdchange_form.hul_rnew_pwd.value)
{
	alert("Please fill passowrd as entered in new password field.");
	document.hul_group_pwdchange_form.hul_rnew_pwd.value="";
	document.hul_group_pwdchange_form.hul_rnew_pwd.focus();
	return false;
}

return true;
  }
  
  
/* added for simulator mode start here */
function setsimulatortext(str)
{

/*
alert("Button id "+str);
return false;
*/
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
	document.getElementById("mobi66_1").innerHTML=xmlhttp.responseText;
	}
  }
xmlhttp.open("GET","setsimulatortext.php?p="+str,true);
xmlhttp.send();

}
/* added for simulator mode end here */

function setsimulatortext1(str,type)
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
	//alert(xmlhttp.responseText);
	document.getElementById("mobi66_1").innerHTML=xmlhttp.responseText;
	}
  }
xmlhttp.open("GET","setsimulatortext1.php?p="+str+"&type="+type,true);
xmlhttp.send();

}
/* added for simulator mode end here */
