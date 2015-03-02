<?php 
session_start();
//include("config/dbConnect.php");
require_once("incs/db.php");
$userId=$_SESSION['usrId'];
$case = $_GET['case']; 

if($case == 'mode') {	
	$auto_types = $_GET['auto_types']; 
	$type=$_GET['type'];
	
	$service_id = $_GET['sid'];
	$caseValueResult = mysql_query("SELECT id FROM master_db.tbl_interface_type_master WHERE value='".$type."'",$dbConn);
		list($caseValue) = mysql_fetch_array($caseValueResult);
		//$modeQuery = "SELECT mode,value FROM master_db.tbl_interface_channel WHERE service_id like '%".$service_id."%' and enableFor='".$caseValue."' order by mode ASC";
		$modeQuery = "SELECT mode,value FROM master_db.tbl_interface_channel WHERE (service_id like '%,".$service_id."' or service_id like '".$service_id.",%' or service_id like '%,".$service_id.",%' or service_id='".$service_id."') and enableFor='".$caseValue."' order by mode ASC";

		$modeResult = mysql_query($modeQuery,$dbConn);
		$numRow = mysql_num_rows($modeResult);
		if($numRow) {
				if($type=='autochurn_renewal') {$type=$auto_types;}
		?>
		<select id="channel" name="channel" class="in" onchange="SetPricePoint('<?php echo $type;?>','<?php echo $service_id;?>');">
			<option value="">-- Select Mode --</option>
			<?php while($row = mysql_fetch_array($modeResult)) {
				echo '<option value="'.$row['value'].'">'.$row['mode'].'</option>';	
			}
			echo "</select>";
		} else {  
			echo '<select id="channel" name="channel" class="in">';
				echo '<option value="">-- Modes Not Available --</option>';	
			echo "</select>";
		}
	
}
elseif($case == 'price') {
	$type=$_GET['type'];
	$service_id = $_GET['sid'];

	$priceQuery = "select plan_id,iamount,iValidty,disc,intFallBack,planFor from master_db.tbl_plan_bank where sname=".$service_id." and planFor like '%".$type."%' order by iamount";
		$priceResult = mysql_query($priceQuery,$dbConn);
		$numPRow = mysql_num_rows($priceResult);
		if($numPRow) {
		
			echo '<select id="price" name="price" class="in">';
			echo '<option value="">-- Select Price Point --</option>';	
			while($row = mysql_fetch_array($priceResult)) {
$planforstring = $row['planFor'];
$findme   = 'ticket';
$pos = strpos($planforstring, $findme);
$isticket='';
if ($pos === false)
{
$isticket='No';
}
else
{
$isticket='Yes';
}

				$fallbackData = $row['intFallBack'];
				if($fallbackData) { 
					$fallBackDataArray = explode(",",$fallbackData);
					//print_r($fallBackDataArray);
					for($j=0;$j<count($fallBackDataArray);$j++) {
						echo "<option value='".$row['plan_id']."-".$fallBackDataArray[$j]."'>Rs. ".$fallBackDataArray[$j]." / ".$fallBackDataArray[$j]." Day(s)</option>";
					}
				} else {
					if($type == "active") 
					{if($isticket=='Yes') $validType=" Ticket "; else $validType="/ ".$row['iValidty']." Day(s)";}
					elseif($type == "topup") $validType="/ ".$row['iValidty']." Minutes";
					elseif($type == "renewal")
					{
					if($row['plan_id']=='64' || $row['plan_id']=='66' || $row['plan_id']=='68')
					{
					$pstatus=" (Splecial@Renewal)";
					}
					else
					{
					$pstatus="";
					}
					if($isticket=='Yes') $validType=" Ticket "; else $validType="/ ".$row['iValidty']." Day(s)";					
					}
					
					echo '<option value="'.$row['plan_id'].'"> Rs. '.$row['iamount'].$validType.$pstatus.'</option>';	
				}
			}
			echo "</select>";
		} else {  
			echo '<select id="price" name="price" class="in">';
			echo '<option value="">-- Price Not Available --</option>';	
			echo "</select>";
		}
	}
?>