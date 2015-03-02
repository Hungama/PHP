<?php
include ("/var/www/html/hungamacare/config/dbConnect.php");
$songname="200_HUN-09-00001";
$servicename="54646V2";
$config_name="0102.cfg";
$rating="2";

if ($servicename=="Endless")
{
	
	$config_location="config/mtsm/songconfig/";
}
else
{
	//$servicename="54646V2";
	$config_location="54646V2/mtsm/mwconfig/songconfig/";
}

if($rating=="5" || $rating=="3" || $rating=="2" || $rating=="1")
{
echo $query="select score from master_db.tbl_content_score where cfg_location='".$config_location."' and config='".$config_name."' and rating='".$rating."' order by score DESC limit 1 ;";
$result=mysql_query($query);
while($row = mysql_fetch_array($result))
	{
	$new_score=$row['score']+($rating/10);
	}
	if($new_score=="")
	{
		$new_score="0";
	}
echo $new_score;
echo "<br>";
}
else if($rating=="4")
{
echo $query="select score from master_db.tbl_content_score where cfg_location='".$config_location."' and config='".$config_name."' and rating=5 order by score DESC limit 1;";
$result=mysql_query($query);
while($row = mysql_fetch_array($result))
	{
	$new_score=$row['score']-($rating/10);
	}
	if($new_score=="")
	{
		$new_score="0";
	}
echo $new_score;
echo "<br>";
}

echo $query_insert="insert into master_db.tbl_content_score(song_name,cfg_location,config,score,rating,servicename) values ('".$songname."','".$config_location."','".$config_name."','".$new_score."','".$rating."','".$servicename."');";
//$result_insert=mysql_query($query_insert);




mysql_close($dbConn);

echo "<br/>"."Done".$i;
?>