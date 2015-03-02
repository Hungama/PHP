function validate_login_form( )
{
if(document.getElementById("obd_form_uname").value=='')
{
   alert ( "Please enter username." );
   document.getElementById("obd_form_uname").focus();
   return false;
}
else if(document.getElementById("obd_form_pwd").value=='')
{
   alert ( "Please enter password." );
   document.getElementById("obd_form_pwd").focus();
   return false;
}
return true;
}

function setRegion(obd)
	{
if(document.getElementById("obd_form_region").value=='')
{
   alert ( "Please select circle." );
   document.getElementById("obd_form_region").focus();
   return false;
}
else
{
if(obd=='Indian')
{
document.getElementById("obd_form_cli").value='131224';
}
else if(obd=='Nepali')
{
document.getElementById("obd_form_cli").value='131222';
}
else if(obd=='Bengali')
{
document.getElementById("obd_form_cli").value='131221';
}
document.getElementById("obd_form_circle").value=obd;
}
}

function validate_obd_form( )
{
if(document.getElementById("obd_form_region").value=='')
{
   alert ( "Please select circle." );
   document.getElementById("obd_form_region").focus();
   return false;
}
else if(document.getElementById("obd_form_mob_file").value=='')
{
   alert ( "Please uplaod text file of mobile numbers." );
   document.getElementById("obd_form_mob_file").focus();
   return false;
}

else if(document.getElementById("obd_form_prompt_file").value=='')
{
alert ( "Please uplaod a prompt file." );
   document.getElementById("obd_form_prompt_file").focus();
   return false;
}

else if(document.getElementById("obd_form_cli").value=='')
{
alert ( "Please fill cli fields." );
   document.getElementById("obd_form_cli").focus();
   return false;
}
else if(document.getElementById("obd_form_circle").value=='')
{
alert ( "Please fill circle fields." );
   document.getElementById("obd_form_circle").focus();
   return false;
}
else if(document.getElementById("startdate").value=='')
{
alert ( "Please select start date." );
   document.getElementById("startdate").focus();
   return false;
}
else if(document.getElementById("enddate").value=='')
{
alert ( "Please select end date." );
   document.getElementById("enddate").focus();
   return false;
}
return true;
}
function validate_digiobd_form( )
{
if(document.getElementById("obd_form_region").value=='')
{
   alert ( "Please select circle." );
   document.getElementById("obd_form_region").focus();
   return false;
}
else if(document.getElementById("obd_form_channel").value=='')
{
   alert ( "Please select channel." );
   document.getElementById("obd_form_channel").focus();
   return false;
}

else if(document.getElementById("obd_form_pricepoint").value=='')
{
   alert ( "Please select price point." );
   document.getElementById("obd_form_pricepoint").focus();
   return false;
}

else if(document.getElementById("obd_form_mob_file").value=='')
{
   alert ( "Please uplaod text file of mobile numbers." );
   document.getElementById("obd_form_mob_file").focus();
   return false;
}

else if(document.getElementById("obd_form_prompt_file").value=='')
{
alert ( "Please uplaod a prompt file." );
   document.getElementById("obd_form_prompt_file").focus();
   return false;
}

else if(document.getElementById("obd_form_cli").value=='')
{
alert ( "Please fill cli fields." );
   document.getElementById("obd_form_cli").focus();
   return false;
}
else if(document.getElementById("obd_form_circle").value=='')
{
alert ( "Please fill circle fields." );
   document.getElementById("obd_form_circle").focus();
   return false;
}
else if(document.getElementById("startdate").value=='')
{
alert ( "Please select start date." );
   document.getElementById("startdate").focus();
   return false;
}
else if(document.getElementById("enddate").value=='')
{
alert ( "Please select end date." );
   document.getElementById("enddate").focus();
   return false;
}
return true;
}
// validate hul obd data
function validate_hul_form( )
{
if(document.getElementById("obd_form_mob_file").value=='')
{
   alert ( "Please uplaod text file of mobile numbers." );
   document.getElementById("obd_form_mob_file").focus();
   return false;
}
/*
else if(document.getElementById("obd_form_prompt_file").value=='')
{
alert ( "Please uplaod a prompt file." );
   document.getElementById("obd_form_prompt_file").focus();
   return false;
}
*/
else if(document.getElementById("obd_form_capsule").value=='')
{
alert ( "Please select capsule." );
   document.getElementById("obd_form_capsule").focus();
   return false;
}
/*
else if(document.getElementById("startdate").value=='')
{
alert ( "Please select start date." );
   document.getElementById("startdate").focus();
   return false;
}
else if(document.getElementById("enddate").value=='')
{
alert ( "Please select end date." );
   document.getElementById("enddate").focus();
   return false;
}*/
return true;
}