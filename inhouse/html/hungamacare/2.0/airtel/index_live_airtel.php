<?php
session_start();
$SKIP=1;
ini_set('display_errors','0');
require_once("../incs/db.php");
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAR'=>'Haryana','PUB'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAY'=>'Haryana');
$query_liveservices = "select Service from misdata.base where type='LiveContent' and value in(1,'true')";	
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
	var service = document.getElementById('service').value;	
	document.getElementById("maindiv").innerHTML="Please select Language also..."; 
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
	    }
	}
	var url="langValue.php?circle="+circle+"&case=2&lang="+lang+"&service="+service;
	//alert(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}

function showContent(service,circle,lang,catname) {
document.getElementById("showinfo").innerHTML='<img src="assets/img/loading-circle-48x48.gif" border="0"/>';
document.getElementById('mainmenu_cat_div_eu').style.display = 'none';
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
			document.getElementById('ac2Div').style.display = 'block';
			document.getElementById('ac3Div').style.display = 'none';
		//	document.getElementById('serviceDiv').style.display = 'none';
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

function showMUSubData(lang,circle,service) {
//alert('hi');
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

function showDevoContent(religion,lang,circle) {
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

function showDevoContent_main(cat,circle,lang,clip,rel) {
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
	document.getElementById('ac1Div').style.display = 'none';
	document.getElementById('ac2Div').style.display = 'none';
	document.getElementById('ac3Div').style.display = 'none';
	document.getElementById("lang").innerHTML='';
	document.getElementById("circle").value=""; 
	//document.getElementById('serviceDiv').style.display = 'none';
	document.getElementById("maindiv").innerHTML="Please select Circle & Language also...";
var aa=document.getElementById('service').value;
if(aa=='eu')
{
document.getElementById("myservice").innerHTML="Airtel - Entertainment Unlimited";
}
else if(aa=='devo')
{
document.getElementById("myservice").innerHTML='Airtel - Sarnam';
}
else
{
document.getElementById("myservice").innerHTML='';
}	
	
}

</script>
<style>
.px12 {
 font-size: 12px;	
}


div.dataTables_length label {
	float: left;
	text-align: left;
}


div.dataTables_filter label {
	float: right;
}

div.dataTables_filter input, div.dataTables_length select {
  width: 210px;
  
  display: inline-block;
  height: 30px;
  padding: 4px;
  margin-bottom: 9px;
  font-size: 13px;
  line-height: 18px;
  color: #555555;
}

div.dataTables_length select {
	width: 75px;
}

div.dataTables_info {
	padding-top: 8px;
}

div.dataTables_paginate {
	float: right;
	margin: 0;
}

table.table {
	clear: both;
	margin-bottom: 6px !important;
	max-width: none !important;
}

table.table thead .sorting,
table.table thead .sorting_asc,
table.table thead .sorting_desc,
table.table thead .sorting_asc_disabled,
table.table thead .sorting_desc_disabled {
	cursor: pointer;
	*cursor: hand;
}

table.table thead .sorting { background: url('assets/img/sort_both.png') no-repeat center right; }
table.table thead .sorting_asc { background: url('assets/img/sort_asc.png') no-repeat center right; }
table.table thead .sorting_desc { background: url('assets/img/sort_desc.png') no-repeat center right; }

table.table thead .sorting_asc_disabled { background: url('assets/img/sort_asc_disabled.png') no-repeat center right; }
table.table thead .sorting_desc_disabled { background: url('assets/img/sort_desc_disabled.png') no-repeat center right; }

table.dataTable th:active {
	outline: none;
}

/* Scrolling */
div.dataTables_scrollHead table {
	margin-bottom: 0 !important;
	border-bottom-left-radius: 0;
	border-bottom-right-radius: 0;
}

div.dataTables_scrollHead table thead tr:last-child th:first-child,
div.dataTables_scrollHead table thead tr:last-child td:first-child {
	border-bottom-left-radius: 0 !important;
	border-bottom-right-radius: 0 !important;
}

div.dataTables_scrollBody table {
	border-top: none;
	margin-bottom: 0 !important;
}

div.dataTables_scrollBody tbody tr:first-child th,
div.dataTables_scrollBody tbody tr:first-child td {
	border-top: none;
}

div.dataTables_scrollFoot table {
	border-top: none;
}




/*
 * TableTools styles
 */
.table tbody tr.active td,
.table tbody tr.active th {
	background-color: #08C;
	color: white;
}

.table tbody tr.active:hover td,
.table tbody tr.active:hover th {
	background-color: #0075b0 !important;
}

.table-striped tbody tr.active:nth-child(odd) td,
.table-striped tbody tr.active:nth-child(odd) th {
	background-color: #017ebc;
}

table.DTTT_selectable tbody tr {
	cursor: pointer;
	*cursor: hand;
}

div.DTTT .btn {
	color: #333 !important;
	font-size: 12px;
}

div.DTTT .btn:hover {
	text-decoration: none !important;
}


ul.DTTT_dropdown.dropdown-menu a {
	color: #333 !important; /* needed only when demo_page.css is included */
}

ul.DTTT_dropdown.dropdown-menu li:hover a {
	background-color: #0088cc;
	color: white !important;
}

/* TableTools information display */
div.DTTT_print_info.modal {
	height: 150px;
	margin-top: -75px;
	text-align: center;
}

div.DTTT_print_info h6 {
	font-weight: normal;
	font-size: 28px;
	line-height: 28px;
	margin: 1em;
}

div.DTTT_print_info p {
	font-size: 14px;
	line-height: 20px;
}



/*
 * FixedColumns styles
 */
div.DTFC_LeftHeadWrapper table,
div.DTFC_LeftFootWrapper table,
table.DTFC_Cloned tr.even {
	background-color: white;
}

div.DTFC_LeftHeadWrapper table {
	margin-bottom: 0 !important;
	border-top-right-radius: 0 !important;
	border-bottom-left-radius: 0 !important;
	border-bottom-right-radius: 0 !important;
}

div.DTFC_LeftHeadWrapper table thead tr:last-child th:first-child,
div.DTFC_LeftHeadWrapper table thead tr:last-child td:first-child {
	border-bottom-left-radius: 0 !important;
	border-bottom-right-radius: 0 !important;
}

div.DTFC_LeftBodyWrapper table {
	border-top: none;
	margin-bottom: 0 !important;
}

div.DTFC_LeftBodyWrapper tbody tr:first-child th,
div.DTFC_LeftBodyWrapper tbody tr:first-child td {
	border-top: none;
}

div.DTFC_LeftFootWrapper table {
	border-top: none;
}



</style>

</head>

<body>

<div class="navbar navbar-inner">
<div class="container-fluid">
<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>

<div class="btn-group pull-right">
	<select name="service" id="service" class="span2" onchange="setServiceData();">
				<option value="">Select Service</option>
				
<?php
while($data_liveservices = mysql_fetch_array($result_liveservices))
{?>
<option value="<?php echo $data_liveservices[0];?>"><?php echo $live_services[$data_liveservices[0]];?></option>
<?php }?>
	<!--option value="devo">Airtel - Sarnam</option>
				<option value="eu">Airtel - Entertainment Unlimited</option-->
			
			</select>
		<select name="circle" id="circle" onchange="setCircleData(this.value);" class="span2">
				<option value="">Select Circle</option>
				<?php foreach($circle_info as $circle_id=>$circle_val) { ?>
					<option value=<?php echo $circle_id?>><?php echo $circle_val;?></option>
				<?php } ?>
			</select>
		<span id='langDiv'>
		<select name="lang" id="lang" class="span2">
				<option value="">Select Language</option>
			</select>
			</span>
		
       
          </div>
</div>

</div>

<div class="container">

<div class="row">

<div class="page-header">
  <h1 id="myservice">Menu List<small>&nbsp;&nbsp;</small></h1>
</div>
<!-- include for direct login access -->
<?php 
require_once("sessioninfo.php");

?>
<!-- include for direct login access end here -->
<div class="tab-pane active" id="pills-basic">
			<div class="tab-content">
			
			<div class="tab-pane active">
<!--table width="85%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="table table-condensed table-bordered">
 	<tr>
		<td  style="padding-left: 5px;" bgcolor="#ffffff" height="35"><div id='maindiv'></div></td>
	</tr>
	<!--tr>
		<td colspan='1'  style="padding-left: 5px;" bgcolor="#ffffff" height="35"><div id='serviceDiv'></div></td>
	</tr-->

<!--/table-->
		<div id='maindiv'></div>			
			</div>
								
								
			 </div>
				  
	<div id="ac1Div" style="display:none">
	<div id='ACdiv1'></div>
	</div>
	<div id="ac2Div" style="display:none">
		<div id='ACdiv2'></div>
	</div>
	<div id="ac3Div" style="display:none">
		<div id='ACdiv3'></div>
	</div>				  
							  <!-- /.tab-content -->
							
						</div>
	<div id="loading"><img src="assets/img/loading-circle-48x48.gif" border="0" /></div> 
        <!--div id="grid" class="pull-left">Data will show here...</div-->  
		<div id="grid"></div>
<div id="showinfo"></div>
		
		<!--- table box start here-->
									    <!--div id="tabs4-pane2" class="tab-pane">
							                             
                                <table class="table table-bordered">

								 <tr> <?php
							
									for($j=0;$j<9;$j++)
								{
								 $i++; 
								 

								 if($i%3==0 && $i !=0) {
									 echo "</tr><tr>";
								 }
									 ?> 
                                 <td><span class="label">Silent</span>
								 <a href="#listService" data-toggle='modal' data-title="<?php echo 'Name';?>" data-service="<?php echo 'selected';?>"><?php echo 'DescName';?></a>
                                 </td>
                                 
                                 
								   <?php
									}
								   
								   for($k=1;$k<(3-$i%3);$k++) {
									   
									   echo "<td>&nbsp;</td>";
								   }
								    ?>
                                  </tr>
                                  </table>
                                
                                
                                                               
                                </div-->
								<!--- table box end here-->
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
		
function showContent_data(cat,circle,lang,clip,rel) {
//alert('cat='+cat+'&circle='+circle+'&lang='+lang+'&clip='+clip+'&rel='+rel);
document.getElementById('mainmenu_cat_div_eu').style.display = 'none';
document.getElementById('ACdiv3').style.display = 'none';
document.getElementById('ac2Div').style.display = 'none';
document.getElementById('ACdiv1').style.display = 'none';

	   $('#loading').show();
		$('#grid').hide();
		$('#grid').html('');
		$.fn.GetContentDetails(cat,circle,lang,clip,rel);
	};
	
$.fn.GetContentDetails = function(cat,circle,lang,clip,rel) {
		$.ajax({
		
		//alert("cat="+cat+"&clip="+clip+"&circle="+circle+"&lang="+lang+"&rel="+rel);
				     	url: 'showContent.php',
					    data: 'cat='+cat+'&circle='+circle+'&lang='+lang+'&clip='+clip+'&rel='+rel,
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
</body>
</html>