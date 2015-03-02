<?php
ob_start();
session_start();
require_once("../../2.0/incs/db.php");
$added_by=$_SESSION['loginId'];
$type=$_REQUEST['type'];
$S_id=$_REQUEST['S_id'];
$msgtype=array('SUB'=>'SUB','RESUB'=>'RESUB','TOPUP'=>'TOPUP');
$circle_info_HIS = array( 'pan' => 'PAN','CHN' => 'Chennai', 'GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi');
//$get_query="select msg_id,S_id,msg_type,msg_desc,circle,kci_type,added_on from Inhouse_IVR.tbl_smskci_serviceMsgDetails where S_id='".$S_id."' and added_by='".$added_by."' and kci_type='".$type."'";
$get_query="select msg_id,S_id,msg_type,msg_desc,circle,kci_type,added_on from Inhouse_IVR.tbl_smskci_serviceMsgDetails where S_id='".$S_id."'";
if($type == 'KCI'){
    $get_query .=" and kci_type='Billing'";
}else if($type == 'CallHangups'){
     $get_query .=" and kci_type='hangup'";
}
else{
     $get_query .=" and kci_type='".$type."' order by msg_type";
}
//echo $get_query;
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
  <div class="pagination" style="float:right">
            <ul>
              <li class="previous"><a href="#" class="fui-arrow-left"></a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li class="active"><a href="#">4</a></li>
              <li><a href="#">5</a></li>
              <li class="next"><a href="#" class="fui-arrow-right"></a></li>
            </ul>
          </div> 
<table class="table table-bordered table-striped">

<tr>
	<th width="8%">SMS ID</th>
	<th width="25%">Type</th>
	<th width="25%">Circle</th>
	<th width="50%">Text</th>
	<th width="8%">Options</th>
</tr>
	<?php
	$i=0;
	while($summarydata = mysql_fetch_array($query)) 
	{
	$msgidarray[$i]=$summarydata['msg_id'];
	?>
	<tr>
	<th width="8%"><?=$summarydata['msg_id'];?></th>
	<th width="25%"><?=ucfirst($summarydata['msg_type']);?></th>
	<th width="25%"><?=$circle_info_HIS[$summarydata['circle']];?></th>
	<th width="50%"><a href="#" id="<?=$summarydata['msg_id'];?>" data-type="textarea" data-url="snippets/smskci.update.php?msg_id=<?php echo $summarydata['msg_id'];?>" data-pk="1" data-title="Edit Message" class="editable editable-pre-wrapped editable-click editable-open" data-original-title="" title=""><?=$summarydata['msg_desc'];?></a></th>
	<!--th width="25%"><?=$summarydata['added_on'];?></th-->
	<th width="8%"><a href="javascript:deleteMsg('<?=$summarydata['msg_id'];?>')">Delete</a></th>
</tr>
	<?php
	$i++;
	}
}
?>
</table>
<script>
<?php
foreach ($msgidarray as $k => $v) 
{?>
$('#<?=$v?>').editable();
<?php } ?>
</script>