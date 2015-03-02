<?php
require_once("../2.0/incs/db.php");
$serviceArray = array('1515' => 'Airtel - Sarnam');
$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra',
    'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa',
    'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala',
    'HPD' => 'Himachal Pradesh');
asort($circle_info);
$sms_cli_array = Array('1515' => '52222');

$rule_id = $_REQUEST['rule_id'];
$selectDisplayQuery = "SELECT id,rule_name,service_id,service_base,filter_base,scenerios,dnd_scrubbing,added_on,circle,status
                                FROM master_db.tbl_rule_engagement where id='" . $rule_id . "'";
$queryDisplaySel = mysql_query($selectDisplayQuery, $dbConn);
$rule_array = mysql_fetch_array($queryDisplaySel);
$selectActionQuery = "SELECT action_name,sms_sequence,time_slot,sms_cli,upload_file,email_user,cc_user,sms_type FROM master_db.tbl_rule_engagement_action 
                            where rule_id='" . $rule_id . "'";
$queryActionSel = mysql_query($selectActionQuery, $dbConn);
$action_array = mysql_fetch_array($queryActionSel);
$timeDisplayArray = explode(":", $action_array['time_slot']);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $rule_array['rule_name']; ?> </h4>
</div>
<div class="modal-body">
    <form id="form-edit" name="form-edit" method="post" enctype="multipart/form-data">
        <table class="table table-bordered table-condensed">
            <tr>
                <td align="left" width="16%" height="32"><span>Rule Id</span></td>
                <td align="left" colspan="2">
                    <?php echo $rule_array['id']; ?>  
                </td>
            </tr>
            <tr>
                <td align="left" width="16%" height="32"><span>Rule Name</span></td>
                <td align="left" colspan="2">
                    <?php echo $rule_array['rule_name']; ?> 
                </td>

            </tr>
            <tr>
                <td align="left" width="16%" height="32"><span>Added On</span></td>
                <td align="left" colspan="2">
                    <?php
                    $added_on = $rule_array['added_on'];
                    echo date('j-M h:i A', strtotime($added_on));
                    ?> 
                </td>

            </tr>
            <tr>
                <td align="left" width="16%" height="32"><span>Service Name</span></td>
                <td align="left" colspan="2">
                    <?php echo $serviceArray[$rule_array['service_id']]; ?> 
                </td>
            </tr>

            <tr>
                <td align="left" width="16%" height="32"><span>Service Base</span></td>
                <td align="left" colspan="2">
                    <input type="radio" name="service_edit_base" value="active" <?php echo ($rule_array['service_base'] == 'active') ? "checked" : ""; ?> >&nbsp; Active &nbsp;&nbsp;&nbsp;
                    <input type="radio"  name="service_edit_base" value="pending" <?php echo ($rule_array['service_base'] == 'pending') ? "checked" : ""; ?>>&nbsp; Pending &nbsp;&nbsp;&nbsp;
                    <input type="radio"  name="service_edit_base" value="both" <?php echo ($rule_array['service_base'] == 'both') ? "checked" : ""; ?>/>&nbsp; Both
                </td>
            </tr>
            <tr>
                <td align="left" width="16%" height="32"><span>Filter Base</span></td>
                <td align="left" colspan="2">
                    <select name="filter_edit_base" data-width="30%" onchange="setEditScenarios(this.value)">
                        <option value="0">Select Filter Base</option>
                        <?php
                        $selectQuery = "SELECT Fid,description FROM master_db.tbl_filter_base WHERE status=1";
                        $querySel = mysql_query($selectQuery, $dbConn);
                        while ($row = mysql_fetch_array($querySel)) {
                            ?>
                            <option value="<?php echo $row['Fid']; ?>" <?php echo ($rule_array['filter_base'] == $row['Fid']) ? 'selected="selected"' : ""; ?>><?php echo $row['description']; ?> </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="left" width="16%" height="32"><span>Scenarios</span></td>
                <td align="left" colspan="2">
                    <?php
                    $selectSceneriosQuery = "SELECT description FROM master_db.tbl_filter_base_scenarios where Scid=" . $rule_array['scenerios'] . "";
                    $querySceneriosSel = mysql_query($selectSceneriosQuery, $dbConn);
                    $Scenerios = mysql_fetch_row($querySceneriosSel);
                    ?> 
                    <select name="edit_scenarios" data-width="70%">
                        <option value="<?php echo $rule_array['scenerios']; ?>"><?php echo $Scenerios[0]; ?></option>
                    </select>

                </td>
            </tr>
            <tr>
                <td align="left" width="16%" height="32">DND scrubbing</td>
                <td>
                    <input type="radio"  name="edit_dnd_scrubbing" value="1" <?php echo ($rule_array['dnd_scrubbing'] == '1') ? "checked" : ""; ?> disabled/>&nbsp; Yes &nbsp;&nbsp;&nbsp;
                    <input type="radio"  name="edit_dnd_scrubbing" value="0" <?php echo ($rule_array['dnd_scrubbing'] == '0') ? "checked" : ""; ?> disabled/>&nbsp; No &nbsp;&nbsp;&nbsp;
                </td>
            </tr>
            <tr>
                <td align="left" width="16%" height="32"><span>Circle</span></td>
                <td align="left" colspan="2">
                    <select name="edit_circle[]" id="edit_circle" multiple="multiple" data-width="auto">
                        <!--                        <option value="0">Select Circle</option>-->
                        <?php
                        $rule_array['circle'] = explode(",", $rule_array['circle']);
                        foreach ($circle_info as $c_id => $c_val) {
                            $select_str = '';
                            for ($i = 0; $i < count($rule_array['circle']); $i++) {
                                if ($c_id == $rule_array['circle'][$i]) {
                                    $select_str = 'selected="selected"';
                                }
                            }
                            ?>
                            <option value="<?php echo $c_id; ?>" <?php echo $select_str; ?>><?php echo $c_val; ?></option>
                        <?php } ?>
                    </select>
                    &nbsp;<a href="javascript:toggleEdit('edit_circle')" id="all-edit_circle">[All]</a><a href="javascript:toggleEdit('edit_circle')" id="none-edit_circle" style="display:none">[X]</a>
                </td>
            </tr>
            <tr>
                <td align="left" width="16%" height="32">Action</td>                                    
                <td>
                    <?php echo $action_array['action_name']; ?>
                </td>

            </tr>
            <?php if ($action_array['action_name'] == 'sms') { ?>
                <tr id="tr_edit_sms_sequence">
                    <td align="left" width="16%" height="32"><span>SMS Sequence</span></td>
                    <td>
                        <input type="radio"  name="sms_edit_sequence" value="random" <?php echo ($action_array['sms_sequence'] == 'random') ? "checked" : ""; ?> />&nbsp; Random &nbsp;&nbsp;&nbsp;
                        <input type="radio"  name="sms_edit_sequence" value="fixed" <?php echo ($action_array['sms_sequence'] == 'fixed') ? "checked" : ""; ?>/>&nbsp; Fixed &nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
                <tr id="tr_edit_sms_type">
                    <td align="left" width="16%" height="32"><span>SMS Type</span></td>
                    <td>
                        <input type="radio"  name="sms_edit_type" value="promotional" <?php echo ($action_array['sms_type'] == 'promotional') ? "checked" : ""; ?> onchange="setEditSmsCli(this.value)" />&nbsp; Promotional &nbsp;&nbsp;&nbsp;
                        <input type="radio"  name="sms_edit_type" value="engagement" <?php echo ($action_array['sms_type'] == 'engagement') ? "checked" : ""; ?> onchange="setEditSmsCli(this.value)" />&nbsp; Engagement &nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
                <tr id="tr_edit_sms_cli">
                    <td align="left" width="16%" height="32"><span>SMS CLI</span></td>
                    <td align="left" colspan="2">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input style="color:#2E3232" type="text" name="sms_edit_cli" value="<?php echo $action_array['sms_cli']; ?>" placeholder="SMS Cli" class="form-control" readonly="readonly"/>
                                </div>          
                            </div>
                        </div>

                    </td>
                </tr>
                <tr id="tr_edit_upload_file">
                    <td align="left" width="16%" height="32"><span>Upload File</span></td>
                    <td align="left"> 
                        <input type="file" name="upload_edit_file" value="<?php echo $action_array['upload_file']; ?>"/>
                        <span id="display_file_name"><?php echo $action_array['upload_file']; ?></span>
                    </td>
                </tr>

            <?php } else { ?>
                <tr id="tr_edit_email_user">
                    <td align="left" width="16%" height="32"><span>Email User</span></td>
                    <td align="left" colspan="2">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input style="color:#2E3232" type="text" name="email_edit_user" value="<?php echo $action_array['email_user']; ?>" placeholder="Email" class="form-control" readonly="readonly"/>
                                </div>          
                            </div>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            <tr id="tr_edit_add_cc">
                <td align="left" width="16%" height="32"><span>Add CC</span></td>
                <td align="left">
                    <select name="add_edit_cc[]" multiple="multiple" data-width="auto">
                        <!--                        <option value="0">Select CC user id</option>-->

                        <?php
                        $action_array['cc_user'] = explode(",", $action_array['cc_user']);
                        $selectemailQuery = "SELECT email FROM master_db.live_user_master order by email";
                        $queryemailSel = mysql_query($selectemailQuery, $dbConn);
                        while ($row = mysql_fetch_array($queryemailSel)) {
                            $select_str = '';
                            for ($i = 0; $i < count($action_array['cc_user']); $i++) {
                                if ($row['email'] == $action_array['cc_user'][$i]) {
                                    $select_str = 'selected="selected"';
                                }
                            }
                            ?>
                            <option value="<?php echo $row['email']; ?>" <?php echo $select_str; ?>><?php echo $row['email']; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="left" width="16%" height="32">Time Slot</td>                                     
                <td>
                    <div class="input-append bootstrap-timepicker">
                        <input  name="edit_time_slot" id="edit_time_slot" class="input-small" type="text" value="<?php echo $action_array['time_slot']; ?>"/>
                        <span class="add-on"><i class="icon-time" style="margin-top:-5px"></i></span>
                    </div>
                </td>
            </tr>

            <tr>
                <td align="left" width="16%" height="32"><span>Last Processed at</span></td>
                <td align="left" colspan="2">
                    <?php
                    $get_rule_query = "SELECT added_on FROM master_db.tbl_new_engagement_data where rule_id='" . $rule_id . "' order by id desc limit 1";
                    $rule_query = mysql_query($get_rule_query, $dbConn);
                    $details = mysql_fetch_array($rule_query);
                    if ($details['added_on'] != '') {
                        $added_on = $details['added_on'];
                        echo date('j-M h:i A', strtotime($added_on));
                    } else {
                        echo "-";
                    }
                    ?>
                </td>

            </tr>
            <tr>
                <td align="left" width="16%" height="32"><span>Next Schedule</span></td>
                <td align="left" colspan="2">

                    <?php
                    if ($rule_array['status'] == 1) {
                        $getCurrentTimeQuery = "select DATE_FORMAT(now(),'%H:%i:%s')";
                        $timequery2 = mysql_query($getCurrentTimeQuery, $dbConn);
                        $currentTime = mysql_fetch_row($timequery2);

                        if ($currentTime[0] >= date('H:i:s', strtotime($action_array['time_slot']))) {
                            $next_date = date('Ymd', strtotime(' +1 day'));
                        } else {
                            $next_date = date('Ymd');
                        }
                        $next_date = $next_date . " " . $action_array['time_slot'];
                        echo date('j-M h:i:s A', strtotime($next_date));
                    } else {
                        echo "-";
                    }
                    ?>
                    <input type="hidden" name="rule_id" id="rule_id" value="<?php echo $rule_array['id']; ?>"/>
                    <input type="hidden" name="data_action" id="data_action" value="<?php echo $action_array['action_name']; ?>"/>
                    <input type="hidden" name="service_id" id="service_id" value="<?php echo $rule_array['service_id']; ?>"/>
                </td>

            </tr>
        </table>
        <?php if ($action_array['action_name'] == 'sms') { ?>
            <div id="fileFormat" class="well well-small">
                Please note: Only .txt file shall be accepted. Also, only 20,000 message shall be accepted in the file. Each row in your file should contain just one message.
            </div>
        <?php } ?>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="SubmitEditDeatil('<?php echo $rule_array['id']; ?>')">Save Rule</button>
    <button type="button" class="btn btn-danger" onclick="showDeleteConfirm('<?php echo $rule_array['id']; ?>')">Delete</button>
</div>
<script type="text/javascript">
    $('#edit_time_slot').timepicker();
    $("select").selectpicker({style: 'btn btn-primary', menuStyle: 'dropdown-inverse'});
    function toggleEdit(id){
		
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
    function setEditSmsCli(type) { 
        var service=document.forms["form-edit"]["service_id"].value;
        if(service == '1515'){
            if(type == 'promotional'){
                document.forms["form-edit"]["sms_edit_cli"].value= "601666";
            }else{
                document.forms["form-edit"]["sms_edit_cli"].value= "HMDEVO";
            }
        }
    }
</script>