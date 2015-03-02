<?php
session_start();
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

$case = $_GET['case'];

switch($case) {
	case 'insert': $operator=$_GET["op"];
				$service=$_GET["service"];
				$circle=$_GET["circle"];
				$msisdn=$_GET["msisdn"];
				$dnis=$_GET["dnis"];
				$code=explode("-",$dnis);
				$query="select count(*) from master_db.tbl_master_whitelist where ANI=$msisdn and ShortCode=$code[0] and LongCode=$code[1] and circle='".$circle."'";
				$queryresult=mysql_query($query);
				$row= mysql_fetch_array($queryresult);
				if($row[0] !='0') {
				 echo "already exits-".$msisdn."-".$code[0]."-".$code[1];
				} else {
					$insertQuery="insert into  master_db.tbl_master_whitelist values($msisdn,$code[0],$code[1],'".$operator."','$circle',$service)";
					$queryresult=mysql_query($insertQuery);
					echo "done";
				}
	break;
	case 'dnis': $serviceId=$_GET["sId"]; 
				$query3="select count(*) from master_db.tbl_operator_dnis where operator IN ('Uninor') and service_id='".$serviceId."' ";  //('docomo','Uninor')
				$queryresult3=mysql_query($query3);
				$row3= mysql_fetch_row($queryresult3);

				$query4="select DNIS,LongCode from master_db.tbl_operator_dnis where operator IN ('Uninor') and service_id='".$serviceId."'";
				$queryresult4=mysql_query($query4);
				for($i=0;$i<$row3[0];$i++) {
					$row4[$i]= mysql_fetch_array($queryresult4);
				} //print_r($row4);?><div>
				<select name="shortcode" id="dnis" onchange="ShowItem()" style='display:block;'>
					<option value='0- '>Select DNIS</option>
					<?php for($k=0;$k<$row3[0];$k++) {
						$dnisValue=$row4[$k]['DNIS']."-".$row4[$k]['LongCode']; ?>
					<option value='<?php echo $dnisValue ?>'><?php echo $row4[$k]['DNIS'] ?></option>
					<?php }  ?>
				</select></div>
				<?php				
		break;
} 

?>