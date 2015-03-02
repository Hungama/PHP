<?php
session_start();
//include("config/dbConnect.php");
require_once("language.php");
	require_once("incs/db.php");
	require_once("base.php");
//	$serviceId = $_GET['sid'];
	$uploadfor = $_GET['type'];
	//active,deactive,topup,EVENT
	$uploadvaluearray = array('active'=>'Activation','deactive'=>'Deactivation','topup'=>'Top-Up','renewal'=>'Renewal');
	//$uploadedby='uni.bulk';
	$uploadedby=$_SESSION[loginId];
	//added_by='$_SESSION[loginId]'
	$get_query="select id,status,batch_id,channel,file_name,added_on,upload_for,total_file_count,service_id,price_point,success_count,failure_count,InRequest from billing_intermediate_db.bulk_upload_history where added_by='".$uploadedby."' and upload_for='".$uploadfor."' order by added_on desc limit 20";
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
	<th align="left"><?php echo 'Success Count';?></th>
	<th align="left"><?php echo 'Failure Count';?></th>
</TR>
 </thead>
<?php
	while(list($id,$status,$batchId, $channel,$file_name, $datetime, $upload_for, $totalCount,$serviceId,$planId,$success_count,$failure_count,$request_count) = mysql_fetch_array($query)) {
	
		foreach ($serviceArray as $key => $value){
if($value==$serviceId)
{
$servicename=$key;
 break;
 }
}
	
	?>
	  <TR height="30">
	  <TD><?php echo $batchId; ?></TD>
		<TD><?php if($status==3) { ?><a href='http://10.130.14.107/hungamacare/bulkuploads/<?php echo $serviceId ?>/log/<?php echo $file_name; ?>' target="_blank"><?php echo $file_name; ?></a><?php } else { echo $file_name; }?></TD>
		<TD><?php if(!empty($datetime)){echo date('j-M \'y g:i a',strtotime($datetime));} ?></TD>
	
	<TD bgcolor="#FFFFFF"><?php echo $Service_DESC[$servicename]['Name'];?></TD>
		<TD bgcolor="#FFFFFF"><?php echo ucfirst($uploadvaluearray[$upload_for]); ?></TD>
		<TD bgcolor="#FFFFFF"><?php echo $channel; ?></TD>
		
		<? if(isset($status) && $status==0)
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
		
			if(!isset($totalCount))
				$totalCount="Not availbale";
			if($status==2) $rejected_count = $totalCount - ($failure_count+$success_count+$request_count);
			else $rejected_count=0;			
			
		?>
		<TD><?php echo $totalCount; ?></TD>
		<TD><?php echo $fileStatus; ?></TD>
		
		<TD><?php echo $success_count?$success_count:"NA"; ?></TD>
		<TD><?php echo $failure_count?$failure_count:"NA"; ?></TD>
		<!--TD><?php echo $request_count?$request_count:"-"; ?></TD>
		<TD><?php echo $rejected_count?$rejected_count:"-"; ?></TD-->
		
	  </TR>	
<?php
}
echo "</TABLE>";
}
mysql_close($dbConn);
?>