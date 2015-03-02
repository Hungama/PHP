<center><div width="85%" align="left" class="txt">
        <div class="alert alert" ><a href="javascript:void(0)" onclick="javascript:viewUploadhistory('<?php echo $uploadfor; ?>')" id="Refresh"><i class="icon-refresh"></i></a>
            <?php
            $limit = 20;
//echo ALERT_VIEW_UPLOAD_HISTORY;
            echo "Config history for " . ucfirst($uploadvaluearray[$uploadfor]) . " Displaying last " . $limit . " records";
            $authtypevaluearray = array('deact' => 'Auto deactivation', 'renew' => 'Auto renewal');
            ?>
            </i>
        </div></div></center>
<TABLE class="table table-condensed table-bordered">
    <thead>
        <TR height="30">
            <th align="left"><?php echo 'Batch id'; ?></th>
            <th align="left"><?php echo 'File Name'; ?></th>
           <th align="left"><?php echo 'Added On'; ?></th>
            <th align="left"><?php echo 'Added By'; ?></th>
            <th align="left"><?php echo 'Status'; ?></th>
            
        </TR>
    </thead>
    <?php
	while (list($id, $batch_id,$status,$file_name,$added_on, $added_by) = mysql_fetch_array($query)) {
	$fileurl="http://10.130.14.107/billing_api/getBalance/log/".$file_name;
 ?>
        <TR height="30">
            <TD><?php echo $id; ?></TD>
            <TD><a href="<?php echo $fileurl;?>" target="_blank"><?php echo $file_name; ?></a></TD>
            <TD><?php echo $added_on; ?></TD>
            <TD><?php echo $added_by; ?></TD>
            <TD><?php echo $status; ?></TD>

<!--<button class="btn btn-danger" style="float:left"  onclick="javascript:editBulkFile('<?php echo $id; ?>','<?php echo 'get'; ?>')">Edit</button>-->
<button class="btn btn-danger" style="float:left;margin-left:5px"  onclick="javascript:deleteBulkFile('<?php echo $id; ?>','<?php echo 'tryandbuy'; ?>')">Delete</button>
            </TD>

        </TR>	
    <?php
}
echo "</TABLE>";