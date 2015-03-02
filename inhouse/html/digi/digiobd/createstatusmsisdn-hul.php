<?php
//include database connection file
include("db.php");
//servicetype -- DIGI | HUL
//check for status ready to upload  

//$checkfiletoprocess=mysql_query("select batchid,odb_filename,uploadtime from master_db.tbl_obdrecording_log where status=2  and  servicetype !='DIGI' and filesize<=10000 and date(processedtime)>='2012-12-01' order by batchid ASC limit 1");

//$checkfiletoprocess=mysql_query("select batchid,odb_filename,uploadtime,TIME_TO_SEC(TIMEDIFF (now(),uploadtime)) as ptime,servicetype  from master_db.tbl_obdrecording_log where status=2  and  servicetype !='DIGI' and servicetype !='uninor_jyotish' and filesize<=10000 and date(processedtime)>='2012-12-01' order by batchid ASC limit 1");
$checkfiletoprocess=mysql_query("select batchid,odb_filename,uploadtime,TIME_TO_SEC(TIMEDIFF (now(),uploadtime)) as ptime,servicetype  from master_db.tbl_obdrecording_log where status=2  and  servicetype IN ('HUL_PROMOTION','HUL') and filesize<=10000 and date(processedtime)>='2012-12-01' order by batchid ASC limit 1");

$notorestore=mysql_num_rows($checkfiletoprocess);

if($notorestore==0)
{
$logData='No file to process'."\n\r";
echo $logData;
//close database connection
mysql_close($dbConn);
exit;
}

else
{
while($row_file_info = mysql_fetch_array($checkfiletoprocess))
{
$obd_servicetype=$row_file_info['servicetype'];
if($obd_servicetype=='uninor_jyotish')
{
echo "Not valid for uninor jyotish";
mysql_close($dbConn);
exit;
}
$file_time_diff=$row_file_info['ptime'];
if($file_time_diff>7200)
{
$obd_batchid=$row_file_info['batchid'];
$update_status_pre = "UPDATE master_db.tbl_obdrecording_log set status='3',uploadtime='".$row_file_info['uploadtime']."' where batchid='".$obd_batchid."'";
mysql_query($update_status_pre);
$hul_obd_filename=$row_file_info['odb_filename'];
$hul_obd_uptime=date("Y-m-d",strtotime($row_file_info['uploadtime']));

$obd_anifile_path="obdrecording/hul/".$hul_obd_filename;
$newstatustextfile="obdrecording/hul/report/".$hul_obd_filename;
$fGetContents = file_get_contents($obd_anifile_path);
    $e = explode("\n", $fGetContents);
   $totalcount=count($e);
    for ($i = 0; $i < $totalcount; $i++) {
	$data = explode("#", $e[$i]);
if($totalcount!=$i+1)
{
$sql_getmsisdnlist = mysql_query("select ANI,service,odb_name,duration,status,date_time,operator,circle from hul_hungama.tbl_hulobd_success_fail_details WHERE  date(date_time) = '$hul_obd_uptime' and ANI=$data[0]");
$result_list = mysql_fetch_array($sql_getmsisdnlist);
$logData_MDN=$data[0]."#".$result_list['service'].'#'.$result_list['status'].'#'.'Duration#'.$result_list['duration'].'#'.$result_list['operator'].'#'.$result_list['circle'].'#'.$result_list['odb_name'].'#'.$result_list['date_time']."\r\n";
error_log($logData_MDN,3,$newstatustextfile);
}
	}
	echo "Processed successfully";
}
else
{
echo "No file to process.";
}

}
//end of while
mysql_close($con);
exit;
}
?>