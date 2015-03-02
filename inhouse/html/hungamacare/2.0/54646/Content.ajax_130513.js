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

var myAjax = ajax(); 
function CheckNetworkConnectivityIssue()
{
    bootbox.alert("The requested service is temporarily unavailable. It is either overloaded or under maintenance. Please try later.");
    document.getElementById("showinfo").innerHTML='';
}
function setCircleData(circleCode) {
    showtooltip('lang');
    var service = document.getElementById('service').value;	
    var operator = document.getElementById('operator').value;
    //document.getElementById("maindiv").innerHTML="Please select Language also..."; 
    document.getElementById("ACdiv1").innerHTML='';
	
    /*	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	*/
    myAjax.onreadystatechange=function() {
        if (myAjax.readyState==4 && myAjax.status==200) { //alert(myAjax.responseText);
            clearTimeout(xhrTimeout);
            if(myAjax.responseText=='404')
            {
                CheckNetworkConnectivityIssue();
            }
            else
            {
                document.getElementById("langDiv").innerHTML=myAjax.responseText;
            }
        }
			 
    }
    var url="Content.Live_langValue.php?circle="+circleCode+"&case=1&service="+service+"&operator="+operator;
    //alert(url);
    myAjax.open("GET",url,true);
    myAjax.send();
    // Timeout to abort in 5 seconds
    var xhrTimeout=setTimeout("ajaxTimeout();",10000);
}
function ajaxTimeout(){
    // Abort the AJAX request.
    myAjax.abort();
    CheckNetworkConnectivityIssue();
}
function getCircleData(serviceCode) {
    /*var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	*/
    myAjax.onreadystatechange=function() {
        if (myAjax.readyState==4 && myAjax.status==200) {
            clearTimeout(xhrTimeout); 
            document.getElementById("circle").innerHTML=myAjax.responseText;
        }
    }
    var url="Content.Live_circle-list.php?sname="+serviceCode;
    myAjax.open("GET",url,true);
    myAjax.send();
    // Timeout to abort in 5 seconds
    var xhrTimeout=setTimeout("ajaxTimeout();",10000);

}
function showMainMenu(lang,circle,service,navlang) {
    document.getElementById("ACdiv1").innerHTML='';
    document.getElementById("ac2Div").style.display = 'none';
    document.getElementById("ACdiv2").style.display = 'none';
    document.getElementById("ac3Div").style.display = 'none';
    document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
    //document.getElementById("ac1Div").innerHTML='';
    $('#grid').hide();
    /*	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	*/
    myAjax.onreadystatechange=function() {
        if (myAjax.readyState==4 && myAjax.status==200) {
            clearTimeout(xhrTimeout); 
            if(myAjax.responseText=='404')
            {
                CheckNetworkConnectivityIssue();
            }
            else
            {

                document.getElementById("maindiv").innerHTML=myAjax.responseText;
                document.getElementById("showinfo").innerHTML='';
            }
        }
    }
    var url="Content.Live_langValue.php?circle="+circle+"&case=2&lang="+lang+"&service="+service+"&navlang="+navlang;
    //alert(url);
    myAjax.open("GET",url,true);
    myAjax.send();
    // Timeout to abort in 5 seconds
    var xhrTimeout=setTimeout("ajaxTimeout();",10000);
}

function showContent(service,circle,lang,catname) {
    document.getElementById('allmenudiv').style.display = 'none';
    document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
    document.getElementById('mainmenu_cat_div_eu').style.display = 'none';
    document.getElementById('ac1Div').style.display = 'none';

    //document.getElementById('grid').style.display = 'none';
    $('#grid').hide();

    /*var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	*/
	
    myAjax.onreadystatechange=function() {
        if (myAjax.readyState==4 && myAjax.status==200) {
            clearTimeout(xhrTimeout); 
            if(myAjax.responseText=='404')
            {
                CheckNetworkConnectivityIssue();
            }
            else {
                document.getElementById('allmenudiv').style.display = 'block';
                if(service == 'bg') {
                    document.getElementById('ac1Div').style.display = 'none';
                    document.getElementById('ac2Div').style.display = 'none';
                    document.getElementById('ac3Div').style.display = 'none';
                    document.getElementById("showinfo").innerHTML='';
                //document.getElementById('serviceDiv').style.display = 'block';
                //document.getElementById("serviceDiv").innerHTML=myAjax.responseText;
				
                } else if(service == 'ac') { 
                    document.getElementById('ac1Div').style.display = 'block';
                    //document.getElementById('serviceDiv').style.display = 'none';
                    document.getElementById('ac2Div').style.display = 'none';
                    document.getElementById('ac3Div').style.display = 'none';
                    document.getElementById("showinfo").innerHTML='';
                    document.getElementById('ACdiv1').style.display = 'block';
                    document.getElementById("ACdiv1").innerHTML=myAjax.responseText; 
                } else if(service == 'mu') { 
                    document.getElementById('ACdiv1').style.display = 'block';
                    document.getElementById('ac1Div').style.display = 'block';
                    //document.getElementById('serviceDiv').style.display = 'none';
                    document.getElementById('ac2Div').style.display = 'none';
                    document.getElementById('ac3Div').style.display = 'none';
                    document.getElementById("showinfo").innerHTML='';
                    document.getElementById("ACdiv1").innerHTML=myAjax.responseText; 
                }
            }
        }
    }
    var url="Content.Live_langValue.php?circle="+circle+"&case=3&lang="+lang+"&service="+service+"&catname="+catname;
    //alert(url);
    myAjax.open("GET",url,true);
    myAjax.send();
    //xmlhttp.abort();
    // Timeout to abort in 5 seconds
    var xhrTimeout=setTimeout("ajaxTimeout();",10000);
}
function showACData(clipValue,circle,lang,service,catname) {
    document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
    $('#grid').hide();
    document.getElementById('ac1Div').style.display = 'none';
    /*	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	*/
    myAjax.onreadystatechange=function() {
        if (myAjax.readyState==4 && myAjax.status==200) {
            clearTimeout(xhrTimeout); 
            if(myAjax.responseText=='404')
            {
                CheckNetworkConnectivityIssue();
            }	
            else 
            {
                document.getElementById('ac2Div').style.display = 'block';
                document.getElementById('ac3Div').style.display = 'none';
                //document.getElementById('serviceDiv').style.display = 'none';
                document.getElementById('ACdiv2').style.display = 'block';
                document.getElementById("showinfo").innerHTML='';
                document.getElementById("ACdiv2").innerHTML=myAjax.responseText; 
            }
        }
    }
    var url="Content.Live_langValue.php?circle="+circle+"&case=4&lang="+lang+"&service="+service+"&clip="+clipValue+"&catname="+catname;
    //alert(url);
    myAjax.open("GET",url,true);
    myAjax.send();	
    // Timeout to abort in 5 seconds
    var xhrTimeout=setTimeout("ajaxTimeout();",10000);
}

function showMUCateData(cat,circle,lang,mucatname,startfrom) {
    //document.getElementById('tabs4_othr').style.display = 'none';
    //document.getElementById('ac1Div').style.display = 'none';
    $('#grid').hide();
    $('#grid').html('');
    document.getElementById('allmenudiv').style.display = 'none';
    document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
    document.getElementById('ACdiv1').style.display = 'none';
    document.getElementById('ACdiv3').style.display = 'none';
    //document.getElementById('tabs4_othr').style.display = 'block';

    /*var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	*/
    myAjax.onreadystatechange=function() {
        if (myAjax.readyState==4 && myAjax.status==200) {
            clearTimeout(xhrTimeout); 
            if(myAjax.responseText=='404')
            {
                CheckNetworkConnectivityIssue();
            }		
            else
            {
                document.getElementById('allmenudiv').style.display = 'block';
                document.getElementById('ac2Div').style.display = 'block';
                document.getElementById('ac3Div').style.display = 'none';
                //	document.getElementById('serviceDiv').style.display = 'none';
                //	document.getElementById('tabs4_othr').style.display = 'block';
                document.getElementById('ACdiv2').style.display = 'block';
                document.getElementById("showinfo").innerHTML='';
                document.getElementById("ACdiv2").innerHTML=myAjax.responseText; 
            }
        }
    }
    var url="Content.Live_langValue.php?circle="+circle+"&case=4&lang="+lang+"&service="+cat+"&mucatname="+mucatname+"&startfrom="+startfrom;
    //alert(url);
    myAjax.open("GET",url,true);
    myAjax.send();	
    // Timeout to abort in 5 seconds
    var xhrTimeout=setTimeout("ajaxTimeout();",10000);
}

function showMUSubData(lang,circle,service) {
    document.getElementById('ac1Div').style.display = 'none';
    //alert('hi');
    $('#grid').hide();
    $('#grid').html('');
    document.getElementById('tabs4_othr').style.display = 'none';
    document.getElementById('ACdiv2').style.display = 'none';

    document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
    /*var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	*/
    myAjax.onreadystatechange=function() {
        if (myAjax.readyState==4 && myAjax.status==200) {
            clearTimeout(xhrTimeout); 
            if(myAjax.responseText=='404')
            {
                CheckNetworkConnectivityIssue();
            }		
            else {
                document.getElementById('ac3Div').style.display = 'block';
                //document.getElementById('serviceDiv').style.display = 'none';
                document.getElementById('ACdiv3').style.display = 'block';
                document.getElementById("showinfo").innerHTML='';
                document.getElementById("ACdiv3").innerHTML=myAjax.responseText; 
            }
        }
    }
    var url="Content.Live_langValue.php?circle="+circle+"&case=5&lang="+lang+"&service="+service;
    //alert(url);
    myAjax.open("GET",url,true);
    myAjax.send();	
    // Timeout to abort in 5 seconds
    var xhrTimeout=setTimeout("ajaxTimeout();",10000);
}

function showDevoContent(religion,lang,circle,navlang,servicename) {
    document.getElementById('mainmenu_cat_div_devo').style.display = 'none';
    document.getElementById('ac1Div').style.display = 'none';
    document.getElementById('grid').style.display = 'none';

    document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
    myAjax.onreadystatechange=function() {
        if (myAjax.readyState==4 && myAjax.status==200) {
            clearTimeout(xhrTimeout); 
            if(myAjax.responseText=='404')
            {
                CheckNetworkConnectivityIssue();
            }
            else {
                document.getElementById('ac1Div').style.display = 'block';
                document.getElementById('ac2Div').style.display = 'none';
                document.getElementById('ac3Div').style.display = 'none';
                document.getElementById('mainmenu_cat_div_devo').style.display = 'none';
                document.getElementById('ACdiv1').style.display = 'block';
                document.getElementById("showinfo").innerHTML='';
                document.getElementById("ACdiv1").innerHTML='';	
                document.getElementById("grid").innerHTML='';			
                //alert(myAjax.responseText);
                document.getElementById("ACdiv1").innerHTML=myAjax.responseText; 
            }
        }
    }
    var url="Content.Live_langValue.php?lang="+lang+"&religion="+religion+"&case=6&circle="+circle+"&navlang="+navlang+"&devoservicename="+servicename;
    //alert(url);
    myAjax.open("GET",url,true);
    myAjax.send();	
    // Timeout to abort in 5 seconds
    var xhrTimeout=setTimeout("ajaxTimeout();",10000);
}

function showDevoContent_main(cat,circle,lang,clip,rel,navlang) {
    document.getElementById('ac1Div').style.display = 'none';
    document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
    myAjax.onreadystatechange=function() {
        if (myAjax.readyState==4 && myAjax.status==200) {
            clearTimeout(xhrTimeout); 
            if(myAjax.responseText=='404')
            {
                CheckNetworkConnectivityIssue();
            }
            else {
                document.getElementById('ac1Div').style.display = 'none';
                document.getElementById('grid').style.display = 'block';
                document.getElementById("showinfo").innerHTML='';
                //	alert(xmlhttp.responseText);
                document.getElementById("grid").innerHTML=myAjax.responseText; 
            }
        }
    }
	
    var url="Content.Live_showContent_devo.php?cat="+cat+"&clip="+clip+"&circle="+circle+"&lang="+lang+"&rel="+rel+"&navlang="+navlang;
    myAjax.open("GET",url,true);
    myAjax.send();	
    // Timeout to abort in 5 seconds
    var xhrTimeout=setTimeout("ajaxTimeout();",10000);

}

function setServiceData() {
    $('#grid').hide();
    $('#grid').html('');
    showtooltip('circle');
    showtooltip('operator');
    document.getElementById('ac1Div').style.display = 'none';
    document.getElementById('ac2Div').style.display = 'none';
    document.getElementById('ac3Div').style.display = 'none';
    document.getElementById("lang").innerHTML='';
    document.getElementById("circle").value=""; 
    var aa=document.getElementById('service').value;
    if(aa=='')
    {
        alert('No service selected.');
        return false;
    }
    else if(aa=='AirtelEU')
    {
        document.getElementById("ttip_operator").style.display='none';
        document.getElementById("myservice").innerHTML="Airtel - Entertainment Unlimited";
        getCircleData(aa);
    }
    else if(aa=='AirtelDevo')
    {
        document.getElementById("ttip_operator").style.display='none';
        document.getElementById("myservice").innerHTML='Airtel - Sarnam';
        getCircleData(aa);
    }
    else if(aa=='TataDoCoMoMX')
    {
        document.getElementById("ttip_operator").style.display='none';
        document.getElementById("myservice").innerHTML='Tata DoCoMo - Endless Music';
        getCircleData(aa);
    }
    else if(aa=='MTSMU')
    {
        document.getElementById("ttip_operator").style.display='none';
        document.getElementById("myservice").innerHTML='MTS - muZic Unlimited';
        getCircleData(aa);
    }
    else if(aa=='MTSDevo')
    {
        document.getElementById("ttip_operator").style.display='none';
        document.getElementById("myservice").innerHTML='MTS - Bhakti Sagar';
        getCircleData(aa);
    }
    else if(aa=='AircelMC')
    {
        document.getElementById("ttip_operator").style.display='none';
        document.getElementById("myservice").innerHTML='Aircel - Music Connect';
        getCircleData(aa);
    }
    else if(aa=='54646')
    {
        showtooltip('operator');
        document.getElementById("myservice").innerHTML='54646';
        getCircleData(aa);
        document.getElementById("ttip_operator").style.display='block';
    }
    else
    {
        document.getElementById("myservice").innerHTML='';
    }	
	
}

function showTDMXCateData(cat,circle,lang,mucatname,startfrom) {
    //alert('cat='+cat+"&circle="+circle+"&lang="+lang);
    $('#grid').hide();
    $('#grid').html('');
    document.getElementById('docomo_mainmenu').style.display = 'none';
    document.getElementById('allmenudiv').style.display = 'none';
    document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
    document.getElementById('ACdiv1').style.display = 'none';
    document.getElementById('ACdiv3').style.display = 'none';
    /*var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	*/
    myAjax.onreadystatechange=function() {
        if (myAjax.readyState==4 && myAjax.status==200) {
            clearTimeout(xhrTimeout); 
            if(myAjax.responseText=='404')
            {
                CheckNetworkConnectivityIssue();
            }
            else
            {
                document.getElementById('allmenudiv').style.display = 'block';
                document.getElementById('ac2Div').style.display = 'block';
                document.getElementById('ac3Div').style.display = 'none';
                document.getElementById('ACdiv2').style.display = 'block';
                document.getElementById("showinfo").innerHTML='';
                document.getElementById("ACdiv2").innerHTML=myAjax.responseText; 
            }
        }
    }
    var url="Content.Live_langValue.php?circle="+circle+"&case=4&lang="+lang+"&service="+cat+"&mucatname="+mucatname+"&startfrom="+startfrom;
    myAjax.open("GET",url,true);
    myAjax.send();	
    // Timeout to abort in 5 seconds
    var xhrTimeout=setTimeout("ajaxTimeout();",10000);
}

function showMTSMUCateData(cat,circle,lang,mucatname,startfrom) {
    $('#grid').hide();
    $('#grid').html('');
    document.getElementById('mtsmu_mainmenu').style.display = 'none';
    document.getElementById('allmenudiv').style.display = 'none';
    document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
    document.getElementById('ACdiv1').style.display = 'none';
    document.getElementById('ACdiv3').style.display = 'none';
    /*	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}*/
	
    myAjax.onreadystatechange=function() {
        if (myAjax.readyState==4 && myAjax.status==200) {
            clearTimeout(xhrTimeout); 
            if(myAjax.responseText=='404')
            {
                CheckNetworkConnectivityIssue();
            }
            else
            {
                document.getElementById('allmenudiv').style.display = 'block';
                document.getElementById('ac2Div').style.display = 'block';
                document.getElementById('ac3Div').style.display = 'none';
                document.getElementById('ACdiv2').style.display = 'block';
                document.getElementById("showinfo").innerHTML='';
                document.getElementById("ACdiv2").innerHTML=xmlhttp.responseText; 
            }
        }
    }
    var url="Content.Live_langValue.php?circle="+circle+"&case=4&lang="+lang+"&service="+cat+"&mucatname="+mucatname+"&startfrom="+startfrom;
    myAjax.open("GET",url,true);
    myAjax.send();	
    // Timeout to abort in 5 seconds
    var xhrTimeout=setTimeout("ajaxTimeout();",10000);
}

//Aircel MC

function showContent_data_aicelmc(cat,lang,catname) {
    $('#grid').hide();
    $('#grid').html('');
    document.getElementById('mtsmu_mainmenu').style.display = 'none';
    document.getElementById('allmenudiv').style.display = 'none';
    document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
    document.getElementById('ACdiv1').style.display = 'none';
    document.getElementById('ACdiv3').style.display = 'none';
    myAjax.onreadystatechange=function() {
        if (myAjax.readyState==4 && myAjax.status==200) {
            clearTimeout(xhrTimeout); 
            if(myAjax.responseText=='404')
            {
                CheckNetworkConnectivityIssue();
            }
            else
            {
                document.getElementById('allmenudiv').style.display = 'block';
                document.getElementById('ac2Div').style.display = 'block';
                document.getElementById('ac3Div').style.display = 'none';
                document.getElementById('ACdiv2').style.display = 'block';
                document.getElementById("showinfo").innerHTML='';
                document.getElementById("ACdiv2").innerHTML=xmlhttp.responseText; 
            }
        }
    }
    var url="Content.Content.Live_showContent.php?case="+cat+"&langmc="+lang+"&mccatname="+catname;
    myAjax.open("GET",url,true);
    myAjax.send();	
    // Timeout to abort in 5 seconds
    var xhrTimeout=setTimeout("ajaxTimeout();",10000);
}
function showMainMenu_54646(lang,circle,service,operator,navlang) { 
    document.getElementById("ACdiv1").innerHTML='';
    document.getElementById("ac2Div").style.display = 'none';
    document.getElementById("ACdiv2").style.display = 'none';
    document.getElementById("ac3Div").style.display = 'none';
    document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
    $('#grid').hide();
    myAjax.onreadystatechange=function() {
        if (myAjax.readyState==4 && myAjax.status==200) {
            clearTimeout(xhrTimeout); 
            if(myAjax.responseText=='404')
            {
                CheckNetworkConnectivityIssue();
            }
            else
            {
                document.getElementById("maindiv").innerHTML=myAjax.responseText;
                document.getElementById("showinfo").innerHTML='';
            }
        }
    }
    var url="Content.Live_langValue.php?circle="+circle+"&case=2&lang="+lang+"&service="+service+"&operator="+operator+"&navlang="+navlang;
    myAjax.open("GET",url,true);
    myAjax.send();
    // Timeout to abort in 5 seconds
    var xhrTimeout=setTimeout("ajaxTimeout();",10000);
}
function showContent_54646(service,circle,lang,operator,catname) { 
    document.getElementById('allmenudiv').style.display = 'none';
    document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
    document.getElementById('mainmenu_cat_div_eu').style.display = 'none';
    document.getElementById('ac1Div').style.display = 'none';

    $('#grid').hide();
 
    myAjax.onreadystatechange=function() {
        if (myAjax.readyState==4 && myAjax.status==200) { 
            clearTimeout(xhrTimeout); 
            if(myAjax.responseText=='404')
            {
                CheckNetworkConnectivityIssue();
            }
            else {
                document.getElementById('allmenudiv').style.display = 'block';
                document.getElementById('ac1Div').style.display = 'none';
                document.getElementById('ac2Div').style.display = 'none';
                document.getElementById('ac3Div').style.display = 'none';
                document.getElementById("showinfo").innerHTML='';
                document.getElementById('mainmenu_cat_div_eu').style.display = 'block';
                document.getElementById("mainmenu_cat_div_eu").innerHTML=myAjax.responseText;
				
            }
        }
    }
    var url="Content.Live_langValue.php?circle="+circle+"&case=7&lang="+lang+"&service="+service+"&operator="+operator+"&catname="+catname;
    myAjax.open("GET",url,true);
    myAjax.send();
    //xmlhttp.abort();
    // Timeout to abort in 5 seconds
    var xhrTimeout=setTimeout("ajaxTimeout();",10000);
}
function showContent_data_54646(service,circle,lang,operator,data_value,catname) { 
    document.getElementById('allmenudiv').style.display = 'none';
    document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
    document.getElementById('mainmenu_cat_div_eu').style.display = 'none';
    document.getElementById('ac1Div').style.display = 'none';

    $('#grid').hide();

    myAjax.onreadystatechange=function() {
        if (myAjax.readyState==4 && myAjax.status==200) { 
            clearTimeout(xhrTimeout); 
            if(myAjax.responseText=='404')
            {
                CheckNetworkConnectivityIssue();
            }
            else {
                document.getElementById('allmenudiv').style.display = 'block';
                document.getElementById('ac1Div').style.display = 'none';
                document.getElementById('ac2Div').style.display = 'none';
                document.getElementById('ac3Div').style.display = 'none';
                document.getElementById("showinfo").innerHTML='';
                document.getElementById('mainmenu_cat_div_eu').style.display = 'block';
                document.getElementById("mainmenu_cat_div_eu").innerHTML=myAjax.responseText;
				
            }
        }
    }
    var url="Content.Live_showContent.php?circle="+circle+"&cat=54646&lang="+lang+"&service="+service+"&operator="+operator+"&data_value="+data_value+"&catname="+catname;
    myAjax.open("GET",url,true);
    myAjax.send();
    var xhrTimeout=setTimeout("ajaxTimeout();",10000);
}
function showSpecialZone_data_54646(service,circle,lang,operator,data_value,catname) { 
    document.getElementById('allmenudiv').style.display = 'none';
    document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
    document.getElementById('mainmenu_cat_div_eu').style.display = 'none';
    document.getElementById('ac1Div').style.display = 'none';

    $('#grid').hide();

    myAjax.onreadystatechange=function() {
        if (myAjax.readyState==4 && myAjax.status==200) { 
            clearTimeout(xhrTimeout); 
            if(myAjax.responseText=='404')
            {
                CheckNetworkConnectivityIssue();
            }
            else {
                document.getElementById('allmenudiv').style.display = 'block';
                document.getElementById('ac1Div').style.display = 'none';
                document.getElementById('ac2Div').style.display = 'none';
                document.getElementById('ac3Div').style.display = 'none';
                document.getElementById("showinfo").innerHTML='';
                document.getElementById('mainmenu_cat_div_eu').style.display = 'block';
                document.getElementById("mainmenu_cat_div_eu").innerHTML=myAjax.responseText;
				
            }
        }
    }
    var url="Content.Live_showContent.php?circle="+circle+"&cat=special_zone&lang="+lang+"&service="+service+"&operator="+operator+"&data_value="+data_value+"&catname="+catname;
    myAjax.open("GET",url,true);
    myAjax.send();
    var xhrTimeout=setTimeout("ajaxTimeout();",10000);
}