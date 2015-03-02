<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

$curdate = date("Y_m_d_H_i_s");


$PDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$reportdate = date('j F ,Y ', strtotime($PDate));
$sub_message = $reportdate;

$get_allData = "select 'MissedCall' as type, count(1) as total from Hungama_Tatasky.tbl_tata_pushobd nolock  
where date(date_time)='" . $PDate . "' and ANI!=''
union
select 'OBD' as type,count(*) as total from Hungama_Tatasky.tbl_tata_pushobd nolock 
where date(date_time)='" . $PDate . "' and ANI!='' and ANI!='' and status!=0";
$data = mysql_query($get_allData, $dbConn) or die(mysql_error());

while ($row1 = mysql_fetch_array($data)) {
    $type = $row1['type'];
    $count[$type] = $row1['total'];
}
//GLC Live Start here
$get_allData_GLC_Live = "
select 'MissedCall' as type, count(1) as total from hul_hungama.tbl_hul_pushobd_sub nolock  
where date(date_time)='" . $PDate . "'  and ANI!='' and service='HUL'
union
select 'OBD' as type,count(*) as total from hul_hungama.tbl_hul_pushobd_sub nolock 
 where date(date_time)='" . $PDate . "' and ANI!='' and service='HUL' and status!=0";

$data_GLC_Live = mysql_query($get_allData_GLC_Live, $dbConn) or die(mysql_error());

while ($row_GLC_Live = mysql_fetch_array($data_GLC_Live)) {
    $type_GLC_Live = $row_GLC_Live['type'];
    $count_GLC_Live[$type_GLC_Live] = $row_GLC_Live['total'];
}

//GLC NONLive Start here
$get_allData_GLC_NLive = "
select 'MissedCall' as type, count(1) as total from hul_hungama.tbl_hul_pushobd_nonsub nolock  
where date(date_time)='" . $PDate . "' and ANI!=''  and service='HUL_NONLIVE'
union
select 'OBD' as type,count(*) as total from hul_hungama.tbl_hul_pushobd_nonsub nolock 
 where date(date_time)='" . $PDate . "' and ANI!='' and service='HUL_NONLIVE' and status!=0";

$data_GLC_NLive = mysql_query($get_allData_GLC_NLive, $dbConn) or die(mysql_error());

while ($row_GLC_NLive = mysql_fetch_array($data_GLC_NLive)) {
    $type_GLC_NLive = $row_GLC_NLive['type'];
    $count_GLC_NLive[$type_GLC_NLive] = $row_GLC_NLive['total'];
}
$totalGLC_MISSED = $count_GLC_Live['MissedCall'] + $count_GLC_NLive['MissedCall'];
$totalGLC_OBD = $count_GLC_Live['OBD'] + $count_GLC_NLive['OBD'];

$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= "<table rules='all' style='border-color: #666;font-size:12px;width:100%' border='0' cellpadding='2'>
<tr><td>Hi All,<br><br>
Please find all missed call vs OBD report for $sub_message.<br><br>
</td></tr></table>";

$message .= '<table rules="all" style="border-color: #666;font-size:12px;width:100%" border="0" cellpadding="2">';
$message .= "<tr bgcolor='#000000' style='color:#ffffff'><td>OBD Application</td><td>Missed Call</td><td>OBD Attempt</td></tr>";
$message .= "<tr bgcolor='#F5DEB3'><td>HUL GLC</td><td>&nbsp;&nbsp;" . $totalGLC_MISSED . "&nbsp;&nbsp;</td><td>&nbsp;&nbsp;" . $totalGLC_OBD . "</td></tr>";
$message .= "<tr bgcolor='#F5DEB3'><td>TATA Tiscon</td><td>&nbsp;&nbsp;" . $count['MissedCall'] . "&nbsp;&nbsp;</td><td>&nbsp;&nbsp;" . $count['OBD'] . "</td></tr>";
$message .= "</table>";

$message .="</body></html>";
echo $message;
$htmlfilename = 'emailcontent_' . date('Y_m_d') . '.html';
$file = fopen($htmlfilename, "w");
fwrite($file, $message);
////////////////////////////////////// code start for msg if missedcall and OBD not match @jyoti.porwal ////////////////////////////////////////////////
if (($totalGLC_MISSED != $totalGLC_OBD) || ($count['MissedCall'] != $count['OBD'])) {
    if (($totalGLC_MISSED != $totalGLC_OBD) && ($count['MissedCall'] != $count['OBD'])) {
        $msg = 'HUL GLC:- Total Missed Call:' . $totalGLC_MISSED . ' and Total OBD:' . $totalGLC_OBD . ' , ';
        $msg .= 'TATA Tiscon:- Total Missed Call:' . $count['MissedCall'] . ' and Total OBD:' . $count['OBD'];
    } else if ($totalGLC_MISSED != $totalGLC_OBD) {
        $msg = 'HUL GLC:- Total Missed Call:' . $totalGLC_MISSED . ' and Total OBD:' . $totalGLC_OBD;
    } else {
        $msg = 'TATA Tiscon:- Total Missed Call:' . $count['MissedCall'] . ' and Total OBD:' . $count['OBD'];
    }
    $procedureCall = "CALL master_db.SENDSMS_NEW(7503324645,\"$msg\",'OBD-Alert','UNIM','sms-promo',5)";
    $result1 = mysql_query($procedureCall, $dbConn);
    $procedureCall = "CALL master_db.SENDSMS_NEW(8587800665,\"$msg\",'OBD-Alert','UNIM','sms-promo',5)";
    $result1 = mysql_query($procedureCall, $dbConn);
    $procedureCall = "CALL master_db.SENDSMS_NEW(8587900178,\"$msg\",'OBD-Alert','UNIM','sms-promo',5)";
    $result1 = mysql_query($procedureCall, $dbConn);
    $procedureCall = "CALL master_db.SENDSMS_NEW(8586967045,\"$msg\",'OBD-Alert','UNIM','sms-promo',5)";
    $result1 = mysql_query($procedureCall, $dbConn);
}
////////////////////////////////////// code end for msg if missedcall and OBD not match @jyoti.porwal ////////////////////////////////////////////////
fclose($file);
mysql_close($dbConn);
?>