<?php
session_start();
$SKIP=1;
ini_set('display_errors','0');
require_once("incs/db.php");
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAR'=>'Haryana','PUB'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAY'=>'Haryana');
//$query_liveservices = "select Service, Value, (select value from base where Service=a.Service and type='Name') as Name from base a where type='LiveContent' and value in (1,'true')";
//$query_liveservices = "select Service from misdata.base where type='LiveContent' and value in(1,'true')";
$query_liveservices = "select Service,(select value from misdata.base where Service=a.Service and type='Name') as Name from misdata.base a where type='LiveContent' and value in (1,'true')";
$result_liveservices = mysql_query($query_liveservices,$dbConn_218) or die(mysql_error());
$live_services=array('AirtelEU'=>'Airtel - Entertainment Unlimited','AirtelDevo'=>'Airtel - Sarnam');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- include all required CSS & JS File start here -->
<?php 
require_once("main-header.php");
?>
<!-- include all required CSS & JS File end here -->
<title>>Airtel EU: Content Information</title>
<script type="text/javascript">

function setCircleData(circleCode) { 
showtooltip('lang');
	var service = document.getElementById('service').value;	
	//document.getElementById("maindiv").innerHTML="Please select Language also..."; 
	document.getElementById("ACdiv1").innerHTML='';
	
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) { //alert(xmlhttp.responseText);
			document.getElementById("langDiv").innerHTML=xmlhttp.responseText;
			 }
	}
	var url="langValue.php?circle="+circleCode+"&case=1&service="+service;
	//alert(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}

function showMainMenu(lang,circle,service) { 
	document.getElementById("ACdiv1").innerHTML='';
	document.getElementById("ac2Div").style.display = 'none';
	document.getElementById("ACdiv2").style.display = 'none';
	document.getElementById("ac3Div").style.display = 'none';
	document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
	//document.getElementById("ac1Div").innerHTML='';
	$('#grid').hide();
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) { 
			document.getElementById("maindiv").innerHTML=xmlhttp.responseText;
			document.getElementById("showinfo").innerHTML='';
	    }
	}
	var url="langValue.php?circle="+circle+"&case=2&lang="+lang+"&service="+service;
	//alert(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}

function showContent(service,circle,lang,catname) {
document.getElementById('allmenudiv').style.display = 'none';
document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
document.getElementById('mainmenu_cat_div_eu').style.display = 'none';
document.getElementById('ac1Div').style.display = 'none';

//document.getElementById('grid').style.display = 'none';
$('#grid').hide();

	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		
		document.getElementById('allmenudiv').style.display = 'block';
			if(service == 'bg') {
				document.getElementById('ac1Div').style.display = 'none';
				document.getElementById('ac2Div').style.display = 'none';
				document.getElementById('ac3Div').style.display = 'none';
				document.getElementById("showinfo").innerHTML='';
				//document.getElementById('serviceDiv').style.display = 'block';
				//document.getElementById("serviceDiv").innerHTML=xmlhttp.responseText;
				
			} else if(service == 'ac') { 
				document.getElementById('ac1Div').style.display = 'block';
				//document.getElementById('serviceDiv').style.display = 'none';
				document.getElementById('ac2Div').style.display = 'none';
				document.getElementById('ac3Div').style.display = 'none';
				document.getElementById("showinfo").innerHTML='';
				document.getElementById('ACdiv1').style.display = 'block';
				document.getElementById("ACdiv1").innerHTML=xmlhttp.responseText; 
			} else if(service == 'mu') { 
			    document.getElementById('ACdiv1').style.display = 'block';
				document.getElementById('ac1Div').style.display = 'block';
				//document.getElementById('serviceDiv').style.display = 'none';
				document.getElementById('ac2Div').style.display = 'none';
				document.getElementById('ac3Div').style.display = 'none';
				document.getElementById("showinfo").innerHTML='';
				document.getElementById("ACdiv1").innerHTML=xmlhttp.responseText; 
			}
	    }
	}
	var url="langValue.php?circle="+circle+"&case=3&lang="+lang+"&service="+service+"&catname="+catname;
	//alert(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}
function showACData(clipValue,circle,lang,service,catname) {
document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
$('#grid').hide(); document.getElementById('ac1Div').style.display = 'none';
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById('ac2Div').style.display = 'block';
			document.getElementById('ac3Div').style.display = 'none';
			//document.getElementById('serviceDiv').style.display = 'none';
			  document.getElementById('ACdiv2').style.display = 'block';
			  document.getElementById("showinfo").innerHTML='';
			document.getElementById("ACdiv2").innerHTML=xmlhttp.responseText; 
		}
	}
	var url="langValue.php?circle="+circle+"&case=4&lang="+lang+"&service="+service+"&clip="+clipValue+"&catname="+catname;
	//alert(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
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

	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		document.getElementById('allmenudiv').style.display = 'block';
			document.getElementById('ac2Div').style.display = 'block';
			document.getElementById('ac3Div').style.display = 'none';
		//	document.getElementById('serviceDiv').style.display = 'none';
	//	document.getElementById('tabs4_othr').style.display = 'block';
			document.getElementById('ACdiv2').style.display = 'block';
			document.getElementById("showinfo").innerHTML='';
			document.getElementById("ACdiv2").innerHTML=xmlhttp.responseText; 
		}
	}
	var url="langValue.php?circle="+circle+"&case=4&lang="+lang+"&service="+cat+"&mucatname="+mucatname+"&startfrom="+startfrom;
	//alert(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}

function showMUSubData(lang,circle,service) {document.getElementById('ac1Div').style.display = 'none';
//alert('hi');
$('#grid').hide();
		$('#grid').html('');
document.getElementById('tabs4_othr').style.display = 'none';
document.getElementById('ACdiv2').style.display = 'none';

document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById('ac3Div').style.display = 'block';
			//document.getElementById('serviceDiv').style.display = 'none';
			document.getElementById('ACdiv3').style.display = 'block';
			document.getElementById("showinfo").innerHTML='';
			document.getElementById("ACdiv3").innerHTML=xmlhttp.responseText; 
		}
	}
	var url="langValue.php?circle="+circle+"&case=5&lang="+lang+"&service="+service;
	//alert(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}

function showDevoContent(religion,lang,circle) {document.getElementById('ac1Div').style.display = 'none';
document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById('ac1Div').style.display = 'block';
			document.getElementById('ac2Div').style.display = 'none';
			document.getElementById('ac3Div').style.display = 'none';
			//document.getElementById('serviceDiv').style.display = 'none';
			document.getElementById('ACdiv1').style.display = 'block';
			document.getElementById("showinfo").innerHTML='';
			document.getElementById("ACdiv1").innerHTML=xmlhttp.responseText; 
		}
	}
	var url="langValue.php?lang="+lang+"&religion="+religion+"&case=6&circle="+circle;
	//alert(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}

function showDevoContent_main(cat,circle,lang,clip,rel) {document.getElementById('ac1Div').style.display = 'none';
document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		document.getElementById('ac1Div').style.display = 'none';
		document.getElementById('grid').style.display = 'block';
			document.getElementById("showinfo").innerHTML='';
		//	alert(xmlhttp.responseText);
		document.getElementById("grid").innerHTML=xmlhttp.responseText; 
		}
	}
	
	var url="showContent_devo.php?cat="+cat+"&clip="+clip+"&circle="+circle+"&lang="+lang+"&rel="+rel;
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	

	}

function setServiceData() {
	    $('#grid').hide();
		$('#grid').html('');
		showtooltip('circle');
	document.getElementById('ac1Div').style.display = 'none';
	document.getElementById('ac2Div').style.display = 'none';
	document.getElementById('ac3Div').style.display = 'none';
	document.getElementById("lang").innerHTML='';
	document.getElementById("circle").value=""; 
	//document.getElementById('serviceDiv').style.display = 'none';
	//document.getElementById("maindiv").innerHTML="Please select Circle & Language also...";
var aa=document.getElementById('service').value;
if(aa=='')
{
alert('No service selected.');
return false;
}
if(aa=='AirtelEU')
{
document.getElementById("myservice").innerHTML="Airtel - Entertainment Unlimited";
}
else if(aa=='AirtelDevo')
{
document.getElementById("myservice").innerHTML='Airtel - Sarnam';
}
else
{
document.getElementById("myservice").innerHTML='';
}	
	
}

</script>
</head>

<body>

<div class="navbar navbar-inner">
<div class="container-fluid">
<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>

<div class="btn-group pull-right"><a id="ttip_service" rel="tooltip" data-placement="bottom" data-original-title="Select Service">
	<select name="service" id="service" class="span2" onchange="setServiceData();">
				<option value="">Select Service</option>
				
<?php
while($data_liveservices = mysql_fetch_array($result_liveservices))
{?>
<!--option value="<?php echo $data_liveservices[0];?>"><?php echo $live_services[$data_liveservices[0]];?></option-->
<option value="<?php echo $data_liveservices[0];?>"><?php echo $data_liveservices[1];?></option>
<?php }?>
<!--option value="dmx"><?php //echo 'DocomoEndless';?></option-->
	<!--option value="devo">Airtel - Sarnam</option>
				<option value="eu">Airtel - Entertainment Unlimited</option-->
			
			</select></a>
			<a id="ttip_circle" rel="tooltip" data-placement="bottom" data-original-title="Select Circle">
		<select name="circle" id="circle" onchange="setCircleData(this.value);" class="span2">
				<option value="">Select Circle</option>
				<?php foreach($circle_info as $circle_id=>$circle_val) { ?>
					<option value=<?php echo $circle_id?>><?php echo $circle_val;?></option>
				<?php } ?>
			</select>
			</a>
			<a id="ttip_lang" rel="tooltip" data-placement="bottom" data-original-title="Select Language">
		<span id='langDiv'>
		
		<select name="lang" id="lang" class="span2">
				<option value="">Select Language</option>
			</select>
			</span>
		</a>
       
          </div>
</div>

</div>

<div class="container">

<div class="row">
 
<div class="page-header">
  <h1 id="myservice">Live Content Listing<small>&nbsp;&nbsp;</small></h1>
</div>
<!-- include for direct login access -->
<?php 
require_once("sessioninfo.php");

?>
<!-- include for direct login access end here -->
<div class="tab-pane active" id="pills-basic">
			<div class="tab-content">
			<div class="tab-pane active">
			<div id='maindiv'></div>			
			</div>
												
			 </div>
	<div id="allmenudiv">			  
	<div id="ac1Div" style="display:none">
	<div id='ACdiv1'></div>
	</div>
	<div id="ac2Div" style="display:none">
		<div id='ACdiv2'></div>
	</div>
	<div id="ac3Div" style="display:none">
		<div id='ACdiv3'></div>
	</div>				  
	</div>						  
							
						</div>
	<div id="loading"><img src="assets/img/loading-circle-48x48.gif" border="0" /></div> 
     <div id="grid"></div>
		<div id="showinfo"></div>
		
									</div>
</div>


<!-- Footer section start here-->
  <?php
 require_once("footer.php");
  ?>
<!-- Footer section end here-->
    
<script>
	$('#loading').hide();
$('#grid').hide();	
		
function showContent_data(cat,circle,lang,clip,rel,musubcat) {

document.getElementById('mainmenu_cat_div_eu').style.display = 'none';
document.getElementById('ACdiv3').style.display = 'none';
document.getElementById('ac2Div').style.display = 'none';
document.getElementById('ACdiv1').style.display = 'none';

	   $('#loading').show();
		$('#grid').hide();
		$('#grid').html('');
		$.fn.GetContentDetails(cat,circle,lang,clip,rel,musubcat);
	};
	
$.fn.GetContentDetails = function(cat,circle,lang,clip,rel,musubcat) {	
//alert("cat="+cat+"&clip="+clip+"&circle="+circle+"&lang="+lang+"&rel="+rel+"&musubcat="+musubcat);
		$.ajax({
		
	
				     	url: 'showContent.php',
					    data: 'cat='+cat+'&circle='+circle+'&lang='+lang+'&clip='+clip+'&rel='+rel+'&musubcat='+musubcat,
						type: 'get',
						cache: false,
						dataType: 'html',
						success: function (abc) {
							$('#grid').html(abc);
							$('#loading').hide();
						}
						
					});
						
					$('#grid').show();
	
};

    $(".second").pageslide({ direction: "right", modal: true });
	
</script>
<script src="assets/js/jquery.dataTables.js"></script>
<script src="assets/js/TableTools.js"></script>
<script src="assets/js/ZeroClipboard.js"></script>
<script src="assets/js/DT_bootstrap.js"></script>
<script src="assets/js/dataTables.bootstrap.js"></script>  
 <script src="assets/js/bootstrap-tooltip.js"></script>
<script>
$('#ttip_service').tooltip('show');

function showtooltip(type)
{
if(type=='circle')
{
$('#ttip_circle').tooltip('show');
}
else if(type=='lang')
{
$('#ttip_lang').tooltip('show');
}
}

</script>
</body>
</html>