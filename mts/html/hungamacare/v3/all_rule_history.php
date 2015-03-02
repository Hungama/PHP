<?php
require_once("incs/db.php");
session_start();
$loginid = $_SESSION['loginId'];
//$serviceArray = Array('1101' => 'MTS - muZic Unlimited');
//$circle_info = array('CHN' => 'Chennai', 'GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi', 'ALL' => 'ALL');
$serviceArray = array('1101' => 'MTS - muZic Unlimited', '1111' => 'MTS - Bhakti Sagar', '1123' => 'MTS - Monsoon Dhamaka', '1110' => 'MTS - Red FM',
    '1116' => 'MTS - Voice Alerts', '1125' => 'MTS - Hasi Ke Fuhare', '1126' => 'MTS - Regional Portal', '1113' => 'MTS - MPD', '1102' => 'MTS - 54646', '1106' => 'MTS - Celebrity Chat');

$circle_info = array('GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi');
$get_process_query = "select process.id,process.count,process.added_on,process.rule_id,process.type,rule.rule_name,rule.service_id,rule.circle,process.filepath
    from master_db.tbl_new_engagement_data process join master_db.tbl_rule_engagement rule ON rule.id = process.rule_id
    where rule.added_by='" . $loginid . "'";
if ($_REQUEST['rule_id'] && $_REQUEST['rule_id'] != '0') {
    $get_process_query .=" and rule_id=" . $_REQUEST['rule_id'];
}
$get_process_query .=" order by id desc";
//echo $get_process_query;
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
                while ($processData = mysql_fetch_array($processQuery)) { //print_r($processData);
                    $rule_id = $processData['rule_id'];
                    $rule_name = $processData['rule_name'];
                    $service_id = $processData['service_id'];
                    $circle = $processData['circle'];
                    $filepath = $processData['filepath'];
//                    $rule_get_query = "SELECT rule_name,service_id,circle,added_on FROM master_db.tbl_rule_engagement where id='" . $rule_id . "'";
//                    $ruleResult = mysql_query($rule_get_query, $dbConn);
//                    $rule_data_array = mysql_fetch_array($ruleResult);
                    $action_get_query = "SELECT action_name FROM master_db.tbl_rule_engagement_action where rule_id='" . $rule_id . "'";
                    $actionResult = mysql_query($action_get_query, $dbConn);
                    $action_data_array = mysql_fetch_array($actionResult);
                    $action_name = $action_data_array['action_name'];
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
                        <TD><?php
                    //echo $processData['added_on'];
                    echo date('j-M h:i A', strtotime($processData['added_on']));
                            ?></TD>
                        <TD><?php
                    echo $processData['count'];
                    $added_on = $processData['added_on'];
                    $lastProcessDate = date('dmy', strtotime($added_on));
                    $format_process_date = date('d-m-Y', strtotime($added_on));
                            ?>
                        </TD>
                        <TD>
                            <?php
                            if ($processData['count'] == 0) {
                                echo "Download";
                            } else {
                                if ($action_name == 'sms') {
                                    $filePath = 'SMS_Rule_Execution_' . $rule_id . '_' . $format_process_date . '.zip';
                                    ?>
                                    <a href="http://119.82.69.212/kmis/services/hungamacare/MTS_NEW_ENGMNT/<?php echo $filePath ?>" target="_blank">
                                        <?php
                                    } else {
                                        $filePath = $filepath;
                                        ?>
                                        <a href="http://119.82.69.212/kmis/services/hungamacare/MTS_NEW_ENGMNT/dndcheck/<?php echo $filePath ?>" target="_blank">
                                        <?php }
                                        ?>
                                        Download
                                    <?php } ?>
                                    </TD>
                                    </TR>
                                    <?php
                                }
                                echo "</TABLE>";
                            }
                            ?>
