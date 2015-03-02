<?php
session_start();
//include("config/dbConnect.php");
require_once("language.php");
	require_once("incs/db.php");
	require_once("base.php");
//	$serviceId = $_GET['sid'];
	$uploadfor = $_GET['type'];
	$uploadfor='sms';
	$uploadvaluearray = array('active'=>'Activation','deactive'=>'Deactivation','topup'=>'Top-Up','renewal'=>'Renewal','sms'=>'SMS');
	//$uploadedby='uni.bulk';
	$uploadedby=$_SESSION[loginId];
		//check for existing session$_SESSION['loginId_airtel']
if(empty($_SESSION['loginId_airtel']))
{
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
		<div class=\"alert alert-danger\">Your session has timed out. Please login again.</div></div>";
exit;
}
else
{
$uploadeby_mts=$_SESSION['loginId_airtel'];
}
	$get_query = "select m.batch_id,m.file_name,m.added_by,m.added_on,m.status,m.total_file_count,m.service_id,m.process_time,md.message,m.upload_for from master_db.bulk_message_history m INNER JOIN master_db.tbl_message_data md ON m.msg_id=md.msg_id order by m.added_on desc limit 20";
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
  <th align="left"><?php echo TH_BATCHID;?></th>
  <th align="left"><?php echo TH_FILENAME;?></th>
	<th align="left"><?php echo TH_ADDEDON;?></th>
	<th align="left"><?php echo TH_SERVICENAME;?></th>
	<th align="left"><?php echo 'Message';?></th>
	<th align="left"><?php echo 'Process Time';?></th>
	<th align="left"><?php echo 'Upload For';?></th>
	<th align="left"><?php echo TH_TOTALCOUNTINFILE;?></th>
	<th align="left"><?php echo TH_FILESTATUS;?></th>
</TR>
 </thead>
 <?php
while(list($batchId,$file_name,$addedby, $addedon,$status,$total_count, $service_id, $processtime,$message,$upload_for) = mysql_fetch_array($query)) {
$sname_ks = array_flip($serviceArrayBulk);
?>
	  <TR height="30">
	  <TD><?php echo $batchId; 
	  $fileurl='http://10.2.73.156/kmis/services/hungamacare/smsbulkuploads/'.$service_id.'/'.$file_name.'.txt';
	  ?></TD>
		<TD>
		<a href="<?php echo $fileurl;?>" target="_blank"><?php echo $file_name;?></a>
		
		</TD>
		<TD><?php if(!empty($addedon)){echo date('j-M \'y g:i a',strtotime($addedon));} ?></TD>
	
		<TD><?php 
		if(!empty($Service_DESC[$sname_ks[$service_id]]['Name']))
		{
		echo $Service_DESC[$sname_ks[$service_id]]['Name'];
		}
		else
		{
		echo $sname_ks[$service_id];
		}
		?></TD>
		<TD><?php echo $message; ?></TD>
		<TD><?php if(!empty($processtime)){echo date('j-M \'y g:i a',strtotime($processtime));} else { echo 'NA';}?></TD>
		<TD><?php echo $upload_for; ?></TD>
		<?php
				if(isset($status) && $status==0)
				$fileStatus='<span class="label">Queued</span>';
				else if($status==1 || $status==2)
				$fileStatus='<span class="label label-success">Completed</span>';
					
			if(!isset($totalCount))
				$totalCount="NA";			
		?>
		<TD><?php echo $total_count; ?></TD>
		<TD><?php echo $fileStatus; ?></TD>		
	  </TR>	
<?php
}
echo "</TABLE>";
}
mysql_close($dbConn);
?>