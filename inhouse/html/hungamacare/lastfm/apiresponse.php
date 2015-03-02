<?php
ob_clean();
$searchstr=$_REQUEST['searchstr'];
$stype=$_REQUEST['stype'];
$apiUrl="http://192.168.100.212/hungamacare/last.fm/lastfm_Notify.php?searchStr=".urlencode($searchstr)."&srctype=".$stype;
echo $status = file_get_contents($apiUrl);
/*
function getResult($searchstr,$stype)
{
	$apiUrl="http://119.82.69.212/hungamacare/last.fm/lastfm_Notify.php?searchStr=".$searchstr."&srctype=".$stype;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$apiUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$response = curl_exec($ch);
	return $response;
}
echo $res=getResult($searchstr,$stype);
*/
?>
