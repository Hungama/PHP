<?php
$con = mysql_connect("119.82.69.210","weburl","weburl");
if(!$con)
{
	die('could not connect1: ' . mysql_error());
}
$view_date1= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

//$file=fopen("http://119.82.69.212/cricketcontentlog/cricket_contentlog_".$view_date1.".txt","r") or exit("Unable to open file!");

$filetoread='http://119.82.69.217/cricket/cricket_calllog_20111212.txt';
$file=fopen($filetoread,"r") or exit("Unable to open file!");
while (!feof($file))
{
	echo $fileline=fgets($file);
	echo "<br>";
	$line_array=explode("#",trim($fileline));
	echo "<pre>";
	print_r($line_array);

	$split1==explode("#",trim($line_array[1]));
	echo $split1;
	exit;
	
	echo $insert_query1="insert into mis_db.tbl_cricket_circle values ('','".trim($line_array[0])."','".trim($line_array[1])."','".date($line_array[2])."','".trim($line_array[3])."','".trim($line_array[4])."')";
	mysql_query($insert_query1);


	$id=mysql_insert_id();
	$i=4;
	echo "<br>".$abc=sizeof($line_array)-2;
	while($i<$abc)
	{
		if (isset($line_array[$i+1]))
		{
		echo $insert_query2="insert into mis_db.tbl_cricket_filedetail values ('".$id."','".trim($line_array[$i+1])."','".trim($line_array[$i+2])."','".trim($line_array[$i+3])."','".trim($line_array[$i+4])."')";
		mysql_query($insert_query2);
		$i=$i+4;
		}
	}
}
fclose($file);
mysql_close($con);
?> 