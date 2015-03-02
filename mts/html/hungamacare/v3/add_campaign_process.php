<?php
session_start();
require_once("../2.0/incs/db.php");
$circle = $_REQUEST['circle'];
$opeartor = $_REQUEST['opeartor'];
$service = $_REQUEST['service'];
$sc = $_REQUEST['sc'];

//Fisrt Block
$adstartendtime = $_REQUEST['adstartendtime'];
$AdStartEnd=explode("-",$adstartendtime);
$timestamp = strtotime($AdStartEnd[0]);
$timestamp1 = strtotime($AdStartEnd[1]);
$stDate1 = date('Y-m-d H:i:s', $timestamp);
$edDate1 = date('Y-m-d H:i:s', $timestamp1);

//Second Block
if(!empty($_REQUEST['adstartendtime2']))
{
$adstartendtime2 = $_REQUEST['adstartendtime2'];
$AdStartEnd2=explode("-",$adstartendtime2);
$stDate2 = strtotime($AdStartEnd2[0]);
$edDate2 = strtotime($AdStartEnd2[1]);
$stDate2 = date('Y-m-d H:i:s', $stDate2);
$edDate2 = date('Y-m-d H:i:s', $edDate2);
}
//Third Block
if(!empty($_REQUEST['adstartendtime3']))
{
$adstartendtime3 = $_REQUEST['adstartendtime3'];
$AdStartEnd3=explode("-",$adstartendtime3);
$stDate3 = strtotime($AdStartEnd3[0]);
$edDate3 = strtotime($AdStartEnd3[1]);
$stDate3 = date('Y-m-d H:i:s', $stDate3);
$edDate3 = date('Y-m-d H:i:s', $edDate3);
}

//Four Block
if(!empty($_REQUEST['adstartendtime4']))
{
$adstartendtime4 = $_REQUEST['adstartendtime4'];
$AdStartEnd4=explode("-",$adstartendtime4);
$stDate4 = strtotime($AdStartEnd4[0]);
$edDate4 = strtotime($AdStartEnd4[1]);
$stDate4 = date('Y-m-d H:i:s', $stDate4);
$edDate4 = date('Y-m-d H:i:s', $edDate4);
}

$add_name = $_REQUEST['add_name'];
$is_skip = $_REQUEST['is_skip'];
$loginid = $_SESSION['loginId'];
$remoteAdd = trim($_SERVER['REMOTE_ADDR']); // for getting IP adress


for($i=1;$i<=4;$i++)
{
	switch($i)
	{
	case '1':$ad_start_date=$stDate1;
			 $ad_end_date=$edDate1;
			 break;
	case '2':$ad_start_date=$stDate2;
			 $ad_end_date=$edDate2;
			 break;
	case '3':$ad_start_date=$stDate3;
			 $ad_end_date=$edDate3;
			 break;
	case '4':$ad_start_date=$stDate4;
			 $ad_end_date=$edDate4;
			 break;
	}

if($ad_start_date!='' && $ad_end_date!='')
{
foreach ($circle as $key => $circleValue) {
    $flag = 1;
    
	$selectQuery = "SELECT starttime,endtime FROM MTS_IVR.tbl_ad_campaign WHERE S_id='" . $service . "' and circle = '" . $circleValue . "' and sc='" . $sc . "'";
	$querySel = mysql_query($selectQuery, $dbConn);
    while ($details = mysql_fetch_array($querySel)) {
    
    if ((strtotime($ad_start_date) >= strtotime($details['starttime']) && strtotime($ad_start_date) <= strtotime($details['endtime'])) || (strtotime($ad_end_date) >= strtotime($details['starttime']) && strtotime($ad_end_date) <= strtotime($details['endtime']))) {
            $flag = 0;
        }
    }
     if ($flag == 1) {
        $insertquery = "insert into MTS_IVR.tbl_ad_campaign(S_id,ad_name,circle,sc,isSkip,added_on,added_by,status,operator,starttime,endtime,ipaddress) 
     values('$service', '$add_name','$circleValue', '$sc', '$is_skip',now(),'$loginid','1','$opeartor','$ad_start_date','$ad_end_date','$remoteAdd')";
        $result = mysql_query($insertquery, $dbConn);
    }

	}
$ad_start_date='';
$ad_end_date='';	
}	

}
$msg="Configuration has been saved successfully.";
echo $msg;
mysql_close($dbConn);
exit;
/*
//$timestamp = strtotime($_REQUEST['timestamp']);
//$timestamp = date('Y-m-d H:i:s', $timestamp);
//$timestamp1 = strtotime($_REQUEST['timestamp1']);
//$timestamp1 = date('Y-m-d H:i:s', $timestamp1);
$adstartendtime = $_REQUEST['adstartendtime'];
$AdStartEnd=explode("-",$adstartendtime);
$timestamp = strtotime($AdStartEnd[0]);
$timestamp1 = strtotime($AdStartEnd[1]);
$timestamp = date('Y-m-d H:i:s', $timestamp);
$timestamp1 = date('Y-m-d H:i:s', $timestamp1);
$add_name = $_REQUEST['add_name'];
$is_skip = $_REQUEST['is_skip'];
$loginid = $_SESSION['loginId'];
$remoteAdd = trim($_SERVER['REMOTE_ADDR']); // for getting IP adress
foreach ($circle as $key => $circleValue) {
    $flag = 1;
    $selectQuery = "SELECT starttime,endtime FROM MTS_IVR.tbl_ad_campaign WHERE S_id='" . $service . "' and circle = '" . $circleValue . "' and sc='" . $sc . "'";
    $querySel = mysql_query($selectQuery, $dbConn);
    while ($details = mysql_fetch_array($querySel)) {
        if ((strtotime($timestamp) >= strtotime($details['starttime']) && strtotime($timestamp) <= strtotime($details['endtime'])) || (strtotime($timestamp1) >= strtotime($details['starttime']) && strtotime($timestamp1) <= strtotime($details['endtime']))) {
            $flag = 0;
        }
    }
    if ($flag == 1) {
        $insertquery = "insert into MTS_IVR.tbl_ad_campaign(S_id,ad_name,circle,sc,isSkip,added_on,added_by,status,operator,starttime,endtime,ipaddress) 
     values('$service', '$add_name','$circleValue', '$sc', '$is_skip',now(),'$loginid','1','MTSM','$timestamp','$timestamp1','$remoteAdd')";
        $result = mysql_query($insertquery, $dbConn);
    }
}
mysql_close($dbConn);
exit;
*/
?>