<?php
error_reporting(0);
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$waplogFile="lastaccessfileinfo.txt";
$fileDumpPath="/var/www/html/hungamacare/wap/".$waplogFile;
if (file_exists($fileDumpPath)) {
//$DeleteQuery = "delete from Inhouse_tmp.all_Contentlist_IVR where date(datetime)='" . $prevdatedb . "'";
//$deleteResult12 = mysql_query($DeleteQuery,$dbConn) or die(mysql_error());	
$insertDump = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath . '" INTO TABLE Inhouse_tmp.all_Contentlist_IVR 
FIELDS TERMINATED BY "#" LINES TERMINATED BY "\n" (folder_name,file_name,org_file_name,last_access_time,added_on)';
    if(mysql_query($insertDump,$dbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Browsing Data'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Browsing Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
 echo $file_process_status;		
}
else
{
echo "NOK";
}
mysql_close($dbConn); 
?>