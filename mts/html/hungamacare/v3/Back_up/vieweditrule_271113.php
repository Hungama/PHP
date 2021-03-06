<?php
require_once("incs/db.php");
$serviceArray = Array('1101' => 'MTS - muZic Unlimited');
$circle_info = array('CHN' => 'Chennai', 'GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi', 'ALL' => 'ALL');
$time_slot_array = array('1' => '01: 00 AM', '2' => '02: 00 AM', '3' => '03: 00 AM', '4' => '04: 00 AM', '5' => '05: 00 AM',
    '6' => '06: 00 AM', '7' => '07: 00 AM', '8' => '08: 00 AM', '9' => '09: 00 AM', '10' => '10: 00 AM', '11' => '11: 00 AM', '12' => '12: 00 AM',
    '13' => '01: 00 PM', '14' => '02: 00 PM', '15' => '03: 00 PM', '16' => '04: 00 PM', '17' => '05: 00 PM', '18' => '06: 00 PM', '19' => '07: 00 PM',
    '20' => '08: 00 PM', '21' => '09: 00 PM', '22' => '10: 00 PM', '23' => '11: 00 PM', '24' => '12: 00 PM');
//echo "<pre>";print_r($_REQUEST);
//          $selectIDQuery = "SELECT max(id) FROM master_db.tbl_rule_engagement";
//$queryIDSel = mysql_query($selectIDQuery, $dbConn);
//$rule_id = mysql_fetch_row($queryIDSel);
$rule_id = $_REQUEST['rule_id'];
$selectDisplayQuery = "SELECT id,rule_name,service_id,service_base,filter_base,scenerios,dnd_scrubbing,added_on,circle
                                FROM master_db.tbl_rule_engagement where id='" . $rule_id . "'";
$queryDisplaySel = mysql_query($selectDisplayQuery, $dbConn);
$rule_array = mysql_fetch_array($queryDisplaySel);
$selectActionQuery = "SELECT action_name,sms_sequence,time_slot,sms_cli,upload_file,email_user,cc_user FROM master_db.tbl_rule_engagement_action 
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
                    <?php  $added_on = $rule_array['added_on']; 
                    //echo $mytime = date("dmy", strtotime($added_on));
                    echo date('j-M h:i A' , strtotime($added_on));//l jS \of F Y h:i:s A
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
                    <?php //echo $rule_array['service_base'];  ?> 
                </td>
            </tr>
            <tr>
                <td align="left" width="16%" height="32"><span>Filter Base</span></td>
                <td align="left" colspan="2">
                    <?php
//                    $selectFilterQuery = "SELECT description FROM master_db.tbl_filter_base where Fid=" . $rule_array['filter_base'] . "";
//                    $queryFilterSel = mysql_query($selectFilterQuery, $dbConn);
//                    $Filter = mysql_fetch_row($queryFilterSel);
                    //echo $Filter[0];
                    ?> 
                    <select name="filter_edit_base" id="filter_edit_base" data-width="auto" onchange="setEditScenarios(this.value)">
                        <option value="0">Select Filter Base</option>
                        <?php
                        $selectQuery = "SELECT Fid,description FROM master_db.tbl_filter_base WHERE status=1";
                        $querySel = mysql_query($selectQuery, $dbConn);
                        while ($row = mysql_fetch_array($querySel)) {
                            // echo $row['Fid']."-------".$rule_array['filter_base'];//die('here');
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
                    <?php // echo $action_array['action_name']; ?>
                    <input type="radio"  name="action_edit_name" value="sms" checked="checked"  onchange="handleEditClick(this.value)" <?php echo ($action_array['action_name'] == 'sms') ? "checked" : ""; ?>/>&nbsp; SMS &nbsp;&nbsp;&nbsp;
                    <input type="radio"  name="action_edit_name" value="email"  onchange="handleEditClick(this.value)" <?php echo ($action_array['action_name'] == 'email') ? "checked" : ""; ?>/>&nbsp; Email &nbsp;&nbsp;&nbsp;

                </td>

            </tr>

            <tr id="tr_edit_sms_sequence" style="display: none;">
                <td align="left" width="16%" height="32"><span>SMS Sequence</span></td>
                <td>
                    <input type="radio" id="sms_edit_sequence_random" name="sms_edit_sequence" value="random" <?php echo ($action_array['sms_sequence'] == 'random') ? "checked" : ""; ?> />&nbsp; Random &nbsp;&nbsp;&nbsp;
                    <input type="radio" id="sms_edit_sequence_fixed" name="sms_edit_sequence" value="fixed" <?php echo ($action_array['sms_sequence'] == 'fixed') ? "checked" : ""; ?>/>&nbsp; Fixed &nbsp;&nbsp;&nbsp;
                </td>
            </tr>
            <tr id="tr_edit_sms_cli" style="display: none;">
                <td align="left" width="16%" height="32"><span>SMS CLI</span></td>
                <td align="left" colspan="2">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="sms_edit_cli" value="<?php echo $action_array['sms_cli']; ?>" placeholder="SMS Cli" class="form-control" />
                            </div>          
                        </div>
                    </div>

                </td>
            </tr>
            <tr id="tr_edit_upload_file" style="display: none;">
                <td align="left" width="16%" height="32"><span>Upload File</span></td>
                <td align="left"> 
                    <input type="file" name="upload_edit_file" value="<?php echo $action_array['upload_file']; ?>"/>
                    <span id="display_file_name"><?php echo $action_array['upload_file'];?></span>
                </td>
            </tr>
            <tr id="tr_edit_email_user" style="display: none;">
                <td align="left" width="16%" height="32"><span>Email User</span></td>
                <td align="left" colspan="2">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="email_edit_user" value="<?php echo $action_array['email_user']; ?>" placeholder="Email" class="form-control" />
                            </div>          
                        </div>
                    </div>
                </td>
            </tr>
            <tr id="tr_edit_add_cc" style="display: none;">
                <td align="left" width="16%" height="32"><span>Add CC</span></td>
                <td align="left">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="add_edit_cc" value="<?php echo $action_array['cc_user']; ?>" placeholder="CC" class="form-control" />
                            </div>          
                        </div>
                    </div>
                    <input type="hidden" name="rule_id" id="rule_id" value="<?php echo $rule_array['id']; ?>"/>
                </td>
            </tr>
            <tr>
                <td align="left" width="16%" height="32">Time Slot</td>                                     
                <td>
                    <?php echo $time_slot_array[$action_array['time_slot']]; ?>
                </td>
            </tr>
            <tr>
                <td align="left" width="16%" height="32"><span>Last Processed at</span></td>
                <td align="left" colspan="2">
                    <?php $added_on = $rule_array['added_on'];
                    echo date('j-M h:i A' , strtotime($added_on));
                    ?> 
                </td>

            </tr>
            <tr>
                <td align="left" width="16%" height="32"><span>Next Schedule</span></td>
                <td align="left" colspan="2">
                    <?php $added_on = $rule_array['added_on'];
                    echo date('j-M h:i A' , strtotime($added_on)); ?> 
                </td>

            </tr>
        </table>
    </form>
</div>
<div class="modal-footer">
    <!--    <button type="button" class="btn btn-default" data-dismiss="modal">Edit Rule</button>-->
    <button type="button" class="btn btn-primary" onclick="SubmitEditDeatil('<?php echo $rule_array['id']; ?>')">Edit Rule</button>
    <button type="button" class="btn btn-primary" onclick="showDeleteConfirm('<?php echo $rule_array['id']; ?>')">Delete Rule</button>
</div>

