<?php
error_reporting(0);
include_once("/var/www/html/kmis/services/hungamacare/config/dbcon/dbConnect212.php");
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
//$view_date1='2014-11-20';
echo $view_date1;
//Delete Old data according servicename
$delete_uninor_data ="delete from mis_db.tbl_device_browser where date(addedon)='" . $view_date1 . "'";
$query = mysql_query($delete_uninor_data, $dbConn212) or die(mysql_error());
// select distinct data
$get_ldr_SubData = "select distinct useragent from mis_db.tbl_browsing_wap_uninor nolock where date(datetime)='" . $view_date1 . "'";
$query1 = mysql_query($get_ldr_SubData, $dbConn212) or die(mysql_error());
$numRows = mysql_num_rows($query1);
if ($numRows > 0)
{
	while ($user_agent = mysql_fetch_array($query1))
	{	
	        // insert the data in mis_db.tbl_device_browser
            $device_browser = $user_agent['useragent'];
			$insert_uninor_SubData = "insert into mis_db.tbl_device_browser(addedon,device_browser,servicename) values('" . $view_date1 . "','".$device_browser."','UninorWAP')";
			$query2 = mysql_query($insert_uninor_SubData, $dbConn212) or die(mysql_error());
			
	}
}
mysql_close($dbConn212);
mysql_close($LivdbConn);
echo "generated";
?>