<?php
include ("dbConnect.php");

$file_ext= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
//$file_ext="20120416";
$view_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

$deletePreviousData="delete from master_db.tbl_voda_calllog where date(call_date)='$view_date'";
$delete_result = mysql_query($deletePreviousData, $dbConn) or die(mysql_error());

// Calllog for Voda MTV
$file_to_read1="http://10.43.248.137/VodafoneLog/fetch_log_MTV/mtv_calllog_".$file_ext.".txt";

$file_name=file($file_to_read1);
$file_size=sizeof($file_name);
for($i=0;$i<$file_size;$i++)
{
        $file_content=explode("#",$file_name[$i]);
        $call_date=date('Y-m-d',strtotime($file_content[3]));
        $call_time=date('H-i-s',strtotime($file_content[4]));

        $pulse=(int)($file_content[5]/60)+1;
        $machine_data=explode("_",$file_content[1]);

         $insert_query="insert into master_db.tbl_voda_calllog(machine_name,status,call_date,call_time,duration_in_sec,msisdn,content_duration,dnis,real_dnis, circle,pulse,operator,ipAddr) values('$file_content[1]','$file_content[2]','$call_date','$call_time','$file_content[5]', '$file_content[6]', '$file_content[7]', '$file_content[8]','$file_content[9]','$machine_data[2]','$pulse','$machine_data[0]','10.43.248.137')";
        $query = mysql_query($insert_query, $dbConn) or die(mysql_error());
}

// end code to Calllog call is for tata Docomo Endless Docomo

//Calllogs for Voda54646
$file_to_read1="http://10.43.248.137/VodafoneLog/54646/54646_calllog_".$file_ext.".txt";

$file_name=file($file_to_read1);
$file_size=sizeof($file_name);
for($i=0;$i<$file_size;$i++)
{
        $file_content=explode("#",$file_name[$i]);
        $call_date=date('Y-m-d',strtotime($file_content[3]));
        $call_time=date('H-i-s',strtotime($file_content[4]));

        $pulse=(int)($file_content[5]/60)+1;
        $machine_data=explode("_",$file_content[1]);

         $insert_query="insert into master_db.tbl_voda_calllog(machine_name,status,call_date,call_time,duration_in_sec,msisdn,content_duration,dnis ,real_dnis,circle,pulse,operator,ipAddr) values('$file_content[1]','$file_content[2]','$call_date','$call_time','$file_content[5]' ,'$file_content[6]','$file_content[7]' ,'$file_content[8]','$file_content[9]','$machine_data[2]','$pulse','$machine_data[0]','10.43.248.137')";
        $query = mysql_query($insert_query, $dbConn) or die(mysql_error());
}

// Calllog for RedFM

$file_to_read1="http://10.43.248.137/VodafoneLog/RedFM/REDFM_calllog_".$file_ext.".txt";

$file_name=file($file_to_read1);
$file_size=sizeof($file_name);
for($i=0;$i<$file_size;$i++)
{
	$file_content=explode("#",$file_name[$i]);
	$call_date=date('Y-m-d',strtotime($file_content[3]));
	$call_time=date('H-i-s',strtotime($file_content[4]));
	
	$pulse=(int)($file_content[5]/60)+1;
	$machine_data=explode("_",$file_content[1]);
	
	 $insert_query="insert into master_db.tbl_voda_calllog (machine_name,status,call_date,call_time,duration_in_sec,msisdn,content_duration,dnis,real_dnis, circle,pulse,operator,ipAddr) values('$file_content[1]','$file_content[2]','$call_date','$call_time','$file_content[5]','$file_content[6]', '$file_content[7]','$file_content[8]','$file_content[9]','$machine_data[2]','$pulse','$machine_data[0]','10.43.248.137')";
	$query = mysql_query($insert_query, $dbConn) or die(mysql_error());
}
// End Code to insert the data for DON

echo "done";

?>
