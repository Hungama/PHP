<?php
//die('here');
session_start();
$loginid = $_SESSION['loginId'];
require_once("../2.0/incs/db.php");
require_once("../2.0/base.php");
$serviceArray1 = array('1302' => 'Vodafone54646');
$circle_info = array('GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi');
if ($_REQUEST['id'] && $_REQUEST['act']) {
    $actionId = $_REQUEST['id'];
    $actionType = $_REQUEST['act'];
    if ($actionType == 'dact') {
        $dacttQuery = "UPDATE Vodafone_IVR.tbl_ad_campaign SET status=0 WHERE id=" . $actionId;
        mysql_query($dacttQuery, $dbConn);
    } elseif ($actionType == 'act') {
        $actQuery = "UPDATE Vodafone_IVR.tbl_ad_campaign SET status=1 WHERE id=" . $actionId;
        mysql_query($actQuery, $dbConn);
    }
}

$get_query = "select id,S_id,ad_name,sc,circle,starttime,endtime,status from ";
$get_query .=" Vodafone_IVR.tbl_ad_campaign nolock order by id desc limit 20";
//echo $get_query;die('here');
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

                <a href="javascript:void(0);viewUploadhistory();" id="Refresh"><i class="fui-eye"></i></a>             

                <?php
                $limit = 20;
                echo " Displaying last " . $limit . " records";
                ?>
                </i>
            </div></div></center>
    <TABLE class="table table-condensed table-bordered">
        <thead>
            <TR height="30">
                <th align="left"><?php echo 'Service ID'; ?></th>
                <th align="left"><?php echo 'Ad Name'; ?></th>
                <th align="left"><?php echo 'Sort Code'; ?></th>
                <th align="left"><?php echo 'Circle'; ?></th>
                <th align="left"><?php echo 'Schedule Time'; ?></th>
                <th align="left"><?php echo 'Status'; ?></th>
                <th align="left"><?php echo 'Action'; ?></th>
            </TR>
        </thead>
        <?php
        while ($summarydata = mysql_fetch_array($query)) {
            $id = $summarydata['id'];
            ?>
            <TR height="30">
                <TD><?php echo $Service_DESC[$serviceArray[$summarydata['S_id']]]['Name']; ?></TD>
                <TD><?php echo $summarydata['ad_name']; ?></TD>
                <TD><?php echo $summarydata['sc']; ?></TD>
                <TD><?php echo $circle_info[$summarydata['circle']]; ?></TD>
                <TD><?php echo date('j-M h:i A', strtotime($summarydata['starttime'])) . " - " . date('j-M h:i A', strtotime($summarydata['endtime'])); ?></TD>
                <TD><?php
        if ($summarydata['status'] == 1) {
            echo "Active";
        } else {
            echo "Not Active";
        }
            ?></TD>
                <td bgcolor="#FFFFFF" height="30px" align="center">
                    <?php if ($summarydata['status'] == 1) { ?>
                        <a href="#" onclick="showStatusConfirm('<?php echo $id ?>','dact');">Deactivate</a>
                    <?php } else { ?>
                        <a href="#" onclick="showStatusConfirm('<?php echo $id ?>','act');">Activate</a>
                    <?php } ?>
                </td>
            </TR>
            <?php
        }
        echo "</TABLE>";
    }
    ?>

    <?php mysql_close($dbConn);
    ?>