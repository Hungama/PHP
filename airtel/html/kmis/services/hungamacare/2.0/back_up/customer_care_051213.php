<?php
ob_start();
session_start();
$user_id=$_SESSION['usrId'];
$PAGE_TAG='cc';
require_once("incs/common.php");
require_once("language.php");

//$SKIP=1;
ini_set('display_errors','0');
require_once("incs/db.php");
$flag=0;
$_SESSION['authid']='true';
require_once("base.php");
//asort($AR_SList);
$service_info=$_REQUEST['service_info'];
$listservices=$_SESSION["access_service"];
//print_r ($listservices);
?>
<!--Page based on service Logic will start here -->
<?php
			$listservices=$_SESSION["access_service"];
			$services = explode(",", $listservices);
			$totalscount=count($services);
			$mainservicearray=array();
			/*	for($i=0;$i<$totalscount;$i++)
				{
					if($Service_DESC[$services[$i]]['Operator']=='Airtel')
									{
							$mainservicearray[$Service_DESC[$services[$i]]['ServiceID']] = $Service_DESC[$services[$i]]['Name'];
									}
				}
				*/	
					foreach ($serviceArray as $k => $v)
                                {
                                    if(in_array($k,$services))
                                    {
									if($v!='')
										{
											//if($Service_DESC[$k]['Operator']=='Airtel')
											//{
												//$mainservicearray[$v] = $Service_DESC[$k]['Name'];
							if($v==1515)
							{
							$mainservicearray[$v] = $Service_DESC[$k]['Name'];
							$mainservicearray['15151'] = 'Airtel - Noor-E-Khuda';
							}
							else
							{
							$mainservicearray[$v] = $Service_DESC[$k]['Name'];
							}
											//}
										}
									} 
								}
					
							 
							 asort($mainservicearray);
		//print_r ($mainservicearray);
			
//This CC interface is only for uninor
	$include_cc_page=14;
	switch($include_cc_page)
{
	case '14':
		$cc_servicename = "customer_care_process";
		$service='MTS';
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

  $(document).ready(function() {
    $('.multiselect').multiselect({
      buttonClass: 'btn',
      buttonWidth: 'auto',
      buttonText: function(options) {
        if (options.length == 0) {
          return 'None selected <b class="caret"></b>';
        }
        else if (options.length > 3) {
          return options.length + ' selected  <b class="caret"></b>';
        }
        else {
          var selected = '';
          options.each(function() {
            selected += $(this).text() + ', ';
          });
          return selected.substr(0, selected.length -2) + ' <b class="caret"></b>';
        }
      }
    });
  });
</script>

</head>

<!--body onload="javascript:getModuleList(<?= $service_info?>)"-->
<body>
<div class="navbar navbar-inner">
<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
</div>

<div class="container">

<div class="row" style="height:auto">

<div class="page-header">
  	<h1>Customer Care <?php //echo '-'.$service;?> </h1>
</div>
<div class="tab-pane active" id="pills-basic">
		 <div class="tab-content" style="height:100%;overflow:visible;">
			<div id="<?php echo $cc_servicename;?>" >

	<?php
	
	if(!isset($_POST['Submit']))
	{
//	$query = mysql_query($get_service_name, $dbConn);
?>
<form name="frm" method="POST" action="" id="form-<?php echo $cc_servicename;?>" onSubmit="return checkfield()">
    <TABLE width="100%" class="table table-bordered table-condensed">
      <TBODY>
      <TR>
 <TD bgcolor="#FFFFFF" width="15%">
 <INPUT name="msisdn" id="msisdn" type="text" class="in" placeholder="Enter Mobile No" style="float:right">
	  </TD>       
	  
		 <TD width="20%" style="vertical-align:middle;padding:2px"><input name="service_info_duration" type="radio" id="service_info_duration" value="2" checked>&nbsp;<span class="label label-important">Last Six Months </span>&nbsp;&nbsp;&nbsp;<input name="service_info_duration" type="radio" id="service_info_duration" value="1">&nbsp;<span class="label label-info"> All Time</span>
		</td>
        <TD bgcolor="#FFFFFF"><select class="multiselect" name='service_info[]' multiple>
			<?php 
			foreach($mainservicearray as $s_id=>$s_val)
							 {?>
						 <option value="<?php echo $s_id;?>"><?php echo $s_val;?></option>
							<?php	} ?>
			
			</select>
		</td>
			  <TD bgcolor="#FFFFFF">
			  <input type="hidden" name="Submit" value="Submit"/>
			    <button class="btn btn-primary" id="submit-<?php echo $cc_servicename;?>" type="button">Submit</button>
				<input type='hidden' name='usrId' value=<?php echo $user_id;?>>
		</TD>
      </TR>
	
</TBODY>
  </TABLE>
  </form>
 <?php 
} ?>
			</div>
							
							
						
     <div id="loading"><img src="assets/img/loading-circle-48x48.gif" border="0" /></div> 
     <div id="alert-success" class="alert alert-success"></div> 
     <div id="grid"></div>  
						
					<div id="loading_billinghistory"><img src="assets/img/loading-circle-48x48.gif" border="0" /></div> 
						<div id="grid-view_billing_details"></div>
						 </div><!-- /.tab-content -->
						</div><!-- /.tabbable -->					
</div>
</div>
<!-- Footer section start here-->
  <?php
 //require_once("footer.php");
include "Menu-Vertical.php";
  ?>
<!-- Footer section end here-->    
<script src="assets/js/jquery.pageslide.js"></script>
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
	//alert(a+" "+b);
		$('#loading_billinghistory').show();
		$('#grid-view_billing_details').hide();
		$('#grid-view_billing_details').html('');
		$.fn.GetChargingDetails(a,b);
	};
	function do_Act_Deactivate(str,service_info,subsrv,action,act,catid)
	{
		$('#loading_billinghistory').show();
		$('#grid-view_billing_details').hide();
		$('#grid-view_billing_details').html('');
		$.fn.do_Act_Deactivate_MND(str,service_info,subsrv,action,act,catid);
	}
	
	function viewMessageDetails(a,b,c)
	{
	/*$('#loading_billinghistory').show();
		$('#grid-view_billing_details').hide();
		$('#grid-view_billing_details').html('');
		$.fn.GetMessagesDetails(a,b,c);*/
	}
$.fn.SubmitForm = function(act) {
	$('#grid-view_billing_details').hide();
		$('#grid-view_billing_details').html('');
		//alert(act);
		$.ajax({
				     	url: act+'.php',
					 //	data: '&action=del&username=<?php echo $username;?>&act='+act,
						data: $('#form-'+act).serialize() + '&username=<?php echo $username;?>',
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

$.fn.do_Act_Deactivate_MND = function(str,service_info,subsrv,action,act,catid) {
		//action>> da(deactivate)| a(activate)
	//	alert(str+" "+service_info+" "+subsrv+" "+action+" "+act);
	
	$.ajax({
		     	     	url: act+'.php',
					    data: 'msisdn='+str+'&service_info='+service_info+'&subsrv='+subsrv+'&act='+action+'&catid='+catid,
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