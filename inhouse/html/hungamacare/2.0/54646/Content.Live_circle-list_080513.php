<?php
require_once("db_connect_livecontent.php");
$servicename=$_REQUEST['sname'];
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','PUB'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAY'=>'Haryana');
$sql_getcirclelist = mysql_query("select value from base where type = 'map_details' and service='$servicename'",$dbConn_218);
$maincirclearray=array();
$isfound=mysql_num_rows($sql_getcirclelist);
if($isfound==0)
{
echo "No Circle found";
}
else
{
$data=mysql_fetch_array($sql_getcirclelist);
$infofilename='../../cmis/maps/'.$data['value'];
require_once($infofilename);
//print_r ($Sheet);
foreach($circle_info as $circle_id=>$circle_val) {
if(in_array($circle_val,$Sheet)) {

$maincirclearray[$circle_id] = $circle_val;
}  
}
asort($maincirclearray);
?>
	<option value="">Select Circle</option>
			<?php
			foreach($maincirclearray as $circle_id=>$circle_val) {
				?>
					<option value=<?php echo $circle_id?>><?php echo $circle_val;?></option>
<?php
}  ?>
<?php

}
mysql_close($dbConn_218);
?>