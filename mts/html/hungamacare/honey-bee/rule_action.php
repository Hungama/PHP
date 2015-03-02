<?php
ini_set('display_errors', '1');
$PAGE_TAG = 'sms-kci';
include "includes/constants.php";
include "includes/language.php";
require_once("incs/db.php");
//$serviceArray = Array('1412' => 'UninorRT');
//$FilerBaseArray = Array('CU' => 'Calling users', 'NCU' => 'Non calling users', 'AOS' => 'Age on service', 'CD' => 'CRBT downloaders',
//    'CND' => 'CRBT non downloaders', 'RD' => 'RT downloaders', 'RND' => 'RT non downloaders');


$rule_name = $_REQUEST['rule_name'];
$service = $_REQUEST['service'];
$circle = $_REQUEST['circle'];
$service_base = $_REQUEST['service_base'];
$filter_base = $_REQUEST['filter_base'];
$scenarios = $_REQUEST['scenarios'];
$dnd_scrubbing = $_REQUEST['dnd_scrubbing'];

//////////////////////////////////////////////////// rule creation  insert  code start here ////////////////////////////////////////////////////
$update_query = "update master_db.tbl_rule_engagement set status=0 where circle='" . $circle . "' and service_id='" . $service . "' and service_base='" . $service_base . "' and filter_base='" . $filter_base . "' and scenerios='" . $scenarios . "'";
mysql_query($update_query, $dbConn);
$insertquery = "insert into master_db.tbl_rule_engagement(rule_name,service_id,service_base,filter_base,scenerios,dnd_scrubbing,status,added_on,added_by,circle) 
     values('$rule_name', '$service','$service_base', '$filter_base', '$scenarios', '$dnd_scrubbing',1,now(),'','$circle')";

//if (mysql_query($insertquery, $dbConn)) {
//    $msg = "Message has been saved successfully";
//    echo "<div width=\"85%\" align=\"left\" class=\"txt\">
//<div class=\"alert alert-success\">$msg</div></div>";
//} else {
//    echo "<div width=\"85%\" align=\"left\" class=\"txt\">
//<div class=\"alert alert-danger\">There seem to be error in saving message.Please try again.</div></div>";
//}
//////////////////////////////////////////////////// rule creation  insert  code end here ////////////////////////////////////////////////////
?>
<div class="row">
    <div class="col-md-12">
        <div id="active" class="tab-pane active">
        <form id="form-action" name="form-action" method="post" enctype="multipart/form-data">
            <table class="table table-bordered table-condensed">
                <tr>
                    <td align="left" width="16%" height="32"><span>Action</span></td>
                    <td align="left" colspan="2">
                        <input type="radio" id="action_sms" name="action" value="sms" />&nbsp; SMS &nbsp;&nbsp;&nbsp;
                        <input type="radio" id="action_email" name="action" value="email"/>&nbsp; Email &nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
                <tr id="tr_sms_sequence" name="tr_sms_sequence" style="display: block;">
                    <td align="left" width="16%" height="32"><span>SMS Sequence</span></td>
                    <td align="left" colspan="2">
                        <input type="radio" id="sms_sequence_random" name="sms_sequence" value="random" />&nbsp; Random &nbsp;&nbsp;&nbsp;
                        <input type="radio" id="sms_sequence_fixed" name="sms_sequence" value="fixed"/>&nbsp; Fixed &nbsp;&nbsp;&nbsp;
                    </td>

                </tr>
                <tr id="tr_sms_cli" name="tr_sms_cli" style="display: block;">
                    <td align="left" width="16%" height="32"><span>SMS CLI</span></td>
                    <td align="left" colspan="2">
                        <input type="text" id="sms_cli" name="sms_cli"/>
                    </td>
                </tr>

                <tr>
                    <td align="left" width="16%" height="32"><span>Time Slot</span></td>
                    <td align="left" colspan="2">
                        <select name="time_slot" id="time_slot" data-width="auto">
                            <option value="0">Select Time Slot</option>
                            <option value="1">01: 00 AM</option>
                            <option value="2">02: 00 AM</option>
                            <option value="3">03: 00 AM</option>
                            <option value="4">04: 00 AM</option>
                            <option value="5">05: 00 AM</option>
                            <option value="6">06: 00 AM</option>
                            <option value="7">07: 00 AM</option>
                            <option value="8">08: 00 AM</option>
                            <option value="9">09: 00 AM</option>
                            <option value="10">10: 00 AM</option>
                            <option value="11">11: 00 AM</option>
                            <option value="12">12: 00 AM</option>
                            <option value="13">01: 00 PM</option>
                            <option value="14">02: 00 PM</option>
                            <option value="15">03: 00 PM</option>
                            <option value="16">04: 00 PM</option>
                            <option value="17">05: 00 PM</option>
                            <option value="18">06: 00 PM</option>
                            <option value="19">07: 00 PM</option>
                            <option value="20">08: 00 PM</option>
                            <option value="21">09: 00 PM</option>
                            <option value="22">10: 00 PM</option>
                            <option value="23">11: 00 PM</option>
                            <option value="24">12: 00 PM</option>
                        </select>
                    </td>
                </tr>
                <tr id="tr_upload_file" name="tr_upload_file" style="display: block;">
                    <td align="left" width="16%" height="32"><span>Upload File</span></td>
                    <td align="left" colspan="2">
                        <input type="file" id="upload_file" name="upload_file"/>
                    </td>
                    <td valign="middle"><a href="javascript:;" class="btn btn-primary">Submit</a>
                </tr>
                <tr id="tr_email_user" name="tr_email_user" style="display: none;">
                    <td align="left" width="16%" height="32"><span>Email User</span></td>
                    <td align="left" colspan="2">
                        <input type="text" id="email_user" name="email_user"/>
                    </td>
                </tr>
                <tr id="tr_add_cc" name="tr_add_cc" style="display: none;">
                    <td align="left" width="16%" height="32"><span>Add CC</span></td>
                    <td align="left" colspan="2">
                        <input type="text" id="add_cc" name="add_cc"/>
                    </td>
                </tr>
                <!-- date range section end here -->
            </table>
        </form>
        </div>
    </div>
    <br/>
</div> 

<script>
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


    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var parts = decodeURI(e.target).split('#');
        $.fn.AjaxAct(parts[1],'');
    });

    $.fn.AjaxAct = function(act,xhr) {
        if(!xhr) {
            $('#loading').show();
            $('#grid').html('');	

        }
		
        $.ajax({
            url: 'snippets/test.php',
            data: '&type='+act,
            type: 'post',
            cache: false,
            dataType: 'html',
            success: function (abc) {
                $('#grid').html(abc);
            }
						
        });
					
					
        $('#loading').hide();
        $('#grid').show();
	
    };
    $(document).ready(function() {
        if (location.hash !== '') $('a[href="' + location.hash + '"]').tab('show');
        return $('a[data-toggle="tab"]').on('shown', function(e) {
            return location.hash = $(e.target).attr('href').substr(1);
        });
    });
    //'CU' => 'Calling users', 'NCU' => 'Non calling users', 'AOS' => 'Age on service','CD' => 'CRBT downloaders',
    // 'CND' => 'CRBT non downloaders', 'RD' => 'RT downloaders','RND' => 'RT non downloaders'
    function setScenarios(filter_base) { 
        if(filter_base == 'CU'){
            document.getElementById('ScenariosDiv').innerHTML = "<select name='scenarios' id='scenarios'><option value='>10 MOUs'>Active subscriber with Little usage (Less than 10 MOUS in last 10 days) >10</option><option value='10-30 MOUs'>Active subscriber with medium usage (More than 10, But less than 30 MOUS  in last 10 days) Between 10 to 30</option><option value='>30 MOUs'>Active subscriber with High usage (More than 30 MOUS in last 10 days) <30</option><option value='<5 Min'>Usage less than > 5 mins in last 1 day</option><option value='<20 Min'>Usage more than < 20 mins in last 1 day</option><option value='1 Days'>Called in last 1 day</option><option value='3 Days'>Called in last 3 days</option><option value='5 Days'>Called in last 5 days</option><option value='7 Days'>Called in last 7 days</option><option value='15 Days'>Called in last 15 days</option><option value='>2 Times'>Called more than 2 times in last 1 day</option><option value='>4 Times'>Called more than 4 times in last 1 day</option><option value='>6 Times'>Called more than 6 times in last 1 day</option></select>"; 
        }else if(filter_base == 'NCU'){
            document.getElementById('ScenariosDiv').innerHTML = "<select name='scenarios' id='scenarios'><option value='3 Days'>Not called in 3 days from activation</option><option value='5 Days'>Not called in 5 days from activation</option><option value='7 Days'>Not called in 7 days from activation</option><option value='15 Days'>Not called in 15 days from activation</option></select>";
        }else if(filter_base == 'AOS'){
            document.getElementById('ScenariosDiv').innerHTML = "<select name='scenarios' id='scenarios'><option value='0-5 Days'>0-5 days</option><option value='5-10 Days'>5-10 days</option><option value='10-20 Days'>10-20 days</option><option value='20-30 Days'>20-30 days</option><option value='>30 Days'>More than 30 days</option></select>";
        }else if(filter_base == 'CD'){
            document.getElementById('ScenariosDiv').innerHTML = "<select name='scenarios' id='scenarios'><option value='1 Days'>Downloaded/changed 1 or more CRBT in last 1 day</option><option value='5 Days'>Downloaded 2 or more CRBT in last 5 day</option></select>";
        }else if(filter_base == 'CND'){
            document.getElementById('ScenariosDiv').innerHTML = "<select name='scenarios' id='scenarios'><option value='3 Days'>No CRBT Download in 3 days from activation</option><option value='5 Days'>No CRBT Download in 5 days from activation</option><option value='7 Days'>No CRBT Download in 7 days from activation</option><option value='15 Days'>No CRBT Download in 15 days from activation</option></select>";
        }else if(filter_base == 'RD'){
            document.getElementById('ScenariosDiv').innerHTML = "<select name='scenarios' id='scenarios'><option value='1 Days'>Downloaded 1 or more RT in last 1 day</option><option value='5 Days'>Downloaded 2 or more RT in last 5 day</option></select>";
        }else if(filter_base == 'RND'){
            document.getElementById('ScenariosDiv').innerHTML = "<select name='scenarios' id='scenarios'><option value='3 Days'>No RT Download in 3 days from activation</option><option value='5 Days'>No RT Download in 5 days from activation</option><option value='7 Days'>No RT Download in 7 days from activation</option><option value='15 Days'>No RT Download in 15 days from activation</option></select>";
        }
    }
        
    $(".action").change(function () { alert('hi');
        if ($("#action_sms").attr("checked")) { alert('if');
            document.getElementById('tr_sms_sequence').style.display='table-row';
            document.getElementById('tr_sms_cli').style.display='table-row';
            document.getElementById('tr_upload_file').style.display='table-row';
            document.getElementById('tr_email_user').style.display='none';
            document.getElementById('tr_add_cc').style.display='none';
        }
        else { alert('else');
            document.getElementById('tr_email_user').style.display='table-row';
            document.getElementById('tr_add_cc').style.display='table-row';
            document.getElementById('tr_sms_sequence').style.display='none';
            document.getElementById('tr_sms_cli').style.display='none';
            document.getElementById('tr_upload_file').style.display='none';            
        }
    });
                    
    var elem = $("#counter");
    $("#msg").limiter(160, elem);
</script>
</body>
</html>