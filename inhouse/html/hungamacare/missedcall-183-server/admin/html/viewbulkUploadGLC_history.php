<?php
ob_start();
session_start();
require_once("../../../db.php");
$uploadedby = $_SESSION['loginId'];
$get_query = "select batchid,uploadtime,ipaddress,odb_filename,filesize,servicetype,capsuleid,status from ";
$get_query .=" master_db.tbl_GLCBulkobdHistory  where uploadedby='".$uploadedby."' order by batchid desc limit 20";
//echo $get_query;
$query = mysql_query($get_query, $con);
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
    <!--center><div width="85%" align="left" class="txt">
            <div class="alert alert" >

                <a href="javascript:void(0);viewUploadhistory();" id="Refresh"><i class="fui-eye"></i></a>             

                <?php
                $limit = 20;
                echo " Displaying last " . $limit . " records";
                ?>
                </i>
            </div></div></center-->
    <TABLE class="table table-condensed table-bordered">
        <thead>
            <TR height="30">
                <th align="left"><?php echo 'Batch ID'; ?></th>
                <th align="left"><?php echo 'File Name'; ?></th>
                <th align="left"><?php echo 'File Size'; ?></th>
                <th align="left"><?php echo 'Status'; ?></th>
                 <th align="left"><?php echo 'Upload Time'; ?></th>
            </TR>
        </thead>
        <?php
        while ($summarydata = mysql_fetch_array($query)) {
            ?>
            <TR height="30">
                <TD><?php echo $summarydata['batchid']; ?></TD>
                <TD><?php echo $summarydata['odb_filename']; ?></TD>
                <TD><?php echo $summarydata['filesize']; ?></TD>
                <?php
        if($summarydata['status']==0) 
		$fileStatus1='<span class="label label-default">Queued</span>';
		elseif($summarydata['status']==1)
		$fileStatus1='<span class="label label-warning">Processing</span>';
		elseif($summarydata['status']==2)
		$fileStatus1='<span class="label label-success">Completed</span>';
		?>
		<td><?php echo $fileStatus1;?></td>
		<TD><?php
        $added_on = $summarydata['uploadtime'];
        echo date('j-M h:i A', strtotime($added_on));
            ?>
                </TD>
            </TR>
            <?php
        }
        echo "</TABLE>";
    }
    ?>

    <?php mysql_close($con);
    ?>