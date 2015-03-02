<?php
include ("/var/www/html/hungamacare/config/dbConnect.php");
echo $rating=$_REQUEST[rating];
//echo $rating="5";
echo $config_location="config/mtsm/songconfig/";
echo $config_name="0102.cfg";

		if($rating=="4")
		{
			
			echo $query="select score from master_db.tbl_content_score where cfg_location='".$config_location."' and config='".$config_name."' order by score DESC limit 1";
			echo "</br>";
			$result=mysql_query($query, $dbConn);
			while($row = mysql_fetch_array($result))
			{
				echo $row['score']."</br>";
				echo $new_score=($row['score']-($row['score']*10/100))+($rating/10);
				echo "</br>";
			}
			if($new_score=="")
			{
				$new_score="0";
			}
		}
		if($rating=="3")
		{
			
			echo $query="select score from master_db.tbl_content_score where cfg_location='".$config_location."' and config='".$config_name."' order by score DESC limit 1";
			echo "</br>";
			$result=mysql_query($query, $dbConn);
			while($row = mysql_fetch_array($result))
			{
				echo $row['score']."</br>";
				echo $new_score=($row['score']-($row['score']*30/100))+($rating/10);
				echo "</br>";
			}
			if($new_score=="")
			{
				$new_score="0";
			}
		}
		if($rating=="2")
		{
			
			echo $query="select score from master_db.tbl_content_score where cfg_location='".$config_location."' and config='".$config_name."' order by score DESC limit 1";
			echo "</br>";
			$result=mysql_query($query, $dbConn);
			while($row = mysql_fetch_array($result))
			{
				echo $row['score']."</br>";
				echo $new_score=($row['score']-($row['score']*40/100))+($rating/10);
				echo "</br>";
			}
			if($new_score=="")
			{
				$new_score="0";
			}
		}
		if($rating=="1")
		{
			
			echo $query="select score from master_db.tbl_content_score where cfg_location='".$config_location."' and config='".$config_name."' order by score DESC limit 1";
			echo "</br>";
			$result=mysql_query($query, $dbConn);
			while($row = mysql_fetch_array($result))
			{
				echo $row['score']."</br>";
				echo $new_score=($row['score']-($row['score']*50/100))+($rating/10);
				echo "</br>";
			}
			if($new_score=="")
			{
				$new_score="0";
			}
		}

		echo $query_insert="insert into master_db.tbl_content_score (song_name,cfg_location,config,score,rating,servicename) values ('".$new_score."','".$rating."')";
		//$result_insert=mysql_query($query_insert, $dbConn);
	
mysql_close($dbConn);
?>