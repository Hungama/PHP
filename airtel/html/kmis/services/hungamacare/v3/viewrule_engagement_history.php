<?php
session_start();
$loginid = $_SESSION['loginId'];
require_once("../2.0/incs/db.php");

if (isset($_REQUEST['act']) && $_REQUEST['act'] != '') {
    echo $_REQUEST['act'];
    if ($_REQUEST['act'] == 'pause') {
        echo $updatePauseQuery = "update master_db.tbl_rule_engagement set status=5 WHERE id='" . $_REQUEST['id'] . "'";
        mysql_query($updatePauseQuery, $dbConn);
    } elseif ($_REQUEST['act'] == 'resume') {
        echo $updatePauseQuery = "update master_db.tbl_rule_engagement set status=1 WHERE id='" . $_REQUEST['id'] . "'";
        mysql_query($updatePauseQuery, $dbConn);
    } elseif ($_REQUEST['act'] == 'del') {
        echo $updatePauseQuery = "update master_db.tbl_rule_engagement set status=10 WHERE id='" . $_REQUEST['id'] . "'";
        mysql_query($updatePauseQuery, $dbConn);
    }
}

$get_query = "select id,rule_name,added_on,status from ";
$get_query .=" master_db.tbl_rule_engagement nolock where status in(1,5) and added_by ='" . $loginid . "' order by id desc limit 20";
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
                $limit = 20;
                echo " Displaying last " . $limit . " records";
                ?>
                </i>
            </div></div></center>
    <TABLE class="table table-condensed table-bordered">
        <thead>
            <TR height="30">
                <th align="left"></th>
                <th align="left"><?php echo 'Rule ID'; ?></th>
                <th align="left"><?php echo 'Rule Name'; ?></th>
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

                    <?php } else { ?>
                        <a href="javascript:void(0)" onclick="showPauseResumeConfirm('<?php echo $summarydata['id']; ?>','resume')" id="resume_id"><i class="fui-play"></i></a>
                    <?php } ?>
                </TD>
                <TD><?php echo $summarydata['id']; ?></TD>
                <TD><?php echo $summarydata['rule_name']; ?></TD>
                <TD><?php
            $added_on = $summarydata['added_on'];
            echo date('j-M h:i A', strtotime($added_on));
                    ?>
                </TD>
                <TD>
                    <?php
                    $get_rule_query = "SELECT added_on FROM master_db.tbl_new_engagement_data where rule_id='" . $summarydata['id'] . "' order by id desc limit 1";
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
                $timDisplay_get_query = "select time_slot from  master_db.tbl_rule_engagement_action nolock where rule_id ='" . $summarydata['id'] . "'";
                $timDisplay_query = mysql_query($timDisplay_get_query, $dbConn);
                $timDisplay_detail = mysql_fetch_array($timDisplay_query);

                $getCurrentTimeQuery = "select DATE_FORMAT(now(),'%H:%i:%s')";
                $timequery2 = mysql_query($getCurrentTimeQuery, $dbConn);
                $currentTime = mysql_fetch_row($timequery2);

                if ($currentTime[0] >= date('H:i:s', strtotime($timDisplay_detail['time_slot']))) {
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


                </TD>

            </TR>
            <?php
        }
        echo "</TABLE>";
    }
    ?>

    <?php mysql_close($dbConn);
    ?>