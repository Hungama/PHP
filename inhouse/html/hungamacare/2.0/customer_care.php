<?php
$SKIP=1;
ini_set('display_errors','0');
//require_once("incs/database.php");
require_once("incs/db.php");
$flag=0;
$_SESSION['authid']='true';
//require_once("../incs/GraphColors-D.php");
//require_once("../../ContentBI/base.php");
//asort($AR_SList);
$service_info=$_REQUEST['service_info'];
?>
<!--Page based on service Logic will start here -->
<?php
$cc_servicename='';
	$include_cc_page=substr($service_info, 0, 2);
	switch($include_cc_page)
{
	case '10':
		$cc_servicename = "customer_care_tatadocomo";
		break;
	case '12':
		$cc_servicename = "customer_care_reliance";
	    break;
	case '14':
		$cc_servicename = "customer_care_uninor";
		break;
	case '16':
		$cc_servicename = "customer_care_tataindicom";
		break;
	case '18':
		$cc_servicename = "customer_care_vmi";
		break;
	case '21':
		$cc_servicename = "customer_care_etisalat";
		break;
}
?>
<!--Logic will end here -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- include all required CSS & JS File start here -->
<?php 
require_once("main-header.php");
?>
<!-- include all required CSS & JS File end here -->
<script type="text/javascript" language="javascript">
function checkfield()
	{
var re5digit=/^\d{10}$/ //regular expression defining a 10 digit number
var re14digit=/^\d{13}$/ //regular expression defining a 10 digit number
if(document.frm.msisdn.value.search(re5digit)==-1 && document.frm.msisdn.value.search(re14digit)==-1)
	{
		alert("Please enter Valid Mobile Number.");
		document.frm.msisdn.focus();
		return false;
	}
return true;
}
function openWindow(str,service_info,subsrv)
{
   window.open("view_billing_details.php?msisdn="+str+"&service_info="+service_info+"&subsrv="+subsrv,"mywindow","menubar=0,resizable=1,width=650, height=500,scrollbars=yes");
}
function openWindow1(pageName,str,service_info)
{
   window.open(pageName+".php?msisdn="+str+"&service_info="+service_info,"mywindow","menubar=0,resizable=1,width=650,height=500,scrollbars=yes");
}
function openWindow3(pageName,str,service_info)
{
   window.open(pageName+".php?msisdn="+str+"&service_id="+service_info,"mywindow","menubar=0,resizable=1,width=650,height=500,scrollbars=yes");
}

function showDetail(service) { //alert(service);
	if(service=='FunNews') {
		document.getElementById('showinfo').style.display='block';
		document.getElementById('showinfo').innerHTML="<table width='85%' align='center' bgcolor='#0369b3' border='0' cellpadding='1' cellspacing='1' class='txt'><tr><th bgcolor='#FFFFFF' align='center'>SMS Pack</th><th bgcolor='#FFFFFF' align='center'>Service Description</th><th bgcolor='#FFFFFF' align='center'>charging model</th><th bgcolor='#FFFFFF' align='center'>Subscription Mode</th><th bgcolor='#FFFFFF' align='center'>Service</th></tr><tr><td bgcolor='#FFFFFF' align='center'>Fun News Pack</td><td bgcolor='#FFFFFF' align='center'>You will now get funny and cool news from around the world on your mobile</td><td bgcolor='#FFFFFF' align='center'>SMS</td><td bgcolor='#FFFFFF' align='center'>Send FNP to 38567 for Fun News Pack</td><td bgcolor='#FFFFFF' align='center'>One alert per day</td></tr></table>";
	} else if(service=='SFP') {
		document.getElementById('showinfo').style.display='block';
		document.getElementById('showinfo').innerHTML="<table width='85%' align='center' bgcolor='#0369b3' border='0' cellpadding='1' cellspacing='1' class='txt'><tr><th bgcolor='#FFFFFF' align='center'>SMS Pack</th><th bgcolor='#FFFFFF' align='center'>Service Description</th><th bgcolor='#FFFFFF' align='center'>charging model</th><th bgcolor='#FFFFFF' align='center'>Subscription Mode</th><th bgcolor='#FFFFFF' align='center'>Service</th></tr><tr><td bgcolor='#FFFFFF' align='center'>Spanish Football Pack</td><td bgcolor='#FFFFFF' align='center'>You will now get latest news and scores of matches on your mobile@ N75/wk</td><td bgcolor='#FFFFFF' align='center'>SMS</td><td bgcolor='#FFFFFF' align=center>Send SPL to 38567 for Spanish Football Pack</td><td bgcolor='#FFFFFF' align='center'>One alert per day</td></tr></table>";
	} else if(service=='JOKES') {
		document.getElementById('showinfo').style.display='block';
		document.getElementById('showinfo').innerHTML="<table width='85%' align='center' bgcolor='#0369b3' border='0' cellpadding='1' cellspacing='1' class='txt'><tr><th bgcolor='#FFFFFF' align='center'>SMS Pack</th><th bgcolor='#FFFFFF' align='center'>Service Description</th><th bgcolor='#FFFFFF' align='center'>charging model</th><th bgcolor='#FFFFFF' align='center'>Subscription Mode</th><th bgcolor='#FFFFFF' align='center'>Service</th></tr><tr><td bgcolor='#FFFFFF' align='center'>Jokes SMS Pack</td><td bgcolor='#FFFFFF' align='center'>You will now get funniest of jokes and share it with your friends @ N75/wk</td><td bgcolor='#FFFFFF' align='center'>SMS</td><td bgcolor='#FFFFFF' align='center'>Send SPL to 38567 for Jokes Pack</td><td bgcolor='#FFFFFF' align='center'>One alert per day</td></tr></table>";
	} else if(service=='HollyWood') {
		document.getElementById('showinfo').style.display='block';
		document.getElementById('showinfo').innerHTML="<table width='85%' align='center' bgcolor='#0369b3' border='0' cellpadding='1' cellspacing='1' class='txt'><tr><th bgcolor='#FFFFFF' align='center'>SMS Pack</th><th bgcolor='#FFFFFF' align='center'>Service Description</th><th bgcolor='#FFFFFF' align='center'>charging model</th><th bgcolor='#FFFFFF' align='center'>Subscription Mode</th><th bgcolor='#FFFFFF' align='center'>Service</th></tr><tr><td bgcolor='#FFFFFF' align='center'>Hollywood News Pack</td><td bgcolor='#FFFFFF' align='center'>You will now get hottest Hollywood gossip on your mobile@ N75/wk</td><td bgcolor='#FFFFFF' align='center'>SMS</td><td bgcolor='#FFFFFF' align='center'>Send HNP to 38567 for Hollywood News Pack</td>	<td bgcolor='#FFFFFF' align='center'>One alert per day</td></tr></table>";
	} else if(service=='EPL') {
		document.getElementById('showinfo').style.display='block';
		document.getElementById('showinfo').innerHTML="<table width='85%' align='center' bgcolor='#0369b3' border='0' cellpadding='1' cellspacing='1' class='txt'><tr><th bgcolor='#FFFFFF' align='center'>SMS Pack</th><th bgcolor='#FFFFFF' align='center'>Service Description</th><th bgcolor='#FFFFFF' align='center'>charging model</th><th bgcolor='#FFFFFF' align='center'>Subscription Mode</th><th bgcolor='#FFFFFF' align='center'>Service</th></tr><tr><td bgcolor='#FFFFFF' align='center'>English Premier League Pack</td><td bgcolor='#FFFFFF' align='center'>You will now get latest news and scores of matches on your mobile@ N75/wk</td><td bgcolor='#FFFFFF' align='center'>SMS</td><td bgcolor='#FFFFFF' align='center'>Send EPL to 38567 for English Premier League Pack</td><td bgcolor='#FFFFFF' align='center'>One alert per day</td></tr></table>";
	} else {
		document.getElementById('showinfo').display='none';
	}
}
	</script>
	
</head>

<body onload="javascript:getModuleList(<?= $service_info?>)">

<div class="navbar navbar-inner">
<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
</div>

<div class="container">

<div class="row">
<!-- include for direct login access -->
<?php 
require_once("sessioninfo.php");
?>
<!-- include for direct login access end here -->
		 <?php
				$service_info=$_REQUEST['service_info'];
	$rest = substr($service_info,0,-2);
	
$serviceArray=array('TataDoCoMoMX'=>'1001','RIAUninor'=>'1409','RIATataDoCoMo'=>'1009','RIATataDoCoMocdma'=>'1609','TataIndicom54646'=>'1602','TataDoCoMo54646'=>'1002','UninorAstro'=>'1416','UninorRT'=>'1412','TataDoCoMoMXcdma'=>'1601','RIATataDoCoMovmi'=>'1809','RedFMUninor'=>'1409','Uninor54646'=>'1402','Reliance54646'=>'1202','RedFMTataDoCoMo'=>'1010','TataDoCoMoFMJ'=>'1005','REDFMTataDoCoMocdma'=>'1610','REDFMTataDoCoMovmi'=>'1810','TataDoCoMoMXvmi'=>'1801','TataDoCoMoFMJcdma'=>'1605','MTVTataDoCoMocdma'=>'1603','MTVUninor'=>'1403','RelianceCM'=>'1208','MTVReliance'=>'1203','MTVTataDoCoMo'=>'1003');
foreach ($serviceArray as $k => $v)
                                  {
								  if($v==$service_info)
                                       {
$service_main_name="select value from misdata.base where service='$k' and type='Name'";
$service_main = mysql_query($service_main_name,$dbConn_218) or die(mysql_error());
$row_service_main = mysql_fetch_array($service_main);	
                             ?>
                      
						
                      <?php }

					  } 
			?>
<div class="page-header">
  	<h1>Customer Care- <?php echo $row_service_main['value'];?>
	</h1>
</div>
<div class="tab-pane active" id="pills-basic">
							<!--<h3>Pills</h3>-->
						  <div class="tab-content">
			
			<div id="<?php echo $cc_servicename;?>" class="tab-pane active">

	<?php
		if(!isset($_POST['Submit']))
	{
?>
<form name="frm" method="POST" action="" id="form-<?php echo $cc_servicename;?>" onSubmit="return checkfield()">
    <TABLE width="100%" align="center" bgcolor="#0369b3" border="0" cellpadding="4" cellspacing="1" class="table table-bordered table-condensed">
      <TBODY>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Enter Mobile No:</B></TD>
        <TD bgcolor="#FFFFFF">
	   <INPUT name="msisdn" id="msisdn" type="text" class="in">
		</TD>
			  <TD bgcolor="#FFFFFF">
			  <button class="btn btn-primary" id="submit-<?php echo $cc_servicename;?>" type="button">Submit</button>
			  <input type='hidden' name='service_info' value=<?php echo $service_info;?>>
		<input type='hidden' name='usrId' value=<?php echo $_SESSION['usrId'];?>>
		</TD>
      </TR>
	
	
<!--TR height="30">
        <td align="right" colspan="2" bgcolor="#FFFFFF">
			<button class="btn btn-primary" id="submit-<?php echo $cc_servicename;?>" type="button">Submit</button>
</td>
     </TR-->
  </TBODY>
  </TABLE>
  </form>
  
  <br/><br/>
  
<?php 
//echo $cc_servicename;
} ?>
			</div>
								
								
							  </div><!-- /.tab-content -->
							</div><!-- /.tabbable -->
						</div>
     <div id="loading"><img src="assets/img/loading-circle-48x48.gif" border="0" /></div> 
     <div id="alert-success" class="alert alert-success"></div> 
     <div id="grid"></div>  
						
					<div id="loading_billinghistory"><img src="assets/img/loading-circle-48x48.gif" border="0" /></div> 
						<div id="grid-view_billing_details"></div>
						<!--div id="grid-viewchargingDetails"></div-->
						
</div>
</div>
<!-- Footer section start here-->
  <?php
 require_once("footer.php");
  ?>
<!-- Footer section end here-->    
 	<script>
	 	$('#loading').hide();
		$('#loading_billinghistory').hide();
		$('#grid-view_billing_details').hide();
		$('#grid-view_billing_details').html('');
		$('#grid').hide();
		
		$('#submit-<?php echo $cc_servicename;?>').on('click', function() {
		
		$('#loading').show();
		$('#grid').hide();
		$('#grid').html('');
		$.fn.SubmitForm('<?php echo $cc_servicename;?>');
	});
	function viewbillinghistory(a,b,c) {
	//alert(a+" "+b+" "+c);
		$('#loading_billinghistory').show();
		$('#grid-view_billing_details').hide();
		$('#grid-view_billing_details').html('');
		$.fn.GetBillingDetails(a,b,c);
	};
	function viewchargingDetails(a,b) {
	//alert(a+" "+b+" "+c);
		$('#loading_billinghistory').show();
		$('#grid-view_billing_details').hide();
		$('#grid-view_billing_details').html('');
		$.fn.GetChargingDetails(a,b);
	};
	function do_Act_Deactivate(str,service_info,subsrv,action,act)
	{
		$('#loading_billinghistory').show();
		$('#grid-view_billing_details').hide();
		$('#grid-view_billing_details').html('');
		$.fn.do_Act_Deactivate_MND(str,service_info,subsrv,action,act);
	}
	
	function viewMessageDetails(a,b,c)
	{
	$('#loading_billinghistory').show();
		$('#grid-view_billing_details').hide();
		$('#grid-view_billing_details').html('');
		$.fn.GetMessagesDetails(a,b,c);
	}
$.fn.SubmitForm = function(act) {
		//alert(act);
		$.ajax({
				     	url: act+'.php',
					    //url: 'customer_care_reliance.php',
					//	data: '&action=del&username=<?php echo $username;?>&act='+act,
						data: $('#form-'+act).serialize() + '&action=del&username=<?php echo $username;?>',
						type: 'post',
						cache: false,
						dataType: 'html',
						success: function (abc) {
							$('#grid').html(abc);
							//alert('OK!'+abc);
							$('#loading').hide();
						}
						
					});
						
					$('#grid').show();
	
};

$.fn.GetBillingDetails = function(str,service_info,subsrv) {
		//alert(act);
		$.ajax({
				     	//url: 'Transactional.'+act+'.Store.php',
					    url: 'view_billing_details.php',
					    data: 'msisdn='+str+'&service_info='+service_info+'&subsrv='+subsrv,
						//data: $('#form-'+act).serialize() + '&action=del&username=<?php echo $username;?>',
						type: 'get',
						cache: false,
						dataType: 'html',
						success: function (abc) {
							$('#grid-view_billing_details').html(abc);
							//alert('OK!'+abc);
							$('#loading_billinghistory').hide();
						}
						
					});
						
					$('#grid-view_billing_details').show();
	
};

$.fn.GetChargingDetails = function(str,service_info) {
		$.ajax({
				     	url: 'viewchargingDetails.php',
					    data: 'msisdn='+str+'&service_info='+service_info,
						type: 'get',
						cache: false,
						dataType: 'html',
						success: function (abc) {
							$('#grid-view_billing_details').html(abc);
							//alert('OK!'+abc);
							$('#loading_billinghistory').hide();
						}
						
					});
						
					$('#grid-view_billing_details').show();
	
};

$.fn.do_Act_Deactivate_MND = function(str,service_info,subsrv,action,act) {
		//action>> da(deactivate)| a(activate)
		alert(str+" "+service_info+" "+subsrv+" "+action+" "+act);
	
		$.ajax({
		     	     	url: act+'.php',
					    data: 'msisdn='+str+'&service_info='+service_info+'&subsrv='+subsrv+'&act='+action,
						type: 'get',
						cache: false,
						dataType: 'html',
						success: function (abc) {
							$('#grid-view_billing_details').html(abc);
							$('#loading_billinghistory').hide();
						}
						
					});
						
					$('#grid-view_billing_details').show();
					
	
};

$.fn.GetMessagesDetails = function(pageName,str,service_info) {
		//alert(act);
		$.ajax({
				   	    url: pageName+'.php',
					    data: 'msisdn='+str+'&service_info='+service_info,
						type: 'get',
						cache: false,
						dataType: 'html',
						success: function (abc) {
							$('#grid-view_billing_details').html(abc);
							//alert('OK!'+abc);
							$('#loading_billinghistory').hide();
						}
						
					});
						
					$('#grid-view_billing_details').show();
	
};
$('#alert-success').hide();
</script>

<script>
    $(".second").pageslide({ direction: "right", modal: true });
</script>
</body>
</html>