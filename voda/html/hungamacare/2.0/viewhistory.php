<?php
session_start();
if(isset($_SESSION['authid']))
{
	//include("config/dbConnect.php");
	require_once("incs/db.php");
	$serviceId = $_GET['sid'];
	$get_query="select batch_id,file_name,added_on,service_type,channel,price_point,upload_for,total_file_count,service_id,status,Already_subscribed,In_process from ";
	$get_query .=" master_db.bulk_upload_history nolock where added_by='$_SESSION[loginId]' and status in(0,1,2) and service_id='".$serviceId."' order by batch_id desc limit 100";

	$query = mysql_query($get_query,$dbConn);
?>
<center><div width="85%" align="left" class="txt">
<div class="alert alert-block">
<FONT COLOR="#FF0000"><B>Bulk Upload History</B></FONT>
</div>
</div><center><br/>
<TABLE align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="table table-condensed table-bordered">
   <thead>
  <TR height="30">
	<TD bgcolor="#FFFFFF" align="center"><B>File Name</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>&nbsp;Added On&nbsp;</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>&nbsp;Uploaded For&nbsp;</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>&nbsp;Price Point&nbsp;</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>&nbsp;Mode&nbsp;</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>&nbsp;Total Count&nbsp;</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>&nbsp;File Status&nbsp;</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>&nbsp;Already Subscribed&nbsp;</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>&nbsp;In Process&nbsp;</B></TD>
</TR>
 </thead>
<?php
	while($summarydata = mysql_fetch_array($query)) 
	{
		$selAmount="select iAmount from master_db.tbl_plan_bank where plan_id=".$summarydata['price_point'];
		$qryAmount = mysql_query($selAmount);
		list($getAmount) = mysql_fetch_array($qryAmount);

		$explodedData=explode($summarydata['batch_id'],$summarydata['file_name']);
		$UploadedFile = substr($explodedData[0], 0, -1).".txt"; 
		$fileUrl="http://119.82.69.212/kmis/services/hungamacare/bulkuploads/".$summarydata['service_id']."/log/out/".$summarydata['file_name'].".csv";
		$excellFile=$summarydata['file_name'].'.csv';
	?>
		<a href=<?php echo $fileUrl;?>> </a>
		<TR height="30">
		<TD bgcolor="#FFFFFF" align="center">
		<font color='blue'>
		<?php
		if($summarydata['status']==2)
		{
		?> 
		 <a href=<?php echo $fileUrl;?>>
		<?php } echo $UploadedFile;?>
			</a>
		</font></TD>
			<?php if($summarydata['status']==0) 
			$fileStatus1='Queued';	
		elseif($summarydata['status']==1) 
			$fileStatus1='Picked';
		elseif($summarydata['status']==2) 
		{
			$fileStatus1='Status Available';
			//$summarydata[10]='NA';
			$summarydata[11]='Completed';
		}
		?>	
		<TD bgcolor="#FFFFFF" align="center"><?php echo $summarydata[2];?></TD>
		<TD bgcolor="#FFFFFF" align="center"><?php echo $summarydata[6];?></TD>
		<TD bgcolor="#FFFFFF" align="center"><?php echo $getAmount;?></TD>
		<TD bgcolor="#FFFFFF" align="center"><?php echo $summarydata['channel'];?></TD>
		<TD bgcolor="#FFFFFF" align="center"><?php echo $summarydata[7];?></TD>			
		<TD bgcolor="#FFFFFF" align="center"><?php echo $fileStatus1;?></TD>
		<TD bgcolor="#FFFFFF" align="center"><?php if($summarydata[10]) echo $summarydata[10]; else echo 'NA'; ?></TD>
		<TD bgcolor="#FFFFFF" align="center"><?php if($summarydata[11]) echo $summarydata[11]; else echo 'NA'; ?></TD>
			
	 </TR>
<?php
}
echo "</TABLE>";
mysql_close($dbConn);
}
?>