<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$flag=0;
error_reporting(0);
if(isset($_REQUEST['date'])) { 
	$date= $_REQUEST['date'];
		$flag=1;
} else {
	$date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}


$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',' '=>'Others');

$TisconQuery = "select Date,Service,Circle,Type,Value,Revenue from Hungama_Tatasky.tbl_dailymis 
where date = '".$date."'   and service='EnterpriseMcDwOBD' and type in('DD_PARTY_A','UU_DD_PARTY_B','UU_DD_PARTY_A','OBD_TF_B')";


$result = mysql_query($TisconQuery,$dbConn);

$delQuery = "DELETE FROM misdata.dailymis WHERE Date='".$date."' 
  and service='EnterpriseMcDwOBD' and type in('DD_PARTY_A','UU_DD_PARTY_B','UU_DD_PARTY_A','OBD_TF_B')";

$delResult = mysql_query($delQuery,$LivdbConn);
$delResult = mysql_query($delQuery,$dbConn);

while($row = mysql_fetch_array($result)) {
	$serviceName = trim($row['Service']);
	$circleId = trim($row[2]);
	$circleName = $circleId;
	if(!$circleName) $circleName ='Others';
	if($row[5]=="") $row[5]=0;
	if($serviceName && $row[3]) {
		$insertQuery = "INSERT INTO misdata.dailymis VALUES ('".$date."','".$serviceName."','".$circleName."', '".$row[3]."', '".$row[4]."','".$row[5]."')";
		$result1 = mysql_query($insertQuery,$LivdbConn);
		//save to inhouse 224 db
		$result1 = mysql_query($insertQuery,$dbConn);
	}
}
echo "Done";

?>
