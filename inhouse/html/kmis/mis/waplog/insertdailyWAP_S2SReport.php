<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbcon/dbConnect212.php");//$dbConn212
$PrevDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
//$PrevDate='2015-01-04';
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh',
'UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
$deletedata="delete from Hungama_WAP_Logging.tbl_wapActivationDailyReportS2S where date='".$PrevDate."' and service='WAPAirtelLDR'";
$result3=mysql_query($deletedata, $dbConn212);
$affidarray=array('1105'=>'DGM','1040'=>'TYRO','1114'=>'RIPPLE');
foreach($affidarray as $affid=>$affid_name)
{
$TOTAL_HITS=0;$UNIQUE_HITS=0;$MISSING_MSISDN=0;$ACTIVATION_SUCCESS=0;
//Total hits
$queryTotalhits="select count(1) as TOTAL_HITS,count(distinct msisdn) as UNIQUE_HITS  from mis_db.tbl_browsing_wap_airtel nolock
where date(datetime)='".$PrevDate."' and service='WAPAirtelLDR' and affiliateid='".$affid."' and response!='BROWSINGAPI'";
$result=mysql_query($queryTotalhits, $dbConn212);
list($TOTAL_HITS,$UNIQUE_HITS) = mysql_fetch_array($result);

//MISSING_MSISDN
$result='';
$queryTotalMissingMsisdn="select count(1) as MISSING_MSISDN from mis_db.tbl_browsing_wap_airtel nolock 
where date(datetime)='".$PrevDate."' and service='WAPAirtelLDR' and affiliateid='".$affid."' and (msisdn=0 or msisdn='' or msisdn='UNKNOWN') and response!='BROWSINGAPI' ";
$result=mysql_query($queryTotalMissingMsisdn, $dbConn212);
list($MISSING_MSISDN) = mysql_fetch_array($result);

//ACTIVATION_SUCCESS
$result='';
$queryTotalSENT_TO_CG="select count(1) as TOTAL_ACTIVATION from mis_db.tbl_browsing_wap_airtel nolock
where date(datetime)='".$PrevDate."' and service='WAPAirtelLDR' and affiliateid='".$affid."' and DGMResponse like '%success%' and datatype='CGCOMPLETE'";
$result=mysql_query($queryTotalSENT_TO_CG, $dbConn212);
list($ACTIVATION_SUCCESS) = mysql_fetch_array($result);

// insert data in table
$insertquery="insert into Hungama_WAP_Logging.tbl_wapActivationDailyReportS2S (date,service,TOTAL_HITS,UNIQUE_HITS,MISSING_MSISDN,ACTIVATION_SUCCESS,AFFID,AFFID_NAME) values('".$PrevDate."','WAPAirtelLDR','".$TOTAL_HITS."','".$UNIQUE_HITS."','".$MISSING_MSISDN."','".$ACTIVATION_SUCCESS."','".$affid."','".$affid_name."')";
mysql_query($insertquery, $dbConn212);

}
mysql_close($dbConn212);
echo "Done";
?>