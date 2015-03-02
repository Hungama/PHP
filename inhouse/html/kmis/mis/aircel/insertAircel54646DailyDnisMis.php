<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
if ($_REQUEST['date']) {
    $view_date1 = $_REQUEST['date'];
} else {
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
//echo $view_date1 = "2014-06-09";

$serviceArray = array('1902' => 'Aircel54646');
$circle_info = array('UND' => 'Others', 'DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'JNK' => 'Jammu-Kashmir', 'HAR' => 'Haryana', ' ' => 'Others');

//----- pause code array ----------
$pauseArray = array('201' => 'Lava', '202' => 'Lemon', '203' => 'Maxx', '204' => 'Videocon', '205' => 'MVL', '206' => 'Chaze', '207' => 'Intex', '208' => 'iBall', '209' => 'Fly', '210' => 'Karbonn', '211' => 'Hitech', '212' => 'MTech', '213' => 'Rage', '214' => 'Zen', '215' => 'Micromax', '216' => 'Celkon');

$pauseCode = array('1' => 'LG', '2' => 'MW', '3' => 'MJ', '4' => 'CW', '5' => 'JAD');
//---------------------------------
// delete the prevoius record
$deleteprevioousdata = "delete from misdata.aircel_dailymis where date(Date)='$view_date1' and Service='Aircel54646'";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

//////////////////////////////// End delete the data of the previous data//////////////////////////////////////////////////////////////////////////////
//////////start code to insert the data for CALLS_T for Aircel 54646///////////////////////////////////////////////////////////////////

$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'Aircel54646' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in ('airc') group by dnis,circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_t_result);
if ($numRows1 > 0) {
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $insert_call_t_data = "insert into misdata.aircel_dailymis(Date,Type,Circle,charging_rate,total_count,Service,dnis,Revenue,mous,pulse,total_sec)
        values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','$call_t[3]','$call_t[5]','0','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_t_data, $dbConn);
    }
}
//////////////End code to insert the data for CALLS_T for Aircel 54646///////////////////////////////////////////////////////////////////
//////////////////////////start code to insert the data for MOU_T for Aircel 54646///////////////////
$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, count(id),'Aircel54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous ,dnis
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') 
group by dnis,circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_t_result);
if ($numRows2 > 0) {
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $insert_mous_t_data = "insert into misdata.aircel_dailymis(Date,Type,Circle,charging_rate,total_count,Service,mous,dnis,Revenue,pulse,total_sec) 
        values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','$call_t[3]','$mous_t[5]','$mous_t[6]','0','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_t_data, $dbConn);
    }
}
// end
/////////////////////////////////////////start code to insert the data for PULSE_T for the Aircel 54646 SErvice/////////////////////////////////////////
$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Aircel54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse ,dnis
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') group by dnis,circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_t_result);
if ($numRows3 > 0) {
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $pulserate = 3;
        $revenue = $pulse_t[5] * $pulserate;
        $insert_pulse_t_data = "insert into misdata.aircel_dailymis(Date,Type,Circle,charging_rate,total_count,Service,mous,pulse,dnis,Revenue,total_sec) 
        values('$view_date1', '$pulse_t[0]','$pulse_t[1]','$pulserate','$pulse_t[5]','$pulse_t[3]','NA','$pulse_t[5]','$pulse_t[6]','$revenue','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_t_data, $dbConn);
    }
}
/////////////////////////////////////////End code to insert the data for PULSE_T for the Aircel 54646 SErvice/////////////////////////////////////////
//////////////////////////start code to insert the data for Unique Users  for Aircel 54646 //////////////////////////////////////////////
$uu_t = array();
$uu_t_query = "select 'UU_T',circle, count(distinct msisdn),'Aircel54646' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') group by dnis,circle";

$uu_t_result = mysql_query($uu_t_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_t_result);
if ($numRows4 > 0) {
    while ($uu_t = mysql_fetch_array($uu_t_result)) {
        $insert_uu_t_data = "insert into misdata.aircel_dailymis(Date,Type,Circle,charging_rate,total_count,Service,mous,pulse,dnis,Revenue,total_sec) 
            values('$view_date1', '$uu_t[0]','$uu_t[1]','0','$uu_t[2]','$uu_t[3]','NA','NA','$uu_t[5]','0','NA')";
        $queryIns_uu = mysql_query($insert_uu_t_data, $dbConn);
    }
}
/////////////////////////// end Unique Users  for Aircel 54646/////////////////////////////////////////////////////////////////////////
/////////////////////start code to insert the data for SEC_T  for Aircel 54646 ///////////////////////////////////////////////////

$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'Aircel54646' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') group by dnis,circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_t_result);
if ($numRows5 > 0) {
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $insert_sec_t_data = "insert into mis_db.aircel_dailymis(Date,Type,Circle,charging_rate,total_count,Service,mous,pulse,total_sec,dnis,Revenue)
        values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','$sec_t[3]','NA','NA','$sec_t[5]','$sec_t[6]','0')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}
// end insert the data for SEC_T  for Aircel 54646
mysql_close($dbConn);
echo "done";
?>
