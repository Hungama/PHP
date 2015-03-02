<?php
ob_start();
session_start();
//$user_id = $_SESSION['usrId'];
$user_id = $_SESSION['loginId'];
$PAGE_TAG = 'switch_cc';
require_once("incs/common.php");
ini_set('display_errors', '0');
//require_once("incs/database.php");
require_once("incs/db.php");
require_once("language.php");
require_once("base.php");
$flag = 0;
$_SESSION['authid'] = 'true';
$service_info = $_REQUEST['service_info'];

$listservices = $_SESSION["access_service"];
//print_r($serviceArray);
$services = explode(",", $listservices);


$serviceArray = array('Vodafone - Radio Unlimited' => '1301');
//$serviceArray = array('VodafoneMU' => '1301');
//$circleArray = array('All' => 'All', 'APD' => 'Andhra Pradesh', 'BIH' => 'Bihar', 'GUJ' => 'Gujarat', 'MAH' => 'Maharashtra', 'UPE' => 'UP EAST', 'UPW' => 'UP WEST');

$circleArray = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh','All' => 'All');

$timeFrom = mktime(9, 30, 0);
$timeTo = mktime(21, 30, 0);
$currTime = mktime(date('H'), date('i'), date('s'));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!-- include all required CSS & JS File start here -->
        <script src="../ts_picker.js"></script>
        <?php
        require_once("main-header.php");
        ?>
        <!-- include all required CSS & JS File end here -->
        <script type="text/javascript" language="javascript">
            function setType(type){ 
                if(type == 'circle'){
                    document.getElementById('tr_Circle').style.display='table-row';
                    document.getElementById('tr_File').style.display='none';
                }else{
                    document.getElementById('tr_File').style.display='table-row';
                    document.getElementById('tr_Circle').style.display='none';
                }
            }
			
			function setFileType(type){ 
					if(type == 0)
					{
					alert('Please select TIVR type');
					}
                if(type == 'type2_SplBase'){
                    document.getElementById('typelist').style.display='inline';
                    }else{
                    document.getElementById('typelist').style.display='none';
                }
            }
			
            function checkfield(type) {
			
                document.getElementById('alert_placeholder').style.display='inline';
                var service_info=document.forms[type]["service_info"].value; 
                var switch_info=document.forms[type]["switch_info"].value;
                var circle_info=document.forms[type]["circle_info"].value;
				var upfile=document.forms[type]["upfile"].value;
                var timestamp=document.forms[type]["timestamp"].value;
                var timestamp1=document.forms[type]["timestamp1"].value;
			
                var stype = document.getElementsByName('via_type');
                var via_type;
                for(var i = 0; i < stype.length; i++){
                    if(stype[i].checked){
                        via_type = stype[i].value;
                    }
                }
                if (service_info==0) {
                    bootstrap_alert.warning('Please select service');
                    return false;
                } else if (switch_info==0) {
                    bootstrap_alert.warning('Please select switch');
                    return false;
                }else if (via_type=='') {
                    bootstrap_alert.warning('Please select type');
                    return false;
                }
                if(via_type == 'circle' && (circle_info == 0))
                {
                    bootstrap_alert.warning('Please select circle');
                    return false;
                }
                 if(via_type == 'file' && (upfile==null || upfile==""))
                {
                    bootstrap_alert.warning('please upload a file');
                    return false;
                }
                if (timestamp == '') {
                    bootstrap_alert.warning('Please select start time');
                    return false;
                }
                if (timestamp1 == '') {
                    bootstrap_alert.warning('Please select end time');
                    return false;
                }
               if(via_type == 'file')
                {
                    var ext = upfile.substring(upfile.lastIndexOf('.') + 1);

                    if(ext=="txt")
                    {
                        var count=(upfile.split(".").length - 1);
                        if(count==1)
                        {
                            //$('#loading').show();
                            //hideMessageBox();
                            //return false;
                            return true;
                        }
                        else
                        {
                            bootstrap_alert.warning('<?php echo JS_FILETYPEERROR; ?>');
                            return false;
                        }
                    }
                    else
                    {
                        bootstrap_alert.warning('<?php echo JS_FILETYPEERROR; ?>');
                        return false;
                    }
                }
                //$('#loading').show();
                //                return false;
                return true;
            }

            function resestForm()
            {
                document.getElementById('form_uninor_switch').reset();
            }

            $(".alert").alert();
            $(".alert").alert('close');

            bootstrap_alert = function() {}
            bootstrap_alert.warning = function(message) {
                $('#alert_placeholder').html('<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a><span>'+message+'</span></div>')
            }
        </script>
        <!-- Bootstrap CSS Toolkit styles -->
        <link rel="stylesheet" href="css/jquery.fileupload-ui.css">
    </head>
      <body onload="javascript:viewSMSUploadhistory('switch')">
        <div class="navbar navbar-inner">
            <a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
        </div>

        <div class="container">
            <div class="row">
                <div class="page-header">
                    <h1>Voda TIVR Configuration<small>&nbsp;&nbsp;</small></h1>
                </div>
                <div class="tab-pane active" id="pills-basic">
                    <div class="tabbable">
                        <ul class="nav nav-pills">
                            <li class="active"><a href="#active" onclick="viewSMSUploadhistory('switch')" data-toggle="tab" data-act="activation">TIVR</a></li>
                        </ul>
                        <div class="tab-content">
                            <!-- Activation section start here-->
                            <div id="active" class="tab-pane active">
                                <form id="form_uninor_switch" name="form_uninor_switch" method="post" enctype="multipart/form-data">
                                    <table class="table table-bordered table-condensed">
                                        <tr>
                                            <td align="left" width="16%" height="32"><span>Service&nbsp;</span></td>
                                            <td><select name="service_info" id="service_info">
                                                    <option value="0">Select Service</option>
                                                    <?php foreach ($serviceArray as $s_val => $s_id) {
												/*	$S_Name=$serviceNameArray[$s_id];
													if(in_array($S_Name,$services)) {
													?>
                                                      <option value="<?php echo $s_id; ?>"><?php echo $s_val; ?></option>
                                                    <?php } */?>
													<option value="<?php echo $s_id; ?>"><?php echo $s_val; ?></option>

												<?php	}?>
													
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" width="16%" height="32"><span>TIVR Type&nbsp;</span></td>
                                            <td><select name="switch_info" id="switch_info" onchange="javascript:setFileType(this.value)">
                                                    <option value="0">Select Type</option>
                                                    <option value="type1_7days">7 days  free access to all non active user</option>
                                                    <option value="type2_SplBase">7 days free access to  specific base ( File Upload)</option>
                                                    <option value="type3_OneDay">One day totally free access to entire base</option>
													<option value="type4_3Songs">Open offer three song selection then subscribe ( For no active user)</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" width="16%" height="32"><span>Type&nbsp;</span></td>
                                            <td>
                                                Circle&nbsp;&nbsp;<input type="radio" name="via_type" value="circle" checked="checked" onclick="setType(this.value)"/>
												<span style="display:none" id="typelist">
												  &nbsp;&nbsp;File&nbsp;&nbsp;<input type="radio" name="via_type" value="file" onclick="setType(this.value)" />&nbsp;&nbsp;
                                             </span>
                                            </td>
                                        </tr>
										
                                        <tr id="tr_Circle">
                                            <td align="left" width="16%" height="32"><span>Circle&nbsp;</span></td>
                                            <td><select name="circle_info" id="circle_info">
                                                    <option value="0">Select Circle</option>
                                                    <?php foreach ($circleArray as $circle_id => $circle_val) { ?>
                                                        <option value="<?php echo $circle_id; ?>"><?php echo $circle_val; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr id="tr_File" style="display:none">
                                            <td align="left" width="16%" height="32"><span>Browse File To Upload </span></td>
                                            <td>
                                                <INPUT name="upfile" id='upfile' type="file" class="in">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="left" width="16%" height="32"><span>Start Time&nbsp;</span></td>
                                            <td><input type="Text" name="timestamp" id="timestamp" value="">
                                                    <a href="javascript:show_calendar('document.form_uninor_switch.timestamp', document.form_uninor_switch.timestamp.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" width="16%" height="32"><span>End Time&nbsp;</span></td>
                                            <td><input type="Text" name="timestamp1" id="timestamp1" value="">
                                                    <a href="javascript:show_calendar('document.form_uninor_switch.timestamp1', document.form_uninor_switch.timestamp1.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <INPUT type="hidden" name="action" value="switch" class="in"/>
                                                <input id="upfor" type="hidden" value="switch" name="upfor"/>
                                               <button class="btn btn-primary" style="float:right">Submit</button>						  
                                                <input type='hidden' name='usrId' value=<?php echo $user_id; ?>>
                                            </td>
                                        </tr>
                                    </table>
                                </form>	
                                <div id="grid-active"></div>
                            </div>

                        </div><!-- /.tab-content -->
                    </div><!-- /.tabbable -->
                </div>

                <div class="alert alert-danger" style='display:none' id="error_box"></div>
                <div id = "alert_placeholder"></div>
                                                            <div id="loading"><img src="assets/img/loading-circle-48x48.gif" border="0" /></div> 
                <div id="grid-view_upload_history"></div> 

            </div>
        </div>
        <!-- Footer section start here-->
        <?php
        require_once("footer.php");
        ?>
        <!-- Footer section end here-->
        <script src="assets/js/jquery.pageslide.js"></script>
        <script>
  
            //$('#loading').hide();
            $('#grid-active').hide();
            $('#grid-active').html('');
            function viewSMSUploadhistory() { 
                document.getElementById('alert_placeholder').style.display='none';
                $('#grid-view_upload_history').hide();
                $('#grid-view_upload_history').html('');
                // $('#loading').show();
                //  $('#loading').hide();
                $.fn.GetUploadHistory('switch');
            };
	
            $.fn.GetUploadHistory = function(type) { 
                //$('#loading').show();
                $.ajax({
	     
                    url: 'voda_tnb_view_history.php',
                    data: 'type='+type,
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


            $("form#form_uninor_switch").submit(function(){ 
                var isok = checkfield('form_uninor_switch');
                if(isok)
                {
                    document.getElementById('alert_placeholder').style.display='none';
                    var formData = new FormData($("form#form_uninor_switch")[0]);
                    $.ajax({
                        url: 'voda_tnb_process.php',
                        type: 'POST',
                        data: formData,
                        async: false,
                        success: function (data) {
                            document.getElementById('grid-active').style.display='inline';
                            document.getElementById('grid-active').innerHTML=data;
                            $('#loading').hide();
                            resestForm();
                            viewSMSUploadhistory('switch');
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
            function showStatusConfirm(swid,action) { 
                if(action == 'enable') {
                    var answer = confirm("Are You Sure To Want Start Selected Time-Slot?");
                    if(answer) {
                    }else{
                        return false;
                    }
                } 
                if(action == 'disable') {
                    var answer = confirm("Are You Sure To Want End Selected Time-Slot?");
                    if(answer){
                        
                    } 
                    else{
                        return false;
                    } 
                } 
                if(action == 'delete') {
                    var answer = confirm("Are You Sure To Want Delete Selected Time-Slot?");
                    if(answer){
                        
                    } 
                    else{
                        return false;
                    } 
                } 
                document.getElementById('alert_placeholder').style.display='none';
                $('#loading').show();
                var datastring = 'id='+swid+'&act='+action;
                $.ajax({
                    url: 'voda_switch_view_history.php',
                    type: 'POST',
                    data: datastring,
                    success: function (data) {
                        $('#loading').hide();
                        viewSMSUploadhistory();
                    }
                });
                
                return false;
            }
 
            $(".second").pageslide({ direction: "right", modal: true });
            
        </script>
        <!-- added for file uplaod using bootstarp api-->
    </body>
</html>