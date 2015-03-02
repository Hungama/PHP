<?php

include ("config/dbConnect.php");
include("http://119.82.69.214/fetch_log_rel/fetch_log_rel.php");

//$file_ext=date("Ymd")-1;
$file_ext= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

$deleteprevioousdata="delete from mis_db.tbl_jbox_calllog where date(call_date)=date(date_add(now(),interval -1 day))";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

for($k=0;$k<2;$k++)
{
	if($k==0)
		$file_to_read1="http://119.82.69.214/fetch_log_rel/54646_calllog_".$file_ext.".txt";
	else
	{
		$file_to_read1="http://119.82.69.213/FetchLogRel/54646_calllog_".$file_ext.".txt";
		//$file_to_read1="http://119.82.69.214/log213/54646_calllog_".$file_ext.".txt";
	}
	
	$file_name=file($file_to_read1);
	$file_size=sizeof($file_name);
	for($i=0;$i<$file_size;$i++)
	{
		$file_content=explode("#",$file_name[$i]);
		$call_date=date('Y-m-d',strtotime($file_content[3]));
		$call_time=date('H-i-s',strtotime($file_content[4]));
		$pulse=(int)($file_content[5]/60)+1;
		$machine_data=explode("_",$file_content[1]);
		$insert_query="insert into mis_db.tbl_jbox_calllog(machine_name,status,call_date,call_time,duration_in_sec,msisdn,content_duration,dnis,real_dnis,circle,pulse,operator) values('$file_content[1]','$file_content[2]','$call_date','$call_time','$file_content[5]','$file_content[6]','$file_content[7]','$file_content[8]','$file_content[9]','$machine_data[2]','$pulse','$machine_data[0]')";
		$query = mysql_query($insert_query, $dbConn) or die(mysql_error());
	}
	
}
	echo "Data Inserted" ;
?>

