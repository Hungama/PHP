<?php
//die('here');
session_start();
$loginid = $_SESSION['loginId'];
require_once("../2.0/incs/db.php");
require_once("../2.0/base.php");
$serviceArray = array('1515' => 'AirtelDevo');
$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra',
    'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa',
    'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala',
    'HPD' => 'Himachal Pradesh');
if ($_REQUEST['id'] && $_REQUEST['act']) {
    $actionId = $_REQUEST['id'];
    $actionType = $_REQUEST['act'];
    if ($actionType == 'dact') {
        $dacttQuery = "UPDATE Airtel_IVR.tbl_ad_campaign SET status=0 WHERE id=" . $actionId;
        mysql_query($dacttQuery, $dbConn);
    } elseif ($actionType == 'act') {
        $actQuery = "UPDATE Airtel_IVR.tbl_ad_campaign SET status=1 WHERE id=" . $actionId;
        mysql_query($actQuery, $dbConn);
    }
}

$get_query = "select id,S_id,ad_name,sc,circle,starttime,endtime,status,added_on from ";
$get_query .=" Airtel_IVR.tbl_ad_campaign nolock order by id desc limit 20";
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
                <th align="left"><?php echo 'Service Name'; ?></th>
                <th align="left"><?php echo 'Ad Name'; ?></th>
                <th align="left"><?php echo 'Short Code'; ?></th>
                <th align="left"><?php echo 'Circle'; ?></th>
                <th align="left"><?php echo 'Schedule Time'; ?></th>
                <th align="left"><?php echo 'Added On'; ?></th>
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
                <TD><?php echo date('j-M h:i A', strtotime($summarydata['added_on'])); ?></TD>
                <TD><?php
        if ($summarydata['status'] == 1) {
            echo "<span class=\"label label-success\">Active</span>";
        } else {
            echo "<span class=\"label label-warning\">Not Active</span>";
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