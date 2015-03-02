<?php
require_once("incs/db.php");
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
$sms_cli_array = Array('1101' => '52222');

$rule_id = $_REQUEST['rule_id'];
$selectDisplayQuery = "SELECT id,rule_name,service_id,service_base,filter_base,scenerios,dnd_scrubbing,added_on,circle
                                FROM master_db.tbl_rule_engagement where id='" . $rule_id . "'";
$queryDisplaySel = mysql_query($selectDisplayQuery, $dbConn);
$rule_array = mysql_fetch_array($queryDisplaySel);
$selectActionQuery = "SELECT action_name,sms_sequence,time_slot,sms_cli,upload_file,email_user,cc_user,min,sec FROM master_db.tbl_rule_engagement_action 
                            where rule_id='" . $rule_id . "'";
$queryActionSel = mysql_query($selectActionQuery, $dbConn);
$action_array = mysql_fetch_array($queryActionSel);
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
                    <input type="radio" id="service_edit_base_active" name="service_edit_base" value="active" <?php echo ($rule_array['service_base'] == 'active') ? "checked" : ""; ?> >&nbsp; Active &nbsp;&nbsp;&nbsp;
                    <input type="radio" id="service_edit_base_pending" name="service_edit_base" value="pending" <?php echo ($rule_array['service_base'] == 'pending') ? "checked" : ""; ?>>&nbsp; Pending &nbsp;&nbsp;&nbsp;
                    <input type="radio" id="service_edit_base_both" name="service_edit_base" value="both" <?php echo ($rule_array['service_base'] == 'both') ? "checked" : ""; ?>/>&nbsp; Both
                </td>
            </tr>
            <tr>
                <td align="left" width="16%" height="32"><span>Filter Base</span></td>
                <td align="left" colspan="2">
                    <select name="filter_edit_base" id="filter_edit_base" data-width="auto" onchange="setEditScenarios(this.value)">
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
                    //echo $Scenerios[0];
                    ?> 
                    <select name="edit_scenarios" data-width="auto">
                        <option value="<?php echo $rule_array['scenerios']; ?>"><?php echo $Scenerios[0]; ?></option>
                    </select>

                </td>
            </tr>
            <tr>
                <td align="left" width="16%" height="32">DND scrubbing</td>
                <td>
                    <input type="radio" id="edit_dnd_scrubbing_yes" name="edit_dnd_scrubbing" value="1" <?php echo ($rule_array['dnd_scrubbing'] == '1') ? "checked" : ""; ?>/>&nbsp; Yes &nbsp;&nbsp;&nbsp;
                    <input type="radio" id="edit_dnd_scrubbing_no" name="edit_dnd_scrubbing" value="0" <?php echo ($rule_array['dnd_scrubbing'] == '0') ? "checked" : ""; ?>/>&nbsp; No &nbsp;&nbsp;&nbsp;
                </td>
            </tr>
            <tr>
                <td align="left" width="16%" height="32"><span>Circle</span></td>
                <td align="left" colspan="2">
                    <select name="edit_circle" data-width="auto">
                        <option value="0">Select Circle</option>
                        <?php foreach ($circle_info as $c_id => $c_val) {
                            ?>
                            <option value="<?php echo $c_id; ?>" <?php echo ($rule_array['circle'] == $c_id) ? 'selected="selected"' : ""; ?>><?php echo $c_val; ?></option>
                        <?php } ?>
                    </select>
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
                        <input type="radio" id="sms_edit_sequence_random" name="sms_edit_sequence" value="random" <?php echo ($action_array['sms_sequence'] == 'random') ? "checked" : ""; ?> />&nbsp; Random &nbsp;&nbsp;&nbsp;
                        <input type="radio" id="sms_edit_sequence_fixed" name="sms_edit_sequence" value="fixed" <?php echo ($action_array['sms_sequence'] == 'fixed') ? "checked" : ""; ?>/>&nbsp; Fixed &nbsp;&nbsp;&nbsp;
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
                <tr>
                    <td align="left" width="16%" height="32">Time Slot</td>                                     
                    <td>
                        <select name="sms_edit_time_slot">
                            <option value="0">Select Time Slot</option>
                            <?php foreach ($sms_time_slot_array as $TS_id => $TS_val) {
                                ?>
                                <option value="<?php echo $TS_id; ?>" <?php echo ($action_array['time_slot'] == $TS_id) ? 'selected="selected"' : ""; ?>><?php echo $TS_val; ?></option>
                            <?php } ?>
                        </select>
                        <select name="sms_edit_min">
                            <option value="0">Select Minute</option>
                            <?php foreach ($min_sec_array as $TS_id => $TS_val) {
                                ?>
                                <option value="<?php echo $TS_id; ?>" <?php echo ($action_array['min'] == $TS_id) ? 'selected="selected"' : ""; ?>><?php echo $TS_val; ?></option>
                            <?php } ?>
                        </select>
                        <select name="sms_edit_sec">
                            <option value="0">Select Second</option>
                            <?php foreach ($min_sec_array as $TS_id => $TS_val) {
                                ?>
                                <option value="<?php echo $TS_id; ?>" <?php echo ($action_array['sec'] == $TS_id) ? 'selected="selected"' : ""; ?>><?php echo $TS_val; ?></option>
                            <?php } ?>
                        </select>
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
                <tr id="tr_edit_add_cc">
                    <td align="left" width="16%" height="32"><span>Add CC</span></td>
                    <td align="left">
                        <select name="add_edit_cc" data-width="auto">
                            <option value="0">Select CC user id</option>
                            <?php
                            $selectemailQuery = "SELECT email FROM master_db.live_user_master order by email";
                            $queryemailSel = mysql_query($selectemailQuery, $dbConn);
                            while ($row = mysql_fetch_array($queryemailSel)) {
                                ?>
                                <option value="<?php echo $row['email']; ?>" <?php echo ($action_array['cc_user'] == $row['email']) ? 'selected="selected"' : ""; ?>><?php echo $row['email']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr id="tr_email_edit_time_slot">
                    <td align="left" width="16%" height="32">Time Slot</td>                                     
                    <td>
                        <select name="email_edit_time_slot">
                            <option value="0">Select Time Slot</option>
                            <?php foreach ($email_time_slot_array as $TS_id => $TS_val) {
                                ?>
                                <option value="<?php echo $TS_id; ?>" <?php echo ($action_array['time_slot'] == $TS_id) ? 'selected="selected"' : ""; ?>><?php echo $TS_val; ?></option>
                            <?php } ?>
                        </select>
                        <select name="email_edit_min">
                            <option value="0">Select Minute</option>
                            <?php foreach ($min_sec_array as $TS_id => $TS_val) {
                                ?>
                                <option value="<?php echo $TS_id; ?>" <?php echo ($action_array['min'] == $TS_id) ? 'selected="selected"' : ""; ?>><?php echo $TS_val; ?></option>
                            <?php } ?>
                        </select>
                        <select name="email_edit_sec">
                            <option value="0">Select Second</option>
                            <?php foreach ($min_sec_array as $TS_id => $TS_val) {
                                ?>
                                <option value="<?php echo $TS_id; ?>" <?php echo ($action_array['sec'] == $TS_id) ? 'selected="selected"' : ""; ?>><?php echo $TS_val; ?></option>
                            <?php } ?>
                        </select>
                        <?php //echo $time_slot_array[$action_array['time_slot']]; ?>
                    </td>
                </tr>
            <?php } ?>


            <tr>
                <td align="left" width="16%" height="32"><span>Last Processed at</span></td>
                <td align="left" colspan="2">
                    <?php
                    $added_on = $rule_array['added_on'];
                    echo date('j-M h:i A', strtotime($added_on));
                    ?> 
                </td>

            </tr>
            <tr>
                <td align="left" width="16%" height="32"><span>Next Schedule</span></td>
                <td align="left" colspan="2">
                    <?php
                    $added_on = $rule_array['added_on'];
                    echo date('j-M h:i A', strtotime($added_on));
                    ?> 
                    <input type="hidden" name="rule_id" id="rule_id" value="<?php echo $rule_array['id']; ?>"/>
                    <input type="hidden" name="data_action" id="data_action" value="<?php echo $action_array['action_name']; ?>"/>
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

