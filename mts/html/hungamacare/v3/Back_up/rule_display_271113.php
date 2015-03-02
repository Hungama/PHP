<?php
session_start();

require_once("incs/db.php");

$serviceArray = Array('1101' => 'MTS - muZic Unlimited');
$time_slot_array = array('1' => '01: 00 AM', '2' => '02: 00 AM', '3' => '03: 00 AM', '4' => '04: 00 AM', '5' => '05: 00 AM',
    '6' => '06: 00 AM', '7' => '07: 00 AM', '8' => '08: 00 AM', '9' => '09: 00 AM', '10' => '10: 00 AM', '11' => '11: 00 AM', '12' => '12: 00 AM',
    '13' => '01: 00 PM', '14' => '02: 00 PM', '15' => '03: 00 PM', '16' => '04: 00 PM', '17' => '05: 00 PM', '18' => '06: 00 PM', '19' => '07: 00 PM',
    '20' => '08: 00 PM', '21' => '09: 00 PM', '22' => '10: 00 PM', '23' => '11: 00 PM', '24' => '12: 00 PM');

$selectIDQuery = "SELECT max(id) FROM master_db.tbl_rule_engagement";
$queryIDSel = mysql_query($selectIDQuery, $dbConn);
$rule_id = mysql_fetch_row($queryIDSel);
$selectDisplayQuery = "SELECT id,rule_name,service_id,service_base,filter_base,scenerios,dnd_scrubbing
                                FROM master_db.tbl_rule_engagement where id='$rule_id[0]'";
$queryDisplaySel = mysql_query($selectDisplayQuery, $dbConn);
$rule_array = mysql_fetch_array($queryDisplaySel);
$selectActionQuery = "SELECT action_name,sms_sequence,time_slot FROM master_db.tbl_rule_engagement_action 
                            where rule_id='$rule_id[0]'";
$queryActionSel = mysql_query($selectActionQuery, $dbConn);
$action_array = mysql_fetch_array($queryActionSel);
?>
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
        <td align="left" width="16%" height="32"><span>Service Name</span></td>
        <td align="left" colspan="2">
            <?php echo $serviceArray[$rule_array['service_id']]; ?> 
        </td>
    </tr>
    <tr>
        <td align="left" width="16%" height="32"><span>Service Base</span></td>
        <td align="left" colspan="2">
            <?php echo $rule_array['service_base']; ?> 
        </td>
    </tr>
    <tr>
        <td align="left" width="16%" height="32"><span>Filter Base</span></td>
        <td align="left" colspan="2">
            <?php
            $selectFilterQuery = "SELECT description FROM master_db.tbl_filter_base where Fid=" . $rule_array['filter_base'] . "";
            $queryFilterSel = mysql_query($selectFilterQuery, $dbConn);
            $Filter = mysql_fetch_row($queryFilterSel);
            echo $Filter[0];
            ?> 
        </td>
    </tr>
    <tr>
        <td align="left" width="16%" height="32"><span>Scenarios</span></td>
        <td align="left" colspan="2">

            <?php
            $selectSceneriosQuery = "SELECT description FROM master_db.tbl_filter_base_scenarios where Fid=" . $rule_array['filter_base'] . "";
            $querySceneriosSel = mysql_query($selectSceneriosQuery, $dbConn);
            $Scenerios = mysql_fetch_row($querySceneriosSel);
            echo $Scenerios[0];
            ?> 
        </td>
    </tr>
    <tr>
        <td align="left" width="16%" height="32">DND scrubbing</td>
        <td>
            <?php
            if ($rule_array['dnd_scrubbing'] == 1) {
                echo "Yes";
            } else {
                echo "No";
            }
            ?> 
        </td>
    </tr>
    <tr>
        <td align="left" width="16%" height="32">Action</td>                                    
        <td>
            <?php echo $action_array['action_name']; ?> 
        </td>
    </tr>
    <?php if ($action_array['action_name'] == 'sms') { ?>
        <tr>
            <td align="left" width="16%" height="32">SMS Sequence</td>
            <td>
                <?php echo $action_array['sms_sequence']; ?> 
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td align="left" width="16%" height="32">Time Slot</td>                                     
        <td>
            <?php echo $time_slot_array[$action_array['time_slot']]; ?>
        </td>
    </tr>
</table>
<?php mysql_close($dbConn);
?>
