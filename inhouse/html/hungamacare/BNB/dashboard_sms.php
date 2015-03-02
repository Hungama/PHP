<?php
ob_start();
session_start();
$SKIP = 1;
ini_set('display_errors', '0');
include("db.php");
$operatorarray = array('all'=>'ALL','vodm'=>'VODAFONE','unim'=>'UNINOR','airm'=>'AIRTEL','airc'=>'AIRCEL','mts'=>'MTS','relm'=>'RELIANCE','tatm'=>'TATM','tatc'=>'TATC');
$uname=$_SESSION["logedinuser"];

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!-- include all required CSS & JS File start here -->
        <?php
        require_once("main-header.php");
        ?>
        <!-- include all required CSS & JS File end here -->
        <link rel="stylesheet" type="text/css" media="all" href="daterangepicker.css" />
        <script type="text/javascript" src="date.js"></script>
        <script type="text/javascript" src="daterangepicker.js"></script>
        <script type="text/javascript" language="javascript">
	
            function checkfield(type){
			if(type=='form-sms')
                {
            
					$('#loading').hide();
					showhideMessageBox();
                    document.getElementById('alert_placeholder').style.display='inline';
                    var keyword=document.forms[type]["form_sms_keyword"].value;
					var subkeyword=document.forms[type]["form_sms_subkeyword"].value;
					
                    var response=document.forms[type]["form_sms_resp"].value;
                    if (keyword==null || keyword=="")
                    {
                        bootstrap_alert.warning('Please select keyword.');
                        return false;
                    }  
					else if (subkeyword==null || subkeyword=="")
                    {
                        bootstrap_alert.warning('Please enter Sub Keyword.');
                        return false;
                    }
                    else if (response==null || response=="")
                    {
                        bootstrap_alert.warning('Please enter response text.');
                        return false;
                    }
                    $('#loading').show();
                    showhideMessageBox();
                    return true;
                }
               
           }

            $(".alert").alert();
            $(".alert").alert('close');

            bootstrap_alert = function() {}
            bootstrap_alert.warning = function(message) {
                $('#alert_placeholder').html('<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a><span>'+message+'</span></div>')
            }
    
            function showhideMessageBox()
            {
                document.getElementById('error_box').style.display='none';
                document.getElementById('alert_placeholder').style.display='none';
                document.getElementById('grid-view_menu_message').style.display='none';
				document.getElementById('grid-sms').style.display='none';
				
            }

         
	
            function deleteSMSKeyword(smsid,smskey) {
			showhideMessageBox();
               var xmlhttp;
                if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp=new XMLHttpRequest();
                } else { // code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange=function() {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                       document.getElementById("btn_action_stop_"+smsid).disabled=false;
                       
                        if(xmlhttp.responseText=='100')
                        {
                          bootstrap_alert.warning('Operation completed.');
						  document.getElementById("ajax_loader_"+smsid).style.display='none';
                          viewSMSKeyboardhistory('smskey');
                        }
                        else
                        {
                          bootstrap_alert.warning('Operation failed.');
                        }
		
                    }
					 else
				   {
				document.getElementById("ajax_loader_"+smsid).style.display='inline';
				  }
                }	
                var url="action_bnb_sms.php?smsid="+smsid+"&smskey="+smskey;
                xmlhttp.open("GET",url,true);
                xmlhttp.send();	
            }

function confirmDelete(smsid,smskey)
{
var x;
var r=confirm("Do you want to delete this Keyword.");
if (r==true)
  {
  deleteSMSKeyword(smsid,smskey);
  }
}

        </script>
<?php

?>
        <!-- Bootstrap CSS Toolkit styles -->
    </head>

    <body onload="javascript:viewSMSKeyboardhistory('smskey')">
	

        <div class="navbar navbar-inner">
            <a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
        </div>

        <div class="container">
            <div class="row">

                <div class="page-header">
                    <h1>BNB ADMIN PANEL<small>&nbsp;&nbsp;</small></h1>
                </div>
				<div class="tab-pane active" id="pills-basic">
                    <div class="tabbable">
				   <ul class="nav nav-pills">
                         <li class="active"><a href="javascript:void(0)">SMS </a></li>
<?php 
if($uname=='demo')
{
?>						
						<li><a href="dashboard_ivr.php">IVR</a></li>
						 <li><a href="javascript:void(0)">Dashboard </a></li>
<?php } ?>	
	<!--li><a href="dashboard.php">Dashboard </a></li-->
				</ul>
				 </div><!-- /.tabbable -->
                </div>

                <div class="tab-pane active" id="pills-basic">
                    <div class="tabbable">
                        <ul class="nav nav-pills">
                         <li class="active"><a href="#sms" data-toggle="tab" data-act="menu" onclick="javascript:viewSMSKeyboardhistory('smskey')">Keyword creation</a></li>
<?php 
if($uname=='demo')
{
?>							
						<li><a href="#smsmis_txhistory" data-toggle="tab" data-act="smsmis_txhistory" onclick="javascript:viewSMSMIS('smsmis_txhistory','all')">Downloadable Transaction Report </a></li>
						 <li><a href="#dash" data-toggle="tab" data-act="dash" onclick="javascript:viewSMSMIS('smsmis_info','all')">MIS</a></li>
<?php }?>	
	</ul>
                        <div class="tab-content">
                           <!--SUB keyword section start here-->

                            <div id="sms" class="tab-pane active">
                                <form id="form-sms" name="form-sms" method="post" enctype="multipart/form-data">
                                    <table class="table table-bordered table-condensed">
							<tr>		<td align="left" width="16%" height="32"><span>Master Keyword</span></td>
						<td>
									<select name="form_sms_keyword" id="form_sms_keyword">
								<option value="0">--Select Keyword--</option>
				<?php
				$query="SELECT master_keywordId,sms_keyword FROM master_db.tbl_bnb_sms_manager WHERE status=1";
				$result = mysql_query($query);
				while($data = mysql_fetch_array($result))
				{?>
				<option value="<?php echo $data['master_keywordId'];?>"><?php echo $data['sms_keyword'];?></option>
				<?php
				}
				?>				
								
							</select>
								</td></tr>	
									<tr><td>Sub-Keyword </td>
									<td  align="left"><input type="text" class="text" name="form_sms_subkeyword" id="form_sms_subkeyword" value=""/></td>
									</tr>
                                    <tr><td>Response</td>
									<td  align="left">
									<textarea cols="40" rows="4" maxlength="400" name="form_sms_resp" id="form_sms_resp"></textarea>
									</td></tr>    
										 <tr>
                                            <td colspan="2">
                                                <input type="hidden" name="post_for" id="post_for" value="DTMF"/>
                                                <button class="btn btn-primary" style="float:right">Submit</button>
                                            </td>
                                        </tr>

                                    </table>
                                </form>	

                                <div id="grid-sms">

                                </div>				
                            </div>		
<!--SUB keyword section end here-->
<!--smsmis_txhistory section start here-->
					 <div id="smsmis_txhistory" class="tab-pane">
					    <table class="table table-bordered table-condensed">
                                        <tr>
                                            <td align="left" width="16%" height="32"><span>Operator&nbsp;</span></td>
                                            <td><select name="service_info" id="service_info" onchange="javascript:viewSMSMIS('smsmis_txhistory',this.value)">
                                                    <option value="0">Select Operator</option>
                                                    <?php foreach ($operatorarray as $s_id => $s_val) { ?>
                                                        <option value="<?php echo $s_id; ?>"><?php echo $s_val; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
										</table>
					   <div id="grid-smsmis_txhistory"></div>				
					 </div>		

<!--smsmis_txhistory section end here-->

<!--Dashboard section start here-->
					<div id="dash" class="tab-pane">
					 <table class="table table-bordered table-condensed">
                                        <tr>
                                            <td align="left" width="16%" height="32"><span>Operator&nbsp;</span></td>
                                            <td><select name="service_info" id="service_info" onchange="javascript:viewSMSMIS('smsmis_info',this.value)">
                                                    <option value="0">Select Operator</option>
                                                    <?php foreach ($operatorarray as $s_id => $s_val) { ?>
                                                        <option value="<?php echo $s_id; ?>"><?php echo $s_val; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
										</table>
					   <div id="grid-dash"></div>				
					 </div>									
<!--Dashboard section end here-->                
                        </div><!-- /.tab-content -->
                    </div><!-- /.tabbable -->
                </div>

                <div class="alert alert-danger" style='display:none' id="error_box"></div>
                <div id = "alert_placeholder"></div>
                <div id="grid-view_menu_message"></div> 

                <div id="loading"><img src="../2.0/assets/img/loading-circle-48x48.gif" border="0" /></div> 

                <div id="grid-view_upload_history"></div> 

            </div>
        </div>
        <!-- Footer section start here-->
<?php
require_once("footer_ussd.php");
?>
        <script src="assets/js/jquery.pageslide.js"></script>
   
        <script>
            function resestForm(type)
            {
                var formname='form-'+type;
                document.getElementById(formname).reset();
            }

            $('#loading').hide();
            $('#grid-active').hide();
            $('#grid-active').html('');
              function viewSMSKeyboardhistory(a) {
                document.getElementById('alert_placeholder').style.display='none';
                $('#loading').show();
                $('#grid-view_upload_history').hide();
                $('#grid-view_upload_history').html('');
                $('#grid-view_menu_message').hide();
                $('#grid-view_menu_message').html('');
				$.fn.GetUploadSubMenuHistory(a);
            };
            $.fn.GetUploadSubMenuHistory = function(a) {
                //$('#loading').show();
                $.ajax({
	     
                    url: 'viewsmsconfighistory.php',
                    data: 'type='+a,
                    //data: $('#form-'+act).serialize() + '&action=del&username=<?php echo $username; ?>',
                    type: 'get',
                    cache: false,
                    dataType: 'html',
                    success: function (abc) {
                        $('#grid-view_upload_history').html(abc);
                        $('#loading').hide();
                    }
						
                });
						
                $('#grid-view_upload_history').show();
	
            };
              function viewSMSMIS(a,b) {
                document.getElementById('alert_placeholder').style.display='none';
                $('#loading').show();
                $('#grid-view_upload_history').hide();
                $('#grid-view_upload_history').html('');
                $('#grid-view_menu_message').hide();
                $('#grid-view_menu_message').html('');
				$.fn.GetSmsMisBnb(a,b);
            };
            $.fn.GetSmsMisBnb = function(a,b) {
                    $.ajax({	     
                    url: 'viewsmsmis_bnb.php',
                    data: 'type='+a+'&operator='+b,
                    type: 'get',
                    cache: false,
                    dataType: 'html',
                    success: function (abc) {
                        $('#grid-view_upload_history').html(abc);
                        $('#loading').hide();
                    }
						
                });
						
                $('#grid-view_upload_history').show();
	
            };
      
            $("form#form-sms").submit(function(){ 
                var isok = checkfield('form-sms');
                if(isok)
                { 
                    document.getElementById('alert_placeholder').style.display='none';
                    //$('#loading').show();
                    var formData = new FormData($("form#form-sms")[0]);
                    $.ajax({
                        url: 'dashboard_sms_process.php',
                        type: 'POST',
                        data: formData,
                        async: false,
                        success: function (data) {
                            document.getElementById('grid-sms').style.display='inline';
                            document.getElementById('grid-sms').innerHTML=data;
                            resestForm('sms');
                            viewSMSKeyboardhistory('smskey')
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });

                    return false;
                }
                else
                {
                    return false;
                }
            });
            $(".second").pageslide({ direction: "right", modal: true });
        </script>
    </body>
</html>