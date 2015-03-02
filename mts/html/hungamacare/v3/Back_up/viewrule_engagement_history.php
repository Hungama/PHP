<?php
session_start();
$loginid = $_SESSION['loginId'];
require_once("incs/db.php");

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
                $limit = 20;
                echo " Displaying last " . $limit . " records";
                ?>
                </i>
            </div></div></center>
    <TABLE class="table table-condensed table-bordered">
        <thead>
            <TR height="30">
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
                        <a href="" onclick="showPauseResumeConfirm('<?php echo $summarydata['id']; ?>','pause')"><i class="fui-pause"></i></a>
            <!--                        <button class="btn btn-primary btn-lg" onclick="showPauseResumeConfirm('<?php echo $summarydata['id']; ?>','pause')">
                                Pause
                            </button>-->
                    <?php } else { ?>
                        <a href="" onclick="showPauseResumeConfirm('<?php echo $summarydata['id']; ?>','resume')"><i class="fui-play"></i></a>
            <!--                        <button class="btn btn-primary btn-lg" onclick="showPauseResumeConfirm('<?php echo $summarydata['id']; ?>','resume')">
                               Resume
                           </button>           -->

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
                    $get_rule_query = "SELECT added_on FROM master_db.tbl_new_engagement_data where rule_id='" . $summarydata['id'] . "'";
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
            $timDisplay_get_query = "select time_slot from  master_db.tbl_rule_engagement_action nolock where rule_id ='" . $summarydata['id'] . "'";
            $timDisplay_query = mysql_query($timDisplay_get_query, $dbConn);
            $timDisplay_detail = mysql_fetch_array($timDisplay_query);
            if (date('H:i:s') >= date('H:i:s', strtotime($timDisplay_detail['time_slot']))) {
                $next_date = date('Ymd') + 1;
            } else {
                $next_date = date('Ymd');
            }
            $next_date = $next_date . " " . $timDisplay_detail['time_slot'];
            echo date('j-M h:i:s A', strtotime($next_date));
                    ?></TD>
                <TD>
                    <button  onclick="showViewConfirm('<?php echo $summarydata['id']; ?>')" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                        View
                    </button>

                    <?php
                    if ($summarydata['status'] == 1) {
                        ?>
                        <button class="btn btn-primary btn-lg" onclick="showPauseResumeConfirm('<?php echo $summarydata['id']; ?>','pause')">
                            Pause
                        </button>


                    <?php } else { ?>
                        <button class="btn btn-primary btn-lg" onclick="showPauseResumeConfirm('<?php echo $summarydata['id']; ?>','resume')">
                            Resume
                        </button>           

                    <?php } ?>
                </TD>

            </TR>
            <?php
        }
        echo "</TABLE>";
    }
    ?>

    <?php mysql_close($dbConn);
    ?>