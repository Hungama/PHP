<?php
	require_once("incs/db.php");
	$cat = $_GET['type'];
	$curdate=date('Y-m-d');
	$get_query="select songid from airtel_radio.tbl_nonstop_config nolock where config_name='".$cat."' and play_date='".$curdate."' order by play_time desc";
	$query = mysql_query($get_query,$dbConn);
	while($data = mysql_fetch_array($query)) 
	{
	//echo $data['songid']."<br>";
	$songid=explode(".",$data['songid']);
	echo $songid[0]."\n";
	}
	mysql_close($dbConn);
?>