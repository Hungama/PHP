<?php
session_start();
$PAGE_TAG='content-live';
$SKIP=1;
//error_reporting(0);
require_once("db_connect_livecontent.php");
//require_once("../incs/GraphColors-D.php");
require_once("base.php");
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUB'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
//$query_liveservices = "select Service from misdata.base where type='LiveContent' and value in(1,'true') limit 2";	
$query_liveservices = "select Service,(select value from misdata.base where Service=a.Service and type='Name') as Name from misdata.base a where type='LiveContent' and value in (1,'true') order by Name";
$result_liveservices = mysql_query($query_liveservices,$dbConn_218) or die(mysql_error());


$live_services=array('AirtelEU'=>'Airtel - Entertainment Unlimited','AirtelDevo'=>'Airtel - Sarnam');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- include all required CSS & JS File start here -->
<?php 
require_once("Content.Live_header.php");
?>
<!-- include all required CSS & JS File end here -->
<title>Live Content Listing</title>
<script language="javascript" type="text/javascript" src="Content.ajax.js"></script>
<!--script type="text/javascript"></script-->
</head>

<body>
<div class="navbar navbar-inner">
<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
<!--/div-->
<!--div class="container"-->
<!--a href="#" data-bb="alert" class="bb-trigger btn btn-large" onclick="CheckNetworkConnectivityIssue()">Ooops</a-->
<div class="btn-group pull-right"><a id="ttip_service" rel="tooltip" data-placement="bottom" data-original-title="Select Service">
	<select name="service" id="service" class="span2" onchange="setServiceData();">
				<option value="">Select Service</option>
				
<?php
while($data_liveservices = mysql_fetch_array($result_liveservices))
{ 
		//	if(in_array($data_liveservices[0],$AR_SList)) {



?>
<option value="<?php echo $data_liveservices[0];?>"><?php echo $data_liveservices[1];?></option>
<?php }
//}
?>
<option value="<?php echo 'AircelMC';?>"><?php echo 'Aircel - Music Connect';?></option>
	</select></a>
			<a id="ttip_circle" rel="tooltip" data-placement="bottom" data-original-title="Select Circle">
		<select name="circle" id="circle" onchange="setCircleData(this.value);" class="span2">
				<option value="">Select Circle</option>
				<!--
				<?php foreach($circle_info as $circle_id=>$circle_val) { ?>
					<option value=<?php echo $circle_id?>><?php echo $circle_val;?></option>
				<?php } ?>
				-->
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
<!--/div-->

</div>

<div class="container">

<div class="row">
 
<div class="page-header">
  <h1 id="myservice">Live Content Listing<small>&nbsp;&nbsp;</small></h1>
</div>
<!-- include for direct login access -->
<?php 
//require_once("sessioninfo.php");
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
 require_once("Content.Live_footer.php");
  ?>
<!-- Footer section end here-->
    
<script>
	$('#loading').hide();
$('#grid').hide();	
		
function showContent_data(cat,circle,lang,clip,rel,musubcat) {
//alert("cat="+cat+"&clip="+clip+"&circle="+circle+"&lang="+lang+"&rel="+rel+"&musubcat="+musubcat);
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

		$.ajax({
		
	
				     	url: 'Content.Live_showContent.php',
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

<!---for tata docomo endless services start here -->
function showContent_data_docomo(cat,circle,lang,clip,rel,musubcat) {
document.getElementById('docomo_mainmenu').style.display = 'none';
document.getElementById('ACdiv3').style.display = 'none';
document.getElementById('ac2Div').style.display = 'none';
document.getElementById('ACdiv1').style.display = 'none';
	   $('#loading').show();
		$('#grid').hide();
		$('#grid').html('');
		$.fn.GetContentDetails_docomo(cat,circle,lang,clip,rel,musubcat);
	};
	
$.fn.GetContentDetails_docomo = function(cat,circle,lang,clip,rel,musubcat) {	

		$.ajax({
		
	
				     	url: 'Content.Live_showContent.php',
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
<!-- docomo endless end here -->
<!-- For MTSMU service code start here -->
function showContent_data_mtsmu(cat,circle,lang,clip,rel,musubcat) {
document.getElementById('mtsmu_mainmenu').style.display = 'none';
document.getElementById('ACdiv3').style.display = 'none';
document.getElementById('ac2Div').style.display = 'none';
document.getElementById('ACdiv1').style.display = 'none';
	   $('#loading').show();
		$('#grid').hide();
		$('#grid').html('');
		$.fn.GetContentDetails_mtsmu(cat,circle,lang,clip,rel,musubcat);
	};
	
$.fn.GetContentDetails_mtsmu = function(cat,circle,lang,clip,rel,musubcat) {	

		$.ajax({
		
	
				     	url: 'Content.Live_showContent.php',
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
<!-- MTSMU service end here -->
    $(".second").pageslide({ direction: "right", modal: true });
	
</script>
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