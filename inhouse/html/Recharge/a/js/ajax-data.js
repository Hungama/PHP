function getMsisdnInfo(type )
{
if(document.getElementById("hul_gp_msisdn").value=='')
{
   alert ( "Please enter mobile number." );
   document.getElementById("hul_gp_msisdn").focus();

}
else 
{
	str=document.getElementById("hul_gp_msisdn").value;
   getMsisdnDetail(str,type);	
}


}

function getMsisdnDetail(str,type)
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
/*
document.getElementById("txtHint").display='inline';
*/
document.getElementById("showinfo").innerHTML=xmlhttp.responseText;
//alert(xmlhttp.responseText);
    }
  }
xmlhttp.open("GET","get-msisdninfo.php?msisdn="+str+"&type="+type,true);
xmlhttp.send();
}
