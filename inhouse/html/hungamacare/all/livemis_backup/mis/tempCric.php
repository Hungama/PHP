<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");
$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$fview_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$fileDate= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

$activeDir="/var/www/html/kmis/testing/activeBase/";

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');


$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese','18'=>'Rajasthani','19'=>'Nepali','20'=>'Kumaoni','21'=>'Maithali','99'=>'Hindi');

//--------------------------------------------------------------------------------------------
$PMTSMUFile="1101/PMTSMU_20130418.txt";
$PMTSMUFilePath=$activeDir.$PMTSMUFile;

echo "conn: ".$dbConn;

echo $getPendingBaseQ7="select 'MTSMU',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_radio.tbl_radio_subscription where status=11 and plan_id!='29' and date(sub_date)<='2013-04-18'";  

echo $query7 = mysql_query($getPendingBaseQ7,$dbConn);


while($PMTSMUActbase = mysql_fetch_array($query7))
{	
	if($circle_info[$PMTSMUActbase[5]]=='')
		$PMTSMUActbase[5]='Others';

	if($languageData[trim($PMTSMUActbase[8])]!='')
		$lang=$languageData[$PMTSMUActbase[8]];
	else
		$lang=trim($PMTSMUActbase[8]);

	$PMTSMUPendingBasedata="2013-04-18|".trim($PMTSMUActbase[0])."|".trim($PMTSMUActbase[1])."|".trim($PMTSMUActbase[2])."|".trim($PMTSMUActbase[3])."|".trim($PMTSMUActbase[4])."|".trim($circle_info[$PMTSMUActbase[5]])."|".trim($PMTSMUActbase[6])."|".trim($PMTSMUActbase[7])."|".trim($lang)."|".trim($PMTSMUActbase[15]).'|'.trim($PMTSMUActbase[15]).'|'.trim($PMTSMUActbase[15])."\r\n";
	error_log($PMTSMUPendingBasedata,3,$PMTSMUFilePath) ;
}

	$del="delete from misdata.tbl_base_active where date(date)='2013-04-18' and service='MTSMU' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);

	$insertDump16= 'LOAD DATA LOCAL INFILE "'.$PMTSMUFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		if(mysql_query($insertDump16,$LivdbConn))
		{
		echo "done";
		}
		else
		{
		echo mysql_errno($LivdbConn) . ": " . mysql_error($LivdbConn). "\n";
		}

echo "done";
mysql_close($dbConn);
mysql_close($LivdbConn);


?>
