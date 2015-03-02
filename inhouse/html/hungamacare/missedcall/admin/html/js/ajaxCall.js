//--------------------------AJAX  Function--------------------------------------------------------------------------------
function ajax() 
{
	var ajax = null;
	if (window.XMLHttpRequest) 
	{
		try {
				ajax = new XMLHttpRequest();
				//alert("mozilla");
		}
		catch(e) {}
	}
	else if (window.ActiveXObject) 
	{
		try {
		
				ajax = new ActiveXObject("Msxm12.XMLHTTP");
				//alert("IE2");
		}
		catch (e)
		{
				try{
						ajax = new ActiveXObject("Microsoft.XMLHTTP");
						//alert("IE");
				}
				catch (e) {}
		}
	}
	return ajax;
}
var xmlhttp = ajax(); 
//put comments here
function stopcampaign(id,value)
{
//document.getElementById("ajax_img").style.display='inline'; 
//document.getElementById("response").innerHTML='';
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	alert(xmlhttp.responseText);
/*	if(xmlhttp.responseText=='100')
	{
	alert('Campaign has been updated successfully.');
}else
{
alert('Oops some error occured. Please try again.');
//document.getElementById("response").innerHTML='Oops some error occured. Please try again.';
}
*/
window.location.href="campaign.php?cpgid="+id;
//document.getElementById("ajax_img").style.display='none'; 
   }
  }
 
	xmlhttp.open("POST", "snippets/stopCampaign.php");
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("cpgid="+id+"&value="+value);

}

 function MobileValidate(y)
        {
              //var y = document.form1.txtMobile.value;
            if(isNaN(y)||y.indexOf(" ")!=-1)
           {
              alert("Enter numeric value")
              return false; 
           }
           if (y.length!=10)
           {
                alert("enter 10 characters");
                return false;
           }
         }
