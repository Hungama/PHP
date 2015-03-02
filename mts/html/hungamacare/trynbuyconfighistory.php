<center><div width="85%" align="left" class="txt">
<div class="alert alert" ><a href="javascript:void(0)" onclick="javascript:viewUploadhistory('<?php echo $uploadfor;?>')" id="Refresh"><i class="icon-refresh"></i></a>
<?php 
$limit=20;
//echo ALERT_VIEW_UPLOAD_HISTORY;
echo "Config history for ".ucfirst($uploadvaluearray[$uploadfor])." Displaying last ".$limit." records";

?>
</i>
</div></div></center>
<TABLE class="table table-condensed table-bordered">
   <thead>
  <TR height="30">
	<th align="left"><?php echo 'ID';?></th>
	<th align="left"><?php echo 'Auto_rew_deact';?></th>
	<th align="left"><?php echo TH_ADDEDON;?></th>
	<th align="left"><?php echo TH_SERVICENAME;?></th>
	<th align="left"><?php echo TH_UPLOADFOR;?></th>
	<th align="left"><?php echo TH_MODE;?></th>
	<th align="left"><?php echo 'tnb_days';?></th>
	<th align="left"><?php echo 'tnb_mins';?></th>
	<th align="left"><?php echo 'pre_sms';?></th>
	<th align="left"><?php echo "circle";?></th>
	<th align="left"><?php echo 'Action';?></th>
</TR>
 </thead>
<?php
	while(list($id,$status,$auto_rew_deact,$serviceId,$tnb_days,$tnb_mins,$pre_sms,$mode,$circle,$reqs_time) = mysql_fetch_array($query)) {
	
foreach ($serviceArray as $key => $value){
if($value==$serviceId)
{
$servicename=$key;
 break;
 }
}
	
	?>
	  <TR height="30">
	  <TD><?php echo $id; ?></TD>
	  <TD><?php echo $auto_rew_deact; ?></TD>
		<TD><?php if(!empty($reqs_time)){echo date('j-M \'y g:i a',strtotime($reqs_time));} ?></TD>
		<TD><?php echo $Service_DESC[$servicename]['Name'];?></TD>
		<TD><?php echo ucfirst($uploadvaluearray[$upload_for]); ?></TD>
		<TD><?php echo $mode; ?></TD>
		<TD><?php echo $tnb_days; ?></TD>
		<TD><?php echo $tnb_mins; ?></TD>
		<TD><?php echo $pre_sms; ?></TD>
		<TD><?php echo $circle; ?></TD>
		<TD>
		<?php 
		if($status==0){?> 
		<button class="btn btn-danger" style="float:right"  onclick="javascript:stopBulkFile('<?php echo $id;?>','<?php echo 'tryandbuy';?>')">Stop</button>
		<?php } else {echo 'NA';}
		?></TD>
		
	  </TR>	
<?php
}
echo "</TABLE>";
}