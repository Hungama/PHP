<?php
require_once("incs/db.php");
$serviceArray = Array('1101' => 'MTS - muZic Unlimited');
$circle_info = array('CHN' => 'Chennai', 'GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi', 'ALL' => 'ALL');


$get_query = "SELECT rule.id,rule.rule_name,rule.last_processed,rule.service_id,rule.circle,rule.scenerios,action.action_name
    FROM master_db.tbl_rule_engagement rule JOIN master_db.tbl_rule_engagement_action action
         ON rule.id = action.rule_id";
if ($_REQUEST['rule_id'] && $_REQUEST['rule_id'] != '0') {
    $get_query .=" where rule.id=" . $_REQUEST['rule_id'];
}
$query = mysql_query($get_query, $dbConn);
$numofrows = mysql_num_rows($query);
$get_rule_query = "SELECT distinct id,rule_name  FROM master_db.tbl_rule_engagement";
$rule_query = mysql_query($get_rule_query, $dbConn);
$numofRulerows = mysql_num_rows($rule_query);
if ($numofrows == 0) {
    ?>
    <div class="row">
        <div class="col-md-12">
            <div width="85%" align="left" class="txt">
                <div class="alert alert-block">
                    <h4>Ooops!</h4>Hey,  we couldn't seem to find any record.
                </div>
            </div>
            <?php
        } else {
            ?>
            <div style="position:absolute;right:50px;top:-1px">
                Filter <select name="select_rule" data-width="auto" id="select_rule" onchange="setRuleData(this.value)">
                    <option value="0">Select Rule</option>
                    <?php
                    while ($ruledata = mysql_fetch_array($rule_query)) {
                        $rule_id = $ruledata['id'];
                        $rule_name = $ruledata['rule_name'];
                        ?>
                        <option value="<?php echo $rule_id; ?>"><?php echo $rule_name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <TABLE class="table table-condensed table-bordered">
                <thead>

                    <TR height="30">
                        <th align="left"><?php echo 'Rule ID'; ?></th>
                        <th align="left"><?php echo 'Rule Name'; ?></th>
                        <th align="left"><?php echo 'Transaction ID'; ?></th>
                        <th align="left"><?php echo 'Service Name'; ?></th>
                        <th align="left"><?php echo 'Action'; ?></th>
                        <th align="left"><?php echo 'Circle'; ?></th>
                        <th align="left"><?php echo 'Processed at'; ?></th>
                        <th align="left"><?php echo 'MSISDN Count'; ?></th>
                        <th align="left"><?php echo 'Output File'; ?></th>
                    </TR>
                </thead>
                <?php
                while ($summarydata = mysql_fetch_array($query)) {
                    $service_id = $summarydata['service_id'];
                    $type = $summarydata['scenerios'];
                    $lastProcessDate = $summarydata['last_processed'];
                    ?>
                    <TR height="30">
                        <TD><?php echo $summarydata['id']; ?></TD>
                        <TD><?php echo $summarydata['rule_name']; ?></TD>
                        <TD></TD>
                        <TD><?php echo $serviceArray[$summarydata['service_id']]; ?></TD>
                        <TD><?php echo $summarydata['action_name']; ?></TD>
                        <TD><?php echo $circle_info[$summarydata['circle']]; ?></TD>
                        <TD><?php echo $summarydata['last_processed']; ?></TD>
                        <TD><?php
            $get_process_query = "select count from master_db.tbl_new_engagement_data nolock 
                        where service_id='$service_id' and type='$type' and date(added_on)=date('" . $lastProcessDate . "')";
            $processQuery = mysql_query($get_process_query, $dbConn);
            $processData = mysql_fetch_array($processQuery);
            echo $processData['count'];
                    ?></TD>
                        <TD>
                            <a href="xls_new_engagement.php?service_id=<?php echo $summarydata['service_id'] ?>&type=<?php echo $type ?>&added_on=<?php echo $lastProcessDate ?>&rule_id=<?php echo $summarydata['id'] ?>">
                                Download
                        </TD>
                    </TR>
                    <?php
                }
                echo "</TABLE>";
            }
            ?>
