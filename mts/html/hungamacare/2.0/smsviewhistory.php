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
		//check for existing session$_SESSION['loginId_mts']
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
	$get_query = "select m.batch_id,m.file_name,m.added_by,m.added_on,m.total_file_count,m.service_id,md.message,m.status from master_db.bulk_message_history m INNER JOIN master_db.tbl_message_data md ON md.msg_id=m.msg_id order by m.added_on desc limit 30";
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
	<th align="left"><?php echo TH_TOTALCOUNTINFILE;?></th>
	<th align="left"><?php echo TH_FILESTATUS;?></th>
	<th align="left"><?php echo 'Action'; ?></th>
</TR>
 </thead>
<?php
while(list($batchId,$file_name,$addedby, $addedon,$total_count, $service_id, $message,$status) = mysql_fetch_array($query)) {
	
/*foreach ($serviceArray as $key => $value){
if($value==$serviceId)
{
$servicename=$key;
 break;
 }
}
*/
$sname_ks = array_flip($serviceArray);

	?>
	  <TR height="30">
	  <TD><?php echo $batchId; 
	  $fileurl='http://10.130.14.107/hungamacare/smsbulkuploads/'.$service_id.'/'.$file_name.'.txt';
	  ?></TD>
		<TD>
		<a href="<?php echo $fileurl;?>" target="_blank"><?php echo $file_name;?></a>
		
		</TD>
		<TD><?php if(!empty($addedon)){echo date('j-M \'y g:i a',strtotime($addedon));} ?></TD>
	
	<TD><?php echo $Service_DESC[$sname_ks[$service_id]]['Name'];
	?></TD>
		<TD><?php echo $message; ?></TD>
		
		<?php
				if(isset($status) && $status==0)
				$fileStatus='<span class="label">Queued</span>';
				else if($status==1)
				$fileStatus='<span class="label label-success">Completed</span>';
				else if($status==5)
				$fileStatus='<span class="label label-warning">Stopped</span>';
					
			if(!isset($totalCount))
				$totalCount="NA";			
		?>
		<TD><?php echo $total_count; ?></TD>
		<TD><?php echo $fileStatus; ?></TD>	
		<TD bgcolor="#FFFFFF" align="center">
                    <?php if ($status == 0) { ?> 
                        <button class="btn btn-danger" style="float:right"  onclick="javascript:stopBulkFile('<?php echo $batchId; ?>','<?php echo 'bulk_sms_history'; ?>')">Stop</button>
                        <?php
                    } else {
                        echo 'NA';
                    }
                    ?></TD>								
	  </TR>	
<?php
}
echo "</TABLE>";
}
mysql_close($dbConn);
?>