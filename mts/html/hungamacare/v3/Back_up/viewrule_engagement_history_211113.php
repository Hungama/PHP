<?php
session_start();

require_once("incs/db.php");

$get_query = "select id,rule_name,added_on from ";
$get_query .=" master_db.tbl_rule_engagement nolock where status=1 order by id desc limit 20";

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
                <TD><?php echo $summarydata['id']; ?></TD>
                <TD><?php echo $summarydata['rule_name']; ?></TD>
                <TD><?php echo $summarydata['added_on']; ?></TD>
                <TD><?php echo $summarydata['added_on']; ?></TD>
                <TD><?php echo $summarydata['added_on']; ?></TD>
                <TD>
                    <a href="#" onclick="showViewConfirm('<?php echo $summarydata['id']; ?>','view');">View</a>&nbsp;&nbsp;|&nbsp;&nbsp;  
                    <a href="#" onclick="showPauseResumeConfirm('<?php echo $summarydata['id']; ?>','del')">Pause</a> 
                </TD>
                        
                    </TR>
                    <?php
                }
                echo "</TABLE>";
            }
            mysql_close($dbConn);
            ?>