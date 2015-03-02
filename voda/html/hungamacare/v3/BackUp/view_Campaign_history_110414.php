<?php
//die('here');
session_start();
$loginid = $_SESSION['loginId'];
require_once("../2.0/incs/db.php");
$serviceArray = array('1402' => 'Uninor54646', '1408' => 'UninorSU', '1423' => 'UninorContest', '1409' => 'RIAUninor',
    '1416' => 'UninorAstro', '1410' => 'REDFMUninor', '1418' => 'UninorComedy', '1412' => 'UninorRT', '1002' => 'TataDoCoMo54646',
    '1602' => 'TataIndicom54646', '1003' => 'MTVTataDoCoMo', '1603' => 'MTVTataIndicom', '1010' => 'REDFMTataDoCoMo', '1610' => 'REDFMTataDoCoMocdma',
    '1009' => 'RIATataDoCoMo', '1609' => 'RIATataDoCoMocdma', '1005' => 'TataDoCoMoFMJ', '1605' => 'TataDoCoMoFMJcdma', '1013' => 'TataDoCoMoMND',
    '1613' => 'TataDoCoMoMNDcdma', '1001' => 'TataDoCoMoMX', '1601' => 'TataDoCoMoMXcdma');
$get_query = "select S_id,ad_name,sc,circle,starttime,endtime from ";
$get_query .=" Inhouse_IVR.tbl_ad_campaign nolock order by id desc limit 20";
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
            </TR>
        </thead>
        <?php
        while ($summarydata = mysql_fetch_array($query)) {
            ?>
            <TR height="30">
                <TD><?php echo $serviceArray[$summarydata['S_id']]; ?></TD>
                <TD><?php echo $summarydata['ad_name']; ?></TD>
                <TD><?php echo $summarydata['sc']; ?></TD>
                <TD><?php echo $summarydata['circle']; ?></TD>
                <TD><?php echo $summarydata['starttime'] . "-" . $summarydata['endtime']; ?></TD>
            </TR>
            <?php
        }
        echo "</TABLE>";
    }
    ?>

    <?php mysql_close($dbConn);
    ?>