<?php 
include("config/dbConnect.php");

$serviceId=$_GET['sid'];
$priceQ = mysql_query("SELECT iAmount,Plan_id from master_db.tbl_plan_bank where S_id=".$serviceId." and fall_back_seqs=0 order by iAmount");
?>
<div>&nbsp;&nbsp;<select name="pricepoint1" id="pricepoint" class='in'>
	<option value="">Select Price Point</option>
	<?php while($row = mysql_fetch_array($priceQ)) { ?>
		<option value="<?php echo $row['Plan_id'];?>"><?php echo "Rs.".$row['iAmount'];?></option>
	<?php } ?>
</select>