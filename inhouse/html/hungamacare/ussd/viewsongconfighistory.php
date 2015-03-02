<?php
session_start();
require_once("db.php");
$uploadfor = $_GET['type'];
$uploadedby=$_SESSION["logedinuser"];
$uploadvaluearray = array('ussd'=>'USSD','menu'=>'MENU','dtmf'=>'DTMF');
$limit=10;
if($uploadfor=='menu')
{
/*$get_query="select menu_id,song_category,song_index,songname,contentid,contenttype,status,ussd_string,circle 
from USSD.tbl_songname where status=1 and ussd_string in('*546*21#','*546*22#','*546*23#','') order by menu_id ASC";
*/
$get_query="select menu_id,song_category,song_index,songname,contentid,contenttype,status,ussd_string,circle 
from USSD.tbl_songname where status=1 and ussd_string like '*546*%' order by sid DESC";
}
else if($uploadfor=='dtmf')
{
$get_query="select menu_id,song_category,song_index,songname,contentid,contenttype,status,ussd_string,circle,DTMF from USSD.tbl_songname_dtmf where status=1 order by menu_id ASC";
}
else
{
$get_query="select menu_id,song_category,song_index,songname,contentid,contenttype,status,ussd_string from USSD.tbl_songname where status=1 order by menu_id ASC";
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
<div class="well well-small">
<?php
if($uploadfor=='menu')
{?>
<a href="javascript:void(0)" onclick="javascript:viewUploadMenuhistory('<?php echo $uploadfor;?>')" id="Refresh">
<?php
}
else
{?>
<a href="javascript:void(0)" onclick="javascript:viewUploadhistory('ussd')" id="Refresh">
<?php } ?>
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
	<?php if($uploadfor!=='dtmf'){ ?><th align="left">Menu Id</th><?php }?>
	<th align="left">Song Category</th>
	<?php if($uploadfor!=='dtmf'){ ?><th align="left">Song Order</th><?php }?>
	<?php if($uploadfor=='dtmf'){?>
	<th align="left">DTMF</th>
	<?php } else { ?>
	<th align="left">Song Name</th>
	<?php } ?>
	<th align="left">Content Id</th>
	<?php if($uploadfor!=='dtmf'){ ?><th align="left">Content Type</th><?php }?>
	<th align="left">Status</th>
	<th align="left">USSD String</th>
	<th align="left">Circle</th>
</TR>
 </thead>
<?php
	while($summarydata = mysql_fetch_array($query)) 
	{
	$ctype=$summarydata['contenttype'];
	
	if(empty($ctype))
	{
	$ctype='OBD';
	}
	?>
	<TR height="30">
		<?php if($uploadfor!=='dtmf'){ ?><TD><?php if(empty($summarydata['menu_id'])){ echo '--';} else {echo $summarydata['menu_id'];}?></TD> <?php }?>
			<TD><?php echo $summarydata['song_category'];?></TD>
			<?php if($uploadfor!=='dtmf'){ ?><TD><?php echo $summarydata['song_index'];?></TD><?php }?>
			<TD><?php
			if($uploadfor=='dtmf'){
			echo $summarydata['DTMF'];
			}
			else
			{
			echo $summarydata['songname'];
			}
			?></TD>
			<TD><?php echo $summarydata['contentid'];?></TD>
			<?php if($uploadfor!=='dtmf'){ ?><TD><?php echo $ctype;?></TD><?php }?>
			<TD><?php echo $summarydata['status'];?></TD>
			<TD><?php 
			if(empty($summarydata['ussd_string']))
			{
			echo '*829#';
			}
			else
			{
			echo $summarydata['ussd_string'];
			}			
			?></TD>
			<TD><?php 
			$circle_info=array('GUJ'=>'Gujarat','BIH'=>'Bihar','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','MUM'=>'Mumbai','PAN'=>'ALL');
			echo $circle_info[$summarydata['circle']];?></TD>
					
	 </TR>
<?php
}
echo "</TABLE>";
}
mysql_close($con);
?>