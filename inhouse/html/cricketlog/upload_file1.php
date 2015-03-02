<?php
date_default_timezone_set('Asia/Calcutta');
$con = mysql_connect("database.master","weburl","weburl");
if(!$con)
{
	die('could not connect1: ' . mysql_error());
}
//$view_date1= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$view_date1='20120802';
/*
echo "##############################################Server 213 ########################################################";
echo "http://192.168.100.212/cricketcontentlog/cricketcontentlog213/cricket_contentlog_".$view_date1.".txt";

echo $file_to_read2='http://192.168.100.212/cricketcontentlog/cricketcontentlog213/cricket_contentlog_'.$view_date1.'.txt';
$file_name1=file($file_to_read2);
$file_size1=sizeof($file_name1);
for($i=0;$i<$file_size1;$i++)
{
	 $line_array=explode("#",$file_name1[$i]);
	 
	 $insert_query2="insert into mis_db.tbl_cricket_circle (ANI,DNIS,DATE,STARTTIME,CIRCLE) values ('".trim($line_array[2])."','".trim($line_array[3])."','".date($line_array[4])."','".trim($line_array[5])."','".trim($line_array[1])."')";
	 mysql_query($insert_query2);

	 $selMaxId="select max(RefId)+1 from mis_db.tbl_cricket_circle";
	 $qryId = mysql_query($selMaxId);
	 list($refId) = mysql_fetch_array($qryId);

	 if(!$refId) $refId = 1;

	 $i=5;
	 $abc1=sizeof($line_array)-2;
	 while($i<$abc1) {
		if (isset($line_array[$i+1]))
		{
			$insert_query2="insert into mis_db.tbl_cricket_filedetail values ('".$refId."','".trim($line_array[$i+1])."','".trim($line_array[$i+2])."', '".trim($line_array[$i+3])."','".trim($line_array[$i+4])."')";
			mysql_query($insert_query2);
			$i=$i+4;
		}
	 }
}
*/
echo "##############################################Server 217########################################################";
//echo "http://192.168.100.212/cricketcontentlog/cricketcontentlog217/cricket_contentlog_".$view_date1.".txt";

echo $file_to_read1="http://192.168.100.212/cricketcontentlog/cricketcontentlog217/cricket_contentlog_".$view_date1.".txt";
$file_name=file($file_to_read1);
$file_size=sizeof($file_name);
for($i=0;$i<$file_size;$i++)
{
	 $line_array1=explode("#",$file_name[$i]);
	 
	 $insert_query2="insert into mis_db.tbl_cricket_circle (ANI,DNIS,DATE,STARTTIME,CIRCLE) values ('".trim($line_array1[2])."','".trim($line_array1[3])."','".date($line_array1[4])."','".trim($line_array1[5])."','".trim($line_array1[1])."')";
	 mysql_query($insert_query2);

	 $selMaxId="select max(RefId)+1 from mis_db.tbl_cricket_circle";
	 $qryId = mysql_query($selMaxId);
	 list($refId) = mysql_fetch_array($qryId);

	 //if(!$refId) $refId = 1;
	 
	 $i=5;
	 $abc1=sizeof($line_array1)-2;
	 while($i<$abc1) {
		if (isset($line_array1[$i+1]))
		{
			$insert_query2="insert into mis_db.tbl_cricket_filedetail values ('".$refId."','".trim($line_array1[$i+1])."','".trim($line_array1[$i+2])."', '".trim($line_array1[$i+3])."','".trim($line_array1[$i+4])."')";
			mysql_query($insert_query2);
			$i=$i+4;
		}
	 }
}
$callQuery1="call mis_db.update_cricket_endtime";
mysql_query($callQuery1);
mysql_close($con);
echo "217 Data Inserted for ";
echo $view_date1;
?>* 
