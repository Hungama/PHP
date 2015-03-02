<?php
require_once("incs/db.php");
$serviceArray = Array('1101' => 'MTS - muZic Unlimited');
$circle_info = array('CHN' => 'Chennai', 'GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi', 'ALL' => 'ALL');
$get_process_query = "select id,count,added_on,rule_id,type from master_db.tbl_new_engagement_data nolock order by id desc";
if ($_REQUEST['rule_id'] && $_REQUEST['rule_id'] != '0') {
    $get_process_query .=" where rule_id=" . $_REQUEST['rule_id'];
}
$processQuery = mysql_query($get_process_query, $dbConn);
$numofprocessrows = mysql_num_rows($processQuery);

$get_rule_query = "SELECT distinct process.rule_id,rule.rule_name FROM master_db.tbl_new_engagement_data process join master_db.tbl_rule_engagement rule 
    ON rule.id = process.rule_id";
if ($_REQUEST['rule_id'] && $_REQUEST['rule_id'] != '0') {
    $get_rule_query .=" where rule.id=" . $_REQUEST['rule_id'];
}
$rule_query = mysql_query($get_rule_query, $dbConn);
if ($numofprocessrows == 0) {
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
                while ($processData = mysql_fetch_array($processQuery)) {
                    $rule_id = $processData['rule_id'];
                    $rule_get_query = "SELECT rule_name,service_id,circle,added_on FROM master_db.tbl_rule_engagement where id='" . $rule_id . "'";
                    $ruleResult = mysql_query($rule_get_query, $dbConn);
                    $rule_data_array = mysql_fetch_array($ruleResult);
                    $action_get_query = "SELECT action_name FROM master_db.tbl_rule_engagement_action where rule_id='" . $rule_id . "'";
                    $actionResult = mysql_query($action_get_query, $dbConn);
                    $action_data_array = mysql_fetch_array($actionResult);
                    ?>
                    <TR height = "30">
                        <TD><?php echo $rule_id; ?></TD>
                        <TD><?php echo $rule_data_array['rule_name']; ?></TD>
                        <TD><?php echo $processData['id']; ?></TD>
                        <TD><?php echo $serviceArray[$rule_data_array['service_id']]; ?></TD>
                        <TD><?php echo $action_data_array['action_name']; ?></TD>
                        <TD><?php echo $circle_info[$rule_data_array['circle']]; ?></TD>
                        <TD><?php echo $processData['added_on']; ?></TD>
                        <TD><?php
            echo $processData['count'];
            $added_on = $processData['added_on'];
            $lastProcessDate = date('dmy', strtotime($added_on));
                    ?>
                        </TD>
                        <TD>
                            <a href="xls_new_engagement.php?service_id=<?php echo $rule_data_array['service_id'] ?>&type=<?php echo $processData['type'] ?>&added_on=<?php echo $lastProcessDate ?>&rule_id=<?php echo $rule_id ?>">
                                Download
                        </TD>
                    </TR>
                    <?php
                }
                echo "</TABLE>";
            }
            ?>
