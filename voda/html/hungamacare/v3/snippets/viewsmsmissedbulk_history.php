<?php
ob_start();
session_start();
require_once("../../2.0/incs/db.php");
require_once("../../2.0/language.php");
$added_by=$_SESSION['loginId'];
$type=$_REQUEST['type'];
$S_id=$_REQUEST['S_id'];
$msgtype=array('SUB'=>'SUB','RESUB'=>'RESUB','TOPUP'=>'TOPUP');
function msgStrEncode($string) {
    $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
    $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
    return str_replace($entities, $replacements, urlencode($string));
}

$circle_info_HIS = array( 'PAN' => 'PAN','BIH'=>'Bihar','APD'=>'Andhra Pradesh','CHN' => 'Chennai', 'GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi','MAH' => 'Maharashtra','UPE' => 'UP EAST');
$get_query="select batch_id,file_name,added_on,status,total_file_count,message from master_db.bulk_tdbsms_history where added_by='tdb.bulk' order by batch_id desc limit 20";
$query = mysql_query($get_query,$dbConn);
$numofrows=mysql_num_rows($query);
$msgidarray=array();
if($numofrows==0)
{
?>
<div width="85%" align="left" class="txt">
<div class="alert alert-block">
<h4>Ooops!</h4>Hey,  we couldn't seem to find any record.
</div>
</div>
<?php
}
else
{?>
<center><div width="85%" align="left" class="txt">
<div class="alert alert" >
<a href="javascript:void(0)" onclick="javascript:viewUploadhistory('SMS')" id="Refresh"><i class="fui-eye"></i></a>
<?php 
$limit=20;
//echo ALERT_VIEW_UPLOAD_HISTORY;
echo "Upload history for SMS Displaying last ".$limit." records";

?>
</i>
</div></div></center>
<table class="table table-bordered table-striped">

	 <TR height="30">
	<th align="left"><?php echo TH_BATCHID;?></th>
	<th align="left"><?php echo TH_FILENAME;?></th>
	<th align="left"><?php echo 'Message';?></th>
	<th align="left"><?php echo TH_ADDEDON;?></th>
	<th align="left"><?php echo TH_TOTALCOUNTINFILE;?></th>
	<th align="left"><?php echo TH_FILESTATUS;?></th>
	<th align="left"><?php echo 'Action';?></th>
	

</TR>

	<?php
	$i=0;
	while($summarydata = mysql_fetch_array($query)) 
	{
	$subStatus=$summarydata['status'];
	$fileurl='http://omega.hungamavoice.com/kmis/services/hungamacare/smsbulkuploads/TDB/'.$summarydata['file_name'].'.txt';
	$batchId=$summarydata['batch_id'];
	?>
	<tr>
	<th width="8%"><?=$summarydata['batch_id'];?></th>
	<th width="25%"><a href="<?= $fileurl;?>" target="_blank"><?=$summarydata['file_name'];?></a></th>
	<th width="25%"><?=$summarydata['message'];?></th>
	<th width="25%"><?=date('j-M \'y g:i a',strtotime($summarydata['added_on']));?></th>
	<th width="25%"><?=$summarydata['total_file_count'];?></th>
	
	<th width="25%">
		<?php if($subStatus == 0)
	{?>
	<span class="label label-warning">
	<?php
	echo 'Queued';
	}
	else if($subStatus == 1 ||$subStatus == 3 )
	{?>
	<span class="label label-success">
	<?php
	echo 'Completed';
	} 
	else if($subStatus == 5)
	{?>
	<span class="label label-danger">
	<?php
	echo 'Stopped';
	} 
	?></span>
	
	</th>
		<TD bgcolor="#FFFFFF" align="center">
		<?php 
		if($subStatus==0){?> 
		<button class="btn btn-danger" style="float:right"  onclick="javascript:stopBulkFile('<?php echo $batchId;?>','<?php echo 'tdb_sms_history';?>')">Stop</button>
		<?php } else {echo 'NA';}
		?></TD>	
	
</tr>
	<?php
	$i++;
	}
}

mysql_close($dbConn);
?>
</table>
