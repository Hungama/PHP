<?php
ob_start();
session_start();
$SKIP = 1;
ini_set('display_errors', '0');
include("db.php");
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
                    document.getElementById('alert_placeholder').style.display='inline';
                    var keyword=document.forms[type]["form_sms_keyword"].value;
                    var response=document.forms[type]["form_sms_resp"].value;
                    if (keyword==null || keyword=="")
                    {
                        bootstrap_alert.warning('Please enter keyword.');
                        return false;
                    }  
                    else if (form_sms_resp==null || form_sms_resp=="")
                    {
                        bootstrap_alert.warning('Please select ussd string.');
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
            }

         
	
            function startStopUssd(type,batchid) {
                if(type=='start')
                {
                    document.getElementById("btn_action_push_"+batchid).disabled=true;
                    document.getElementById("btn_action_push_"+batchid).style.display = 'none';
                    document.getElementById("btn_action_stop_"+batchid).style.display = 'inline';
                }
                else if(type=='kill')
                {
                    document.getElementById("btn_action_kill_"+batchid).disabled=true;
                }
                else
                {
                    document.getElementById("btn_action_stop_"+batchid).disabled=true;
                    document.getElementById("btn_action_stop_"+batchid).style.display = 'none';
                    document.getElementById("btn_action_push_"+batchid).style.display = 'inline';
                }
                var xmlhttp;
                if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp=new XMLHttpRequest();
                } else { // code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange=function() {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                        //alert(xmlhttp.responseText);
                        if(type=='start')
                        {
                            document.getElementById("btn_action_push_"+batchid).disabled=false;
                        }
                        else if(type=='kill')
                        {
                            document.getElementById("btn_action_kill_"+batchid).disabled=true;
                        }
                        else
                        {
                            document.getElementById("btn_action_stop_"+batchid).disabled=false;
                        }
                        if(xmlhttp.responseText=='100')
                        {
                            alert('Operation completed.');
                            viewUploadhistory('ussd');
                        }
                        else
                        {
                            alert('Operation failed.');
                        }
		
                    }
                }	
                var url="start_stopUssdFile.php?type="+type+"&batchid="+batchid;
                xmlhttp.open("GET",url,true);
                xmlhttp.send();	
            }
            function stopautorefresh()
            {
                clearTimeout(xhrTimeout); 
            }


        </script>

        <!-- Bootstrap CSS Toolkit styles -->
    </head>

    <body onload="javascript:viewSMSKeyboardhistory('smskey')">

        <div class="navbar navbar-inner">
            <a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
        </div>

        <div class="container">
            <div class="row">

                <div class="page-header">
                    <h1> BNB ADMIN PANEL<small>&nbsp;&nbsp;</small></h1>
                </div>
                <div class="tab-pane active" id="pills-basic">
                    <div class="tabbable">
                        <ul class="nav nav-pills">
                         <li class="active"><a href="#sms" data-toggle="tab" data-act="menu" onclick="javascript:viewSMSKeyboardhistory('smskey')">SMS </a></li>
						 <li class="active"><a href="#menu" data-toggle="tab" data-act="menu" onclick="javascript:viewSMSKeyboardhistory('smskey')">IVR</a></li>
						 <li class="active"><a href="#menu" data-toggle="tab" data-act="menu" onclick="javascript:viewSMSKeyboardhistory('smskey')">Dashboard </a></li>
						</ul>
                        <div class="tab-content">
                           <!--SUB keyword section start here-->

                            <div id="sms" class="tab-pane active">
                                <form id="form-sms" name="form-sms" method="post" enctype="multipart/form-data">
                                    <table class="table table-bordered table-condensed">
									<tr><td>Keyword </td><td  align="left"><input type="text" class="text" name="form_sms_keyword" id="form_sms_keyword" value=""/></td></tr>
                                    <tr><td>Response</td><td  align="left"><input type="text" class="text" name="form_sms_resp" id="form_sms_resp" value=""/></td></tr>    
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
        <script type="text/javascript">
            $(document).ready(function() {
                $('#schedule_date').daterangepicker();
            });
        </script>
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
            $.fn.GetUploadSubMenuHistory = function(DTMF) {
                //$('#loading').show();
                $.ajax({
	     
                    url: 'viewsmsconfighistory.php',
                    data: 'type=smskey',
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

      
            $("form#form-sms").submit(function(){ 
                var isok = checkfield('form-sms');
                if(isok)
                { 
                    document.getElementById('alert_placeholder').style.display='none';
                    //$('#loading').show();
                    var formData = new FormData($("form#form-sms")[0]);
                    $.ajax({
                        url: 'bulkupload_menu_process.php',
                        type: 'POST',
                        data: formData,
                        async: false,
                        success: function (data) {
                            document.getElementById('grid-sms').style.display='inline';
                            document.getElementById('grid-sms').innerHTML=data;
                            resestForm('sms');
                            viewUploadMenuhistory('DTMF')
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