<?php
include_once './dbconnect.php';
$msisdn=$_REQUEST['msisdn'];

$table=array('tbl_jbox_subscription'=>'reliance_hungama',
'tbl_mtv_subscription'=>'reliance_hungama','tbl_cricket_subscription'=>'reliance_cricket');

foreach($table as $key=>$value)
{
	$query="select count(*) from $value.$key where ani='$msisdn'";
	$queryresult=mysql_query($query);
}
	for(i=0;i<2;i++)
{
	$row[i] = mysql_fetch_row($queryresult);
	print_r($row[i]);
	echo "<br>";
	//$abc[i]=$row;
	
}
	
	
	//print_r($row);
	//echo "<br>";
	//$result[i]=$strVal;
	
	//echo $result0];
	//echo $result[1]


?>

