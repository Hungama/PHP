<?php
session_start();
//include("config/dbConnect.php");
require_once("language.php");
require_once("incs/db.php");
require_once("base.php");

$service_info = $_REQUEST['service_info'];
$type = $_REQUEST['type'];

$uploadvaluearray = array('no_call_activation' => 'No call since activation', 'entire_active_base' => 'Entire active base', 'mou' => 'Mou', 'call_hang_up' => 'Call hang up');
$get_query = "select id,count,service_id,status,type,added_on from ";
$get_query .=" master_db.tbl_sms_engagement_data nolock where service_id='$service_info' and type='$type' order by id desc limit 20";
$query = mysql_query($get_query, $dbConn);
$numofrows = mysql_num_rows($query);
if ($numofrows == 0) {
    ?>
    <div width="85%" align="left" class="txt">
        <div class="alert alert-block">
            <?php // echo ALERT_NO_RECORD_FOUND; ?>
            <h4>Ooops!</h4>Hey,  we couldn't seem to find any record.
        </div>
    </div>
    <?php
} else {
    ?>
    <center><div width="85%" align="left" class="txt">
            <div class="alert alert" ><a href="javascript:void(0)" onclick="javascript:viewUploadhistory('<?php echo $uploadfor; ?>')" id="Refresh"><i class="icon-refresh"></i></a>
                <?php
                $limit = 20;
                echo " Displaying last " . $limit . " records";
                ?>
                </i>
            </div></div><center>
            <TABLE class="table table-condensed table-bordered">
                <thead>
                    <TR height="30">
                        <th align="left"><?php echo 'ID'; ?></th>
                        <th align="left"><?php echo 'Service Name'; ?></th>
                        <th align="left"><?php echo 'Count'; ?></th>
                        <th align="left"><?php echo 'Added On'; ?></th>
                        <!--th align="left"><?php echo 'Status'; ?></th-->
                    </TR>
                </thead>
                <?php
                while ($summarydata = mysql_fetch_array($query)) {
                    if ($summarydata['status'] == '1') {
                        $status = '<span class="label label-success">Active</span>';
                    } else {
                        $status = '<span class="label label-warning">Inactive</span>';
                    }
                    $servicelistarray = Array('1513' => 'Airtel - MND','1517'=>'Airtel Spoken English');
// $sname_ks = array_flip($serviceArray);
                    ?>
                    <TR height="30">
                        <TD><?php echo $summarydata['id']; ?></TD>
                        <TD><?php echo $servicelistarray[$summarydata['service_id']]; ?></TD>
                        <?php
                        $type = $summarydata['type'];
                        $added_on = $summarydata['added_on'];
                        $replace_array = array(" ", "-", ">");
                        $type_path = str_replace($replace_array, "_", $type);
                        $mytime = date("dmy", strtotime($added_on));
                        $filePath = "/var/www/html/kmis/services/hungamacare/2.0/logs/sms_engmnt/" . $summarydata['service_id'] . "/" . $type_path . "/log_" . $mytime . ".log";
                        $lines = file($filePath);
                        ?>
                        <TD><?php if (count($lines) >= 1) { ?>
                                <a href="xls_sms_engagement.php?service_id=<?php echo $summarydata['service_id'] ?>&type=<?php echo $summarydata['type'] ?>&added_on=<?php echo $summarydata['added_on'] ?>">
                                <?php } ?>                               
                                <?php echo $summarydata['count']; ?>
                                <?php if (count($lines) >= 1){ ?>   </a>
                            <?php } ?> </TD>
                        <TD><?php
                    echo date('j-M \'y', strtotime($summarydata['added_on']));
                            ?></TD>
                        <!--TD><?php echo $status; ?></TD-->	
                    </TR>
                    <?php
                }
                echo "</TABLE>";
            }
            mysql_close($dbConn);
            ?>