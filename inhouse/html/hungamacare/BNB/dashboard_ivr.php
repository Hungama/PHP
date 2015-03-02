<?php
ob_start();
session_start();
$SKIP = 1;
ini_set('display_errors', '0');
include("db.php");
$operatorarray = array('all'=>'ALL','vodm'=>'VODAFONE','unim'=>'UNINOR','airm'=>'AIRTEL','airc'=>'AIRCEL','mts'=>'MTS','relm'=>'RELIANCE','tatm'=>'TATM','tatc'=>'TATC');
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
      </script>
<?php

?>
        <!-- Bootstrap CSS Toolkit styles -->
    </head>

    <body>
	

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
                         <li><a href="dashboard_sms.php">SMS </a></li>
						 <li class="active"><a href="#">IVR</a></li>
						 <li><a href="javascript:void(0)">Dashboard </a></li>
						 <!--li><a href="dashboard.php">Dashboard </a></li-->
				</ul>
				 </div><!-- /.tabbable -->
                </div>

                <div class="tab-pane active" id="pills-basic">
                    <div class="tabbable">
                        <ul class="nav nav-pills">
                         <li class="active"><a href="#contest_info" data-toggle="tab" data-act="contest_info" onclick="javascript:viewIvrMIS('contest_info','all')">Contest Info</a></li>
						 <!--li><a href="#call_logs" data-toggle="tab" data-act="call_logs">Call Logs</a></li-->
						 <li><a href="#mis" data-toggle="tab" data-act="mis" onclick="javascript:viewIvrMIS('ivrmis','all')">MIS</a></li>
						</ul>
                        <div class="tab-content">
                           <!--contest_info keyword section start here-->
                            <div id="contest_info" class="tab-pane active">
                                <table class="table table-bordered table-condensed">
                                        <tr>
                                            <td align="left" width="16%" height="32"><span>Operator&nbsp;</span></td>
                                            <td><select name="service_info" id="service_info" onchange="javascript:viewIvrMIS('contest_info',this.value)">
                                                    <option value="0">Select Operator</option>
                                                    <?php foreach ($operatorarray as $s_id => $s_val) { ?>
                                                        <option value="<?php echo $s_id; ?>"><?php echo $s_val; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
										</table>
							  <div id="grid-contest_info">

                                </div>				
                            </div>		
						   <!--contest_info keyword section end here-->
					 <!--call_logs section start here-->
					 <div id="call_logs" class="tab-pane">
					 <table class="table table-bordered table-condensed">
					 <tr><td><h2>Coming Soon</h2> </td> </tr>
					</table>
					   <div id="grid-call_logs"></div>				
					 </div>		

					<!--call_logs section end here-->

					<!--MIS section start here-->
					<div id="mis" class="tab-pane">
					 <table class="table table-bordered table-condensed">
					 <tr><td><h2>Coming Soon</h2> </td> </tr>
					</table>
					   <div id="grid-mis"></div>				
					 </div>									
<!--MIS section end here-->                
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
              function viewIvrMIS(a,b) {
                document.getElementById('alert_placeholder').style.display='none';
                $('#loading').show();
                $('#grid-view_upload_history').hide();
                $('#grid-view_upload_history').html('');
                $('#grid-view_menu_message').hide();
                $('#grid-view_menu_message').html('');
				$.fn.GetUploadSubMenuHistory(a,b);
            };
            $.fn.GetUploadSubMenuHistory = function(a,b) {
                    $.ajax({	     
                    url: 'viewivrmis_bnb.php',
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
			$(".second").pageslide({ direction: "right", modal: true });
        </script>
    </body>
</html>