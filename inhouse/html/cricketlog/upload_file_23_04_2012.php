<?php
date_default_timezone_set('Asia/Calcutta');
$con = mysql_connect("119.82.69.210","weburl","weburl");
if(!$con)
{
	die('could not connect1: ' . mysql_error());
}
$view_date1= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
//$view_date1='20120416';

$file=fopen("http://119.82.69.212/cricketcontentlog/cricketcontentlog213/cricket_contentlog_".$view_date1.".txt","r") or exit("Unable to open file!");
while (!feof($file))
{
	$fileline=fgets($file);
	$line_array=explode("#",trim($fileline));
	$insert_query1="insert into mis_db.tbl_cricket_circle (ANI,DNIS,DATE,STARTTIME,CIRCLE) values ('".trim($line_array[2])."','".trim($line_array[3])."','".date($line_array[4])."','".trim($line_array[5])."','".trim($line_array[1])."')";
	mysql_query($insert_query1);
	$id=mysql_insert_id();
	$i=5;
	$abc=sizeof($line_array)-2;
	while($i<$abc)
	{
		if (isset($line_array[$i+1]))
		{
			$insert_query2="insert into mis_db.tbl_cricket_filedetail values ('".$id."','".trim($line_array[$i+1])."','".trim($line_array[$i+2])."','".trim($line_array[$i+3])."','".trim($line_array[$i+4])."')";
			mysql_query($insert_query2);
			$i=$i+4;
		}
	}
}
fclose($file);
$callQuery="call mis_db.update_cricket_endtime";
mysql_query($callQuery);
sleep(5);
echo "213 Data Inserted for ";
echo $view_date1;
echo "##############################################Server 217########################################################";
$file1=fopen("http://119.82.69.212/cricketcontentlog/cricketcontentlog217/cricket_contentlog_".$view_date1.".txt","r") or exit("Unable to open file!");
while (!feof($file1))
{
	$fileline1=fgets($file1);
	$line_array1=explode("#",trim($fileline1));
	$insert_query2="insert into mis_db.tbl_cricket_circle (ANI,DNIS,DATE,STARTTIME,CIRCLE) values ('".trim($line_array1[2])."','".trim($line_array1[3])."','".date($line_array1[4])."','".trim($line_array1[5])."','".trim($line_array1[1])."')";
	mysql_query($insert_query2);
	$id1=mysql_insert_id();
	$i=5;
	$abc1=sizeof($line_array1)-2;
	while($i<$abc1)
	{
		if (isset($line_array1[$i+1]))
		{
			$insert_query2="insert into mis_db.tbl_cricket_filedetail values ('".$id1."','".trim($line_array1[$i+1])."','".trim($line_array1[$i+2])."','".trim($line_array1[$i+3])."','".trim($line_array1[$i+4])."')";
			mysql_query($insert_query2);
			$i=$i+4;
		}
	}
}
fclose($file);
$callQuery1="call mis_db.update_cricket_endtime";
mysql_query($callQuery1);
mysql_close($con);
echo "217 Data Inserted for ";
echo $view_date1;
?> 
