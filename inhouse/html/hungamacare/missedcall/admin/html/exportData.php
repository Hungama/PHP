<?php
require_once("../../../db.php");
$StartDate=$_REQUEST['StartDate'];
$EndDate=$_REQUEST['EndDate'];
$type=$_REQUEST['type'];
if($_REQUEST['type']=='missedcall')
	{
$data_query="select ANI,date_time from Hungama_Tatasky.tbl_tata_pushobd nolock 
 where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' order by date_time desc ";
	}
else if($_REQUEST['type']=='content')
	{
$data_query="select ANI,service,duration,circle,odb_name,date_time from Hungama_Tatasky.tbl_tataobd_success_fail_details nolock 
 where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' and status=2 order by date_time desc ";
	}
	else
	{	
	exit;
	}

$data = mysql_query($data_query,$con);
$result_row=mysql_num_rows($data);

if($result_row>0){
$exportFile=$type.'_'.date('YMDhis');
$excellFile = $exportFile . ".csv";
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$excellFile");
if($_REQUEST['type']=='missedcall')
	{
echo "ANI,Datetime"."\r\n";
while($mis_array=mysql_fetch_array($data))
{
echo $mis_array['ANI'] . "," . $mis_array['date_time'] . "\r\n";
}
}
else if($_REQUEST['type']=='content')
	{
echo "ANI,Service,Duration,Circle,ObdName,Datetime"."\r\n";
while($mis_array=mysql_fetch_array($data))
{
echo $mis_array['ANI'] . "," . $mis_array['service'] . "," . $mis_array['duration'] . "," .$mis_array['circle'] . ",".$mis_array['odb_name'] . ",".$mis_array['date_time']."\r\n";
}
}
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$excellFile");
?>
<?php
}
mysql_close($dbConn);