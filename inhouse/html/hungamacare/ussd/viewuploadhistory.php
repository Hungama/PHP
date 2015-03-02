<?php
session_start();
require_once("db.php");
$uploadfor = $_GET['type'];
$uploadedby=$_SESSION["logedinuser"];
$uploadvaluearray = array('ussd'=>'USSD','ussd2'=>'USSD');
$limit=10;
if($uploadfor=='ussd2')
{//  
$get_query="select batch_id,file_name,added_on,added_by,total_file_count,status,menuid,ussd_string,status,menuserialid,upload_for from ";
$get_query .=" master_db.bulk_ussd_history nolock where added_by='$uploadedby' and status in(0,1,2,3) and ussd_string in('*546*21#','*546*22#','*546*23#') order by batch_id desc limit $limit";
}
else
{
$get_query="select batch_id,file_name,added_on,added_by,total_file_count,status,menuid,ussd_string,status,menuserialid,upload_for from ";
$get_query .=" master_db.bulk_ussd_history nolock where added_by='$uploadedby' and status in(0,1,2,3) and ussd_string not in('*546*21#','*546*22#','*546*23#') order by batch_id desc limit $limit";
}
	$query = mysql_query($get_query,$con);
	$numofrows=mysql_num_rows($query);
if($numofrows==0)
{
?>
<div width="85%" align="left" class="txt">
<div class="alert alert-block">
<?php // echo ALERT_NO_RECORD_FOUND;?>
<h4>Ooops!</h4>Hey, we couldn't seem to find any record of bulk upload for <?php echo strtoupper($uploadvaluearray[$uploadfor]); ?>
</div>
</div>
<?php
}
else
{
?>
<center><div width="85%" align="left" class="txt">
<div class="well well-small"><a href="javascript:void(0)" onclick="javascript:viewUploadhistory('<?php echo $uploadfor;?>')" id="Refresh"><i class="icon-refresh"></i></a>
<?php 
//echo ALERT_VIEW_UPLOAD_HISTORY;
echo "Upload history for ".strtoupper($uploadvaluearray[$uploadfor])." displaying last ".$limit." records";
?>
</i>
</div></div><center>
<TABLE class="table table-condensed table-bordered">
   <thead>
  <TR height="30">
	<th align="left">Batch Id</th>
	<th align="left">File Name</th>
	<th align="left">Added On</th>
	<th align="left">Added By</th>
	<th align="left">Processed/Success</th>
	<th align="left">Menu Id</th>
	<th align="left">USSD String</th>
	<th align="left">Total Count</th>
	<th align="left">File Status</th>
	<th align="left">Action</th>
	
</TR>
 </thead>
<?php
	while($summarydata = mysql_fetch_array($query)) 
	{
		//check status of pushed USSD
		//$get_currentstatus="select count(*) from USSD.tbl_uninor_ussd_bulkpush where batchid='$summarydata[batch_id]'";
		$get_currentstatus="select sum(status) as status from USSD.tbl_uninor_ussd_bulkpush where batchid='$summarydata[batch_id]' and status in(1,0)";
		$query_status = mysql_query($get_currentstatus,$con);
		$result_status=mysql_fetch_array($query_status);
		
		$get_success_count="select count(*) from USSD.tbl_uninor_ussd_bulkpush_log where batchid='$summarydata[batch_id]'";
		$query_success_status = mysql_query($get_success_count,$con);
		$result_success_status=mysql_fetch_array($query_success_status);
	?>
	<TR height="30">
		<TD><?php echo $summarydata['batch_id'];?></TD>		
		<TD><?php 
		if($summarydata['upload_for']=='live'){echo $summarydata['file_name'];} else {echo 'Testing Mode';}?></TD>
		<TD><?php
echo date('j-M \'y g:i a',strtotime($summarydata['added_on']));
		?></TD>
		<TD><?php echo $summarydata['added_by'];?></TD>
		<TD>
		<?php 
		if(!empty($summarydata['total_file_count']))
		{
		echo $summarydata['total_file_count'].'/'.$result_success_status[0];
		}
		else
		{
		echo 'NA';
		}
		?>
		</TD>
		<TD>
		<a href="javascript:void(0)" onclick="setmenumessage('<?php echo $summarydata['menuserialid'];?>')"><?php echo $summarydata['menuid'];?></a>
		</TD>
		<?php if($summarydata['status']==0)
		{
		$fileStatus1='<span class="label">Queued</span>';
		}		
		elseif($summarydata['status']==1) 
		$fileStatus1='<span class="label label-warning">Picked</span>';
		elseif($summarydata['status']==2) 
		{
			$fileStatus1='<span class="label label-success">Completed</span>';
			
		}
		elseif($summarydata['status']==3) 
		{
			$fileStatus1='<span class="label label-warning">Terminated </span>';
			
		}
	
		
?>	
		<TD><?php echo $summarydata['ussd_string'] ?></TD>
		<TD><?php if($summarydata['upload_for']=='live'){echo $summarydata['total_file_count'];} else {echo 'NA';}?></TD>	
		<TD><?php 
		if($summarydata['status']==0)
		{
		?>
		<button class="btn btn-danger" style="float:left"  id="<?php echo 'btn_action_kill_'.$summarydata['batch_id']?>" onclick="javascript:confirmStop('<?php echo $summarydata[batch_id];?>')">END</button>
		<?php
		}
		else
		{
		echo $fileStatus1;
		}
		?></TD>
		<TD>
		<?php
		//echo 'status'.$result_status['status'];
		if($result_status['status']!=null)
		{
	if($result_status['status']==0)
		{ //echo $result_status['status'];
	?>
		<button class="btn btn-success" style="float:left;display:none"  id="<?php echo 'btn_action_push_'.$summarydata['batch_id']?>" onclick="javascript:startStopUssd('start','<?php echo $summarydata[batch_id];?>')">RUN</button>
	<button class="btn btn-danger" style="float:left;" id="<?php echo 'btn_action_stop_'.$summarydata['batch_id']?>" onclick="javascript:startStopUssd('stop','<?php echo $summarydata[batch_id];?>')">PAUSE</button>
	
		<button class="btn btn-danger" style="float:right"  onclick="javascript:confirmBaseStop('<?php echo $summarydata[batch_id];?>')">END</button>
			<?php
		}
		else
		{ //echo $result_status['status'];
		?>
	<button class="btn btn-danger" style="float:left;display:none" id="<?php echo 'btn_action_stop_'.$summarydata['batch_id']?>" onclick="javascript:startStopUssd('stop','<?php echo $summarydata[batch_id];?>')">PAUSE</button>
	<button class="btn btn-success" style="float:left;"  id="<?php echo 'btn_action_push_'.$summarydata['batch_id']?>" onclick="javascript:startStopUssd('start','<?php echo $summarydata[batch_id];?>')">RUN</button>
	
<button class="btn btn-danger" style="float:right"  onclick="javascript:confirmBaseStop('<?php echo $summarydata[batch_id];?>')">END</button>
	<?php
		}
		}
		else
		{
		echo 'NA';
		}
		?>
		
		</TD>
		
				
	 </TR>
<?php
}
echo "</TABLE>";
}
mysql_close($dbConn);
?>