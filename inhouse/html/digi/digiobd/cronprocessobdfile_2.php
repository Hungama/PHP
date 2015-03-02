<?php
//include database connection file
include("db.php");
$logPath = "logs/cron/obdrecording_log_9nov12.txt";
//check for status ready to upload
//$checkfiletoprocess=mysql_query("select batchid,odb_filename,circle, startdate, enddate from tbl_obdrecording_log where status='1' limit 1");
$checkfiletoprocess=mysql_query("select batchid,odb_filename,circle, startdate, enddate from tbl_obdrecording_log where batchid='2'");
echo $notorestore=mysql_num_rows($checkfiletoprocess);

if($notorestore==0)
{
$logData='No file to process'."\n\r";
echo $logData;
	//error_log($logData,3,$logPath);
//close database connection
mysql_close($con);
}
else
{
while($row_file_info = mysql_fetch_array($checkfiletoprocess))
{
$obd_form_batchid=$row_file_info['batchid'];
$obd_form_mob_file=$row_file_info['odb_filename'];
$obd_form_circle=$row_file_info['circle'];
$obd_form_startdate=$row_file_info['startdate'];
$obd_form_enddate=$row_file_info['enddate'];
$status=0;
$lines = file('obdrecording/'.$obd_form_mob_file);
$isupload=false;
foreach ($lines as $line_num => $mobno) {
//read and insert line by line in database
$mno=trim($mobno);
if(!empty($mno))
{
echo $sql_obdinfo="INSERT INTO db_obd.TBL_User_OBD (StartDate,EndDate,Status,Circle,ANI)
VALUES ('".$obd_form_startdate."','".$obd_form_enddate."','".$status."','".$obd_form_circle."','".trim($mobno)."')";
if(mysql_query($sql_obdinfo,$con))
{
$isupload=true;
}
else
{
$isupload=false;
}
}
$update_status_pre = "UPDATE tbl_obdrecording_log set status='1' where batchid='".$obd_form_batchid."'";
mysql_query($update_status_pre,$con);
}
//save log here
$logData="#filename#".$obd_form_mob_file."#circle#".$obd_form_circle."#startdate#".$obd_form_startdate."#enddate#".$obd_form_enddate."#status#".$status."#".date("Y-m-d H:i:s")."\n\r";
	error_log($logData,3,$logPath);


//If file successfully read and insert line by line in database we remove that file from here and copy it to lock folder and chage table column status to 1
if($isupload)
{
$update_status_post = "UPDATE tbl_obdrecording_log set status='2' where batchid='".$obd_form_batchid."'";
mysql_query($update_status_post,$con);
if (!copy('obdrecording/'.$obd_form_mob_file, "obdrecording/lock/".$obd_form_mob_file))
{
 echo "failed to copy $file...\n";
}
else
{
unlink('obdrecording/'.$obd_form_mob_file);
}
}
echo "File processed successfully.";
}
//close database connection
mysql_close($con);
}
?>