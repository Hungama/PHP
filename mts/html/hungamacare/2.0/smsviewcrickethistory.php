<?php
session_start();
require_once("language.php");
require_once("incs/db.php");
require_once("base.php");
$msg="";
$uploadfor = $_GET['type'];
$uploadfor='sms';
$uploadvaluearray = array('sms'=>'SMS');
$uploadedby=$_SESSION[loginId];
if(empty($_SESSION['loginId_mts']))
{
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">Your session has timed out. Please login again.</div></div>";
exit;
}
else
{
$uploadeby_mts=$_SESSION['loginId_mts'];
}
$get_query = "select id,message,type,waplink,datetime,status,end_time,start_time,filename,senderId,totalCount,success,pending from MTS_cricket.tbl_msg_history where status!='5' order by id desc limit 30";
$query = mysql_query($get_query,$dbConn);
$viewhistoryfor=ucfirst($uploadvaluearray[$uploadfor]);
$numofrows=mysql_num_rows($query);
if($numofrows==0)
{
$i=1;
?>
<div width="85%" align="left" class="txt">
<div class="alert alert-block">
<?php// echo ALERT_NO_RECORD_FOUND;?>
<h4>Ooops!</h4>Hey,  we couldn't seem to find any record of uploads for <?php echo ucfirst($uploadvaluearray[$uploadfor]); ?>
</div>
</div>
<?php
}
else
{
?>
<center><div width="85%" align="left" class="txt">
<div class="alert alert" ><a href="javascript:void(0)" onclick="javascript:viewSMSUploadhistory('<?php echo $uploadfor;?>')" id="Refresh"><i class="icon-refresh"></i></a>
<?php 
$limit=20;
//echo ALERT_VIEW_UPLOAD_HISTORY;
echo "Upload history for ".ucfirst($uploadvaluearray[$uploadfor])." Displaying last ".$limit." records";

?>
</i>
</div></div><center>
<TABLE class="table table-condensed table-bordered">
   <thead>
  <TR height="30">
  <th align="left">S.No</th>
  <th align="left">BatchId</th>
	<!--th align="left">Type</th-->
	<th align="left">Message</th>
	<th align="left">SenderId</th>
	<th align="left">Added On</th>
	<th align="left">Start Date</th>
	<th align="left">End Date</th>
	<th align="left">Status</th>
	<th align="left"><?php echo 'Action'; ?></th>
</TR>
 </thead>
<?php
$i=1;
while($row= mysql_fetch_array($query)) {
$status=$row['status'];
				if($status==0)
				$fileStatus='<span class="label">Queued</span>';
				else if($status==2)
				$fileStatus='<span class="label label-success">Completed</span>';
				else if($status==5 || $status==1)
				$fileStatus='<span class="label label-warning">Stopped</span>';
				
?>
<TR height="30">
<TD><?php echo $i;?></TD>
<TD><?php echo $row['id'] ;?></TD>
<!--TD><?php echo $row['type'] ;?></TD-->
<TD><?php echo $row['message'] ;?></TD>
<TD><?php echo $row['senderId'] ;?></TD>
<TD><?php if(!empty($row['datetime'])){echo date('j-M \'y g:i a',strtotime($row['datetime']));} ?></TD>
<TD><?php if(!empty($row['start_time'])){echo date('j-M \'y g:i a',strtotime($row['start_time']));} ?></TD>
<TD><?php if(!empty($row['end_time'])){echo date('j-M \'y g:i a',strtotime($row['end_time']));} ?></TD>
<TD><?php echo $fileStatus ;?></TD>
<TD bgcolor="#FFFFFF" align="center">
<?php 
if ($row['status'] == 0) { ?> 
<button class="btn btn-danger" style="float:right"  onclick="javascript:stopBulkFile('<?php echo $row['id']; ?>','<?php echo 'del'; ?>')">Delete</button>
<?php
 } else {
echo 'NA';
}
?></TD>								
	  </TR>	
<?php
$i++;
}
echo "</TABLE>";
}
mysql_close($dbConn);
?>