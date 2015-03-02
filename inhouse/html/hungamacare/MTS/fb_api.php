<?php
error_reporting(0);
include("../db.php");
	$message = $_REQUEST['message'];
	$user_id = $_REQUEST['user_id'];
	$msisdn = $_REQUEST['msisdn'];
	$songName = $_REQUEST['songName'];
	$albumName = $_REQUEST['albumName'];
	$cid = $_REQUEST['cid'];
	$feed_from = ($_REQUEST['feed_from']!="") ? $_REQUEST['feed_from'] : "web";
	$mode=$_REQUEST['mode'];

$curdate = date("Y-m-d");
$logPath = "logs/fb_post_".$curdate.".txt";
//send request to 227 server
//http://124.153.73.2/MTS/fb_api.php?mode=post&msisdn=918587800665&cid=Hun-09-68600
//http://119.82.69.212/hungamacare/MTS/fb_api.php?mode=post&msisdn=918587800665&cid=Hun-09-68600

$sql = "
				SELECT
					ContentName,
					AlbumName,
					MaleSingers
				FROM
					master_db.master_content
				WHERE 
					SongUniqueCode = '".trim(substr($cid,4))."'
			";

	$result = mysql_query($sql, $con);
			$arr_content = array();
			while($row = mysql_fetch_row($result))
			{
				$songName = urlencode($row[0]);
				$albumName = urlencode($row[1]);
			}

mysql_close($con);
//$sendreqst="http://124.153.73.2/MTS/fb_api.php?mode=$mode&msisdn=$msisdn&message=$message&cid=$cid&user_id=$user_id&feed_from=$feed_from&songName=$songName&albumName=$albumName";
$sendreqst="http://124.153.73.2/MTS/fb_api.php?mode=$mode&msisdn=$msisdn&message=$message&cid=&user_id=$user_id&feed_from=$feed_from&songName=$songName&albumName=$albumName";
echo $initrequest = file_get_contents($sendreqst);
$logData="#msisdn#".$msisdn."#user_id#".$user_id."#cid#".$cid."#url#".$sendreqst."#"."#response#".trim($initrequest)."#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logPath);				
?>