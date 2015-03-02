function getAPIResult(str,type)
{
document.getElementById("showinfo").innerHTML='';
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
document.getElementById("ajax_loader").style.display='none';
document.getElementById("submit_button").disabled = false;
document.getElementById("showinfo").innerHTML=xmlhttp.responseText;
   }
   else
   {
document.getElementById("ajax_loader").style.display='inline';
document.getElementById("submit_button").disabled = true;
   }
  }
//xmlhttp.open("GET","apiresponse.php?searchstr="+encodeURI(str)+"&stype="+type,true);

xmlhttp.open("GET","apiresponse.php?searchstr="+str+"&stype="+type,true);
xmlhttp.send();
}
function geResult()
{
var str=document.getElementById("searchstr").value;
var stype=document.getElementById("stype").value;
//alert(str+' '+stype);
getAPIResult(str,stype);
return false;
}
