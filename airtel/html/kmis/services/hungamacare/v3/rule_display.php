<?php
session_start();

require_once("../2.0/incs/db.php");
include "base.php";
//$serviceArray = array('1515' => 'Airtel - Sarnam');
$serviceArray = array('1515' => 'AirtelDevo', '1513' => 'AirtelMND', '1517' => 'AirtelSE', '1502' => 'Airtel54646', 'AirtelMNDKK' => 'AirtelMNDKK',
    '1511' => 'AirtelGL', '1518' => 'AirtelComedy', '1501' => 'AirtelEU');

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra',
    'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa',
    'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala',
    'HPD' => 'Himachal Pradesh');

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
            <?php echo $Service_DESC[$serviceArray[$rule_array['service_id']]]['Name']; ?> 
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
            $selectSceneriosQuery = "SELECT description FROM master_db.tbl_filter_base_scenarios where Scid=" . $rule_array['scenerios'] . "";
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
            <?php echo $action_array['time_slot']; ?>
        </td>
    </tr>
</table>
<?php mysql_close($dbConn);
?>
