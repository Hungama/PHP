<?php
//include database connection file
include("db.php");
//servicetype -- DIGI | HUL
$logPath = "logs/cron/obdrecording_log_11nov12.txt";
//check for status ready to upload  
$checkfiletoprocess=mysql_query("select batchid,odb_filename,circle, startdate, enddate,channel,planid,servicetype,capsuleid from master_db.tbl_obdrecording_log where status IN ( 1, 0) and prcocess_status='free' and filesize<=10000 order by batchid ASC limit 1");
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
$update_status_pre = "UPDATE master_db.tbl_obdrecording_log set status='1',prcocess_status='block' where batchid='".$obd_form_batchid."'";
    mysql_query($update_status_pre,$con);

$obd_form_mob_file=$row_file_info['odb_filename'];
$obd_form_circle=$row_file_info['circle'];
$obd_form_startdate=$row_file_info['startdate'];
$obd_form_enddate=$row_file_info['enddate'];
$obd_form_channel=$row_file_info['channel'];
$obd_form_planid=$row_file_info['planid'];
$obd_form_servicetype=$row_file_info['servicetype'];


//mysql_close($con);

if($obd_form_servicetype=='DIGI')
	{

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
$serverip=rand(42, 43);
//$msisdn;
fwrite($file,$msisdn . "#" . $obd_form_startdate . "#" . $obd_form_enddate . "#" . $status . "#" . $obd_form_circle. "#" . $obd_form_channel. "#" . $obd_form_planid. "#" .$serverip."\r\n" );
 }
fclose($file);

// insert data in digi server start here
$con_digi = mysql_connect("172.16.56.42","billing","billing");
if (!$con_digi)
{
die('Could not connect: ' . mysql_error("Could not connect to digi"));
}
//mysql_select_db("db_obd", $con_digi);
//insert data in table using data load 
$obd_anifile_path="obdrecording/".$obd_form_mob_file;
$sql_obdinfo= 'LOAD DATA LOCAL INFILE "'.$obd_anifile_path.'" 
        INTO TABLE db_obd.TBL_User_OBD
        FIELDS TERMINATED BY "#" 
        LINES TERMINATED BY "\n" 
        (ANI,StartDate,EndDate,Status,Circle,channel,planid,ip)';

if(mysql_query($sql_obdinfo,$con_digi))
                               {
                                   $isupload=true;
								  
                               }
                           else
                               {
                                    $isupload=false;
     							    
                               }
mysql_close($con_digi);
// insert in digi server end here
	}
	else
	{
/* update LAST_HEARD where ANI
select * from hul_hungama.tbl_hul_subdetails

	ANI  LAST_HEARD
		only update
*/
	
$lines = file('obdrecording/hul/'.$obd_form_mob_file);
$allani= array();
$i=0;
foreach ($lines as $line_num => $mobno)
 {
	$pieces = explode("#", $mobno);
//read line of file
$mno=trim($pieces[0]);
$allani[$line_num]=$mno;
	          
 }//end of foreach
fclose($lines);

foreach ($allani as $allani_no => $msisdn)
 {
//$msisdn;
//CONFIG_OLD   CONFIG_NEW
//HUL_7
$pushcapsuleid='HUL_'.$row_file_info['capsuleid'];
//$update_hul_obd_capsule = "UPDATE hul_hungama.tbl_hul_subdetails set LAST_HEARD='".$row_file_info['capsuleid']."' where ANI='".$msisdn."'";
$update_hul_obd_capsule = "UPDATE hul_hungama.tbl_hul_subdetails set CONFIG_OLD='".$pushcapsuleid."',CONFIG_NEW='".$pushcapsuleid."' where ANI='".$msisdn."'";
mysql_query($update_hul_obd_capsule,$con);
 }
//insert data in table using data load 

//ANI,STATUS,DNIS,message,retry,circle,operator
//fwrite($file,$msisdn . "#" .$status. "#" .$dnis. "#" .$messge. "#" .$retry. "#" .$cir."#".$op . "\r\n" );
//9711071741
//fwrite($file,$msisdn . "#" .$status. "#" .$service. "#" .$dnis. "#" .$messge. "#" .$retry. "#" .$cir."#".$op . "\r\n" );
$obd_anifile_path="obdrecording/hul/".$obd_form_mob_file;
$sql_hul_obdinfo= 'LOAD DATA LOCAL INFILE "'.$obd_anifile_path.'" 
        INTO TABLE newseleb_hungama.tbl_max_bupa_details
        FIELDS TERMINATED BY "#" 
        LINES TERMINATED BY "\n" 
        (ANI,STATUS,DNIS,message,retry,circle,operator)';

if(mysql_query($sql_hul_obdinfo,$con))
                               {
                                   $isupload=true;
								   echo "success";
								  
                               }
                           else
                               {
                                    $isupload=false;
   								    echo "fail";
     							    
                               }


//insert data in table using data load in tbl_hul_pushobd1
//fwrite($file,$msisdn . "#" .$status. "#" .$service. "#" .$dnis. "#" .$messge. "#" .$retry. "#" .$cir."#".$op . "\r\n" );
$obd_anifile_path="obdrecording/hul/tbl_hul_pushobb/".$obd_form_mob_file;
$sql_hul_obdinfo_push= 'LOAD DATA LOCAL INFILE "'.$obd_anifile_path.'" 
        INTO TABLE hul_hungama.tbl_hul_pushobd1
        FIELDS TERMINATED BY "#" 
        LINES TERMINATED BY "\n" 
        (ANI,service,status)';

if(mysql_query($sql_hul_obdinfo_push,$con))
                               {
                                   $isupload=true;
								//   echo "<br>"."success--hul_hungama.tbl_hul_pushobd1";
								  
                               }
                           else
                               {
                                    $isupload=false;
								//   echo "<br>"."failed--hul_hungama.tbl_hul_pushobd1";
     							    
                               }
//	mysql_close($con);
	//exit;
	}

}//end of while
//save log here

//close database connection




$logData="#BatchId#".$obd_form_batchid."#filename#".$obd_form_mob_file."#circle#".$obd_form_circle."#startdate#".$obd_form_startdate."#enddate#".$obd_form_enddate."#status#".$status."#"."\n\r";
	//error_log($logData,3,$logPath);

//If file successfully read and insert line by line in database we remove that file from here and copy it to lock folder and chage table column status to 1
$isupload=true;
if($isupload)
{
$update_status_post = "UPDATE master_db.tbl_obdrecording_log set status='2',prcocess_status='completed',processedtime=NOW() where batchid='".$obd_form_batchid."'";
mysql_query($update_status_post,$con);
mysql_close($con);    
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
exit;
}
?>