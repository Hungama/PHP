<?php 
$serviceId=$_GET['sid'];
if($serviceId=="1511") {
	$planArray = array('29'=>'Rs. 2/day', '46'=>'Rs. 30/month');
} elseif($serviceId=="1507") { 
	$planArray = array('28'=>'Rs. 2/day', '47'=>'Rs. 30/month');
} 
?>
<div>&nbsp;&nbsp;<select name='subtype' id='subtype'>
<option value="">Select Subscription Type</option>
<?php foreach($planArray as $key=>$row) { ?>
	<option value="<?php echo $key?>"><?php echo $planArray[$key];?></option>
<?php }?>
</select>