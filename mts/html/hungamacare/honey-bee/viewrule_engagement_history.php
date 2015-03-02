<?php
session_start();
$loginid = $_SESSION['loginId'];
require_once("incs/db.php");

if (isset($_REQUEST['act']) && $_REQUEST['act'] != '') {
    echo $_REQUEST['act'];
    if ($_REQUEST['act'] == 'pause') {
        echo $updatePauseQuery = "update honeybee_sms_engagement.tbl_rule_engagement set status=5 WHERE id='" . $_REQUEST['id'] . "'";
        mysql_query($updatePauseQuery, $dbConn);
    } elseif ($_REQUEST['act'] == 'resume') {
        echo $updatePauseQuery = "update honeybee_sms_engagement.tbl_rule_engagement set status=1 WHERE id='" . $_REQUEST['id'] . "'";
        mysql_query($updatePauseQuery, $dbConn);
    } elseif ($_REQUEST['act'] == 'del') {
        $updatePauseQuery = "update honeybee_sms_engagement.tbl_rule_engagement set status=10 WHERE id='" . $_REQUEST['id'] . "'";
        mysql_query($updatePauseQuery, $dbConn);
		//delete message also for the same rule
		$updateSmSQuery = "update honeybee_sms_engagement.tbl_new_sms_engagement set status=5 WHERE rule_id='" . $_REQUEST['id'] . "' and status!=0 ";
        mysql_query($updateSmSQuery, $dbConn);
		
    }
}

$serviceArray = array('1101' => 'MTSMU', '1111' => 'MTSDevo', '1123' => 'MTSContest', '1110' => 'REDFMMTS', '1116' => 'MTSVA', '1125' => 'MTSJokes',
    '1126' => 'MTSReg', '1113' => 'MTSMND', '1102' => 'MTS54646', '1106' => 'MTSFMJ');

$get_query = "select id,rule_name,service_id,action_base,added_on,status from ";
$get_query .=" honeybee_sms_engagement.tbl_rule_engagement nolock where status in(1,5) and added_by ='" . $loginid . "' order by id desc";
//echo $get_query;
$query = mysql_query($get_query, $dbConn);
$numofrows = mysql_num_rows($query);
if ($numofrows == 0) {
    ?>
    <div width="85%" align="left" class="txt">
        <div class="alert alert-block">
            <h4>Ooops!</h4>Hey,  we couldn't seem to find any record.
        </div>
    </div>
    <?php
} else {
    ?>
    <center><div width="85%" align="left" class="txt">
            <div class="alert alert" >

                <a href="javascript:void(0);viewUploadhistory('me');" id="Refresh"><i class="fui-eye"></i></a>             

                <?php
                //$limit = 20;
                echo " Displaying All records. <b>Click on Rule id to view all messages for that rule.</b>";
                ?>
                </i>
            </div></div></center>
    <TABLE class="table table-condensed table-bordered">
        <thead>
            <TR height="30">
                <th align="left"></th>
                <th align="left"><?php echo 'Rule ID'; ?></th>
                <th align="left"><?php echo 'Rule Name'; ?></th>
				<!--th align="left"><?php echo 'Transactional Id'; ?></th>
				<th align="left"><?php echo 'Service Name'; ?></th>
				<th align="left"><?php echo 'Action'; ?></th-->
                <th align="left"><?php echo 'Added On'; ?></th>
                <th align="left"><?php echo 'Last Processed at'; ?></th>
                <th align="left"><?php echo 'Next Schedule'; ?></th>
                <th align="left"><?php echo 'Manage Rule'; ?></th>
            </TR>
        </thead>
        <?php
        while ($summarydata = mysql_fetch_array($query)) {
            ?>
            <TR height="30">
                <TD>
                    <?php
                    if ($summarydata['status'] == 1) {
                        ?>
                        <a href="javascript:void(0)" onclick="showPauseResumeConfirm('<?php echo $summarydata['id']; ?>','pause')" id="pause_id"><i class="fui-pause"></i></a>
            <!--                        <button class="btn btn-primary btn-lg" onclick="showPauseResumeConfirm('<?php echo $summarydata['id']; ?>','pause')">
                                Pause
                            </button>-->
                    <?php } else { ?>
                        <a href="javascript:void(0)" onclick="showPauseResumeConfirm('<?php echo $summarydata['id']; ?>','resume')" id="resume_id"><i class="fui-play"></i></a>
            <!--                        <button class="btn btn-primary btn-lg" onclick="showPauseResumeConfirm('<?php echo $summarydata['id']; ?>','resume')">
                               Resume
                           </button>           -->

                    <?php } ?>
                </TD>
                <TD><a href="javascript:void(0)" onclick="showViewmessage('<?php echo $summarydata['id']; ?>')" id="edit_view_id" data-toggle="modal" data-target="#myModal"><?php echo $summarydata['id']; ?></a></TD>
                <TD><?php echo $summarydata['rule_name']; ?></TD>
				<!--TD><?php echo '------'; ?></TD>
				<TD><?php echo $serviceArray[$summarydata['service_id']]; ?></TD>
				<TD><?php echo 'sms_'.$summarydata['action_base']; ?></TD-->
				
				
                <TD><?php
            $added_on = $summarydata['added_on'];
            echo date('j-M h:i A', strtotime($added_on));
                    ?>
                </TD>
                <TD>
                    <?php
                    $get_rule_query = "SELECT added_on FROM honeybee_sms_engagement.tbl_new_engagement_data where rule_id='" . $summarydata['id'] . "' order by id desc limit 1";
                    $rule_query = mysql_query($get_rule_query, $dbConn);
                    $details = mysql_fetch_array($rule_query);
                    if ($details['added_on'] != '') {
                        $added_on = $details['added_on'];
                        echo date('j-M h:i A', strtotime($added_on));
                    } else {
                        echo "-";
                    }
                    ?>
                </TD>
                <TD><?php
            if ($summarydata['status'] == 1) {
                $timDisplay_get_query = "select time_slot from  honeybee_sms_engagement.tbl_rule_engagement_action nolock where rule_id ='" . $summarydata['id'] . "'";
                $timDisplay_query = mysql_query($timDisplay_get_query, $dbConn);
                $timDisplay_detail = mysql_fetch_array($timDisplay_query);

                $getCurrentTimeQuery = "select DATE_FORMAT(now(),'%H:%i:%s')";
                $timequery2 = mysql_query($getCurrentTimeQuery, $dbConn);
                $currentTime = mysql_fetch_row($timequery2);
                
                if ($currentTime[0] >= date('H:i:s', strtotime($timDisplay_detail['time_slot']))) {
                    //$next_date = date('Ymd') + 1;
                    $next_date = date('Ymd', strtotime(' +1 day'));
                } else {
                    $next_date = date('Ymd');
                }
                $next_date = $next_date . " " . $timDisplay_detail['time_slot'];
                echo date('j-M h:i:s A', strtotime($next_date));
            } else {
                echo "-";
            }
                    ?></TD>
                <TD>
                    <a href="javascript:void(0)" onclick="showViewConfirm('<?php echo $summarydata['id']; ?>')" id="edit_view_id" data-toggle="modal" data-target="#myModal">Edit/view</a>
        <!--                    <button  onclick="showViewConfirm('<?php echo $summarydata['id']; ?>')" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                        View
                    </button>-->

                    <!--                    <?php
            if ($summarydata['status'] == 1) {
                        ?>
                                                                <button class="btn btn-primary btn-lg" onclick="showPauseResumeConfirm('<?php echo $summarydata['id']; ?>','pause')">
                                                                    Pause
                                                                </button>
                                        
                                        
                    <?php } else { ?>
                                                                <button class="btn btn-primary btn-lg" onclick="showPauseResumeConfirm('<?php echo $summarydata['id']; ?>','resume')">
                                                                    Resume
                                                                </button>           
                                        
                    <?php } ?>-->
                </TD>

            </TR>
            <?php
        }
        echo "</TABLE>";
    }
    ?>

    <?php mysql_close($dbConn);
    ?>