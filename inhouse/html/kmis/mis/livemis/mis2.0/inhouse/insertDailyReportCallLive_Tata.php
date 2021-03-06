<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
// delete the prevoius record
error_reporting(0);
$type=strtolower($_REQUEST['last']);
if (date('H') == '00' || $type=='y')
{
$type='y';
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
else
{
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}
echo $view_date1;

$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/inhouse/livedump/';
//include service name configuration
include ("/var/www/html/kmis/mis/livemis/mis2.0/inhouse/serviceNameconfig.php");
$kpiPrevfiledate=date("Ymd", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/livekpi_".$kpiPrevfiledate.".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate=date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/livekpi_".$kpifiledate.".txt";
$kpi_process_status = '***************Script start for insertDailyReportCallLive_Tata******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);


$service_array = array('TataDoCoMoMX', 'MTVTataDoCoMo', 'TataDoCoMo54646', 'TataDoCoMoFMJ', 'TataDoCoMoMND', 'TataIndicom54646', 'TataDoCoMoMXcdma', 'MTVTataDoCoMocdma', 'TataDoCoMoFMJcdma', 'RIATataDoCoMocdma', 'TataDoCoMoMNDcdma', 'RIATataDoCoMo','TataDoCoMoMXvmi', 'RIATataDoCoMovmi', 'TataDoCoMoMNDvmi', 'REDFMTataDoCoMo', 'REDFMTataDoCoMocdma', 'REDFMTataDoCoMovmi');


$check_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$next_date = date("Y-m-d", strtotime($view_date1 . ' + 1 day'));
if (strtotime($check_date) == strtotime($view_date1)) {
    $DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "'  and date>'" . $view_date1 . " 00:00:00'
                    and service IN ('" . implode("','", $service_array) . "') 
                    and (type like 'CALLS_%')";
} else {
   $DeleteQuery = "delete from misdata.livemis where (date(date)='" . $view_date1 . "' 
                        or date='" . $next_date . " 00:00:00')  and service IN ('" . implode("','", $service_array) . "') 
                        and (type like 'CALLS_%')";
}
echo $DeleteQuery;

$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

//////////////////////////////start code to insert the data for call_tf for Tata Docomo Endless////////////////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'1001' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_radio_calllog 
where date(call_date)='$view_date1'
and dnis like '59090%' and operator in ('TATM') group by circle ,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1002' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator ='tatm' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1009' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator ='tatm' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1003' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '546461%' and operator='tatm' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1005' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666')  and operator='tatm' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1010' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='tatm' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1013' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and (dnis = '55001' or dnis='550011') and operator ='tatm' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1601' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATC','tatc') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1602' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in ('546461','5464626') and operator in('TATC') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1609' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator in('TATC') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1603' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('TATC') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1605' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis=56666 and operator in('TATC') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1608' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in(54433) and operator in('TATC') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1613' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and (dnis = '55001' or dnis='550011') and operator in('TATC') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1801' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in ('virm') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1809' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464626%' and operator in ('virm') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1810' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator in ('virm') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1813' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and (dnis = '55001' or dnis='550011') and operator in ('virm') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1610' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1'  and dnis=55935 and operator in ('tatc') group by circle,hour(call_time)";
//echo $call_tf_query;
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $i = 0;
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $i++;
        if ($circle_info[strtoupper($call_tf[1])] == '')
            $circle_info[strtoupper($call_tf[1])] = 'Other';
        $service_name = getServiceName($call_tf[3]);

        $insert_call_tf_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_tf[6]',interval 1 hour),'$service_name', '" . $circle_info[strtoupper($call_tf[1])] . "','$call_tf[0]','$call_tf[2]',0)";
        $queryIns_call = mysql_query($insert_call_tf_data1, $LivdbConn);
    }
}

///////////////End code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for call_t for Live Mis////////////////////////////////////////////////
$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'1002' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator ='tatm' group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T',circle, count(id),'1009' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T',circle, count(id),'1602' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T',circle, count(id),'1609' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator in('TATC') group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T',circle, count(id),'1608' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('TATC') group by circle,dnis,hour(call_time)";

$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $call_type = 'CALLS_T';
        if ($call_t[5] == 5464669 && $call_t[3] == 1009)
            $call_type = 'CALLS_T';
        elseif ($call_t[3] == 1009)
            $call_type = 'CALLS_T_1';
        if ($call_t[5] == 5464669 && $call_t[3] == 1609)
            $call_type = 'CALLS_T';
        elseif ($call_t[3] == 1609)
            $call_type = 'CALLS_T_1';
        if (($call_t[5] == '5464669' || $call_t[5] == '5464666') && $call_t[3] == 1202)
            $call_type = "CALLS_T_6";
        elseif ($call_t[3] == 1202)
            $call_type = 'CALLS_T';
        if (($call_tf[5] == '544334' || $call_tf[5] == '5443344') && $call_t[3] == 1208)
            $call_type = "CALLS_T_6";
        elseif ($call_tf[5] == '544337' && $call_t[3] == 1208)
            $call_type = "CALLS_T_9";
        elseif (($call_tf[5] != '544334' && $call_tf[5] != '544337' && $call_tf[5] != '5443344') && $call_t[3] == 1208)
            $call_type = "CALLS_T";

        $service_name = getServiceName($call_t[3]);
        $insert_call_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_t[7]',interval 1 hour),'$service_name', '" . $circle_info[strtoupper($call_t[1])] . "','$call_type','$call_t[2]',0)";
        $queryIns_call = mysql_query($insert_call_t_data1, $LivdbConn);
    }
}
// sleep for 10 seconds
sleep(10);
//delete data for next day default datetime 2013-10-27 00:00:00
$date_Currentthour = date('H');
$next_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
$nextDeleteQuery="delete from misdata.livemis where date=date_format('".$next_date."','%Y-%m-%d 00:00:00') and service IN ('".implode("','",$service_array)."')";
if($date_Currentthour!='00')
{
if($type!='y')
{
echo "Next day data delete".$nextDeleteQuery;
$deleteResult12 = mysql_query($nextDeleteQuery,$LivdbConn) or die(mysql_error());
}
}



echo "Current hour is".$date_Currentthour;
$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' and service IN ('" . implode("','", $service_array) . "')";
if($date_Currentthour!='23')
{
if($type!='y')
{
echo $DeleteQuery;
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
}
else
{
echo 'NOK';
}
}

mysql_close($dbConn);
mysql_close($LivdbConn);
$kpi_process_status = '*******Script end for insertDailyReportCallLive_Tata*********' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
?>