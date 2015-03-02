<?php
 $DB_HOST_M224     = '192.168.100.224'; //'172.28.106.4'; //DB HOST
 $DB_USERNAME_M224 = 'webcc';  //DB Username
 $DB_PASSWORD_M224 = 'webcc';  //DB Password 'Te@m_us@r987';
 $DB_DATABASE_M224 = 'master_db';  //Datbase Name  hul_hungama
 $db_m224 = $DB_DATABASE_M224;

 $con = mysql_connect($DB_HOST_M224,$DB_USERNAME_M224,$DB_PASSWORD_M224);
if (!$con)
 {
  die('Could not connect: ' . mysql_error("could not connect to Local"));
 }
 $processlogPath="/var/www/html/hungamacare/all/temp/ivr/ivr.txt";
$plog = "Process start at- " . date('Y-m-d H:i:s') . "\n";
error_log($plog, 3, $processlogPath);

for($i=14;$i<=30;$i++)
{
$date='2014-11-'.$i;
	$query="select count(1) as total from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate_backup_03Feb2015 where ANI not in 
	(select ANI from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate_backup where date(date_time)='$date') and date(date_time)='$date'";
	$query_call= mysql_query($query, $con);
	$numofrows = mysql_num_rows($query_call);
	echo "Toatl Count is- " .$numofrows.'</br/>';
	$res="Total Count#".$numofrows. "\n";
	 error_log($res, 3, $processlogPath);
	if ($numofrows !='0' && $numofrows<=50) {
	$new_data="insert into Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate_backup(ANI,service,status,date_time,obd_sent_date_time,
	obd_diff,retry_count,ANI_Dial,circle,in_dnd,obd_retry_date_time,operator,realdnis,BPARTYANI,MOMessage)
	select ANI,service,status,date_time,obd_sent_date_time,obd_diff,retry_count,ANI_Dial,circle,in_dnd,obd_retry_date_time,operator,realdnis,BPARTYANI,'ManualInsert' from
	 Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate_backup_03Feb2015 where ANI not in (select ANI from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate_backup where date(date_time)='$date') and date(date_time)='$date'";
	
	if(mysql_query($new_data, $con))
	$result='SUCCESS';
	else
	$result=mysql_error();
	
	 $res1=$numofrows."#".$result."#".$new_data. "\n";
	 error_log($res1, 3, $processlogPath);
	}
	
	
}  
$plog = "End start at- " . date('Y-m-d H:i:s') . "\n";
error_log($plog, 3, $processlogPath);
echo "Done";
mysql_close($con);
?>