<center><div width="85%" align="left" class="txt">
        <div class="alert alert" ><a href="javascript:void(0)" onclick="javascript:viewUploadhistory('<?php echo $uploadfor; ?>')" id="Refresh"><i class="icon-refresh"></i></a>
            <?php
            $limit = 20;
//echo ALERT_VIEW_UPLOAD_HISTORY;
            echo "Config history for Get BALANCE Activity Displaying last " . $limit . " records";
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
			<th align="left"><?php echo 'Schedule Time'; ?></th>
            <th align="left"><?php echo 'Status'; ?></th>			 
			<th align="left"><?php echo 'Action'; ?></th>
            
        </TR>
    </thead>
    <?php
	//echo $query;
    while (list($id, $batch_id,$status,$file_name,$added_on, $added_by,$schedule_on) = mysql_fetch_array($query)) {
	$fileurl="http://10.130.14.107/billing_api/getBalance/log/".$file_name;
 ?>
        <TR height="30">
            <TD><?php echo $id; ?></TD>
            <TD><a href="<?php echo $fileurl;?>" target="_blank"><?php echo $file_name; ?></a></TD>
            <TD><?php echo date('j-M \'y g:i a',strtotime($added_on));?></TD>
            <TD><?php echo $added_by; ?></TD>
			<TD><?php echo date('j-M \'y g:i a',strtotime($schedule_on));?></TD>
            <TD>
			<?php if(isset($status) && $status==0)
				$fileStatus='<span class="label">Queued</span>';
			else if($status==1)
			{
			$fileStatus='<span class="label label-warning">Processing</span>';
			}
			else if($status==2 || $status==3) 
				$fileStatus='<span class="label label-success">Completed</span>';
			else if($status==5) 
				$fileStatus='<span class="label label-warning">Deleted</span>';
			echo $fileStatus;
			
		?>

			</TD>
<TD>
<?php
if(isset($status) && $status==0)
{?>
<button class="btn btn-danger" style="float:left;margin-left:5px"  onclick="javascript:deleteBulkFile('<?php echo $id; ?>','<?php echo 'getbalance'; ?>')">Delete</button>
<?php } else { echo 'NA';}?>

</TD>
            </TD>

        </TR>	
    <?php
}
echo "</TABLE>";