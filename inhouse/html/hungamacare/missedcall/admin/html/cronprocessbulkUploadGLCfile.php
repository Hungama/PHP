<?php
//include database connection file
ob_start();
session_start();
//require_once("../../../db.php");
require_once("/var/www/html/hungamacare/db.php");


$logPath = "/var/www/html/hungamacare/missedcall/admin/html/bulkupload/logs/bulkUploadGLC_log_" . date(Ymd) . ".txt";
//check for status ready to upload  
$checkfiletoprocess = mysql_query("select batchid,odb_filename,startdate, enddate,uploadtime from master_db.tbl_GLCBulkobdHistory nolock where status IN ( 1, 0) and prcocess_status='free' and filesize<=10000 and servicetype='HUL' order by batchid ASC limit 1");
$notorestore = mysql_num_rows($checkfiletoprocess);
if ($notorestore == 0) {
    $logData = 'No file to process' . date('H:i:s')."\n\r";
    echo $logData;
	 error_log($logData,3,$logPath);
//close database connection
    mysql_close($con);
    exit;
} else {
    while ($row_file_info = mysql_fetch_array($checkfiletoprocess)) {

        $obd_form_batchid = $row_file_info['batchid'];
        $update_status_pre = "UPDATE master_db.tbl_GLCBulkobdHistory set status='1',prcocess_status='block' where batchid='" . $obd_form_batchid . "'";
        mysql_query($update_status_pre, $con);

        $obd_form_mob_file = $row_file_info['odb_filename'];
        $obd_form_startdate = $row_file_info['startdate'];
        $obd_form_enddate = $row_file_info['enddate'];
        $uploadtime = $row_file_info['uploadtime'];
        $status = 0;
        $lines = file('/var/www/html/hungamacare/missedcall/admin/html/bulkupload/' . $obd_form_mob_file);
        $isupload = false;

        $allani = array();
        $i = 0;
        foreach ($lines as $line_num => $mobno) {
//read line of file
            $mno = trim($mobno);
            $allani[$line_num] = $mno;
        }//end of foreach
//open file to rewrite
        $file = fopen('/var/www/html/hungamacare/missedcall/admin/html/bulkupload/hul/' . $obd_form_mob_file, "w");
        foreach ($allani as $allani_no => $msisdn) {
         fwrite($file, $msisdn . "#HUL#0#" . $uploadtime . "\r\n");
        }
        fclose($file);
//insert data in table using data load 
        $obd_anifile_path = "bulkupload/hul/" . $obd_form_mob_file;
        $sql_obdinfo = 'LOAD DATA LOCAL INFILE "' . $obd_anifile_path . '" 
        INTO TABLE hul_hungama.tbl_hul_pushobd_sub
        FIELDS TERMINATED BY "#" 
        LINES TERMINATED BY "\n" 
        (ANI,service,status,date_time)';

        if (mysql_query($sql_obdinfo, $con)) {
            $isupload = true;
        } else {
            $isupload = false;
        }
    }//end of while
//save log here
    $logData = "#BatchId#" . $obd_form_batchid . "#filename#" . $obd_form_mob_file . "#startdate#" . $obd_form_startdate . "#enddate#" . $obd_form_enddate . "#status#" . $status . "#" . date('H:i:s')."\n\r";
    error_log($logData,3,$logPath);
//file successfully read then  remove that file from here and copy it to lock folder and change table column status to 2
    $isupload = true;
    if ($isupload) {
        $update_status_post = "UPDATE master_db.tbl_GLCBulkobdHistory set status='2',prcocess_status='completed' where batchid='" . $obd_form_batchid . "'";
        mysql_query($update_status_post, $con);
        if (!copy('/var/www/html/hungamacare/missedcall/admin/html/bulkupload/hul/' . $obd_form_mob_file, "/var/www/html/hungamacare/missedcall/admin/html/bulkupload/hul/lock/" . $obd_form_mob_file)) {
            echo "failed to copy $file...\n";
        } else {
            unlink('/var/www/html/hungamacare/missedcall/admin/html/bulkupload/hul/' . $obd_form_mob_file);
        }
    }
    echo "File processed successfully.";
//close database connection
    mysql_close($con);
    exit;
}
?>