<?php
error_reporting(0);
include ("db.php");
$prevdate = date("Y-m-d", time() - 60 * 60 * 24);
$aircelQuery1 = "select distinct msisdn,circle,device_browser from misdata.tbl_browsing_wap_store_aircel nolock where date(date)='".$prevdate."' and msisdn!='' ";
    //where date(date)='" . $prevdate . "'";
$result1 = mysql_query($aircelQuery1, $con);
$num=  mysql_num_rows($result1);

$callPath1 = "/var/www/html/kmis/mis/waplog/logs/aircel_live_step1_live".$prevdate.".txt";


$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra',
    'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa',
    'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala',
    'HPD' => 'Himachal Pradesh','OTH'=>'Others');

$revert_circle=array_flip($circle_info);


if (file_exists($callPath1))
    unlink($callPath1);

while ($row1 = mysql_fetch_array($result1)) {
    $msisdn = trim($row1[0]);
    
    $circle = trim($revert_circle[$row1[1]]);
    $date = $prevdate;
    $operator = 'airc';
    //$status='0';
    //$device_model = trim($row1[3]);
    //$device_os = trim($row1[4]);
    $device_browser = trim($row1[2]);
    //$device_screen = trim($row1[6]);
    
$logData = $msisdn . "#" . $circle . "#".$date."#". $operator . "#0#0#0#" . $device_browser . "#0"."\n"; 
    error_log($logData, 3, $callPath1);

    //$insertQuery1 = "insert into misdata.tbl_calling_astro VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1418']."')";
    //$result11 = mysql_query($insertQuery1,$LivdbConn);
}
//changed on 29sep2014 as per bhoopraksh call
//connect to 224 database
mysql_close($con);

$LivdbConn = mysql_connect($DB_HOST_M224,$DB_USERNAME_M224,$DB_PASSWORD_M224) or die(mysql_error());
if (!$LivdbConn)
   {
   die('Could not connect Live: ' . mysql_error());
   }

$delete_data=mysql_query("delete from Inhouse_tmp.tbl_browsing_wap_store_aircel",$LivdbConn);
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath1 . '" INTO TABLE Inhouse_tmp.tbl_browsing_wap_store_aircel 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,circle,date,operator,status,device_model,device_os,device_browser,device_screen)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath1);
mysql_close($LivdbConn);
echo "Done Step 1";
exit;
?>