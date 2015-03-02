<?php

require_once("../../../db.php");
$con_218 = mysql_connect('192.168.100.218','php','php');
if (!$con_218)
 {
  die('Could not connect:Mis data');
 }
$StartDate = $_REQUEST['StartDate'];
$EndDate = $_REQUEST['EndDate'];
$type = $_REQUEST['type'];
$mistable='misdata.dailymis';
$service='EnterpriseMcDw';
if ($StartDate == '' || $EndDate == '' || $type == '') {
    echo "Please provide all parameter";
    exit;
}
if ($_REQUEST['type'] == 'missedcall') {
    $data_query = "select ANI,date_time,circle from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_liveapp nolock 
 where date(date_time) between '" . $StartDate . "' and '" . $EndDate . "' and ANI!='' order by date_time desc ";
} else if ($_REQUEST['type'] == 'content') {
    $data_query = "select ANI,service,duration,circle,date_time from Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_details nolock 
 where date(date_time) between '" . $StartDate . "' and '" . $EndDate . "' and ANI!='' and status=2 order by date_time desc ";
 $data_query1 = "select ANI,service,duration,circle,date_time from Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_details_SongDedicate nolock 
 where date(date_time) between '" . $StartDate . "' and '" . $EndDate . "' and ANI!='' and status=2 order by date_time desc ";
} 
else if ($_REQUEST['type'] == 'mdr') {
//total user
/* $get_TotalMissedCall="select sum(Value) as total from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type='CALLS_TF' and service='".$service."'";
$query_TotalMissedCall = mysql_query($get_TotalMissedCall,$con_218);
list($total_user) = mysql_fetch_array($query_TotalMissedCall); 
///total dedication and total recharge pushed
$getdedication=mysql_query("select  sum(Value) from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."'
 and type ='B_CALLS_OBD' and service='".$service."' ",$con_218);
list($totaldedication) = mysql_fetch_array($getdedication); 
$getrechargepush=mysql_query("select sum(Value) as total  from $mistable nolock
  where date between '".$StartDate."' and '".$EndDate."' and type='B_RECHARGEPUSHED' and service='".$service."' ",$con_218);
list($totalrechargepushed) = mysql_fetch_array($getrechargepush); */

$get_result=mysql_query("select type,sum(value) as total,date from  misdata.dailymis where type in('RECHRG_ELG','DD_PARTY_A','CALLS_TF' )
and service in('EnterpriseMcDwOBD','EnterpriseMcDw') and date between '2014-11-13' and  '2014-11-20'   
group by date ,type order by type,date",$con_218);

}


			




else {
    echo "Type is not valid";
    exit;
}

$data = mysql_query($data_query, $con);
$result_row = mysql_num_rows($data);
$data1 = mysql_query($data_query1, $con);
$result_row1 = mysql_num_rows($data1);

if ($result_row > 0) {
    $exportFile = $type . '_' . date('YMDhis');
    $excellFile = $exportFile . ".csv";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$excellFile");
    if ($_REQUEST['type'] == 'missedcall') {
        echo "ANI,Circle,Datetime" . "\r\n";
        while ($mis_array = mysql_fetch_array($data)) {
            echo $mis_array['ANI'] ."," . $mis_array['circle'] . "," . $mis_array['date_time'] . "\r\n";
        }
    } else if ($_REQUEST['type'] == 'content') {
        echo "ANI,Duration,Circle,Datetime,Party A" . "\r\n";
        while ($mis_array = mysql_fetch_array($data)) {
		/* if($mis_array['service']=='MCW_LIVEAPP') */
            echo $mis_array['ANI'] . ",". $mis_array['duration'] . "," . $mis_array['circle'] . "," . $mis_array['date_time'] . "\r\n";
/* 		 "," . $mis_array1['service'] .	elseif($mis_array['service']=='MCW_LIVEAPPSONGDEDIC')
			echo $mis_array['ANI'] . "," . 'Party B' . "," . $mis_array['duration'] . "," . $mis_array['circle'] . "," . $mis_array['date_time'] . "\r\n"; */
        }
		echo "<b>ANI,Service,Duration,Circle,Datetime,Party B</b>" . "\r\n";
		while ($mis_array1 = mysql_fetch_array($data1)) {
            echo $mis_array1['ANI'] . "," . $mis_array1['duration'] . "," . $mis_array1['circle'] . "," . $mis_array1['date_time'] . "\r\n";
        }
		
		
		
    }

    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$excellFile");
} 
else {
if ($_REQUEST['type'] == 'mdr') {
$exportFile = $type . '_' . date('YMDhis');
    $excellFile = $exportFile . ".csv";
echo "Type,total,Date" . "\r\n";
/* echo $total_user . "," . $totaldedication . "," . $totalrechargepushed .  "\r\n"; */

while ($mis_array = mysql_fetch_array($get_result)) {
if($mis_array['type']=='CALLS_TF')
echo  'Total Missed call' . "," . $mis_array['total'] . "," . $mis_array['date'] . "\r\n";
elseif($mis_array['type']=='DD_PARTY_A')
echo  'Total Dedication' . "," . $mis_array['total'] . "," . $mis_array['date'] . "\r\n";
elseif($mis_array['type']=='RECHRG_ELG')
echo  'Total Recharge Pushed' . "," . $mis_array['total'] . "," . $mis_array['date'] . "\r\n";

        }
header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$excellFile");
}
else{


    echo "No Record Found";
    exit;
	}
}
mysql_close($dbConn);
?>