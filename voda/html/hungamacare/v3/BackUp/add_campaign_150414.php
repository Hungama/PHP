<?php
//die('here');
ob_start();
session_start();
ini_set('display_errors', '0');
$PAGE_TAG = 'sms_eng';
include "includes/constants.php";
include "includes/language.php";
include "base.php";
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
$sel_opt = $_REQUEST['sel_opt'];
$sel_service = $_REQUEST['sel_service'];
$serviceArray1 = array('1302' => 'Vodafone54646');
$circle_info = array('GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi');

asort($circle_info);

$serviceArray = array();
foreach ($serviceArray1 as $k => $v) {
    if (in_array($v, $services)) {
        if ($k != '') {
            //	if($Service_DESC[$v]['Operator']=='Uninor') {
            $serviceArray[$k] = $Service_DESC[$v]['Name'];
            //}
        }
    }
}
asort($serviceArray);
//print_r ($serviceArray);			
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
        <link rel="stylesheet" href="css/bootstrap123.css" type="text/css" media="screen" />
        <script src="../ts_picker.js"></script>
        <script language="javascript" type="text/javascript" src="http://stuff.w3shaman.com/jquery-plugins/js/jquery.js"></script>
        <script language="javascript" type="text/javascript" src="http://stuff.w3shaman.com/jquery-plugins/auto-suggest/js/jquery.suggestion.js"></script>
        <link rel="stylesheet" type="text/css" href="http://stuff.w3shaman.com/jquery-plugins/auto-suggest/css/styles.css" />
    </head>

    <body onload="javascript:viewUploadhistory();">
        <div class="container">
            <?php
            include "includes/menu.php";
            ?>
            <div class="row">
                <div class="col-md-12"><h4><?php echo "ADD CAMPAIGN"; ?></h4></div>
            </div>    
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-pane active" id="pills-basic">
                        <div class="tabbable">
                            <ul class="nav nav-pills">
                                <li class="active"><a href="add_campaign.php" onclick="reloadPage();viewUploadhistory();" data-toggle="tab" data-act="create_rule">Create Campaign</a></li>
                            </ul>
                            <br/>
                            <div class="tab-content">
                                <div id="active" class="tab-pane active">
                                    <!--div id="active" class="tab-pane active" style="display:none"-->
                                    <form id="tstest" name="tstest" method="post" enctype="multipart/form-data">
                                        <table class="table table-bordered table-condensed">

                                            <tr>
                                                <td align="left" width="16%" height="32"><span>Service Name</span></td>
                                                <td align="left" colspan="2">
                                                    <select name="service" data-width="30%" onchange="setSC(this.value);">
                                                        <option value="0">Select Service</option>
                                                        <?php
                                                        foreach ($serviceArray as $s_id => $s_val) {
                                                            $select_str = '';
                                                            if ($sel_service == $s_id) {
                                                                $select_str = 'selected="selected"';
                                                            }
                                                            ?>
                                                            <option value="<?php echo $s_id; ?>" <?php echo $select_str; ?>><?php echo $s_val; ?></option>
                                                        <?php } ?>
                                                    </select></td>

                                            </tr>
                                            <tr>
                                                <td align="left" width="16%" height="32"><span>Short Code</span></td>
                                                <td align="left" colspan="2">
                                                    <?php
                                                    $selectQuery = "SELECT SC FROM master_db.tbl_sc_base WHERE status=1 and service_id = " . $sel_service . " ";
                                                    $querySel = mysql_query($selectQuery, $dbConn);
                                                    ?>
                                                    <select name="sc" data-width="30%">
                                                        <option value="0">Select Sort Code</option>
                                                        <?php
                                                        while ($row = mysql_fetch_array($querySel)) {
                                                            ?>
                                                            <!--                                                                                                                <option value="1111">1111</option>-->
                                                            <option value="<?php echo $row['SC']; ?>"><?php echo $row['SC']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" width="16%" height="32"><span>Circle</span></td>
                                                <td align="left" colspan="2">
                                                    <select name="circle[]" id="circle" multiple="multiple"  data-width="auto">
                                                        <!--                                                        <option value="0">Select Circle</option>-->
                                                        <?php foreach ($circle_info as $c_id => $c_val) {
                                                            ?>
                                                            <option value="<?php echo $c_id; ?>"><?php echo $c_val; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <!--                                                        &nbsp;<a href="javascript:toggle('circle')" id="all-circle">[All]</a><a href="javascript:toggle('circle')" id="none-circle" style="display:none">[X]</a>-->
                                                </td>

                                            </tr>
                                            <tr>
                                                <td align="left" width="16%" height="32"><span>Schedule For</span></td>
                                                <td align="left" colspan="2">
                                                    <input type="Text" name="timestamp" id="timestamp" value="">
                                                    <a href="javascript:show_calendar('document.tstest.timestamp', document.tstest.timestamp.value);"><img src="../2.0/images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                    <input type="Text" name="timestamp1" id="timestamp1" value="">
                                                    <a href="javascript:show_calendar('document.tstest.timestamp1', document.tstest.timestamp1.value);"><img src="../2.0/images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td align="left" width="16%" height="32"><span>Add Name</span></td>
                                                <td align="left" colspan="2">
                                                    <?php
                                                    $selectQuery = "SELECT ad_name FROM Vodafone_IVR.tbl_ad_nameMap WHERE status=1";
                                                    $querySel = mysql_query($selectQuery, $dbConn);
                                                    ?>
                                                    <select name="add_name" data-width="30%">
                                                        <option value="0">Select Ad Name</option>
                                                        <?php
                                                        while ($row = mysql_fetch_array($querySel)) {
                                                            ?>
                                                            <option value="<?php echo $row['ad_name']; ?>"><?php echo $row['ad_name']; ?></option>
                                                        <?php } ?>
                                                    </select>                                                                                                     
                                                </td>

                                            </tr>
                                            <tr>
                                                <td align="left" width="16%" height="32">Do You Want to Skip Customers</td>
                                                <td>
                                                    <label class="radio">
                                                        <input type="radio" id="is_skip_no" name="is_skip" value="0" data-toggle="radio" checked />&nbsp; No &nbsp;&nbsp;&nbsp;
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" id="is_skip_yes" name="is_skip" value="1" data-toggle="radio" checked />&nbsp; Yes &nbsp;&nbsp;&nbsp;
                                                    </label>
                                                </td>

                                                <td valign="middle"><button class="btn btn-primary">Submit</button>
                                            </tr>
                                        </table>
                                    </form>
                                </div>

                                <div id="history" class="tab-pane">

                                </div>
                            </div>
                        </div>
                        <div id="grid-active"></div>
                    </div>
                    <br/>
                    <div id = "alert_placeholder"></div>
                    <div id = "alert_msg"></div>
                    <div class="alert alert-danger" style='display:none' id="error_box"></div>
                    <div id="grid-view_upload_history"></div> 
                </div> 
                <div  class="row">
                    <div class="col-md-12">
                        <ul id="myTab" class="nav nav-pills">

                        </ul>
                    </div>
                </div>
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
                  //location.reload();
                window.location.href='add_campaign.php';
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

            $("form#tstest").submit(function(){  
                var isok = checkfield('tstest');
                if(isok)
                {
                    document.getElementById('alert_placeholder').style.display='none';
                    $('#loading').show();
                    var formData = new FormData($("form#tstest")[0]);
                    $.ajax({
                        url: 'add_campaign_process.php',
                        type: 'POST',
                        data: formData,
                        async: false,
                        success: function (data) {
                            document.getElementById('grid-active').style.display='inline';
                            document.getElementById('grid-active').innerHTML=data;
                            document.getElementById("active").style.display = "none";
                            document.getElementById("action").style.display = "block";
                            document.getElementById('alert_msg').style.display='inline';
                            //bootstrap_alert.msg('<?php echo 'Campaign has been added successfully'; ?>');
                            resestForm('tstest');    
                            viewUploadhistory();
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
                var service = document.forms["tstest"]["service"].value;
                var sc = document.forms["tstest"]["sc"].value;
                var timestamp = document.forms["tstest"]["timestamp"].value;
                var timestamp1 = document.forms["tstest"]["timestamp1"].value;
                var add_name = document.forms["tstest"]["add_name"].value;
                    
                $('#loading').hide();
                showMessageBox();
                if (service=='0' || service=='') {
                    bootstrap_alert.warning('<?php echo 'Please select service'; ?>');
                    return false;
                }
                else if(sc=='0' || sc == '')
                {	
                    bootstrap_alert.warning('<?php echo 'Please select SC'; ?>');
                    return false;
                } else if(timestamp=='0' || timestamp == '')
                {	
                    bootstrap_alert.warning('<?php echo 'Please select start date'; ?>');
                    return false;
                } else if(timestamp1=='0' || timestamp1 == '')
                {	
                    bootstrap_alert.warning('<?php echo 'Please select end time'; ?>');
                    return false;
                }else  if (add_name=='0' || add_name=='') {
                    bootstrap_alert.warning('<?php echo 'Please select add name'; ?>');
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
            bootstrap_alert.msg = function(message) {
                $('#alert_msg').html('<div class="alert alert-danger" style="color:green"><a class="close" data-dismiss="alert">&times;</a><span>'+message+'</span></div>')
            }
            function hideMessageBox() {
                document.getElementById('error_box').style.display='none';
                document.getElementById('alert_placeholder').style.display='none';
            }

            function showMessageBox() {
                //document.getElementById('error_box').style.display='inline';
                document.getElementById('alert_placeholder').style.display='inline';
            }
                
            
            function resestForm(formname)
            { alert('hi');
                window.location.href='add_campaign.php';
                //document.getElementById(formname).reset();
            }
                
            function viewUploadhistory() { 
                document.getElementById('alert_placeholder').style.display='none';
                document.getElementById('history').style.display='none';
                document.getElementById('grid-view_upload_history').style.display='block';
                $('#grid-view_upload_history').hide();
                $('#grid-view_upload_history').html('');
                $('#loading').show();
                $.fn.GetUploadHistory();
            };
            $.fn.GetUploadHistory = function() { 
                $('#loading').show();
                $.ajax({
	     
                    url: 'view_Campaign_history.php',
                    data: '',
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
                      
            $("select").selectpicker({style: 'btn btn-primary', menuStyle: 'dropdown-inverse'});
            function toggle(id){
		
                if( $("#all-"+id).is(":visible") ) {
                    $("#"+id).selectpicker("selectAll");
                    $("#all-"+id).toggle();
                    $("#none-"+id).toggle();
                }
                else {
                    $("#"+id).selectpicker("deselectAll");
                    $("#all-"+id).toggle();
                    $("#none-"+id).toggle();
		
                }
            }	
            
            var elem = $("#counter");
            $("#msg").limiter(160, elem);
            
            function setSC(service) { 
                window.location.href='add_campaign.php?sel_service='+service;
            }
            function showStatusConfirm(Id,action) { 
                if(action == 'dact') {
                    var answer = confirm("Are You Sure To Want Deactivate?");
                    if(answer) {
                    }else{
                        return false;
                    }
                } 
                if(action == 'act') {
                    var answer = confirm("Are You Sure To Want Activate?");
                    if(answer){
                        
                    } 
                    else{
                        return false;
                    } 
                } 
                document.getElementById('alert_placeholder').style.display='none';
                $('#loading').show();
                var datastring = 'id='+Id+'&act='+action;
                $.ajax({
                    url: 'view_Campaign_history.php',
                    type: 'POST',
                    data: datastring,
                    success: function (data) {
                        $('#loading').hide();
                        viewUploadhistory();
                    }
                });
                
                return false;
            }

        </script>
    </body>
</html>