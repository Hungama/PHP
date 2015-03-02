<?php
require_once("db.php");
$uploadfor = $_GET['type'];
$uploadvaluearray = array('ussd'=>'OBD');
$limit=10;
$get_query="select id,obd_name,added_on,status,description from ";
$get_query .=" master_db.obd_upload_history nolock where status in(0,1) order by id desc limit $limit";

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
{?>
<center><div width="85%" align="left" class="txt">
<div class="well well-small"><a href="javascript:void(0)" onclick="javascript:viewUploadOBDhistory('<?php echo $uploadfor;?>')" id="Refresh"><i class="icon-refresh"></i></a>
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
	<th align="left">Description</th>
	<th align="left">Status</th>
	
</TR>
 </thead>
<?php
	while($summarydata = mysql_fetch_array($query)) 
	{
	?>
	<TR height="30">
		<TD><?php echo $summarydata['id'];?></TD>
		<TD><?php echo $summarydata['obd_name'];?></TD>
		<TD><?php echo date('j-M \'y g:i a',strtotime($summarydata['added_on']));?></TD>
		<TD><?php echo $summarydata['description']; ?></TD>
		<?php if($summarydata['status']==0)
		{
		$fileStatus1='<span class="label">Queued</span>';
		}		
		elseif($summarydata['status']==1) 
		$fileStatus1='<span class="label label-success">Completed</span>';
		elseif($summarydata['status']==2) 
		{
			$fileStatus1='<span class="label label-success">Completed</span>';
			
		}
		elseif($summarydata['status']==3) 
		{
			$fileStatus1='<span class="label label-warning">Terminated </span>';
			
		}
		?>
	<TD><?php echo $fileStatus1; 
	if($summarydata['status']==1)
	{
	//$path='prompt/'.$summarydata['obd_name'];
	$path='http://192.168.100.227/sendobd/'.$summarydata['obd_name'];
	//http://192.168.100.227/sendobd/7.wav
	?>
<span id=dummyspan></span>
&nbsp;&nbsp;
    	<a href="javascript:void(0)" onClick="DHTMLSound('<?php echo $path;?>')"><i class="icon-large icon-music"></i></a>
	<?php
	}
	?></TD>
		
				
	 </TR>
<?php
}
echo "</TABLE>";
}
mysql_close($con);
?>
