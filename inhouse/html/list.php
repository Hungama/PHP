<?php

include_once("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

$service=$_GET["service"];
$circle=$_GET["circle"];
$msisdn=$_GET["msisdn"];
$dnis=$_GET["dnis"];
$code=explode("-",$dnis);

$query="select count(*) from master_db.tbl_master_whitelist where ANI=$msisdn and ShortCode=$code[0] and LongCode=$code[1]";

$queryresult=mysql_query($query);
$row= mysql_fetch_array($queryresult);

if($row[0] !='0')
{
	 echo "already exits-".$msisdn."-".$code[0]."-".$code[1];
}
else
{
	$insertQuery="insert into  master_db.tbl_master_whitelist values($msisdn,$code[0],$code[1],'docomo','$circle',$service)";
	$queryresult=mysql_query($insertQuery);
	echo "done";

}

/*else


$delete=$_GET["delete"];
if($delete=='updateRecord')
{
	$query1="delete from master_db.tbl_master_whitelist where  ANI='8527000779' and ShortCode='546460' and LongCode='66291050'";
	//$queryresult1=mysql_query($query1);
}
*/

?>