<?php
ob_start();
session_start();
ini_set('display_errors', '0');
$PAGE_TAG = 'sms-kci';
include "includes/constants.php";
include "includes/language.php";
$loginid = $_SESSION['loginId'];
if ($loginid == '') {
    Header("location:login.php?ERROR=500");
}
$SKIP = 1;
require_once("../2.0/incs/common.php");
require_once("../2.0/incs/db.php");
require_once("../2.0/language.php");
require_once("../2.0/base.php");
$listservices = $_SESSION["access_service"];
$services = explode(",", $listservices);

$serviceArray = Array('1101' => 'MTS - muZic Unlimited');
$circle_info = array('CHN' => 'Chennai', 'GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi');
$email_time_slot_array = array('01' => '01: 00 AM', '02' => '02: 00 AM', '03' => '03: 00 AM', '04' => '04: 00 AM', '05' => '05: 00 AM',
    '06' => '06: 00 AM', '07' => '07: 00 AM', '08' => '08: 00 AM', '09' => '09: 00 AM', '10' => '10: 00 AM', '11' => '11: 00 AM', '12' => '12: 00 AM',
    '13' => '01: 00 PM', '14' => '02: 00 PM', '15' => '03: 00 PM', '16' => '04: 00 PM', '17' => '05: 00 PM', '18' => '06: 00 PM', '19' => '07: 00 PM',
    '20' => '08: 00 PM', '21' => '09: 00 PM', '22' => '10: 00 PM', '23' => '11: 00 PM', '24' => '12: 00 PM');
$sms_time_slot_array = array('09' => '09: 00 AM', '10' => '10: 00 AM', '11' => '11: 00 AM', '12' => '12: 00 AM', '13' => '01: 00 PM', '14' => '02: 00 PM',
    '15' => '03: 00 PM', '16' => '04: 00 PM', '17' => '05: 00 PM', '18' => '06: 00 PM', '19' => '07: 00 PM', '20' => '08: 00 PM');
$min_sec_array = array('01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' => '05', '06' => '06', '07' => '07', '08' => '08', '09' => '09',
    '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20',
    '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31', '32' => '32',
    '33' => '33', '34' => '34', '35' => '35', '36' => '36', '37' => '37', '38' => '38', '39' => '39', '40' => '40', '41' => '41', '42' => '42', '43' => '43', '44' => '44', '45' => '45',
    '46' => '46', '47' => '47', '48' => '48', '49' => '49', '50' => '50', '51' => '51', '52' => '52', '53' => '53', '54' => '54', '55' => '55', '56' => '56', '57' => '57', '58' => '58',
    '59' => '59', '60' => '60');
asort($circle_info);
$sms_cli_array = Array('1101' => '52222');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="favicon.png">
        <title><?php echo "CREATE RULE"; ?></title>
        <?php
        echo CONST_CSS;
        echo EDITINPLACE_CSS;
        ?>

    </head>

    <body onload="javascript:viewUploadhistory('me');">
        <div class="container">
            <?php
            include "includes/menu.php";
            ?>
            <div class="row">
                <div class="col-md-12"><h4><?php echo "RULE Engine"; ?></h4></div>
            </div>    
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-pane active" id="pills-basic">
                        <div class="tabbable">
                            <ul class="nav nav-pills">
                                <li class="active"><a href="#active" onclick="reloadPage();viewUploadhistory('active')" data-toggle="tab" data-act="create_rule">Create Rule</a></li>
                                <li class=""><a href="#history" onclick="stopDisplayUploadhistory()"  data-toggle="tab" data-act="history">History</a></li>
                            </ul>
                            <br/>
                            <div class="tab-content">
                                <div id="active" class="tab-pane active">
                                    <!--div id="active" class="tab-pane active" style="display:none"-->
                                    <form id="form-active" name="form-active" method="post" enctype="multipart/form-data">
                                        <table class="table table-bordered table-condensed">
                                            <tr>
                                                <td align="left" width="16%" height="32"><span>Rule Name</span></td>
                                                <td align="left" colspan="2">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <input type="text" name="rule_name" value="" placeholder="Rule Name" class="form-control" />
                                                            </div>          
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" width="16%" height="32"><span>Service Name</span></td>
                                                <td align="left" colspan="2">
                                                    <select name="service" data-width="auto" onchange="setSmsCli(this.value)">
                                                        <option value="0">Select Service</option>
                                                        <?php foreach ($serviceArray as $s_id => $s_val) {
                                                            ?>
                                                            <option value="<?php echo $s_id; ?>"><?php echo $s_val; ?></option>
                                                        <?php } ?>
                                                    </select></td>

                                            </tr>
                                            <tr>
                                                <td align="left" width="16%" height="32"><span>Circle</span></td>
                                                <td align="left" colspan="2">
                                                    <select name="circle" data-width="auto">
                                                        <option value="0">Select Circle</option>
                                                        <?php foreach ($circle_info as $c_id => $c_val) {
                                                            ?>
                                                            <option value="<?php echo $c_id; ?>"><?php echo $c_val; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td align="left" width="16%" height="32"><span>Service Base</span></td>
                                                <td align="left" colspan="2">

                                                    <input type="radio" id="service_base_active" name="service_base" value="active" checked="checked"/>&nbsp; Active &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" id="service_base_pending" name="service_base" value="pending"/>&nbsp; Pending &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" id="service_base_both" name="service_base" value="both"/>&nbsp; Both
                                                </td>                   </tr>
                                            <tr>
                                                <td align="left" width="16%" height="32"><span>Filter Base</span></td>
                                                <td align="left" colspan="2">
                                                    <select name="filter_base" data-width="auto" onchange="setScenarios(this.value)">
                                                        <option value="0">Select Filter Base</option>
                                                        <?php
                                                        $selectQuery = "SELECT Fid,description FROM master_db.tbl_filter_base WHERE status=1 order by description";
                                                        $querySel = mysql_query($selectQuery, $dbConn);
                                                        while ($row = mysql_fetch_array($querySel)) {
                                                            ?>
                                                            <option value="<?php echo $row['Fid']; ?>"><?php echo $row['description']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" width="16%" height="32"><span>Scenarios</span></td>
                                                <td align="left" colspan="2">
                                                    <select name="scenarios" data-width="auto"></select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" width="16%" height="32">DND scrubbing</td>
                                                <td>

                                                    <input type="radio" id="dnd_scrubbing_yes" name="dnd_scrubbing" value="1" checked="checked"/>&nbsp; Yes &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" id="dnd_scrubbing_no" name="dnd_scrubbing" value="0"/>&nbsp; No &nbsp;&nbsp;&nbsp;
                                                </td>

                                                <td valign="middle"><button class="btn btn-primary">Submit</button>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                                <div id="action" class="tab-pane" style="display:none">
                                    <!--div id="action" class="tab-pane" style="display:block"-->
                                    <form id="form-action" name="form-action" method="post" enctype="multipart/form-data">
                                        <table class="table table-bordered table-condensed">
                                            <tr>
                                                <td align="left" width="16%" height="32"><span>Action</span></td>
                                                <td align="left" colspan="2">

                                                    <input type="radio"  name="action_name" value="sms" checked="checked"  onchange="handleClick(this.value)" />&nbsp; SMS &nbsp;&nbsp;&nbsp;
                                                    <input type="radio"  name="action_name" value="email"  onchange="handleClick(this.value)" />&nbsp; Email &nbsp;&nbsp;&nbsp;
                                                </td>
                                            </tr>
                                            <tr id="tr_sms_sequence">
                                                <td align="left" width="16%" height="32"><span>SMS Sequence</span></td>
                                                <td align="left" colspan="2">
                                                    <input type="radio" id="sms_sequence_random" name="sms_sequence" value="random" checked="checked" />&nbsp; Random &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" id="sms_sequence_fixed" name="sms_sequence" value="fixed"/>&nbsp; Fixed &nbsp;&nbsp;&nbsp;

                                                </td>

                                            </tr>
                                            <tr id="tr_sms_cli">
                                                <td align="left" width="16%" height="32"><span>SMS CLI</span></td>
                                                <td align="left" colspan="2">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <input  style="color:#2E3232" type="text" name="sms_cli" placeholder="SMS Cli" class="form-control" readonly="readonly"/>
                                                            </div>          
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>

                                            <tr id="tr_sms_time_slot">
                                                <td align="left" width="16%" height="32"><span>Time Slot</span></td>
                                                <td align="left" colspan="2">
                                                    <select  name="sms_time_slot">
                                                        <option value="0">Select Hour</option>
                                                        <?php foreach ($sms_time_slot_array as $TS_id => $TS_val) {
                                                            ?>
                                                            <option value="<?php echo $TS_id; ?>"><?php echo $TS_val; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <select name="sms_min">
                                                        <option value="0">Select Minute</option>
                                                        <?php foreach ($min_sec_array as $TS_id => $TS_val) {
                                                            ?>
                                                            <option value="<?php echo $TS_id; ?>"><?php echo $TS_val; ?></option>
                                                        <?php } ?>
                                                    </select>
<!--                                                    <select name="sms_sec">
                                                        <option value="0">Select Second</option>
                                                    <?php foreach ($min_sec_array as $TS_id => $TS_val) {
                                                        ?>
                                                                <option value="<?php echo $TS_id; ?>"><?php echo $TS_val; ?></option>
                                                    <?php } ?>
                                                    </select>-->
                                                </td>
                                            </tr>
                                            <tr id="tr_email_time_slot"  style="display:none">
                                                <td align="left" width="16%" height="32"><span>Time Slot</span></td>
                                                <td align="left" colspan="2">
                                                    <select name="email_time_slot">
                                                        <option value="0">Select Hour</option>
                                                        <?php foreach ($email_time_slot_array as $TS_id => $TS_val) {
                                                            ?>
                                                            <option value="<?php echo $TS_id; ?>"><?php echo $TS_val; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <select name="email_min">
                                                        <option value="0">Select Minute</option>
                                                        <?php foreach ($min_sec_array as $TS_id => $TS_val) {
                                                            ?>
                                                            <option value="<?php echo $TS_id; ?>"><?php echo $TS_val; ?></option>
                                                        <?php } ?>
                                                    </select>
<!--                                                    <select name="email_sec">
                                                        <option value="0">Select Second</option>
                                                        <?php foreach ($min_sec_array as $TS_id => $TS_val) {
                                                            ?>
                                                            <option value="<?php echo $TS_id; ?>"><?php echo $TS_val; ?></option>
                                                        <?php } ?>
                                                    </select>-->
                                                </td>
                                            </tr>
                                            <tr id="tr_upload_file">
                                                <td align="left" width="16%" height="32"><span>Upload File</span></td>
                                                <td align="left"> 
                                                    <input type="file" name="upload_file"/>
                                                </td>
                                                <td valign="middle"><button class="btn btn-primary">Submit</button>
                                            </tr>
                                            <tr id="tr_email_user" style="display: none;">
                                                <td align="left" width="16%" height="32"><span>Email User</span></td>
                                                <td align="left" colspan="2">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <?php
                                                                $selectMailQuery = "SELECT email FROM master_db.live_user_master WHERE username='" . $loginid . "'";
                                                                $MailResult = mysql_query($selectMailQuery, $dbConn);
                                                                $mail_array = mysql_fetch_array($MailResult);
                                                                ?>
                                                                <input style="color:#2E3232" type="text" name="email_user" value="<?php echo $mail_array['email']; ?>" placeholder="Email" class="form-control" readonly="readonly"/>
                                                            </div>          
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="tr_add_cc" style="display: none;">
                                                <td align="left" width="16%" height="32"><span>Add CC</span></td>
                                                <td align="left">
                                                    <select name="add_cc" data-width="auto">
                                                        <option value="0">Select CC user id</option>
                                                        <?php
                                                        $selectemailQuery = "SELECT email FROM master_db.live_user_master nolock where ac_flag=1  order by email";
                                                        $queryemailSel = mysql_query($selectemailQuery, $dbConn);
                                                        while ($row = mysql_fetch_array($queryemailSel)) {
                                                            ?>
                                                            <option value="<?php echo $row['email']; ?>"><?php echo $row['email']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <input type="hidden" name="rule_id" id="rule_id" />
                                                </td>
                                                <td valign="middle"><button class="btn btn-primary">Submit</button> </td>
                                            </tr>
                                        </table>
                                        <div id="fileFormat" class="well well-small">
                                            Please note: Only .txt file shall be accepted. Also, only 20,000 message shall be accepted in the file. Each row in your file should contain just one message.
                                        </div>
                                    </form>
                                </div>
                                <div id="history" class="tab-pane">

                                </div>
                                <div id="display" class="tab-pane"  style="display:none">

                                </div>
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div style="width:900px" class="modal-dialog">
                                        <div class="modal-content" id="modal_content">
                                            <div id = "edit_alert_placeholder"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="grid-active"></div>
                    </div>
                    <br/>
                    <div id = "alert_placeholder"></div>
                    <div class="alert alert-danger" style='display:none' id="error_box"></div>
                    <div id="grid-view_upload_history"></div> 
                </div> 
                <div  class="row"><div class="col-md-12">
                        <ul id="myTab" class="nav nav-pills">

                        </ul>
                    </div></div>
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <div id="loading"><img src="<?php echo IMG_LOADING; ?>" border="0" /></div> 
                    </div>

                </div> 
                <div id="myTabContent" class="tab-content">

                    <div id="SMS" class="tab-pane fade active in">
                    </div>

                    <div id="CallHangups" class="tab-pane fade">
                    </div>				 

                    <div id="Footer" class="tab-pane fade">
                    </div>				 

                </div>

                <div class="row">
                    <div class="col-md-12" id="grid">

                    </div>
                </div>
            </div>  


        </div>  

        <?php
        echo CONST_JS;
        echo EDITINPLACE_JS;
        ?>
        <script>
            function reloadPage()
              {
                  location.reload();
                  }
            
            (function($) {
                $.fn.extend( {
                    limiter: function(limit, elem) {
                        $(this).on("keyup focus", function() {
                            setCount(this, elem);
                        });
                        function setCount(src, elem) {
                            var chars = src.value.length;
                            if (chars > limit) {
                                src.value = src.value.substr(0, limit);
                                chars = limit;
                            }
                            elem.html( (limit - chars)+' characters left' );
                        }
                        setCount($(this)[0], elem);
                    }
                });
            })(jQuery);

            function setScenarios(filter_base) { 
                var xmlhttp;
                if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp=new XMLHttpRequest();
                } else { // code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange=function() {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                        document.forms["form-active"]["scenarios"].innerHTML=xmlhttp.responseText;
                    }
                }	
                var url="getScenerios.php?filter_base="+filter_base;
                xmlhttp.open("GET",url,true);
                xmlhttp.send();	
            }
            function setSmsCli(service) { 
                var smscli = new Array();
                smscli[1101] = "52222";
                var sms_cli_value = smscli[service];
                document.forms["form-action"]["sms_cli"].value=sms_cli_value;
            }
            function setEditScenarios(filter_base) {
                           
                var xmlhttp;
                if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp=new XMLHttpRequest();
                } else { // code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange=function() {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                        document.forms["form-edit"]["edit_scenarios"].innerHTML=xmlhttp.responseText;
                    }
                }	
                var url="getEditScenerios.php?filter_base="+filter_base;
                xmlhttp.open("GET",url,true);
                xmlhttp.send();	
            }
            $("form#form-active").submit(function(){  
                var isok = checkfield('form-active');
                if(isok)
                {
                    document.getElementById('alert_placeholder').style.display='none';
                    $('#loading').show();
                    var formData = new FormData($("form#form-active")[0]);
                    $.ajax({
                        url: 'rule_creation_process.php',
                        type: 'POST',
                        data: formData,
                        async: false,
                        success: function (data) {
                            document.getElementById('grid-active').style.display='inline';
                            document.getElementById('grid-active').innerHTML=data;
                            document.getElementById("active").style.display = "none";
                            document.getElementById("action").style.display = "block";
                            // handleClick('sms');
                            resestForm('active');    
                            viewUploadhistory('me');
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
            function SubmitEditDeatil(id){ 
                var isok = checkEditfield('form-edit');
                if(isok)
                {
                    $('#loading').show();
                    var formData = new FormData($("form#form-edit")[0]);
                    $.ajax({
                        url: 'rule_edit_process.php',
                        type: 'POST',
                        data: formData,
                        async: false,
                        success: function (data) {
                            alert('Rule has been updated successfully');                            
                            reloadPage();
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
            }

            function closeWin()
            {
                myWindow.close();                                                // Closes the new window
            }
            function checkfield(type) { 
                $('#loading').hide();
                document.getElementById('alert_placeholder').style.display='inline';
                var rule_name=document.forms[type]["rule_name"].value; 
                var service=document.forms[type]["service"].value;
                var circle=document.forms[type]["circle"].value;
                var filter_base=document.forms[type]["filter_base"].value;     
                var scenarios=document.forms[type]["scenarios"].value;
			
                if (rule_name== '') {
                    bootstrap_alert.warning('<?php echo 'Please enter rule name' ?>');
                    return false;
                } else if (service=='0' || service=="") {
                    bootstrap_alert.warning('<?php echo 'Please select service'; ?>');
                    return false;
                }
                else if(circle=='' || circle == '0')
                {   
                    bootstrap_alert.warning('<?php echo 'Please select circle'; ?>');
                    return false;
                }
                else if(filter_base=='' || filter_base == '0')
                {	
                    bootstrap_alert.warning('<?php echo 'Please select filter base'; ?>');
                    return false;
                }
                if (scenarios=='0' || scenarios=="") {
                    bootstrap_alert.warning('<?php echo 'Please select scenarios'; ?>');
                    return false;
                }
		
                $('#loading').show();
                hideMessageBox();
                return true;
            }
            bootstrap_alert = function() {}
            bootstrap_alert.warning = function(message) {
                $('#alert_placeholder').html('<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a><span>'+message+'</span></div>')
            }
            function hideMessageBox() {
                document.getElementById('error_box').style.display='none';
                document.getElementById('alert_placeholder').style.display='none';
            }

            function showMessageBox() {
                document.getElementById('error_box').style.display='inline';
                document.getElementById('alert_placeholder').style.display='inline';
            }
            function checkEditfield(type) { 
                $('#loading').hide();
             
                var filter_base=document.forms[type]["filter_edit_base"].value;   
                var scenarios=document.forms[type]["edit_scenarios"].value;
                var edit_circle=document.forms[type]["edit_circle"].value;
                var action_name= $('input:radio[name=action_edit_name]:checked').val(); 
                //var sms_cli=document.forms[type]["sms_edit_cli"].value;
                //var email_user=document.forms[type]["email_edit_user"].value;
                
                // var sms_edit_sequence= $('input:radio[name=sms_edit_sequence]:checked').val(); 
                var action_name=document.forms[type]["data_action"].value; 
                
                //var upfile=document.forms[type]["upload_edit_file"].value;
               
                if(filter_base=='' || filter_base == '0')
                {	  
                    alert('Please select filter base');
                    return false;
                }else if (scenarios=='0' || scenarios=="") {
                    alert('Please select scenarios');
                    return false;
                }else if (edit_circle=='0' || edit_circle=="") {
                    alert('Please select circle');
                    return false;
                }
                if (action_name == 'email'){
                    var time_slot=document.forms[type]["email_edit_time_slot"].value;  
                    var min=document.forms[type]["email_edit_min"].value;  
                    //var sec=document.forms[type]["email_edit_sec"].value; 
                    var add_cc=document.forms[type]["add_edit_cc"].value;
                    if (add_cc=="" || add_cc=="0") {
                        alert('Please enter cc user');
                        return false;
                    }
                }else{
                    var time_slot=document.forms[type]["sms_edit_time_slot"].value;  
                    var min=document.forms[type]["sms_edit_min"].value;  
                    // var sec=document.forms[type]["sms_edit_sec"].value; 
                }
                if (time_slot=='0' || time_slot=="") {
                    alert('Please select time slot');
                    return false;
                } 
                if (min=='0' || min=="") {
                    alert('Please select minute');
                    return false;
                } 
                //                if (sec=='0' || sec=="") {
                //                    alert('Please select second');
                //                    return false;
                //                } 
                //                if (action_name == 'sms'){
                //                    if (sms_cli== '') {
                //                        //bootstrap_alert.warning('<?php echo 'Please enter sms cli'; ?>');
                //                        alert('Please select sms cli');
                //                        return false;
                //                    }else if(sms_edit_sequence == '' || sms_edit_sequence == 'undefined' || sms_edit_sequence == 'null'){
                //                        alert('Please select sms sequence');
                //                        return false;
                //                    }
                //                    if(data_action == 'email' && (upfile=="" || upfile == 'null')){
                //                        alert('Please upload a file');
                //                        return false;
                //                    }
                //                
                //                }else{
                //                if (email_user== '') {
                //                    alert('Please enter email user');
                //                    return false;
                //                }else 
                //                if (add_cc=="" || add_cc=="0") {
                //                    alert('Please enter cc user');
                //                    return false;
                //                }     
                //                    var email_valid=validateEmail(email_user);
                //                    var cc_email_valid=validateEmail(add_cc);
                //                    if (email_valid != 1) {
                //                        alert('Please enter valid email user');
                //                        return false;
                //                    }else if (cc_email_valid != 1) {
                //                        alert('Please enter valid cc user');
                //                        return false;
                //                    }  
                       
                //}
                $('#loading').show();
                hideMessageBox();
                return true;
            }
            bootstrap_alert = function() {}
            bootstrap_alert.warning = function(message) {
                $('#alert_placeholder').html('<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a><span>'+message+'</span></div>')
            }
            
            function hideMessageBox() {
                document.getElementById('error_box').style.display='none';
                document.getElementById('alert_placeholder').style.display='none';
            }

            function showMessageBox() {
                document.getElementById('error_box').style.display='inline';
                document.getElementById('alert_placeholder').style.display='inline';
            }
            function resestForm(type)
            { ;
                var formname='form-'+type;
                document.getElementById(formname).reset();
            }
            function handleClick(action){ 
                
                if (action == 'sms') { 
                    document.getElementById('tr_sms_sequence').style.display='table-row';
                    document.getElementById('tr_sms_cli').style.display='table-row';
                    document.getElementById('tr_sms_time_slot').style.display='table-row';
                    document.getElementById('tr_upload_file').style.display='table-row';
                    document.getElementById('fileFormat').style.display='block';
                    document.getElementById('tr_email_user').style.display='none';
                    document.getElementById('tr_add_cc').style.display='none';
                    document.getElementById('tr_email_time_slot').style.display='none';
                }
                else { 
                    document.getElementById('tr_email_user').style.display='table-row';
                    document.getElementById('tr_add_cc').style.display='table-row';
                    document.getElementById('tr_sms_cli').style.display='table-row';
                    document.getElementById('tr_email_time_slot').style.display='table-row';
                    document.getElementById('tr_sms_sequence').style.display='none';
                    document.getElementById('tr_sms_cli').style.display='none';
                    document.getElementById('tr_upload_file').style.display='none';     
                    document.getElementById('fileFormat').style.display='none';
                    document.getElementById('tr_sms_time_slot').style.display='none';
                }
            }
            function handleEditClick(action){ 
                if (action == 'sms') { 
                    document.getElementById('tr_edit_sms_sequence').style.display='table-row';
                    document.getElementById('tr_edit_sms_cli').style.display='table-row';
                    document.getElementById('tr_sms_edit_time_slot').style.display='table-row';
                    document.getElementById('tr_edit_upload_file').style.display='table-row';
                    document.getElementById('tr_edit_email_user').style.display='none';
                    document.getElementById('tr_edit_add_cc').style.display='none';
                    document.getElementById('tr_email_edit_time_slot').style.display='none';
                }
                else { 
                    document.getElementById('tr_edit_email_user').style.display='table-row';
                    document.getElementById('tr_edit_add_cc').style.display='table-row';
                    document.getElementById('tr_email_edit_time_slot').style.display='table-row';
                    document.getElementById('tr_edit_sms_sequence').style.display='none';
                    document.getElementById('tr_edit_sms_cli').style.display='none';
                    document.getElementById('tr_edit_upload_file').style.display='none'; 
                    document.getElementById('tr_sms_edit_time_slot').style.display='none';
                }
            }
            $("form#form-action").submit(function(){
                var isok = checkactionfield('form-action');
                if(isok)
                {
                    document.getElementById('alert_placeholder').style.display='none';
                    $('#loading').show();
                    var formData = new FormData($("form#form-action")[0]);
                    $.ajax({
                        url: 'rule_action_process.php',
                        type: 'POST',
                        data: formData,
                        async: false,
                        success: function (data) {
                            document.getElementById('grid-active').style.display='inline';
                            document.getElementById('grid-active').innerHTML=data;
                            document.getElementById("action").style.display = "none";
                            document.getElementById("display").style.display = "block";
                            $.fn.GetDisplayHistory('aaded_by');
                            resestForm('active');    
                            viewUploadhistory('me');
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
            
            function checkactionfield(type) {
                $('#loading').hide();
                document.getElementById('alert_placeholder').style.display='inline';
                var action_name= $('input:radio[name=action_name]:checked').val(); 
                var sms_cli=document.forms[type]["sms_cli"].value;
                var sms_time_slot=document.forms[type]["sms_time_slot"].value;
                var sms_min=document.forms[type]["sms_min"].value;
                // var sms_sec=document.forms[type]["sms_sec"].value;
                var email_time_slot=document.forms[type]["email_time_slot"].value;
                var email_min=document.forms[type]["email_min"].value;
                //var email_sec=document.forms[type]["email_sec"].value;
                var upfile=document.forms[type]["upload_file"].value;  
                var email_user=document.forms[type]["email_user"].value;
                var add_cc=document.forms[type]["add_cc"].value;
                
                
                if (action_name == 'sms'){
                    if (sms_time_slot == '0' || sms_time_slot == "") {
                        bootstrap_alert.warning('<?php echo 'Please select time slot'; ?>');
                        return false;
                    }  
                    if (sms_min == '0' || sms_min == "") {
                        bootstrap_alert.warning('<?php echo 'Please select minute'; ?>');
                        return false;
                    }  
                    //                    if (sms_sec == '0' || sms_sec == "") {
                    //                        bootstrap_alert.warning('<?php echo 'Please select second'; ?>');
                    //                        return false;
                    //                    }               
                    if (sms_cli== '') {
                        bootstrap_alert.warning('<?php echo 'Please enter sms cli'; ?>');
                        return false;
                    }else if (upfile=="" || upfile == 'null') {
                        bootstrap_alert.warning('<?php echo 'Please upload a file'; ?>');
                        return false;
                    }    
                    var ext = upfile.substring(upfile.lastIndexOf('.') + 1);

                    if(ext=="txt")
                    {
                        var count=(upfile.split(".").length - 1);
                        if(count==1)
                        {
                            $('#loading').show();
                            return true;
                        }
                        else
                        {
                            bootstrap_alert.warning('Please upload valid (.txt) file.');
                            return false;
                        }
                    }
                    else
                    {
                        bootstrap_alert.warning('Please upload valid (.txt) file.');
                        return false;
                    }
                }else{
                    if (email_time_slot == '0' || email_time_slot == "") {
                        bootstrap_alert.warning('<?php echo 'Please select time slot'; ?>');
                        return false;
                    }  
                    if (email_min == '0' || email_min == "") {
                        bootstrap_alert.warning('<?php echo 'Please select minute'; ?>');
                        return false;
                    }  
                    //                    if (email_sec == '0' || email_sec == "") {
                    //                        bootstrap_alert.warning('<?php echo 'Please select second'; ?>');
                    //                        return false;
                    //                    }  
                    if (email_user== '') {
                        bootstrap_alert.warning('<?php echo 'Please enter email user'; ?>');
                        return false;
                    }else if (add_cc=="" || add_cc=="0") {
                        bootstrap_alert.warning('<?php echo 'Please enter cc user'; ?>');
                        return false;
                    }     
                    var email_valid=validateEmail(email_user);
                    var cc_email_valid=validateEmail(add_cc);
                    if (email_valid != 1) {
                        bootstrap_alert.warning('<?php echo 'Please enter valid email user'; ?>');
                        return false;
                    }else if (cc_email_valid != 1) {
                        bootstrap_alert.warning('<?php echo 'Please enter valid cc user'; ?>');
                        return false;
                    }  
                       
                }
            
                $('#loading').show();
                hideMessageBox();
                return true;
            }
            function validateEmail(email) 
            {
                var re = /\S+@\S+\.\S+/;
                return re.test(email);
            }
            function viewUploadhistory(added_by) { 
                document.getElementById('alert_placeholder').style.display='none';
                document.getElementById('history').style.display='none';
                document.getElementById('grid-view_upload_history').style.display='block';
                $('#grid-view_upload_history').hide();
                $('#grid-view_upload_history').html('');
                $('#loading').show();
                $.fn.GetUploadHistory(added_by);
            };
            $.fn.GetUploadHistory = function(added_by) {
                $('#loading').show();
                $.ajax({
	     
                    url: 'viewrule_engagement_history.php',
                    data: 'added_by='+added_by,
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
        
            function stopDisplayUploadhistory() { 
                document.getElementById('grid-view_upload_history').style.display='none';
                document.getElementById('active').style.display='none';
                document.getElementById('action').style.display='none';
                document.getElementById('display').style.display='none';
                $('#loading').hide();
                $.fn.GetAllHistory();
            }
         
        
            $.fn.GetDisplayHistory = function(added_by) {
                $('#loading').show();
                $.ajax({
	     
                    url: 'rule_display.php',
                    type: 'get',
                    cache: false,
                    dataType: 'html',
                    success: function (abc) {
                        $('#display').html(abc);
                        $('#loading').hide();
                    }
						
                });
						
                $('#display').show();
	
            };
            $.fn.GetAllHistory = function() {
                $.ajax({
	     
                    url: 'all_rule_history.php',
                    type: 'get',
                    cache: false,
                    dataType: 'html',
                    success: function (abc) {
                        $('#history').html(abc);
                        $('#loading').hide();
                    }
						
                });
						
                $('#history').show();
	
            };
            
            function BackFunction(){ 
                document.getElementById('alert_placeholder').style.display='none';
                document.getElementById("action").style.display = "none";
                document.getElementById("active").style.display = "block";
            }
            function showPauseResumeConfirm(id,act){
                if(act == 'pause'){
                    var answer = confirm("Are You Sure To Want pause rule");
                }else{
                    var answer = confirm("Are You Sure To Want resume rule");
                }
                if(answer){ 
                }else{ 
                    return false;
                }
                $('#loading').show();
                var datastring = 'id='+id+'&act='+act;
                $.ajax({
                    url: 'viewrule_engagement_history.php',
                    type: 'POST',
                    data: datastring,
                    success: function (data) {
                        $('#loading').hide();
                        viewUploadhistory('me');
                    }
                });
               
                return false;
            }
            function showViewConfirm(id){ 
                $('#loading').show();
                $.ajax({
	     
                    url: 'vieweditrule.php',
                    data: 'rule_id='+id,
                    type: 'get',
                    cache: false,
                    dataType: 'html',
                    success: function (abc) {
                        $('#modal_content').html(abc);
                        $('#loading').hide();
                    }
						
                });
						
                $('#modal_content').show();
            }
            function showDeleteConfirm(id){
                var answer = confirm("Are You Sure To Delet rule");
                if(answer){ 
                }else{ 
                    return false;
                }
                $('#loading').show();
                var datastring = 'id='+id+'&act=del';
                $.ajax({
                    url: 'viewrule_engagement_history.php',
                    type: 'POST',
                    data: datastring,
                    success: function (data) {
                        $('#loading').hide();
                        alert('Rule has been deleted successfully')
                        reloadPage();
                    }
                });
               
                return false;
            }
            function setRuleData(rule_id){
                $('#loading').show();
                var datastring = 'rule_id='+rule_id;
                $.ajax({
                    url: 'all_rule_history.php',
                    type: 'POST',
                    data: datastring,
                    success: function (abc) {
                        $('#history').html(abc);
                        $('#loading').hide();
                        document.getElementById('select_rule').value=rule_id;
                    }
                });
               
                return false;
            }
            var elem = $("#counter");
            $("#msg").limiter(160, elem);
        </script>
    </body>
</html>