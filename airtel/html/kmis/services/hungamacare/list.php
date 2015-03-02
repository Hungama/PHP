<?php

include("config/dbConnect.php");
if($_REQUEST['action']=='getDnis')
{
	$query3="select DNIS,LongCode from master_db.tbl_operator_dnis where service_id='".$_REQUEST['service1']."'";
	
	$queryresult3=mysql_query($query3);
	echo "<select name='shortcode' id='dnis' onchange='ShowItem()'>";
	echo "<option value=0>Select Dnis</option>";
	while($row3= mysql_fetch_array($queryresult3))
	{
		$longValue=$row3[0]."-".$row3[1];
		echo "<option value='".$longValue."'>$row3[0]</option>";
		//echo "test";
	}
	echo "</select>";
	exit;
}

$service=$_GET["service"];
$circle=$_GET["circle"];
$msisdn=$_GET["msisdn"];
$dnis1=$_GET["dnis"];
$operator=$_GET["operator"];
$code=explode("-",$dnis1);
$action=$_GET["action"];
$serviceName=$_GET["sN"];
$s1code=$code[0];
$dnis=$code[0];

if($s1code==56666 || $s1code==56660)
		$s1code=substr($s1code,0,4);
if(strlen($s1code)>5)
	$s1code=substr($s1code,0,5);
	
$query="select count(*) from master_db.airtel_longcode_routing where ani=$msisdn";
$queryresult=mysql_query($query);
$row= mysql_fetch_array($queryresult);

if($row[0] !='0' && $action=='getRecord')
{
	$query12="Delete from master_db.tbl_master_whitelist where  ANI='$msisdn'";
 	$queryresult=mysql_query($query12);
	$delQuery = "Delete from master_db.airtel_longcode_routing where ani='$msisdn'";
 	$delResult = mysql_query($delQuery);

    $insertQuery="insert into  master_db.tbl_master_whitelist values('$msisdn','$dnis','$dnis','$operator','$circle','$service')";
	$queryresult1=mysql_query($insertQuery); 
	
	$sdataQ = "SELECT service_name FROM master_db.tbl_whlservice_list WHERE service_id='".$service."'";
	$result = mysql_query($sdataQ);
	list($sname) = mysql_fetch_array($result);

	$newquery="insert into master_db.airtel_longcode_routing(ani,path,DNIS) values ('".$msisdn."', '".$sname."','".$dnis."')";
	mysql_query($newquery);

	//echo "already exits-".$msisdn."-".$code[0]."-".$code[1]."-".$operator."-".$service."-".$circle."-";
	echo "user update successfully";
	exit;
} elseif($row[0] =='0' && $action=='getRecord') {
	$insertQuery="insert into  master_db.tbl_master_whitelist values($msisdn,$code[0],$code[1],'$operator','".strtolower($circle)."',$service)";
	$queryresult=mysql_query($insertQuery);
	
	$sdataQ = "SELECT service_name FROM master_db.tbl_whlservice_list WHERE service_id='".$service."'";
	$result = mysql_query($sdataQ);
	list($sname) = mysql_fetch_array($result);

	$newquery="insert into master_db.airtel_longcode_routing(ani,path,DNIS) values ('".$msisdn."', '".$sname."','".$dnis."')";
	mysql_query($newquery);
	//echo $newquery;
	echo "User Created Successfully";
	exit;
}

mysql_close($dbConn); 
?>