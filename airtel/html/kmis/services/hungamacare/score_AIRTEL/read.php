<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbconfigairtel.php");

	$allowedExts = array("csv");
	if($_FILES["file"]["name"])
	{
		$extension = end(explode(".", $_FILES["file"]["name"]));
	}
	else
	{
		$redirect = "index.php?logerr=notup";
	}

	if (in_array($extension, $allowedExts))
	{
		move_uploaded_file($_FILES["file"]["tmp_name"],"upload/" ."score.csv");
	}
	else
	{
		$redirect = "index.php?logerr=notup";
	}

	$filepath="/var/www/html/kmis/services/hungamacare/score_AIRTEL/upload/score.csv";
	$source = fopen($filepath, 'r') or die("Problem open file");
    while (($data = fgetcsv($source, 1000, ",")) !== FALSE)
    {
       $songname = $data[0];
       $config_name = $data[1];
       $servicename = $data[2];
       $rating = $data[3];

		$config_location="";
		if ($servicename=="AirtelEU")
		{
			$config_location="AMUconfig/songconfig/";
		}

		if($rating=="5")
		{
			$query="select score from master_db.tbl_content_score where cfg_location='".$config_location."' and config='".$config_name."' order by score DESC limit 1";
			$result=mysql_query($query, $dbConn);
			list($new_score)=mysql_fetch_array($result);
			if($new_score) 
			{
				$new_score=$new_score+($rating/10);
			}  
			else 
			{
				$new_score=0;
			}
		}
		if($rating=="3" || $rating=="2" || $rating=="1")
		{
			$query="select score from master_db.tbl_content_score where cfg_location='".$config_location."' and config='".$config_name."' and rating='".$rating."' order by score DESC limit 1";
			$result=mysql_query($query, $dbConn);
			while($row = mysql_fetch_array($result))
			{
				$new_score=$row['score']+($rating/10);
			}
			if($new_score=="")
			{
				$new_score="0";
			}
		}
		else if($rating=="4")
		{
			$query="select score from master_db.tbl_content_score where cfg_location='".$config_location."' and config='".$config_name."' and rating=5 order by score DESC limit 1";
			$result=mysql_query($query, $dbConn);
			while($row = mysql_fetch_array($result))
			{
				$new_score=$row['score']-($rating/10);
			}
			if($new_score=="")
			{
				$new_score="0";
			}
		}

		$query_insert="insert into master_db.tbl_content_score (song_name,cfg_location,config,score,rating,servicename) values ('".$songname."','".$config_location."','".$config_name."','".$new_score."','".$rating."','".$servicename."')";
		$result_insert=mysql_query($query_insert, $dbConn);
		$redirect = "index.php?logerr=sec";
	}
    fclose($source);

mysql_close($dbConn);

header("Location: $redirect");

//header("Location: $redirect");


?>
