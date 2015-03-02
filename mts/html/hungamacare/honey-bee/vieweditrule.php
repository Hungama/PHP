<?php
require_once("incs/db.php");
include "includes/constants.php";
include "includes/language.php";
require_once("../2.0/incs/common.php");
$serviceArray = array('1101' => 'MTS - muZic Unlimited', '1111' => 'MTS - Bhakti Sagar', '1123' => 'MTS - Monsoon Dhamaka', '1110' => 'MTS - Red FM',
    '1116' => 'MTS - Voice Alerts', '1125' => 'MTS - Hasi Ke Fuhare', '1126' => 'MTSReg', '1113' => 'MTS - MPD', '1102' => 'MTS - 54646', '1106' => 'MTSFMJ');

$circle_info = array('GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi');
asort($circle_info);
$sms_cli_array = Array('1101' => '52222','1111' => '5432105','1123' => '55333','1110' => '55935','1116' => '54444',
'1125' => '54646','1126' => '51111','1113' => '54646196','1102' => '54646','1106' => '5432155');

$rule_id = $_REQUEST['rule_id'];
$selectDisplayQuery = "SELECT id,rule_name,service_id,action_base,service_base,filter_base,scenerios,dnd_scrubbing,added_on,circle,status,
    date(last_processed_time) as last_processed_date,last_processed_time FROM honeybee_sms_engagement.tbl_rule_engagement where id='" . $rule_id . "'";
$queryDisplaySel = mysql_query($selectDisplayQuery, $dbConn);
$rule_array = mysql_fetch_array($queryDisplaySel);
$selectActionQuery = "SELECT action_name,sms_sequence,time_slot,sms_cli,upload_file,email_user,cc_user FROM honeybee_sms_engagement.tbl_rule_engagement_action 
                            where rule_id='" . $rule_id . "'";
$queryActionSel = mysql_query($selectActionQuery, $dbConn);
$action_array = mysql_fetch_array($queryActionSel);
$timeDisplayArray = explode(":", $action_array['time_slot']);
//$current_date = date('Y-m-d');
$current_date = date('Y-m-d h:i A');
$last_processed_time = date('h:i A', strtotime($rule_array['last_processed_time']));

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
<td align="left" width="16%" height="32"><span>Action</span></td>
<td align="left" colspan="2">
<input type='hidden' name="action_edit_base" value="<?php echo $rule_array['action_base']; ?>"/>
<input type="radio"    value="trigger_time"  <?php echo ($rule_array['action_base'] == 'trigger_time') ? "checked" : "";  ?> disabled  />&nbsp; Trigger Time for Transactional &nbsp;&nbsp;&nbsp;
<input type="radio"    value="pre_defined_time" <?php echo ($rule_array['action_base'] == 'pre_defined_time') ? "checked" : ""; ?> disabled />&nbsp; Pre Defined Time
<input type="radio"   value="call_hang_up"  <?php echo ($rule_array['action_base'] == 'call_hang_up') ? "checked" : ""; ?> disabled />&nbsp; Call Hang up

</td></tr>
<?php if($rule_array['action_base'] == 'pre_defined_time'){ ?>

            <tr class="member1">
                <td align="left" width="16%" height="32"><span>Service Base</span></td>
                <td align="left" colspan="2">
                    <input type="radio" name="service_edit_base" value="active" <?php echo ($rule_array['service_base'] == 'active') ? "checked" : ""; ?>  >&nbsp; Active &nbsp;&nbsp;&nbsp;
                    <input type="radio"  name="service_edit_base" value="pending" <?php echo ($rule_array['service_base'] == 'pending') ? "checked" : ""; ?>>&nbsp; Pending &nbsp;&nbsp;&nbsp;
                    <input type="radio"  name="service_edit_base" value="both" <?php echo ($rule_array['service_base'] == 'both') ? "checked" : ""; ?>/>&nbsp; Both
                    <input type="radio"  name="service_edit_base" value="non live" <?php echo ($rule_array['service_base'] == 'non live') ? "checked" : ""; ?>/>&nbsp; Non Live
                </td>
            </tr>
            <tr class="member1">
                <td align="left" width="16%" height="32"><span>Filter Base</span></td>
                <td align="left" colspan="2">
                    <select name="filter_edit_base" data-width="30%" onchange="setEditScenarios(this.value)">
                        <option value="0">Select Filter Base</option>
                        <?php
                        $selectQuery = "SELECT Fid,description FROM honeybee_sms_engagement.tbl_filter_base WHERE status=1 order by description";
                        $querySel = mysql_query($selectQuery, $dbConn);
                        while ($row = mysql_fetch_array($querySel)) {
                            ?>
                            <option value="<?php echo $row['Fid']; ?>" <?php echo ($rule_array['filter_base'] == $row['Fid']) ? 'selected="selected"' : ""; ?>><?php echo $row['description']; ?> </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr class="member1">
                <td align="left" width="16%" height="32"><span>Scenarios</span></td>
                <td align="left" colspan="2">
                    <?php
                    $selectSceneriosQuery = "SELECT description FROM honeybee_sms_engagement.tbl_filter_base_scenarios where Scid=" . $rule_array['scenerios'] . "";
                    $querySceneriosSel = mysql_query($selectSceneriosQuery, $dbConn);
                    $Scenerios = mysql_fetch_row($querySceneriosSel);
                    ?> 
                    <select name="edit_scenarios" data-width="70%">
                        <option value="<?php echo $rule_array['scenerios']; ?>"><?php echo $Scenerios[0]; ?></option>
                    </select>

                </td>
            </tr>
			<?php } ?>
         
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
       
        
                <tr id="tr_edit_sms_sequence">
                    <td align="left" width="16%" height="32"><span>SMS Sequence</span></td>
                    <td>
                        <input type="radio"  name="sms_edit_sequence" value="random" <?php echo ($action_array['sms_sequence'] == 'random') ? "checked" : ""; ?> />&nbsp; Random &nbsp;&nbsp;&nbsp;
                        <input type="radio"  name="sms_edit_sequence" value="fixed" <?php echo ($action_array['sms_sequence'] == 'fixed') ? "checked" : ""; ?>/>&nbsp; Fixed &nbsp;&nbsp;&nbsp;
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


<?php  if ($rule_array['action_base'] == 'trigger_time'){
$time=explode(":",$action_array['time_slot']);
?>

<tr >
<td align="left" width="16%" height="32">Transactional Time</td>                                     
<td>
<select name="hours" id="hours" >
<option value="<?php echo $time[0]; ?>" selected><?php echo $time[0]; ?></option>
<option value="00">Hour</option>
<option value="00">00</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
</select>
<select name="minutes" id="minutes">
<option value="<?php echo $time[1]; ?>" selected><?php echo $time[1]; ?></option>
<option value="00">minute</option>
<!--option value="00">00</option-->
<option value="05">05</option>
<option value="10">10</option>
<option value="15">15</option>
<option value="20">20</option>
<option value="25">25</option>
<option value="30">30</option>
<option value="35">35</option>
<option value="40">40</option>
<option value="45">45</option>
<option value="50">50</option>
<option value="55">55</option>
<!--option value="60">60</option-->
</select>

</div>
</td>
</tr>
<?php } else if($rule_array['action_base'] == 'pre_defined_time'){ ?>
            <tr>
                <td align="left" width="16%" height="32">Time Slot</td>                                     
                <td>
                    <div class="input-append bootstrap-timepicker">
                        <input  name="edit_time_slot" id="edit_time_slot" class="input-small" type="text" value="<?php echo $action_array['time_slot']; ?>"/>
                        <span class="add-on"><i class="icon-time" style="margin-top:-5px"></i></span>
                    </div>
                </td>
            </tr>
			<?php } ?>
            <tr>
                <td align="left" width="16%" height="32"><span>Last Processed at</span></td>
                <td align="left" colspan="2">
                    <?php
                    $get_rule_query = "SELECT added_on FROM honeybee_sms_engagement.tbl_new_engagement_data where rule_id='" . $rule_id . "' order by id desc limit 1";
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
                            //$next_date = date('Ymd') + 1;
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
                    <input type="hidden" name="last_processed_date" id="last_processed_date" value="<?php echo $rule_array['last_processed_date']; ?>"/>
                    <input type="hidden" name="last_processed_time" id="last_processed_time" value="<?php echo $last_processed_time; ?>"/>
                    <input type="hidden" name="current_date" id="current_date" value="<?php echo $current_date; ?>"/>
                </td>

            </tr>
			   <tr>
                <td align="left" width="16%" height="32">DND scrubbing</td>
                <td>
                    <input type="radio"  name="edit_dnd_scrubbing" value="1" <?php echo ($rule_array['dnd_scrubbing'] == '1') ? "checked" : ""; ?>/>&nbsp; Yes &nbsp;&nbsp;&nbsp;
                    <input type="radio"  name="edit_dnd_scrubbing" value="0" <?php echo ($rule_array['dnd_scrubbing'] == '0') ? "checked" : ""; ?>/>&nbsp; No &nbsp;&nbsp;&nbsp;
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
        <?php
        //echo CONST_JS;
        //echo EDITINPLACE_JS;
        ?>
<script type="text/javascript">
    $('#edit_time_slot').timepicker();
    $("select").selectpicker({style: 'btn btn-primary', menuStyle: 'dropdown-inverse'});
	
/* //radio button selection script
$("input[name='action_edit_base']").change(function () {
var selection=$(this).val();

if (selection=='trigger_time')
{

$("tr.member1").css({
  display: "none",
  visibility: "hidden"
});
$("tr.member2").css({
 display: "",
  visibility: "visible"
});
}
else if(selection=='call_hang_up')
{
$("tr.member1").css({
  display: "none",
  visibility: "hidden"
});
$("tr.member2").css({
  display: "none",
  visibility: "hidden"
});
}
else if(selection=='pre_defined_time'){
$("tr.member1").css({
 display: "",
  visibility: "visible"
});
$("tr.member2").css({
  display: "none",
  visibility: "hidden"
});


}
});
//radio button selection end */

<?php if($rule_array['action_base'] == 'trigger_time'  ||    $rule_array['action_base'] =='call_hang_up'){ ?>
$("tr.member1").css({
  display: "none",
  visibility: "hidden"
});
<?php } ?>
	
	
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
</script>