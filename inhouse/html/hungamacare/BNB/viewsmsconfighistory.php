<?php
session_start();
require_once("db.php");
$uploadfor = $_GET['type'];
$uploadedby=$_SESSION["logedinuser"];
$uploadvaluearray = array('smskey'=>'SMS Sub Keyword','ivr'=>'IVR','dash'=>'Dashboard','sms-tp'=>'SMS Transaction','sms-mis'=>'SMS MIS');
$limit=20;
//var/www/html/hungamacare/contestApi.php
if($uploadfor=='smskey')
{
$get_query="select a.smsid as smsid,a.sms_keyword as sms_keyword,a.response as response,a.added_on as added_on,a.added_by as added_by,a.status as status,b.sms_keyword as Master_keyword
from master_db.tbl_bnb_sms as a, master_db.tbl_bnb_sms_manager as b 
where a.status=b.status and a.status=1 and a.master_keywordId=b.master_keywordId order by a.added_on desc ";
}
	$query = mysql_query($get_query,$con);
	$numofrows=mysql_num_rows($query);
if($numofrows==0)
{
?>
<div width="85%" align="left" class="txt">
<div class="alert alert-block">
<?php // echo ALERT_NO_RECORD_FOUND;?>
<h4>Ooops!</h4>Hey, we couldn't seem to find any record for <?php echo strtoupper($uploadvaluearray[$uploadfor]); ?>
</div>
</div>
<?php
}
else
{
?>
<center><div width="85%" align="left" class="txt">
<div class="well well-small">
<?php
if($uploadfor=='smskey')
{?>
<a href="javascript:void(0)" onclick="javascript:viewSMSKeyboardhistory('<?php echo $uploadfor;?>')" id="Refresh">
<?php
}?>
<i class="icon-refresh"></i></a>
<?php 
//echo ALERT_VIEW_UPLOAD_HISTORY;
echo "Upload history for ".strtoupper($uploadvaluearray[$uploadfor])." displaying last ".$limit." records";
?>
</i>
</div></div><center>
<TABLE class="table table-condensed table-bordered">
   <thead>
  <TR height="30">
	<th align="left">Master KeyWord</th>
	<th align="left">KeyWord</th>
	<th align="left">Response</th>
	<!--th align="left">Added By</th-->
	<th align="left">Added On</th>
	<th align="left">Action</th>
</TR>
 </thead>
<?php
	while($summarydata = mysql_fetch_array($query)) 
	{
	$Master_keyword=$summarydata['Master_keyword'];
	$sms_keyword=$summarydata['sms_keyword'];
	$response=$summarydata['response'];
	$added_on=$summarydata['added_on'];
	$added_by=$summarydata['added_by'];
	?>
	<TR height="30">
	<TD><span class="label label-info"><?php echo $Master_keyword;?></span></TD>
	<TD><?php echo $sms_keyword;?></TD>
	<TD><?php echo $response;?></TD>
	<!--TD><?php //echo $added_by;?></TD-->
	<TD><?php echo $added_on;?></TD>
	<td>
	<?php 
		if($summarydata['status']==1){?> 
		<button class="btn btn-danger"id="btn_action_stop_<?php echo $summarydata['smsid'];?>" style="float:left"  onclick="javascript:confirmDelete('<?php echo $summarydata['smsid'];?>','smskey')">Delete</button>
		<?php } else {echo 'NA';}
		?>
		<center><img src="img/ajax-loader.gif" id="ajax_loader_<?php echo $summarydata['smsid'];?>" style="display:none;"></center>
	</td>
	<?php 
	}?>
	</TR>

</TABLE>
<?php
}
mysql_close($con);
?>