<?php
exit;
//include database connection file
include("db.php");
$logPath = "logs/cron/obdrecording_log_11nov12.txt";
//check for status ready to upload  
$checkfiletoprocess=mysql_query("select batchid,odb_filename,circle, startdate, enddate,channel,planid from tbl_obdrecording_log where status IN ( 1, 0) and prcocess_status='free' and filesize<=10000 and servicetype='DIGI' order by batchid ASC limit 1");
$notorestore=mysql_num_rows($checkfiletoprocess);

if($notorestore==0)
{
$logData='No file to process'."\n\r";
echo $logData;
//error_log($logData,3,$logPath);
//close database connection
mysql_close($con);
exit;
}

else
{
while($row_file_info = mysql_fetch_array($checkfiletoprocess))
{
	
$obd_form_batchid=$row_file_info['batchid'];
$update_status_pre = "UPDATE tbl_obdrecording_log set status='1',prcocess_status='block' where batchid='".$obd_form_batchid."'";
    mysql_query($update_status_pre,$con);

$obd_form_mob_file=$row_file_info['odb_filename'];
$obd_form_circle=$row_file_info['circle'];
$obd_form_startdate=$row_file_info['startdate'];
$obd_form_enddate=$row_file_info['enddate'];
$obd_form_channel=$row_file_info['channel'];
$obd_form_planid=$row_file_info['planid'];
$status=0;
$lines = file('obdrecording/'.$obd_form_mob_file);
$isupload=false;

$allani= array();
$i=0;
foreach ($lines as $line_num => $mobno)
 {
//read line of file
$mno=trim($mobno);
//echo $line_num.'-'.$mno."<br>";
 $allani[$line_num]=$mno;
	          
 }//end of foreach
//open file in appned mode
$file=fopen('obdrecording/'.$obd_form_mob_file,"w");
foreach ($allani as $allani_no => $msisdn)
 {
//$msisdn;
fwrite($file,$msisdn . "#" . $obd_form_startdate . "#" . $obd_form_enddate . "#" . $status . "#" . $obd_form_circle. "#" . $obd_form_channel. "#" . $obd_form_planid."\r\n" );
 }
fclose($file);




//insert data in table using data load 
$obd_anifile_path="obdrecording/".$obd_form_mob_file;
$sql_obdinfo= 'LOAD DATA LOCAL INFILE "'.$obd_anifile_path.'" 
        INTO TABLE db_obd.TBL_User_OBD
        FIELDS TERMINATED BY "#" 
        LINES TERMINATED BY "\n" 
        (ANI,StartDate,EndDate,Status,Circle,channel,planid)';

if(mysql_query($sql_obdinfo,$con))
                               {
                                   $isupload=true;
								  
                               }
                           else
                               {
                                    $isupload=false;
     							    
                               }




}//end of while
//save log here
$logData="#BatchId#".$obd_form_batchid."#filename#".$obd_form_mob_file."#circle#".$obd_form_circle."#startdate#".$obd_form_startdate."#enddate#".$obd_form_enddate."#status#".$status."#"."\n\r";
	//error_log($logData,3,$logPath);

//If file successfully read and insert line by line in database we remove that file from here and copy it to lock folder and chage table column status to 1
$isupload=true;
if($isupload)
{
$update_status_post = "UPDATE tbl_obdrecording_log set status='2',prcocess_status='completed' where batchid='".$obd_form_batchid."'";
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

//close database connection
mysql_close($con);
exit;
}
?>