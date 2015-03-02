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
                if(type=='form-obd')
                {
                    $('#loading').hide();
                    document.getElementById('alert_placeholder').style.display='inline';
                    var obd_name=document.forms[type]["obd_name"].value;
                    var obd_description=document.forms[type]["obd_description"].value;
                    var upfile=document.forms[type]["upfile"].value;
                    if (obd_name==null || obd_name=="")
                    {
                        bootstrap_alert.warning('Please enter obd name.');
                        return false;
                    }  
                    else if (obd_description==null || obd_description=="")
                    {
                        bootstrap_alert.warning('Please enter obd description.');
                        return false;
                    }
                    else if (upfile==null || upfile=="")
                    {
                        bootstrap_alert.warning('Please select prompt file.');
                        return false;
                    }
                    $('#loading').show();
                    showhideMessageBox();
                    return true;
                }
                else if(type=='form-menu')
                {
                    $('#loading').hide();
                    document.getElementById('alert_placeholder').style.display='inline';
                    var catname=document.forms[type]["form_song_categoryname"].value;
                    var ussd_str=document.forms[type]["ussd_str"].value;
                    //var menu_id=document.forms[type]["menu_id"].value;
                    var obd_form_circle=document.forms[type]["obd_form_circle"].value;
                    var form_dtmf_1=document.forms[type]["form_dtmf_1"].value;
                    var form_contentid_1=document.forms[type]["form_contentid_1"].value;
   
                    if (catname==null || catname=="")
                    {
                        bootstrap_alert.warning('Please enter category name.');
                        return false;
                    }  
                    else if (ussd_str==null || ussd_str=="")
                    {
                        bootstrap_alert.warning('Please select ussd string.');
                        return false;
                    }
//                    else if (menu_id==null || menu_id=="")
//                    {
//                        bootstrap_alert.warning('Please select menu id.');
//                        return false;
//                    }
                    else if (obd_form_circle==null || obd_form_circle=="")
                    {
                        bootstrap_alert.warning('Please select circle.');
                        return false;
                    }
                    else if (form_dtmf_1==null || form_dtmf_1=="")
                    {
                        bootstrap_alert.warning('Please eneter DTMF.');
                        return false;
                    }
                    else if (form_contentid_1==null || form_contentid_1=="")
                    {
                        bootstrap_alert.warning('Please eneter Content ID.');
                        return false;
                    }
                    $('#loading').show();
                    showhideMessageBox();
                    return true;
                }
                else if(type=='form-active')
                {
                    $('#loading').hide();
                    document.getElementById('alert_placeholder').style.display='inline';
                    var ussd_str=document.forms[type]["ussd_str"].value;
                    var obd_form_service=document.forms[type]["obd_form_service"].value;
                    var upfile=document.forms[type]["upfile"].value;

                    if (ussd_str==null || ussd_str=="")
                    {
                        bootstrap_alert.warning('Please select ussd string.');
                        return false;
                    }  
                    else if (obd_form_service==0)
                    {
                        bootstrap_alert.warning('Please select service.');
                        return false;
                    }
                    else if (upfile==null || upfile=="")
                    {
                        bootstrap_alert.warning('Please upload a valid .txt file.');
                        return false;
                    }
                    $('#loading').show();
                    showhideMessageBox();
                    return true;
                }
                $('#loading').hide();
                document.getElementById('alert_placeholder').style.display='inline';
                var menuid=document.forms[type]["obd_form_menuid"].value;
                var service_info=document.forms[type]["obd_form_service"].value;
                var test_mode_value=document.forms[type]["test_mode_value"].value;
   
                if (menuid==null || menuid=="")
                {
                    bootstrap_alert.warning('Please select menu id.');
                    return false;
                }  
                else if (service_info==0)
                {
                    bootstrap_alert.warning('Please select service.');
                    return false;
                }
                else if(test_mode_value==0)
                {
                    var testingno=document.forms[type]["testingno"].value;
                    if(testingno==0)
                    {
                        bootstrap_alert.warning('Please enter testing number.');
                        return false;
                    }
                }
                else if(test_mode_value==1)
                {
                    var upfile=document.forms[type]["upfile"].value;
                    if(upfile==null || upfile=="")
                    {
                        bootstrap_alert.warning('Please select a file to upload.');
                        return false;
                    }
                    var ext = upfile.substring(upfile.lastIndexOf('.') + 1);

                    if(ext=="txt")
                    {
                        var count=(upfile.split(".").length - 1);
                        if(count==1)
                        {
                            $('#loading').show();
                            showhideMessageBox();
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
                }
                $('#loading').show();
                showhideMessageBox();	
                //	return false;
                return true;
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
	
            function showhide(type)
            {
                if(type=='live')
                {
                    document.getElementById('live_mode').style.display = 'table-row';
                    document.getElementById('test_mode').style.display = 'none';
                    document.getElementById('test_mode_value').value = 1;
                }
                else
                {
                    document.getElementById('live_mode').style.display = 'none';
                    document.getElementById('test_mode').style.display = 'table-row';
                    document.getElementById('test_mode_value').value = 0;
                }
            }
            function showhidetimediv()
            {	
                if(document.getElementById("showtime").checked == true)
                {
                    document.getElementById('settime').value='yes';
                    document.getElementById('time_mode').style.display = 'table-row';
                }
                else
                {
                    document.getElementById('time_mode').style.display = 'none';
                    document.getElementById('settime').value='no';
                }
            }
            function confirmKillBase(batchid)
            {
                var xmlhttp;
                if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp=new XMLHttpRequest();
                } else { // code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange=function() {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                        //alert(xmlhttp.responseText);
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
                var url="start_stopUssdFile.php?type=ussd&batchid="+batchid;
                xmlhttp.open("GET",url,true);
                xmlhttp.send();	

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
            function confirmStop(batchid)
            {
                var x;
                var r=confirm("This will terminate the campaign and the RUN cannot be executed on the same base.");
                if (r==true)
                {
                    startStopUssd('kill',batchid);
                }
            }
            function confirmBaseStop(batchid)
            {
                var x;
                var r=confirm("This will terminate the campaign and the RUN cannot be executed on the same base.");
                if (r==true)
                {
                    confirmKillBase(batchid);
                }
            }
            function stopautorefresh()
            {
                clearTimeout(xhrTimeout); 
            }

            function showmore(id)
            {
                if(id=='setmenu2')
                {
                    document.getElementById('setmenu2').style.display = 'table-row';
                }
                else if(id=='setmenu3')
                {
                    document.getElementById('setmenu3').style.display = 'table-row';
                }else if(id=='setmenu4')
                {
                    document.getElementById('setmenu4').style.display = 'table-row';
                }else if(id=='setmenu5')
                {
                    document.getElementById('setmenu5').style.display = 'table-row';
                }
            }
        </script>

        <!-- Bootstrap CSS Toolkit styles -->
    </head>

    <body onload="javascript:viewUploadMenuhistory('DTMF')">

        <div class="navbar navbar-inner">
            <a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
        </div>

        <div class="container">
            <div class="row">

                <div class="page-header">
                    <h1>USSD PULL PUSH<small>&nbsp;&nbsp;</small></h1>
                </div>
                <div class="tab-pane active" id="pills-basic">
                    <div class="tabbable">
                        <ul class="nav nav-pills">
                            <!--					 <li class="active"><a href="#active" data-toggle="tab" data-act="activation" onclick="javascript:viewUploadhistory('ussd2')">USSD</a></li>-->
                            <li class="active"><a href="#menu" data-toggle="tab" data-act="menu" onclick="javascript:viewUploadMenuhistory('DTMF')">Menu </a></li>
                            <!--					   <li><a href="#obd" data-toggle="tab" data-act="obd" onclick="javascript:viewUploadOBDhistory('ussd')">OBD</a></li>-->
                        </ul>
                        <div class="tab-content">
                            <div id="active" class="tab-pane">
                                <form id="form-active" name="form-active" method="post" enctype="multipart/form-data">
                                    <table class="table table-bordered table-condensed">
                                        <tr>
                                            <td align="left" width="16%" height="32"><span>USSD String&nbsp;</span></td>
                                            <td>
                                                <?php
                                                $menudata = '';
                                                $getlivemenu = "select Sid,ussd_string,menu_id from USSD.tbl_songname where status=1 and ussd_string in('*546*21#','*546*22#','*546*23#')";
                                                $result_livemenu = mysql_query($getlivemenu) or die(mysql_error());
                                                ?>
                                                <select name="ussd_str" id="ussd_str" onchange="setmenumessage(this.value)">
                                                    <option value="">Select USSD String</option>

                                                    <?php
                                                    while ($data_livemenu = mysql_fetch_array($result_livemenu)) {
                                                        ?>
                                                        <option value="<?php echo $data_livemenu['ussd_string'] . '-' . $data_livemenu['menu_id']; ?>"><?php echo $data_livemenu['ussd_string']; ?></option>
                                                    <?php } ?>

                                                </select>

                                            </td>
                                        </tr>

                                        <tr>

                                            <td align="left" width="16%" height="32">
                                                Please select service
                                            </td>
                                            <td>
                                                <select name="obd_form_service" id="obd_form_service" onchange="">
                                                    <option value="0">Select any one--</option>
                                                    <option value="1401">Uninor-MusicUnlimited</option>
                                                    <option value="1410">RedFM</option>
                                                    <option value="1450">My Music</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="16%" height="32" align="left">Mode</td>
                                            <td>
                                                <!--input type="radio" name="mode" value="live" checked onchange="showhide(this.value)"-->
                                                <input type="radio" name="mode" value="live" checked >Push
                                                    <!--input type="radio" name="mode" value="test" >Testing-->
                                            </td>
                                        </tr>
                                        <tr id="test_mode" style="display:none">
                                            <td align="left" width="16%" height="32" >Enter Testing Number</td>
                                            <td>

                                                <input type="text" name="testingno" id="testingno" value="" size="">
                                                    (Please don't enter more than 10 mobile numbers for testing)
                                            </td>
                                        </tr>
                                        <tr id="live_mode">
                                            <td align="left" width="16%" height="32">
                                                <span>Browse File To Upload </span>
                                            </td>
                                            <td>
                                                <INPUT name="upfile" id='upfile' type="file" class="in">
                                            </td>
                                        </tr>


                                        <tr>
                                            <td align="left" width="16%" height="32">
                                                <span>Date Range</span>
                                            </td>
                                            <td>
                                                <fieldset>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <div class="input-prepend">

                                                                <span class="add-on"><i class="icon-calendar"></i></span><input type="text" name="schedule_date" id="schedule_date" value="<?php echo date("m/d/Y"); ?> - <?php echo date("m/d/Y"); ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <input type="checkbox" name="showtime" id="showtime" onclick="showhidetimediv()">&nbsp;Want to schedule time ?
                                                    <input type="hidden" name="settime" id="settime" value="no"/>
                                            </td>
                                        </tr>
                                        <tr id="time_mode" style="display:none">
                                            <td align="left" width="16%" height="32">
                                                <span>Time Range</span>
                                            </td>
                                            <td>
                                                <fieldset>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <div class="input-prepend">
                                                                <span class="add-on"><i class="icon-time"></i></span>
                                                                <select name="schedule_start_time" id="schedule_start_time">
                                                                    <option value="00:00:00">Select Start Time</option>
                                                                    <option value="08:00:00">8:00 AM</option>
                                                                    <option value="09:00:00">9:00 AM</option>
                                                                    <option value="10:00:00">10:00 AM</option>
                                                                    <option value="11:00:00">11:00 AM</option>
                                                                    <option value="12:00:00">12:00 PM</option>
                                                                    <option value="13:00:00">01:00 PM</option>
                                                                    <option value="14:00:00">02:00 PM</option>
                                                                    <option value="15:00:00">03:00 PM</option>
                                                                    <option value="16:00:00">04:00 PM</option>
                                                                    <option value="17:00:00">05:00 PM</option>
                                                                    <option value="18:00:00">06:00 PM</option>
                                                                    <option value="19:00:00">07:00 PM</option>
                                                                    <option value="20:00:00">20:00 PM</option>
                                                                </select>
                                                                <select name="schedule_end_time" id="schedule_end_time">
                                                                    <option value="00:00:00">Select End Time</option>
                                                                    <option value="08:00:00">8:00 AM</option>
                                                                    <option value="09:00:00">9:00 AM</option>
                                                                    <option value="10:00:00">10:00 AM</option>
                                                                    <option value="11:00:00">11:00 AM</option>
                                                                    <option value="12:00:00">12:00 PM</option>
                                                                    <option value="13:00:00">01:00 PM</option>
                                                                    <option value="14:00:00">02:00 PM</option>
                                                                    <option value="15:00:00">03:00 PM</option>
                                                                    <option value="16:00:00">04:00 PM</option>
                                                                    <option value="17:00:00">05:00 PM</option>
                                                                    <option value="18:00:00">06:00 PM</option>
                                                                    <option value="19:00:00">07:00 PM</option>
                                                                    <option value="20:00:00">20:00 PM</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>


                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" width="16%" height="32">
                                            </td>
                                            <td>
                                                <input type="hidden" name="test_mode_value" id="test_mode_value" value="1"/>
                                                <input type="hidden" name="post_for" id="post_for" value="BASE"/>
                                                <button class="btn btn-primary" style="float:right">Submit</button>
                                            </td>
                                        </tr>

                                    </table>
                                </form>	

                                <div id="grid-active">

                                </div>				
                            </div>
                            <!--MEnu section start here-->

                            <div id="menu" class="tab-pane active">
                                <form id="form-menu" name="form-menu" method="post" enctype="multipart/form-data">
                                    <table class="table table-bordered table-condensed">
                                        <tr><td>Song Category</td><td colspan="2"><input type="text" name="form_song_categoryname" id="form_song_categoryname" value=""/></td></tr>
                                        <tr><td>USSD String</td><td colspan="2">
                                                <select id="ussd_str" name="ussd_str">
                                                    <option value="">Select USSD String</option>
                                                    <option value="*546*21#">*546*21#</option>
                                                    <option value="*546*22#">*546*22#</option>
                                                    <option value="*546*23#">*546*23#</option>
                                                </select>
                                            </td></tr>
                            <!--		<tr><td>Menu ID</td><td colspan="2">
                                            <select id="menu_id" name="menu_id">
                                            <option value="">Select menu id</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            </select>
                                            </td></tr>-->
                                        <tr>
                                            <td>Circle</td>
                                            <td align="left" colspan="2">
                                                <select name="obd_form_circle" id="obd_form_circle" onchange="">
                                                    <option value="">Select any one--</option>
<?php
$circle_info = array('GUJ' => 'Gujarat', 'BIH' => 'Bihar', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'MUM' => 'Mumbai', 'PAN' => 'ALL');
foreach ($circle_info as $key => $value) {
    echo "<option value=\"$key\">$value</option>";
}
?>                    </select>
                                            </td>
                                        </tr>
                                        <tr><td>1<input type="hidden" name="form_dtmf_1_id" id="form_dtmf_1_id" value="1"/></td>
                                            <td align="left">DTMF: <input type="text" class="text" name="form_dtmf_1" id="form_dtmf_1" value=""/></td>
                                            <td align="left">Content ID: <input type="text" class="text" name="form_contentid_1" id="form_contentid_1" value=""/>

                                                <a href="Javascript:void(0)" onclick="showmore('setmenu2')">Add More</a>
                                            </td>
                                        </tr>

                                        <tr id="setmenu2" style="display:none"><td>2<input type="hidden" name="form_dtmf_2_id" id="form_dtmf_2_id" value="2"/></td>
                                            <td  align="left">DTMF: <input type="text" class="text" name="form_dtmf_2" id="form_dtmf_2" value=""/></td>
                                            <td  align="left">Content ID: <input type="text" class="text" name="form_contentid_2" id="form_contentid_2" value=""/>
                                                <a href="Javascript:void(0)" onclick="showmore('setmenu3')">Add More</a>
                                            </td>
                                        </tr>

                                        <tr id="setmenu3" style="display:none"><td>3<input type="hidden" name="form_dtmf_3_id" id="form_dtmf_3_id" value="3"/></td>
                                            <td align="left">DTMF: <input type="text" class="text" name="form_dtmf_3" id="form_dtmf_3" value=""/></td>
                                            <td align="left">Content ID: <input type="text" class="text" name="form_contentid_3" id="form_contentid_3" value=""/>
                                                <a href="Javascript:void(0)" onclick="showmore('setmenu4')">Add More</a></td>
                                        </tr>
                                        <tr id="setmenu4" style="display:none"><td>4<input type="hidden" name="form_dtmf_4_id" id="form_dtmf_4_id" value="4"/></td>
                                            <td align="left">DTMF: <input type="text" class="text" name="form_dtmf_4" id="form_dtmf_4" value=""/></td>
                                            <td align="left">Content ID: <input type="text" class="text" name="form_contentid_4" id="form_contentid_4" value=""/>
                                                <a href="Javascript:void(0)" onclick="showmore('setmenu5')">Add More</a></td>
                                        </tr>
                                        <tr id="setmenu5" style="display:none"><td>5<input type="hidden" name="form_dtmf_5_id" id="form_dtmf_5_id" value="5"/></td>
                                            <td align="left">DTMF: <input type="text" class="text" name="form_dtmf_5" id="form_dtmf_5" value=""/></td>
                                            <td align="left">Content ID: <input type="text" class="text" name="form_contentid_5" id="form_contentid_5" value=""/>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="3">
                                                <input type="hidden" name="post_for" id="post_for" value="DTMF"/>
                                                <button class="btn btn-primary" style="float:right">Submit</button>
                                            </td>
                                        </tr>

                                    </table>
                                </form>	

                                <div id="grid-menu">

                                </div>				
                            </div>					
                            <!--OBD SEction Start here--->					
                            <div id="obd" class="tab-pane">
                                <form id="form-obd" name="form-obd" method="post" enctype="multipart/form-data">
                                    <table class="table table-bordered table-condensed">
                                        <tr>
                                            <td width="16%" height="32" align="left">OBD</td>
                                            <td>
                                                <input type="text" class="text" name="obd_name" id="obd_name"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="16%" height="32" align="left">Description</td>
                                            <td>
                                                <input type="text" class="text" name="obd_description" id="obd_description"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="16%" height="32" align="left">Upload Prompt</td>
                                            <td>
                                                <INPUT name="upfile" id='upfile' type="file" class="in">
                                                    *(Upload valid .wav File)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" width="16%" height="32">
                                            </td>
                                            <td>
                                                <input type="hidden" name="post_for" id="post_for" value="OBD"/>
                                                <button class="btn btn-primary" style="float:right">Submit</button>
                                            </td>
                                        </tr>
                                    </table>
                                </form>	

                                <div id="grid-obd">

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
            function viewUploadhistory(a) {
                document.getElementById('alert_placeholder').style.display='none';
                $('#loading').show();
                $('#grid-view_upload_history').hide();
                $('#grid-view_upload_history').html('');
                $('#grid-view_menu_message').hide();
                $('#grid-view_menu_message').html('');
                $.fn.GetUploadHistory(a);
		
            };
	
            function viewUploadOBDhistory(a) {
                document.getElementById('alert_placeholder').style.display='none';
                $('#loading').show();
                $('#grid-view_upload_history').hide();
                $('#grid-view_upload_history').html('');
                $('#grid-view_menu_message').hide();
                $('#grid-view_menu_message').html('');
                $.fn.GetUploadOBDHistory(a);
		
            };
            function setmenumessage(a) {
                $('#loading').show();
                $('#grid-view_menu_message').hide();
                $('#grid-view_menu_message').html('');
                $.fn.GetMenuMessage(a);
		
            };
            function viewUploadMenuhistory(a) {
                document.getElementById('alert_placeholder').style.display='none';
                $('#loading').show();
                $('#grid-view_upload_history').hide();
                $('#grid-view_upload_history').html('');
                $('#grid-view_menu_message').hide();
                $('#grid-view_menu_message').html('');
                $.fn.GetUploadMenuHistory(a);
            };
            $.fn.GetUploadMenuHistory = function(DTMF) {
                //$('#loading').show();
                $.ajax({
	     
                    url: 'viewsongconfighistory_inProgress.php',
                    data: 'type=DTMF',
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
            $.fn.GetUploadOBDHistory = function(DTMF) {
                $.ajax({
	     
                    url: 'viewuploadobdhistory.php',
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

            $.fn.GetUploadHistory = function(type) {
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

            $.fn.GetMenuMessage = function(id) {
                $.ajax({
	     
                    url: 'viewmenumessage.php',
                    data: 'ussdstr='+id,
                    type: 'get',
                    cache: false,
                    dataType: 'html',
                    success: function (abc) {
                        $('#grid-view_menu_message').html(abc);
                        $('#loading').hide();
                    }
						
                });
						
                $('#grid-view_menu_message').show();
	
            };

            $("form#form-active").submit(function(){
                var isok = checkfield('form-active');
                if(isok)
                {
                    document.getElementById('alert_placeholder').style.display='none';
                    //$('#loading').show();
                    var formData = new FormData($("form#form-active")[0]);
                    $.ajax({
                        url: 'bulkupload_menu_process.php',
                        type: 'POST',
                        data: formData,
                        async: false,
                        success: function (data) {
                            document.getElementById('grid-active').style.display='inline';
                            document.getElementById('grid-active').innerHTML=data;
                            resestForm('active');
                            viewUploadhistory('ussd2');
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

            $("form#form-obd").submit(function(){
                var isok = checkfield('form-obd');
                if(isok)
                {
                    document.getElementById('alert_placeholder').style.display='none';
                    //$('#loading').show();
                    var formData = new FormData($("form#form-obd")[0]);
                    $.ajax({
                        url: 'bulkupload_menu_process.php',
                        type: 'POST',
                        data: formData,
                        async: false,
                        success: function (data) {
                            document.getElementById('grid-obd').style.display='inline';
                            document.getElementById('grid-obd').innerHTML=data;
                            resestForm('obd');
                            viewUploadOBDhistory('ussd')
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

            $("form#form-menu").submit(function(){ 
                var isok = checkfield('form-menu');
                if(isok)
                { 
                    document.getElementById('alert_placeholder').style.display='none';
                    //$('#loading').show();
                    var formData = new FormData($("form#form-menu")[0]);
                    $.ajax({
                        url: 'bulkupload_menu_process_inProgress.php',
                        type: 'POST',
                        data: formData,
                        async: false,
                        success: function (data) {
                            document.getElementById('grid-menu').style.display='inline';
                            document.getElementById('grid-menu').innerHTML=data;
                            resestForm('menu');
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
        <!--script src="../2.0/assets/js/bootstrap-datetimepicker.min.js"></script-->
        <!-- added for file uplaod using bootstarp api-->
        <!--script src="http://mediaplayer.yahoo.com/js"></script-->
        <script>
            function DHTMLSound(surl) {
                document.getElementById("dummyspan").innerHTML=
                    "<embed src='"+surl+"' hidden=true autostart=true loop=false>";
            }
        </script>
    </body>
</html>