<?php
session_start();
//include("config/dbConnect.php");
	require_once("language.php");
	require_once("incs/db.php");
	require_once("base.php");
	$uploadfor = $_GET['type'];
	//active,deactive,topup,EVENT
	$uploadvaluearray = array('active'=>'Activation','deactive'=>'Deactivation');
	//$uploadedby='uni.bulk';
	$uploadedby=$_SESSION[loginId];
	//check for existing session
if(empty($_SESSION['loginId_voda']))
{
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
		<div class=\"alert alert-danger\">Your session has timed out. Please login again.</div></div>";
exit;
}
else
{
$uploadeby_voda=$_SESSION['loginId_voda'];
}

$get_query="select batch_id,channel,file_name,added_on,upload_for,status,total_file_count,service_id,price_point,success_count,failure_count,InRequest from vodafone_hungama.bulk_upload_history nolock where added_by='".$uploadeby_voda."' and upload_for='".$uploadfor."' order by batch_id desc limit 20";

	$query = mysql_query($get_query,$dbConn);
$viewhistoryfor=ucfirst($uploadvaluearray[$uploadfor]);
	$numofrows=mysql_num_rows($query);
if($numofrows==0)
{

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
<div class="alert alert" ><a href="javascript:void(0)" onclick="javascript:viewUploadhistory('<?php echo $uploadfor;?>')" id="Refresh"><i class="icon-refresh"></i></a>
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
  <th align="left"><?php echo TH_BATCHID;?></th>
	<th align="left"><?php echo TH_FILENAME;?></th>
	<th align="left"><?php echo TH_ADDEDON;?></th>
	<th align="left"><?php echo TH_SERVICENAME;?></th>
	<th align="left"><?php echo TH_UPLOADFOR;?></th>
	<!--th align="left"><?php echo TH_PRICEPOINT;?></th-->
	<th align="left"><?php echo TH_MODE;?></th>
	<th align="left"><?php echo TH_TOTALCOUNTINFILE;?></th>
	<th align="left"><?php echo TH_FILESTATUS;?></th>
	<th align="left"><?php echo "In Success #'s";?></th>
	<th align="left"><?php echo "In Failure #'s";?></th>
	<th align="left"><?php echo "In Request #'s";?></th>
	<th align="left"><?php echo "Action";?></th>
</TR>
 </thead>
<?php

	while(list($batchId, $channel,$file_name, $datetime, $upload_for,$status, $totalCount,$serviceId,$planId,$success_count,$failure_count,$request_count) = mysql_fetch_array($query)) {
	$explodedData=explode($batchId."_",$file_name);		
		$UploadedFile = substr($explodedData[0], 0, -1).".txt"; 
		$fileUrl="http://203.199.126.129/hungamacare/bulkuploads/".$serviceId."/".$file_name.".txt";
		$sname_ks = array_flip($serviceArray);	
	?>
	  <TR height="30">
	  <TD><?php echo $batchId; ?></TD>
		<TD><?php if($status==2) { ?><a href='<?php echo $fileUrl;?>' target="_blank"><?php echo $UploadedFile; ?></a><?php } else { echo $UploadedFile; }?></TD>
		<TD><?php if(!empty($datetime)){echo date('j-M \'y g:i a',strtotime($datetime));} ?></TD>
	
	<TD bgcolor="#FFFFFF">
	<?php
	if(!empty($Service_DESC[$sname_ks[$serviceId]]['Name']))
		{
		echo $Service_DESC[$sname_ks[$serviceId]]['Name'];
		}
		else
		{
		echo $sname_ks[$serviceId];
		}
		?>
	</TD>
		<TD bgcolor="#FFFFFF"><?php echo ucfirst($uploadvaluearray[$upload_for]); ?></TD>
		<TD bgcolor="#FFFFFF"><?php echo $channel; ?></TD>
		
		<?php if(isset($status) && $status==0)
				$fileStatus='<span class="label">Queued</span>';
			else if($status==1)
			{
			if($upload_for=='deactive')
			{
				$fileStatus='<span class="label label-success">Completed</span>';
				}
				else
				{
				$fileStatus='<span class="label label-warning">Processing</span>';
				}
				}
			else if($status==2 || $status==3) 
				$fileStatus='<span class="label label-success">Completed</span>';
			else if($status==5) 
				$fileStatus='<span class="label label-warning">Deleted</span>';
			if(!isset($totalCount))
				$totalCount="Not availbale";
			if($status==2) $rejected_count = $totalCount - ($failure_count+$success_count+$request_count);
			else $rejected_count=0;			
			
		?>
		<TD><?php echo $totalCount; ?></TD>
		<TD><?php echo $fileStatus; ?></TD>
		
		<TD><?php echo $success_count?$success_count:"0";?></TD>
		<TD><?php echo $failure_count?$failure_count:"0";?></TD>
		<TD><?php echo $request_count?$request_count:"0";?></td>
		<TD>
		<?php 
		if($status==0){?> 
		<button class="btn btn-danger" style="float:right"  onclick="javascript:stopBulkFile('<?php echo $batchId;?>','<?php echo 'bulk_history';?>')">Stop</button>
		<?php } else {echo 'NA';}
		?></TD>
	  </TR>	
<?php
}
echo "</TABLE>";
}
mysql_close($dbConn);
?>