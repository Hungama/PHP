<?php
error_reporting(1);
include ("db_224.php");
$type=strtolower($_REQUEST['last']);
if (date('H') == '00' || $type=='y')
{
$type='y';
$prevdate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$prevdatedb = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
else
{
$prevdate = date("Ymd", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$prevdatedb = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}
#$prevdate='20141120';
#$prevdatedb='2014-11-20';

$DeleteQuery = "delete from mis_db.tbl_browsing_wap where date(datetime)='" . $prevdatedb . "' and service='WAPUninorContest'";
$deleteResult12 = mysql_query($DeleteQuery) or die(mysql_error());	

function enumValues($filename,$datatype) {
   $fGetContents = file_get_contents($filename);
    $e = explode("\n", $fGetContents);
   $totalcount=count($e);
    for ($i = 0; $i < $totalcount; $i++) {
	$data = explode("|", $e[$i]);
		
//to handle last blank line
if($totalcount!=$i+1)
{
$hitip='117.239.178.108';
$mode='WAP';
if($datatype=='browsing')
{
 $stype=$data[0];
 $zoneid_db=0;
 $datetime_db=$data[1];
 $msisdn_db=$data[2];
 $remoteaddress_db=$data[3];
 $useragent_db=$data[4];
 $chargingurlfired_db=$data[5];
 $response_db=$data[6];
 if(empty($response_db))
 {
 $response_db='Double consent';
 }
 $planid_db=$data[7];
 $mode_db=$data[8];
 $service_name=$data[9];
 $hitip_db=$data[10];
 $referer_db=$data[11];
$mode_db='WAP';
$afid=trim($data[12]);
$circle=trim($data[14]);
if(empty($afid)) 
 {
 $afid=0;
 }
$hitip_db=$hitip;
 if (!is_numeric($zoneid_db)) 
 {
 $zoneid_db=0;
 }
if (!is_numeric($msisdn_db)) 
 {
 $msisdn_db=0;
 }
						
if (!is_numeric($planid_db)) 
 {
 $planid_db=0;
 }
}
else if($datatype=='ccgresponse')
{
//Logs after CCG VISIT
 $stype=$data[0];
 $zoneid_db=0;
 $datetime_db=$data[15];
 $msisdn_db=$data[2];
 $remoteaddress_db=$data[7];
 $useragent_db=$data[8];
 $chargingurlfired_db='';
 $response_db=$data[5];
 $planid_db=$data[4];//CCG ID in this case
 $hitip_db=$data[11];
 $referer_db=$data[12];
 $mode_db='WAP';
$afid=trim($data[13]);
$circle=trim($data[14]);
if(empty($afid)) 
 {
 $afid=0;
 }
 $hitip_db=$hitip;
 if (!is_numeric($zoneid_db)) 
 {
 $zoneid_db=0;
 }
if (!is_numeric($msisdn_db)) 
 {
 $msisdn_db=0;
 }
					
}
$service_name='WAPUninorContest';


					
 $sql_waplog="INSERT INTO mis_db.tbl_browsing_wap (zoneid,datetime,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip,referer,affiliateid,datatype,circle)
VALUES ('".$zoneid_db."','".$datetime_db."','".$msisdn_db."','".$remoteaddress_db."','".mysql_real_escape_string($useragent_db)."','".trim($chargingurlfired_db)."','".$response_db."','".$planid_db."','".$mode_db."','".$service_name."','".$hitip_db."','".$referer_db."','".$afid."','".$datatype."','".$circle."')";
mysql_query($sql_waplog);
}
   }
   mysql_close($con);
}

#http://117.239.178.108/hungamawap/uninorcontest/doubleconsent/logs/CCG/UninorKIJIAfterCCGVisitorMIS_20141109.txt
#http://117.239.178.108/hungamawap/uninorcontest/doubleconsent/logs/CCG/UninorKIJISendCCGVisitorMIS_20141109.txt

$baseurl_browsing='http://117.239.178.108/hungamawap/uninorcontest/doubleconsent/logs/CCG/UninorKIJISendCCGVisitorMIS_';
$urltohit_browsing=$baseurl_browsing.$prevdate.'.txt';
enumValues($urltohit_browsing,'browsing');
echo $urltohit_browsing."<br>";
sleep(2);
$baseurl_ccgresponse='http://117.239.178.108/hungamawap/uninorcontest/doubleconsent/logs/CCG/UninorKIJIAfterCCGVisitorMIS_';
$urltohit_ccgresponse=$baseurl_ccgresponse.$prevdate.'.txt';
enumValues($urltohit_ccgresponse,'ccgresponse');
echo $urltohit_ccgresponse."<br>";
echo "Done";
?>
