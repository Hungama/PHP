
<?php
date_default_timezone_set('Asia/Calcutta');
$con = mysql_connect("192.168.100.224","weburl","weburl");
if(!$con)
{
	die('could not connect1: ' . mysql_error());
}
//$view_date1= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$view_date1='20120803';

$file=fopen("/var/www/html/cricketcontentlog/cricketcontentlog213/cricket_contentlog_".$view_date1.".txt","r")  or exit("Unable to open file!");
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
?> 
