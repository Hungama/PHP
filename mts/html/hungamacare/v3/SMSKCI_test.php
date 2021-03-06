<?php
ob_start();
session_start();
ini_set('display_errors', '0');
$PAGE_TAG = 'sms-kci';
include "includes/constants.php";
include "includes/language.php";
//echo $user_id=$_SESSION['usrId'];
$loginid=$_SESSION['loginId'];
$SKIP=1;

require_once("../2.0/incs/common.php");
require_once("../2.0/incs/db.php");
require_once("../2.0/language.php");
require_once("../2.0/base.php");
$listservices=$_SESSION["access_service"];
$services = explode(",", $listservices);


//include "includes/constants.php";
//include "includes/language.php";
//require_once("incs/db.php");
$serviceArray = Array('1101' => 'MTS - muZic Unlimited');
$circle_info = array('CHN' => 'Chennai', 'GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi', 'ALL' => 'ALL');
$time_slot_array = array('1' => '01: 00 AM', '2' => '02: 00 AM', '3' => '03: 00 AM', '4' => '04: 00 AM', '5' => '05: 00 AM',
    '6' => '06: 00 AM', '7' => '07: 00 AM', '8' => '08: 00 AM', '9' => '09: 00 AM', '10' => '10: 00 AM', '11' => '11: 00 AM', '12' => '12: 00 AM',
    '13' => '01: 00 PM', '14' => '02: 00 PM', '15' => '03: 00 PM', '16' => '04: 00 PM', '17' => '05: 00 PM', '18' => '06: 00 PM', '19' => '07: 00 PM',
    '20' => '08: 00 PM', '21' => '09: 00 PM', '22' => '10: 00 PM', '23' => '11: 00 PM', '24' => '12: 00 PM');
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
                <div class="col-md-8">
                    <h6><a href="javascript:void(0)" onclick="reloadPage()">Add New Rule</a></h6></div>
                <div class="col-md-4">
                    <!--    	<div class="btn-group btn-group-xs pull-right">
                      <button type="button" class="btn btn-info">Upload TSV</button>
                      <button type="button" class="btn btn-success">Download TSV</button>
                    </div><br/>-->
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="active" class="tab-pane active">
					<!--div id="active" class="tab-pane active" style="display:none"-->
<form name="testform">
<div class="col-md-3">
									 
		<label class="radio checked">
            <span class="icons"><span class="first-icon fui-radio-unchecked"></span>
			<span class="second-icon fui-radio-checked"></span></span>
			<input type="radio" name="model"  value="active"  checked="checked" onchange="checkChecked()">
            Active Base
          </label>
         <label class="radio">
            <span class="icons">
			<span class="first-icon fui-radio-unchecked"></span>
			<span class="second-icon fui-radio-checked"></span></span>
			<input type="radio" name="model"  value="pending" onchange="checkChecked()">
           Pending Base
          </label>
		    <label class="radio">
            <span class="icons">
			<span class="first-icon fui-radio-unchecked"></span>
			<span class="second-icon fui-radio-checked"></span></span>
			<input type="radio" name="model"  value="both"  onchange="checkChecked()">
           Both
          </label>
         


        </div>
		
 </form>
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
                                    <td align="left" colspan="2"><select name="service" data-width="auto">
                                            <option value="0">Select Service</option>
                                            <?php foreach ($serviceArray as $s_id => $s_val) {
                                                ?>
                                                <option value="<?php echo $s_id; ?>"><?php echo $s_val; ?></option>
                                            <?php } ?>
                                        </select></td>

                                </tr>
                                <tr>
                                    <td align="left" width="16%" height="32"><span>Circle</span></td>
                                    <td align="left" colspan="2"><select name="circle" data-width="auto">
                                            <option value="0">Select Circle</option>
                                            <?php foreach ($circle_info as $c_id => $c_val) {
                                                ?>
                                                <option value="<?php echo $c_id; ?>"><?php echo $c_val; ?></option>
                                            <?php } ?>
                                        </select></td>

                                </tr>
                                <tr>
                                    <td align="left" width="16%" height="32"><span>Service Base</span></td>
<td align="left" colspan="2">


<div class="col-md-3">
									 
		<label class="radio checked">
            <span class="icons"><span class="first-icon fui-radio-unchecked"></span>
			<span class="second-icon fui-radio-checked"></span></span>
			<input type="radio" name="service_base" id="optionsRadios1" value="active" data-toggle="radio" checked="checked">
            Active Base
          </label>
         <label class="radio">
            <span class="icons">
			<span class="first-icon fui-radio-unchecked"></span>
			<span class="second-icon fui-radio-checked"></span></span>
			<input type="radio" name="service_base" id="optionsRadios2" value="pending" data-toggle="radio">
           Pending Base
          </label>
		    <label class="radio">
            <span class="icons">
			<span class="first-icon fui-radio-unchecked"></span>
			<span class="second-icon fui-radio-checked"></span></span>
			<input type="radio" name="service_base" id="optionsRadios3" value="both" data-toggle="radio">
           Both
          </label>
         


        </div>
             </td>                   </tr>
                                <tr>
                                    <td align="left" width="16%" height="32"><span>Filter Base</span></td>
                                    <td align="left" colspan="2">
                                        <select name="filter_base" data-width="auto" onchange="setScenarios(this.value)">
                                            <option value="0">Select Filter Base</option>
                                            <?php
                                            $selectQuery = "SELECT Fid,description FROM master_db.tbl_filter_base WHERE status=1";
                                            $querySel = mysql_query($selectQuery, $dbConn);
                                            while ($row = mysql_fetch_array($querySel)) {
                                                ?>
                                                <option value="<?php echo $row['Fid']; ?>"><?php echo $row['description']; ?></option>
                                            <?php } ?>
                                        </select></td>
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
        <div class="col-md-3">
									 
		<label class="radio checked">
            <span class="icons"><span class="first-icon fui-radio-unchecked"></span>
			<span class="second-icon fui-radio-checked"></span></span>
			<input type="radio" name="dnd_scrubbing" id="dnd_scrubbing_yes" value="1" data-toggle="radio" checked="checked">
           Yes
          </label>
         <label class="radio">
            <span class="icons">
			<span class="first-icon fui-radio-unchecked"></span>
			<span class="second-icon fui-radio-checked"></span></span>
			<input type="radio" name="dnd_scrubbing" id="dnd_scrubbing_no" value="0" data-toggle="radio">
           No
          </label>
		   

        </div>
                                    </td>

                                    <td valign="middle"><button class="btn btn-primary" >Submit</button>
                                        <!--                                        <a href="javascript:;" class="btn btn-primary">Reset</a></td>-->
                                </tr>
                            </table>
                        </form>
                    </div>
                   <!--
				   <div id="action" class="tab-pane" style="display:none">
				                     <form id="form-action" name="form-action" method="post" enctype="multipart/form-data">
                            <table class="table table-bordered table-condensed">
                                <tr>
                                    <td align="left" width="16%" height="32"><span>Action</span></td>
                                    <td align="left" colspan="2">
                                        									
																				
		<div class="col-md-3">
									 
		<label class="radio checked">
            <span class="icons"><span class="first-icon fui-radio-unchecked"></span>
			<span class="second-icon fui-radio-checked"></span></span>
			<input type="radio" name="action_name" id="action_name_sms" value="sms" data-toggle="radio" checked="checked" onchange="handleClick(this.value)">
           SMS
          </label>
         <label class="radio">
            <span class="icons">
			<span class="first-icon fui-radio-unchecked"></span>
			<span class="second-icon fui-radio-checked"></span></span>
			<input type="radio" name="action_name" id="action_name_email" value="email" data-toggle="radio" onchange="handleClick(this.value)">
           Email
          </label>
		   

        </div>
                                    </td>
                                </tr>
                                <tr id="tr_sms_sequence">
                                    <td align="left" width="16%" height="32"><span>SMS Sequence</span></td>
                                    <td align="left" colspan="2">
                                     
										 <div class="col-md-3">
									 
		<label class="radio checked">
            <span class="icons"><span class="first-icon fui-radio-unchecked"></span>
			<span class="second-icon fui-radio-checked"></span></span>
			<input type="radio" name="sms_sequence" id="sms_sequence_random" value="random" data-toggle="radio" checked="checked">
           Random
          </label>
         <label class="radio">
            <span class="icons">
			<span class="first-icon fui-radio-unchecked"></span>
			<span class="second-icon fui-radio-checked"></span></span>
			<input type="radio" name="sms_sequence" id="sms_sequence_random" value="fixed" data-toggle="radio">
           Fixed
          </label>
		   

        </div>
                                       
                                    </td>

                                </tr>
                                <tr id="tr_sms_cli">
                                    <td align="left" width="16%" height="32"><span>SMS CLI</span></td>
                                    <td align="left" colspan="2">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="text" name="sms_cli" value="" placeholder="SMS Cli" class="form-control" />
                                                </div>          
                                            </div>
                                        </div>

                                    </td>
                                </tr>

                                <tr>
                                    <td align="left" width="16%" height="32"><span>Time Slot</span></td>
                                    <td align="left" colspan="2">
                                        <select name="time_slot">

                                            <option value="0">Select Time Slot</option>
                                            <?php foreach ($time_slot_array as $TS_id => $TS_val) {
                                                ?>
                                                <option value="<?php echo $TS_id; ?>"><?php echo $TS_val; ?></option>
                                            <?php } ?>
                                        </select>
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
                                                    <input type="text" name="email_user" value="" placeholder="Email" class="form-control" />
                                                </div>          
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr id="tr_add_cc" style="display: none;">
                                    <td align="left" width="16%" height="32"><span>Add CC</span></td>
                                    <td align="left">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="text" name="add_cc" value="" placeholder="CC" class="form-control" />
                                                </div>          
                                            </div>
                                        </div>
                                        <input type="hidden" name="rule_id" id="rule_id" />
                                    </td>
                                    <td valign="middle"><button class="btn btn-primary">Submit</button> </td>
                                </tr>
                                
                            </table>
                        </form>
                    </div>
					
					-->
                    <div id="display" class="tab-pane"  style="display:none">

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
                        <!--                        <li class="active"><a href="#SMS" data-toggle="tab">Create Rule</a></li>-->
                        <!--                        <li class=""><a href="#CallHangups" data-toggle="tab">Call Hangups</a></li>
                                                <li class=""><a href="#Footer" data-toggle="tab">Footer Messages</a></li>-->
                        <!-- Expand this to include Other types as well if there are -->
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
	
	function checkChecked(){
    for (var i = 0; i< document.getElementsByName('model').length; i++) {
        if(document.testform["model"][i].checked){          
            var omodcheck = document.testform["model"][i].value
            alert(omodcheck);
        }
    }
}

	function reloadPage()
  {
  location.reload();
  }
/*
function getVote()
{
for( i = 0; i < document.form-action.incident.elements.model.length; i++ )
{
  if(document.forms.incident.elements.model[i].checked){
        var omodcheck = document.forms.incident.elements.model[i].value;
        document.write(omodcheck);
    }
}

 var radiovalue= $('input[name="service_base"]:checked').val();
 alert("hello"+radiovalue);
 }*/
/*	
	function getRadioValue () {
    if( $('input[name=service_base]:radio:checked').length > 0 ) {
        return $('input[name=service_base]:radio:checked').val();
    }
    else {
        return 0;
    }
}
var aa=getRadioValue();
alert(aa);*/
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

        function setScenarios(filter_base) { 
            var xmlhttp;
            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                    //document.getElementById('scenarios').innerHTML=xmlhttp.responseText;
                    document.forms["form-active"]["scenarios"].innerHTML=xmlhttp.responseText;
                }
            }	
            var url="getScenerios.php?filter_base="+filter_base;
            xmlhttp.open("GET",url,true);
            xmlhttp.send();	
        }
        $("form#form-active").submit(function(){  
            var isok = checkfield('form-active');
            if(1)
            {
                document.getElementById('alert_placeholder').style.display='none';
                $('#loading').show();
                var formData = new FormData($("form#form-active")[0]);
                $.ajax({
				    //url: 'rule_creation_process.php',
                    url: 'snippets/sms_process.php',
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function (data) {
                        document.getElementById('grid-active').style.display='inline';
                        document.getElementById('grid-active').innerHTML=data;
                        //document.getElementById("active").style.display = "none";
                        //document.getElementById("action").style.display = "block";
                        // handleClick('sms');
                       // resestForm('active');    
                       // viewUploadhistory('me');
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



        function checkfield(type) { 
            $('#loading').hide();
            document.getElementById('alert_placeholder').style.display='inline';
            var rule_name=document.forms[type]["rule_name"].value; 
            var service=document.forms[type]["service"].value;
            var circle=document.forms[type]["circle"].value;
            var filter_base=document.forms[type]["filter_base"].value;     
            var scenarios=document.forms[type]["scenarios"].value;
			
			//var service_base=$('input:radio[name=service_base]:checked').val(); alert(service_base);
         //   var service_base=document.forms[type]["service_base"].value;alert(service_base);
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
            //return false;
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
        { //alert('here');
            var formname='form-'+type;
            document.getElementById(formname).reset();
        }
        function handleClick(action){ //alert(action);
            //currentValue = action.value;alert(currentValue);alert('bye');
            //if (action == 'sms') { 
			if (action == 'email') { 
                document.getElementById('tr_sms_sequence').style.display='table-row';
                document.getElementById('tr_sms_cli').style.display='table-row';
                document.getElementById('tr_upload_file').style.display='table-row';
                document.getElementById('tr_email_user').style.display='none';
                document.getElementById('tr_add_cc').style.display='none';
            }
            else { 
                document.getElementById('tr_email_user').style.display='table-row';
                document.getElementById('tr_add_cc').style.display='table-row';
                document.getElementById('tr_sms_sequence').style.display='none';
                document.getElementById('tr_sms_cli').style.display='none';
                document.getElementById('tr_upload_file').style.display='none';            
            }
        }
        $("form#form-action").submit(function(){
            var isok = checkactionfield('form-action');
			
            if(1)
            {
                document.getElementById('alert_placeholder').style.display='none';
                $('#loading').show();
                var formData = new FormData($("form#form-action")[0]);
                $.ajax({
                    //url: 'rule_creation_process.php',
                    url: 'rule_action_process.php',
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function (data) {
                        document.getElementById('grid-active').style.display='inline';
                        document.getElementById('grid-active').innerHTML=data;
                        document.getElementById("action").style.display = "none";
                        document.getElementById("display").style.display = "block";
                        $.fn.GetDisplayHistory();
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
/*		function getRadioValue () {
    if( $('input[name=action_name]:radio:checked').length > 0 ) {
        return $('input[name=action_name]:radio:checked').val();
    }
    else {
        return 0;
    }
}
function getResults() {
    var radios = document.getElementsByName("action_name");

    for (var i = 0; i < radios.length; i++) {       
        if (radios[i].checked) {
            alert(radios[i].value);
            break;
        }
    }
}
*/
        function checkactionfield(type) {
            $('#loading').hide();
            document.getElementById('alert_placeholder').style.display='inline';
           var action_name= $('input:radio[name=action_name]:checked').val(); //alert(action_name);
		   var sms_cli=document.forms[type]["sms_cli"].value;//alert(sms_cli);
            var time_slot=document.forms[type]["time_slot"].value;//alert(time_slot);
            var upfile=document.forms[type]["upload_file"].value;//alert(upload_file);     
            var email_user=document.forms[type]["email_user"].value;//alert(email_user);
            var add_cc=document.forms[type]["add_cc"].value;//alert(add_cc);
            if (time_slot == '0' || time_slot == "") {
                bootstrap_alert.warning('<?php echo 'Please select time slot'; ?>');
                return false;
            }           
            if (action_name == 'sms'){
			//this is because of radio button returned selected value..use email in case of sms otherwise sms in case of email
			//if (action_name == 'email'){                
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
                        //showhideMessageBox();
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
                if (email_user== '') {
                    bootstrap_alert.warning('<?php echo 'Please enter email user'; ?>');
                    return false;
                }else if (add_cc=="") {
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
            //return false;
            return true;
        }
        function validateEmail(email) 
        {
            var re = /\S+@\S+\.\S+/;
            return re.test(email);
        }
        function viewUploadhistory(added_by) { 
            document.getElementById('alert_placeholder').style.display='none';
            $('#grid-view_upload_history').hide();
            $('#grid-view_upload_history').html('');
            $('#loading').show();
            $.fn.GetUploadHistory(added_by);
            //$('#loading').hide();
       	};
        $.fn.GetUploadHistory = function(added_by) {
            $('#loading').show();
            $.ajax({
	     
                url: 'viewrule_engagement_history.php',
                data: 'added_by='+added_by,
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
        
        $.fn.GetDisplayHistory = function(added_by) {
            $('#loading').show();
            $.ajax({
	     
                url: 'rule_display.php',
                //data: 'added_by='+added_by,
                //data: $('#form-'+act).serialize() + '&action=del&username=<?php echo $username; ?>',
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
                    //                        document.forms['show']["service"].value=serviceId;
                    //                        document.forms['show']["circle"].value=circle;
                    //                        $("form#show").submit();
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
                //data: $('#form-'+act).serialize() + '&action=del&username=<?php echo $username; ?>',
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
                    //                        document.forms['show']["service"].value=serviceId;
                    //                        document.forms['show']["circle"].value=circle;
                    //                        $("form#show").submit();
                    document.getElementById("myModal").style.display = "none";
                    viewUploadhistory('me');
                }
            });
               
            return false;
        }
        var elem = $("#counter");
        $("#msg").limiter(160, elem);
    </script>
    <!-- Button trigger modal -->
    <!--    <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
            Launch demo modal
        </button>-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="modal_content">

            </div>
        </div>
    </div>
    <!-- Modal -->


</body>
</html>