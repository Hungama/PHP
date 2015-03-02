<?php
session_start();
require_once("incs/db.php");
require_once("language.php");
require_once("base.php");
$id = $_GET['id'];
$Result = mysql_query("select id,status,auto_rew_deact,service_id,tnb_days,tnb_mins,pre_sms,submode,circle,reqs_time,added_by from MTS_IVR.tbl_new_tnb_whitelisted_config where id='" . $id . "'", $dbConn);
$details = mysql_fetch_array($Result);
$authtypevaluearray = array('deact' => 'Auto deactivation', 'renew' => 'Auto renewal');
$circle_info = array('GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi');
foreach ($serviceArray as $key => $value) {
    if ($value == $details['service_id']) {
        $servicename = $key;
        break;
    }
}
?>
<TABLE class="table table-condensed table-bordered">
    <thead>
        <TR height="30">
            <th align="left"><?php echo 'ID'; ?></th>
            <th align="left"><?php echo 'Type'; ?></th>
            <th align="left"><?php echo 'Uploaded on'; ?></th>
            <th align="left"><?php echo 'Service'; ?></th>
            <th align="left"><?php echo 'Days'; ?></th>
            <th align="left"><?php echo 'Minutes'; ?></th>
            <th align="left"><?php echo 'Pre Renewal SMS'; ?></th>
            <th align="left"><?php echo 'Mode'; ?></th>
            <th align="left"><?php echo 'Circle'; ?></th>
            <th align="left"><?php echo 'Action'; ?></th>
        </TR>
    </thead>
    <TR height="30">
        <TD><?php echo $details['id']; ?></TD>
        <TD><?php echo $authtypevaluearray[$details['auto_rew_deact']]; ?></TD>
        <TD><?php
if (!empty($details['reqs_time'])) {
    echo date('j-M \'y g:i a', strtotime($details['reqs_time']));
}
?></TD>
        <TD><?php echo $Service_DESC[$servicename]['Name']; ?></TD>
        <TD>
            <input type="text" name="edit_tnb_days" id="edit_tnb_days" value="<?php echo $details['tnb_days']; ?>"/>
        </TD>
        <TD><?php
            if ($details['tnb_mins']) {
                $tnb_mins = $details['tnb_mins'];
            } else {
                $tnb_mins = 'NA';
            }
?>
            <input type="text" name="edit_tnb_mins" id="edit_tnb_mins" value="<?php echo $tnb_mins; ?>"/>
        </TD>
        <TD>
            <input type="text" name="edit_pre_sms" id="edit_pre_sms" value="<?php echo $details['pre_sms']; ?>"/>
        </TD>
        <TD><?php echo $details['submode']; ?></TD>
        <TD><?php echo $circle_info[$details['circle']]; ?></TD>
        <TD>

            <button class="btn btn-danger" style="float:right"  onclick="javascript:submitEditDeatil('<?php echo $id; ?>','<?php echo 'tryandbuy'; ?>')">Submit</button>
        </TD>

    </TR>	
    <?php
    echo "</TABLE>";