<?php
include("config/dbConnect.php");

if($_SERVER['REQUEST_METHOD']=="POST") {
	$serviceName = $_POST['service1'];	
	$tableName = "tbl_content_score";

	$andQuery = "";

	if($_POST['searchtxt'] && $_POST['skeyword']) {
		$searchTxt = $_POST['searchtxt'];
		$fieldName = $_POST['skeyword'];
		$andQuery = " and ".$fieldName." LIKE '%".$searchTxt."%'";
	}

	$dataQuery = "SELECT id,song_name,rating,score,servicename FROM master_db.".$tableName." WHERE servicename='".$serviceName."' ".$andQuery; 
	$allData = mysql_query($dataQuery,$dbConn);
	$result_row=mysql_num_rows($allData);
	
	$excellFile="MTS_".$serviceName."_".date("Y_m_d").".csv";
	$excellFilePath=$excellDirPath.$excellFile;

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=$excellFile");	
	
	if($result_row>0 || $result_row1>0) {
		echo "Id,SongName,Rating,Score,ServiceName"."\r\n";
		while($content_array=mysql_fetch_array($allData))
		{
			$song_data = explode("_",$content_array[1]);
			$songId = $song_data[1];
			echo $content_array[0].",".$songId.",".$content_array[2].",".$content_array[3].",".$content_array[4]."\r\n";		
		}
	} else {
		echo "No Content available.";
	}

	header("Pragma: no-cache");
	header("Expires: 0");
}
?>