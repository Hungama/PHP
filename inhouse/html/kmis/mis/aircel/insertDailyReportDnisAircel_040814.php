<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
if ($_REQUEST['date']) {
    $view_date1 = $_REQUEST['date'];
} else {
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
//echo $view_date1="2013-04-02";

$serviceArray = array('1902' => 'Aircel54646');
$circle_info = array('mah' => 'Maharashtra', 'pub' => 'Punjab', 'upe' => 'UP EAST', 'apd' => 'Andhra Pradesh', 'kar' => 'Karnataka', 'ori' => 'Orissa',
    'guj' => 'Gujarat', 'asm' => 'Assam', 'mpd' => 'Madhya Pradesh', 'upw' => 'UP WEST', 'tnu' => 'Tamil Nadu', 'wbl' => 'WestBengal', 'jnk' => 'Jammu-Kashmir',
    'del' => 'Delhi', 'bih' => 'Bihar', 'mum' => 'Mumbai', 'raj' => 'Rajasthan', 'hay' => 'Haryana', 'hpd' => 'Himachal Pradesh', 'kol' => 'Kolkata',
    'nes' => 'NE', 'ker' => 'Kerala', 'chn' => 'Chennai', 'oth' => 'Others', 'UND' => 'Others', 'har' => 'Haryana');

// delete the prevoius record
$deleteprevioousdata = "delete from misdata.tbl_browsing_mis where date(Date)='$view_date1' and service = 'Aircel54646'";
$delete_result = mysql_query($deleteprevioousdata, $LivdbConn) or die(mysql_error());

//////////////////////////////// End delete the data of the previous data//////////////////////////////////////////////////////////////////////////////
//////////start code to insert the data for CALLS_T for Aircel 54646///////////////////////////////////////////////////////////////////

$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'Aircel54646' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in ('airc') group by circle,dnis";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_t_result);
if ($numRows1 > 0) {
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $circle = $circle_info[$call_t[1]];
        $insert_call_t_data = "insert into misdata.tbl_browsing_mis(Date,Service,Circle,Type,Value,Revenue,dnis) 
        values('$view_date1', '$call_t[3]','$circle','$call_t[0]','$call_t[2]','0','$call_t[5]')";
        $queryIns_call = mysql_query($insert_call_t_data, $LivdbConn);
    }
}
//////////////End code to insert the data for CALLS_T for Aircel 54646///////////////////////////////////////////////////////////////////
//////////////////////////start code to insert the data for MOU_T for Aircel 54646///////////////////
$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, count(id),'Aircel54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') 
group by circle,dnis";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_t_result);
if ($numRows2 > 0) {
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $circle = $circle_info[$mous_t[1]];
        $insert_mous_t_data = "insert into misdata.tbl_browsing_mis(Date,Service,Circle,Type,Value,Revenue,dnis)
        values('$view_date1', '$mous_t[3]','$circle','$mous_t[0]','$mous_t[2]','0','$mous_t[6]')";
        $queryIns_mous = mysql_query($insert_mous_t_data, $LivdbConn);
    }
}
//////////////End code to insert the data for MOU_T for Aircel 54646///////////////////////////////////////////////////////////////////
/////////////////////////////////////////start code to insert the data for PULSE_T for the Aircel 54646 SErvice/////////////////////////////////////////
$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Aircel54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') 
group by circle,dnis";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_t_result);
if ($numRows3 > 0) {
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $pulserate = 3;
        $revenue = $pulse_t[5] * $pulserate;
        $circle = $circle_info[$pulse_t[1]];
        $insert_pulse_t_data = "insert into misdata.tbl_browsing_mis(Date,Service,Circle,Type,Value,Revenue,dnis)
        values('$view_date1', '$pulse_t[3]','$circle','$pulse_t[0]','$pulse_t[5]','$revenue','$pulse_t[6]')";
        $queryIns_pulse = mysql_query($insert_pulse_t_data, $LivdbConn);
    }
}

/////////////////////////////////////////End code to insert the data for PULSE_T for the Aircel 54646 SErvice/////////////////////////////////////////
//////////////////////////start code to insert the data for Unique Users  for Aircel 54646 //////////////////////////////////////////////
$uu_t = array();
$uu_t_query = "select 'UU_T',circle, count(distinct msisdn),'Aircel54646' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') group by circle,dnis";

$uu_t_result = mysql_query($uu_t_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_t_result);
if ($numRows4 > 0) {
    while ($uu_t = mysql_fetch_array($uu_t_result)) {
        $circle = $circle_info[$uu_t[1]];
        $insert_uu_t_data = "insert into misdata.tbl_browsing_mis(Date,Service,Circle,Type,Value,Revenue,dnis)
        values('$view_date1', '$uu_t[3]','$circle','$uu_t[0]','$uu_t[2]','0','$uu_t[5]')";
        $queryIns_uu = mysql_query($insert_uu_t_data, $LivdbConn);
    }
}
/////////////////////////// end Unique Users  for Aircel 54646/////////////////////////////////////////////////////////////////////////
/////////////////////start code to insert the data for SEC_T  for Aircel 54646 ///////////////////////////////////////////////////

$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'Aircel54646' as service_name,date(call_date),sum(duration_in_sec) ,dnis
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc')
group by circle,dnis";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_t_result);
if ($numRows5 > 0) {
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $circle = $circle_info[$sec_t[1]];
        $insert_sec_t_data = "insert into misdata.tbl_browsing_mis(Date,Service,Circle,Type,Value,Revenue,dnis)
        values('$view_date1', '$sec_t[3]','$circle','$sec_t[0]','$sec_t[2]','0','$sec_t[6]')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $LivdbConn);
    }
}

// end insert the data for SEC_T  for Aircel 54646

mysql_close($LivdbConn);

mysql_close($dbConn);
echo "done";
?>
