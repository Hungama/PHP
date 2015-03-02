<?php
require_once("../2.0/incs/db.php");
session_start();
$loginid = $_SESSION['loginId'];
$serviceArray = array('1515' => 'Airtel - Sarnam');

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra',
    'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa',
    'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala',
    'HPD' => 'Himachal Pradesh');
$get_process_query = "select process.id,process.count,process.added_on,process.rule_id,process.type,rule.rule_name,rule.service_id,rule.circle
    from master_db.tbl_new_engagement_data process join master_db.tbl_rule_engagement rule ON rule.id = process.rule_id
    where rule.added_by='" . $loginid . "'";
if ($_REQUEST['rule_id'] && $_REQUEST['rule_id'] != '0') {
    $get_process_query .=" and rule_id=" . $_REQUEST['rule_id'];
}
$get_process_query .=" order by id desc";
$processQuery = mysql_query($get_process_query, $dbConn);
$numofprocessrows = mysql_num_rows($processQuery);

$get_rule_query = "SELECT distinct process.rule_id,rule.rule_name FROM master_db.tbl_new_engagement_data process join master_db.tbl_rule_engagement rule 
    ON rule.id = process.rule_id where rule.added_by='" . $loginid . "'";
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
                        $rule_id = $ruledata['rule_id'];
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
                    $rule_name = $processData['rule_name'];
                    $service_id = $processData['service_id'];
                    $circle = $processData['circle'];
                    $action_get_query = "SELECT action_name FROM master_db.tbl_rule_engagement_action where rule_id='" . $rule_id . "'";
                    $actionResult = mysql_query($action_get_query, $dbConn);
                    $action_data_array = mysql_fetch_array($actionResult);
                    ?>
                    <TR height = "30">
                        <TD><?php echo $rule_id; ?></TD>
                        <TD><?php echo $rule_name; ?></TD>
                        <TD><?php echo $processData['id']; ?></TD>
                        <TD><?php echo $serviceArray[$service_id]; ?></TD>
                        <TD><?php echo $action_data_array['action_name']; ?></TD>
                        <TD>
                            <?php
                            $circleDisplay = explode(",", $circle);
                            $circle_str = '';
                            foreach ($circleDisplay as $key => $value) {
                                $circle_str .= "$circle_info[$value],";
                            }
                            $circle_str = substr($circle_str, 0, -1);
                            echo $circle_str;
                            ?>
                        </TD>
                        <TD><?php echo date('j-M h:i A', strtotime($processData['added_on'])); ?></TD>
                        <TD><?php
                    echo $processData['count'];
                    $added_on = $processData['added_on'];
                    $lastProcessDate = date('dmy', strtotime($added_on));
                            ?>
                        </TD>
                        <TD>
                            <?php
                            if ($processData['count'] == 0) {
                                echo "Download";
                            } else {
                                if ($action_data_array['action_name'] == 'sms') {
                                    ?>
                                    <a href="xls_new_engagement.php?service_id=<?php echo $service_id ?>&type=<?php echo $processData['type'] ?>&added_on=<?php echo $lastProcessDate ?>&rule_id=<?php echo $rule_id ?>">
                                        <?
                                    } else {
                                        $format_process_date = date('d-m-Y', strtotime($added_on));
                                        ?>
                                        <a href="http://119.82.69.212/kmis/services/hungamacare/MTS_NEW_ENGMNT/dndcheck/<?php echo $rule_id . '_' . $format_process_date . '.csv' ?>" target="_blank">
                                        <?php } ?>
                                        Download
                                    <?php } ?>
                                    </TD>
                                    </TR>
                                    <?php
                                }
                                echo "</TABLE>";
                            }
                            ?>
