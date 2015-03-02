<?php
session_start();
//include("config/dbConnect.php");
require_once("language.php");
	require_once("incs/db.php");
	require_once("base.php");
	$uploadfor = $_GET['type'];
$listservices=$_SESSION["access_service"];
$services = explode(",", $listservices);
//print_r ($services);
	//active,deactive,topup,EVENT
		$uploadvaluearray = array('no_call_activation'=>'No call since activation','entire_active_base'=>'Entire active base','mou'=>'Mou','call_hang_up'=>'Call hang up');
	$get_query="select id,message,status,added_on,circle,scheduledDate,duration,category,service_id,daily_msg from ";
	$get_query .=" master_db.tbl_sms_engagement nolock where type='$uploadfor' order by id desc limit 20";
	
	$query = mysql_query($get_query,$dbConn);
$viewhistoryfor=ucfirst($uploadvaluearray[$uploadfor]);
	$numofrows=mysql_num_rows($query);
if($numofrows==0)
{

?>
<div width="85%" align="left" class="txt">
<div class="alert alert-block">
<?php// echo ALERT_NO_RECORD_FOUND;?>
<h4>Ooops!</h4>Hey,  we couldn't seem to find any record.
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
echo " Displaying last ".$limit." records";

?>
</i>
</div></div><center>
<TABLE class="table table-condensed table-bordered">
   <thead>
  <TR height="30">
	<th align="left"><?php echo 'ID';?></th>
	<th align="left"><?php echo 'Service Name';?></th>
	<th align="left"><?php echo 'Message';?></th>
	<th align="left"><?php echo 'Added On';?></th>
	<th align="left"><?php echo 'Circle';?></th>
	<?php if($uploadfor=='active_base')
		{?>
	<th align="left"><?php echo 'Schedule Date';?></th>
	<?php }
	if($uploadfor!='active_base' and $uploadfor!='call_hang_up')
	{ ?>
	<th align="left"><?php echo 'Duration';?></th>
	<?php }
	if($uploadfor=='call_hang_up')
	{ ?>
	<th align="left"><?php echo 'Category';?></th>
	<?php } ?>
	<th align="left"><?php echo 'Status';?></th>
</TR>
 </thead>
<?php
	while($summarydata = mysql_fetch_array($query)) 
	{
					if($summarydata['status']=='1') 
					{
					$status='<span class="label label-success">Active</span>';
					}
					else
                   {
		           	$status='<span class="label label-warning">Inactive</span>';
					}
$servicelistarray=Array ('1001'=>'Tata DoCoMo - Endless Music','1009'=>'Tata DoCoMo - Miss Riya','1409'=>'Uninor - Miss Riya','1408'=>'Uninor - Sports Unlimited','1513'=>'Airtel - MND','1517'=>'Airtel Spoken English'); 
// $sname_ks = array_flip($serviceArray);
		?>
		<TR height="30">
		<TD><?php echo $summarydata['id'];?></TD>
		<TD><?php echo $servicelistarray[$summarydata['service_id']];?></TD>
		<TD><?php echo $summarydata['message'];?></TD>
		<TD><?php 
		echo date('j-M \'y',strtotime($summarydata['added_on'])); ?></TD>
		<TD><?php echo $summarydata['circle'];?></TD>
		<?php 
		if($uploadfor=='active_base')
		{ 
			echo '<TD>';
			if($summarydata['daily_msg'] == 1){
                             echo 'Daily';
                        }else{
                            echo date('j-M \'y',strtotime($summarydata['scheduledDate']));
                                                }
			echo '</TD>';
	}

?>
		<?php
	if($uploadfor!='active_base' and $uploadfor!='call_hang_up')
	{ ?><TD><?php if(!empty($summarydata['duration'])){echo $summarydata['duration'];} else { echo 'NA';}?></TD>
	<?php
	}
	
	if($uploadfor=='call_hang_up')
	{ ?>
	<TD><?php if(!empty($summarydata['category'])){echo $summarydata['category'];} else { echo 'NA';}?></TD>
	<?php }?>
		<TD><?php echo $status;?></TD>	
	 </TR>
<?php
}
echo "</TABLE>";
}
mysql_close($dbConn);
?>