<?php
error_reporting(0);
$type=strtolower($_REQUEST['last']);
if($type=='y')
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
else
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));

$service_array = array('TataDocomoMX', 'MTVTataDoCoMo', 'TataDoCoMo54646');
$date_Currentthour = date('H');
//$date_Currentthour='02';
echo "Current hour is".$date_Currentthour."<br>";
$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' and service IN ('" . implode("','", $service_array) . "') and (type like 'CALLS_%' OR type like 'PULSE_%' OR type like 'MOU_%' OR type like 'SEC_%' OR type like 'UU_%')";

echo $DeleteQuery."<br>"; 
if($date_Currentthour!='23' && $date_Currentthour!='00')
{
echo $date_Currentthour."<br>"; 
if($type!='y')
{
echo 'Delete will work here';
//$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
}
else
{
echo 'NOK';
}
}

/*
$kpiPrevfiledate=date("Ymd", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/livekpi_".$kpiPrevfiledate.".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate=date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/livekpi_".$kpifiledate.".txt";
$kpi_process_status = '***************Script start for insertDailyReportLiveAllVoda1******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
*/
?>