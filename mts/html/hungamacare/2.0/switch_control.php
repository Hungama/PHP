<?php
ob_start();
session_start();
$user_id = $_SESSION['usrId'];
$PAGE_TAG = 'switch_control';
require_once("incs/common.php");
ini_set('display_errors', '0');
require_once("incs/db.php");
require_once("language.php");
require_once("base.php");
$flag = 0;
$_SESSION['authid'] = 'true';
$servicearray=array('1101'=>'MTS - muZic Unlimited','1111'=>'MTS - Bhakti Sagar','1116'=>'MTS - Voice Alerts','1110'=>'MTS - Red FM',
                        '1102'=>'MTS - 54646','1113'=>'MTS - MPD','1106'=>'MTSFMJ','1103'=>'MTS - MTV DJ Dial','1124'=>'MTS - muZic2Cinema');
$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAR' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', '' => 'Other', 'HAY' => 'Haryana');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php
        require_once("main-header.php");
        ?>
        <!-- include all required CSS & JS File start here -->
        <link rel="stylesheet" href="css/jquery.fileupload-ui.css"></link>
        <script src="assets/js/jquery.pageslide.js"></script>
        <script src="../ts_picker.js"></script>
        <!-- include all required CSS & JS File end here -->
        <script type="text/javascript" language="javascript">
            $(".alert").alert();
            $(".alert").alert('close');

            bootstrap_alert = function() {}
            bootstrap_alert.warning = function(message) {
                $('#alert_placeholder').html('<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a><span>'+message+'</span></div>')
            }
            function setShortCode(service){
                $("#Scode").val("");
                if(service == '1101'){
                    $("#Scode").val("52222");
                }else if(service == '1111'){
                    $("#Scode").val("5432105");
                }else if(service == '1116'){
                    $("#Scode").val("54444");
                }else if(service == '1110'){
                    $("#Scode").val("55935");
                }else if(service == '1102'){
                    $("#Scode").val("54646");
                }else if(service == '1113'){
                    $("#Scode").val("54646196");
                }else if(service == '1106'){
                    $("#Scode").val("5432155");
                }else if(service == '1103'){
                    $("#Scode").val("546461");
                }else if(service == '1124'){
                    $("#Scode").val("522223");
                }
                else
                {
                    $("#Scode").val("NA");
                }
            }
            function showDateTime() {	
                if(document.getElementById('time1').style.display=='none') {
                    document.getElementById('time1').style.display='block';
                } else if(document.getElementById('time2').style.display=='none') {
                    document.getElementById('time2').style.display='block';
                } else if(document.getElementById('time3').style.display=='none') {
                    document.getElementById('time3').style.display='block';
                } else if(document.getElementById('time4').style.display=='none') {
                    document.getElementById('time4').style.display='block';
                    document.getElementById('more').style.display='none';
                }
                else if(document.getElementById('time5').style.display=='none') {
                    document.getElementById('time5').style.display='block';
                    document.getElementById('more').style.display='none';
                }
                else if(document.getElementById('time6').style.display=='none') {
                    document.getElementById('time6').style.display='block';
                    document.getElementById('more').style.display='none';
                }
                else if(document.getElementById('time7').style.display=='none') {
                    document.getElementById('time7').style.display='block';
                    document.getElementById('more').style.display='none';
                }
            }
            bootstrap_alert = function() {}
            bootstrap_alert.warning = function(message) {
                $('#alert_placeholder').html('<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a><span>'+message+'</span></div>')
            }
            function resestForm(type)
            {
                var formname=type;
                document.getElementById(formname).reset();
                $('#loading').hide();
            }
        </script>
    </head>

    <body onload="viewUploadhistory('active')">

        <div class="navbar navbar-inner">
            <a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
        </div>

        <div class="container">
            <div class="row">
                <div class="page-header">
                    <h1>Switch Control<small>&nbsp;&nbsp;</small></h1>
                </div>
                <div class="tab-pane active" id="pills-basic">
                    <div class="tabbable">
                        <ul class="nav nav-pills">
                            <li class="active"><a href="#active" onclick="viewUploadhistory('active')" data-toggle="tab" data-act="activation">Activation</a></li>
                            <li class=""><a href="#show_time_slot" onclick="viewUploadhistory('show_time_slot')" data-toggle="tab" data-act="show_time_slot">Show Time-Slot</a></li>
                        </ul>
                        <div class="tab-content">
                            <!-- Activation section start here-->
                            <div id="active" class="tab-pane active">
                                <form id="tstest" name="tstest" method="post">
                                    <table class="table table-bordered table-condensed">
                                        <tr>
                                            <td align="left" width="16%" height="32"><span>Service&nbsp;</span></td>
                                            <td><select name='service' id="service" onchange="setShortCode(this.value);">
                                                    <option value="0">Select Service</option>
                                                    <?php foreach ($servicearray as $s_id => $s_val) { ?>
                                                        <option value="<?php echo $s_id; ?>"><?php echo $s_val; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" width="16%" height="32"><span>Short Code:&nbsp;</span></td>
                                            <td>
                                                <input type="text" name="Scode" id="Scode" value=""/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" width="16%" height="32"><span>Circle&nbsp;</span></td>
                                            <td><select name='circle[]' id='circle1' multiple='multiple'>
                                                    <?php foreach ($circle_info as $s_id => $s_val) { ?>
                                                        <option value="<?php echo $s_id; ?>"><?php echo $s_val; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td bgcolor="#FFFFFF" height="30px" colspan=2>
                                                <div id='time1' style="display:none;" width='100%'>
                                                    <table class="table table-bordered table-condensed">
                                                        <tr><td align="left" width="16%" height="32">Select Start Time:&nbsp;</td><td bgcolor="#FFFFFF"><input type="Text" name="timestamp" id="timestamp" value="">
                                                                    <a href="javascript:show_calendar('document.tstest.timestamp', document.tstest.timestamp.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                            </td></tr>
                                                        <tr><td align="left" width="16%" height="32">Select End Time:&nbsp;</td><td bgcolor="#FFFFFF"><input type="Text" name="timestamp1" id="timestamp1" value="">
                                                                    <a href="javascript:show_calendar('document.tstest.timestamp1', document.tstest.timestamp1.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                            </td></tr>
                                                    </table>
                                                </div>
                                                <div id='time2' style="display:none;">
                                                    <table class="table table-bordered table-condensed">
                                                        <tr><td align="left" width="16%" height="32">Select Start Time:&nbsp;</td><td bgcolor="#FFFFFF"><input type="Text" name="timestamp2" id="timestamp2" value="">
                                                                    <a href="javascript:show_calendar('document.tstest.timestamp2', document.tstest.timestamp2.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                            </td></tr>
                                                        <tr><td align="left" width="16%" height="32">Select End Time:&nbsp;</td><td bgcolor="#FFFFFF"><input type="Text" name="timestamp21" id="timestamp21" value="">
                                                                    <a href="javascript:show_calendar('document.tstest.timestamp21', document.tstest.timestamp21.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                            </td></tr>
                                                    </table>
                                                </div>
                                                <div id='time3' style="display:none;">
                                                    <table class="table table-bordered table-condensed">
                                                        <tr><td align="left" width="16%" height="32">Select Start Time:&nbsp;</td><td bgcolor="#FFFFFF"><input type="Text" name="timestamp3" id="timestamp3" value="">
                                                                    <a href="javascript:show_calendar('document.tstest.timestamp3', document.tstest.timestamp3.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                            </td></tr>
                                                        <tr><td align="left" width="16%" height="32">Select End Time:&nbsp;</td><td bgcolor="#FFFFFF"><input type="Text" name="timestamp31" id="timestamp31" value="">
                                                                    <a href="javascript:show_calendar('document.tstest.timestamp31', document.tstest.timestamp31.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                            </td></tr>
                                                    </table>
                                                </div>
                                                <div id='time4' style="display:none;">
                                                    <table class="table table-bordered table-condensed">
                                                        <tr><td align="left" width="16%" height="32">Select Start Time:&nbsp;</td><td bgcolor="#FFFFFF"><input type="Text" name="timestamp4" id="timestamp4" value="">
                                                                    <a href="javascript:show_calendar('document.tstest.timestamp4', document.tstest.timestamp4.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                            </td></tr>
                                                        <tr><td align="left" width="16%" height="32">Select End Time:&nbsp;</td><td bgcolor="#FFFFFF"><input type="Text" name="timestamp41" id="timestamp41" value="">
                                                                    <a href="javascript:show_calendar('document.tstest.timestamp41', document.tstest.timestamp41.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                            </td></tr>
                                                    </table>
                                                </div>
                                                <div id='time5' style="display:none;">
                                                    <table class="table table-bordered table-condensed">
                                                        <tr><td align="left" width="16%" height="32">Select Start Time:&nbsp;</td><td bgcolor="#FFFFFF"><input type="Text" name="timestamp5" id="timestamp5" value="">
                                                                    <a href="javascript:show_calendar('document.tstest.timestamp5', document.tstest.timestamp5.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                            </td></tr>
                                                        <tr><td align="left" width="16%" height="32">Select End Time:&nbsp;</td><td bgcolor="#FFFFFF"><input type="Text" name="timestamp51" id="timestamp51" value="">
                                                                    <a href="javascript:show_calendar('document.tstest.timestamp51', document.tstest.timestamp51.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                            </td></tr>
                                                    </table>
                                                </div>
                                                <div id='time6' style="display:none;">
                                                    <table class="table table-bordered table-condensed">
                                                        <tr><td align="left" width="16%" height="32">Select Start Time:&nbsp;</td><td bgcolor="#FFFFFF"><input type="Text" name="timestamp6" id="timestamp6" value="">
                                                                    <a href="javascript:show_calendar('document.tstest.timestamp6', document.tstest.timestamp6.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                            </td></tr>
                                                        <tr><td align="left" width="16%" height="32">Select End Time:&nbsp;</td><td bgcolor="#FFFFFF"><input type="Text" name="timestamp61" id="timestamp61" value="">
                                                                    <a href="javascript:show_calendar('document.tstest.timestamp61', document.tstest.timestamp61.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                            </td></tr>
                                                    </table>
                                                </div>
                                                <div id='time7' style="display:none;">
                                                    <table class="table table-bordered table-condensed">
                                                        <tr><td align="left" width="16%" height="32">Select Start Time:&nbsp;</td><td bgcolor="#FFFFFF"><input type="Text" name="timestamp7" id="timestamp7" value="">
                                                                    <a href="javascript:show_calendar('document.tstest.timestamp7', document.tstest.timestamp7.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                            </td></tr>
                                                        <tr><td align="left" width="16%" height="32">Select End Time:&nbsp;</td><td bgcolor="#FFFFFF"><input type="Text" name="timestamp71" id="timestamp71" value="">
                                                                    <a href="javascript:show_calendar('document.tstest.timestamp71', document.tstest.timestamp71.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                            </td></tr>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" height="32">
                                                <a href="#" onclick="javascript:showDateTime();">Add more time..</td>
                                            <td><button class="btn btn-primary" style="float:right">Submit</button></td>
                                        </tr>
                                    </table>
                                </form>	
                                <div id="grid-active"></div>
                            </div>
                            <!-- Activation section end here-->
                            <!-- Show time slot section start here-->
                            <div id="show_time_slot" class="tab-pane">
                                <!--                                <form id="form-active" name="form-active" method="post" enctype="multipart/form-data">-->
                                <form id="show" name="show">
                                    <table class="table table-bordered table-condensed">
                                        <tr>
                                            <td align="left" width="16%" height="32"><span>Service&nbsp;</span></td>
                                            <td><select name='service' id="service">
                                                    <option value="0"><?php echo 'Select Service'; ?></option>
                                                    <?php foreach ($servicearray as $s_id => $s_val) { ?>
                                                        <option value="<?php echo $s_id; ?>"><?php echo $s_val; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" width="16%" height="32"><span>Circle&nbsp;</span></td>
                                            <td><select name='circle' id='circle'>
                                                    <option value="0"><?php echo 'Select Circle'; ?></option>
                                                    <?php foreach ($circle_info as $s_id => $s_val) { ?>
                                                        <option value="<?php echo $s_id; ?>"><?php echo $s_val; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <button class="btn btn-primary" style="float:right">Submit</button>
                                            </td>

                                        </tr>
                                     </table>
                                </form>	
                                <div id="grid-show"></div>
                            </div>
                            <!-- Show time slot section end here-->
                        </div>
                    </div>
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

        <script type="text/javascript" language="javascript">
            function validateData() { 
                if(document.forms['tstest']["service"].value=='' || document.forms['tstest']["service"].value==0) {
                    document.getElementById('alert_placeholder').style.display='inline';
                    bootstrap_alert.warning('<?php echo 'Please select service.'; ?>');
                    document.forms['tstest']["service"].focus();
                    return false;
                }
                if(document.forms['tstest']["Scode"].value=='' || document.forms['tstest']["Scode"].value=='NA') {
                    document.getElementById('alert_placeholder').style.display='inline';
                    bootstrap_alert.warning('<?php echo 'Please enter short code.'; ?>');
                    document.forms['tstest']["Scode"].focus();
                    return false;
                }
                len = document.forms['tstest']["circle[]"].length;
                j=0;
                for(i=0; i<len; i++) {
                    if (document.forms['tstest']["circle[]"][i].selected) 
                        j++;
                }
                if(!j) {
                    document.getElementById('alert_placeholder').style.display='inline';
                    bootstrap_alert.warning('<?php echo 'Please select circle.'; ?>');
                    return false;
                }

//                if(j > 2) {
//                    document.getElementById('alert_placeholder').style.display='inline';
//                    bootstrap_alert.warning('<?php echo 'Only two circles at one time, Please try again!'; ?>');
//                    return false;
//                }
                if(document.forms['tstest']["timestamp"].value=='') {
                    document.getElementById('alert_placeholder').style.display='inline';
                    bootstrap_alert.warning('<?php echo 'Please enter Time Slot.'; ?>');
                    document.forms['tstest']["timestamp"].focus();
                    return false;
                }
                if(document.getElementById('timestamp').value) {
                    if(!document.forms['tstest']["timestamp1"].value) { 
                        document.getElementById('alert_placeholder').style.display='inline';
                        bootstrap_alert.warning('<?php echo 'Please enter Endtime.'; ?>');
                        document.forms['tstest']["timestamp1"].focus();
                        return false;
                    }
                }
                if(document.forms['tstest']["timestamp2"].value) {
                    if(!document.forms['tstest']["timestamp21"].value) { 
                        document.getElementById('alert_placeholder').style.display='inline';
                        bootstrap_alert.warning('<?php echo 'Please enter Endtime.'; ?>');
                        document.forms['tstest']["timestamp21"].focus();
                        return false;
                    }
                }
                if(document.forms['tstest']["timestamp3"].value) {
                    if(!document.forms['tstest']["timestamp31"].value) { 
                        document.getElementById('alert_placeholder').style.display='inline';
                        bootstrap_alert.warning('<?php echo 'Please enter Endtime.'; ?>');
                        document.forms['tstest']["timestamp31"].focus();
                        return false;
                    }
                }
                if(document.forms['tstest']["timestamp4"].value) {
                    if(!document.forms['tstest']["timestamp41"].value) { 
                        document.getElementById('alert_placeholder').style.display='inline';
                        bootstrap_alert.warning('<?php echo 'Please enter Endtime.'; ?>');
                        document.forms['tstest']["timestamp41"].focus();
                        return false;
                    }
                }
                if(document.forms['tstest']["timestamp5"].value) {
                    if(!document.forms['tstest']["timestamp51"].value) { 
                        document.getElementById('alert_placeholder').style.display='inline';
                        bootstrap_alert.warning('<?php echo 'Please enter Endtime.'; ?>');
                        document.forms['tstest']["timestamp51"].focus();
                        return false;
                    }
                }
                if(document.forms['tstest']["timestamp6"].value) {
                    if(!document.forms['tstest']["timestamp61"].value) { 
                        document.getElementById('alert_placeholder').style.display='inline';
                        bootstrap_alert.warning('<?php echo 'Please enter Endtime.'; ?>');
                        document.forms['tstest']["timestamp61"].focus();
                        return false;
                    }
                }
                if(document.forms['tstest']["timestamp7"].value) {
                    if(!document.forms['tstest']["timestamp71"].value) { 
                        document.getElementById('alert_placeholder').style.display='inline';
                        bootstrap_alert.warning('<?php echo 'Please enter Endtime.'; ?>');
                        document.forms['tstest']["timestamp71"].focus();
                        return false;
                    }
                }
                return true;
            }
            function validateShowData() { 
                if(document.forms['show']["service"].value=='' || document.forms['show']["service"].value==0) {
                    document.getElementById('alert_placeholder').style.display='inline';
                    bootstrap_alert.warning('<?php echo 'Please select service.'; ?>');
                    document.forms['show']["service"].focus();
                    return false;
                }
                if(document.forms['show']["circle"].value=='' || document.forms['show']["circle"].value==0) {
                    document.getElementById('alert_placeholder').style.display='inline';
                    bootstrap_alert.warning('<?php echo 'Please select circle.'; ?>');
                    document.forms['show']["circle"].focus();
                    return false;
                }
                return true;
            }
            function viewUploadhistory(a) {
                document.getElementById('alert_placeholder').style.display='none';
                $('#grid-view_upload_history').hide();
                $('#grid-view_upload_history').html('');
                $('#loading').show();
                $('#loading').hide();
            };
	
            $.fn.GetUploadHistory = function(type) {
                $('#loading').show();
                $.ajax({
	     
                    url: 'viewuploadhistory.php',
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
            $("form#tstest").submit(function(){
                var isok = validateData();
                if(isok)
                { 
                    document.getElementById('alert_placeholder').style.display='none';
                    $('#loading').show();
                    var formData = new FormData($("form#tstest")[0]);
                    $.ajax({
                        url: 'activation_process.php',
                        type: 'POST',
                        data: formData,
                        async: false,
                        success: function (data) {
                            document.getElementById('grid-active').style.display='inline';
                            document.getElementById('grid-active').innerHTML=data;
                            resestForm('tstest');
                            //viewUploadhistory('active');
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
            $("form#show").submit(function(){ 
                var isok = validateShowData();
                if(isok)
                {
                    document.getElementById('alert_placeholder').style.display='none';
                    $('#loading').show();
                    var formData = new FormData($("form#show")[0]);
                    $.ajax({
                        url: 'show_process.php',
                        type: 'POST',
                        data: formData,
                        async: false,
                        success: function (data) {
                            document.getElementById('grid-show').style.display='inline';
                            document.getElementById('grid-show').innerHTML=data;
                            resestForm('show');
                            viewUploadhistory('active');
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
            function showStatusConfirm(sId,action,serviceId,circle) { 
                if(action == 'strt') {
                    var answer = confirm("Are You Sure To Want Start Selected Time-Slot?");
                    if(answer) {
                    }else{
                        return false;
                    }
                } 
                if(action == 'end') {
                    var answer = confirm("Are You Sure To Want End Selected Time-Slot?");
                    if(answer){
                        
                    } 
                    else{
                        return false;
                    } 
                } 
                document.getElementById('alert_placeholder').style.display='none';
                $('#loading').show();
                var datastring = 'id='+sId+'&act='+action+'&service='+serviceId+'&circle='+circle;
                $.ajax({
                    url: 'show_process.php',
                    type: 'POST',
                    data: datastring,
                    success: function (data) {
                        $('#loading').hide();
                        document.forms['show']["service"].value=serviceId;
                        document.forms['show']["circle"].value=circle;
                        $("form#show").submit();  
                    }
                });
                
                return false;
            }

            function showDeleteConfirm(sId,del,serviceId,circle) { 
                var answer = confirm("Are You Sure To Want Delete Selected Time-Slot?");
                if(answer){ 
                }else{ 
                    return false;
                }
                $('#loading').show();
                var datastring = 'id='+sId+'&act=del&service='+serviceId+'&circle='+circle;
                $.ajax({
                    url: 'show_process.php',
                    type: 'POST',
                    data: datastring,
                    success: function (data) {
                        $('#loading').hide();
                        document.forms['show']["service"].value=serviceId;
                        document.forms['show']["circle"].value=circle;
                        $("form#show").submit();
                    }
                });
               
                return false;
            }
        </script>
    </body>
</html>